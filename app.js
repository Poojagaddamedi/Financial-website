const BASE_URL = 'http://localhost/fintech/apis';

// Utility function to format numbers
const formatNumber = (number) => {
    return new Intl.NumberFormat('en-IN', {
        style: 'decimal',
        maximumFractionDigits: 2
    }).format(number);
};

// Function to show loading state
const showLoading = (elementId) => {
    document.getElementById(elementId).innerHTML = '<div class="loading">Loading...</div>';
};

// Function to show error state
const showError = (elementId, message) => {
    document.getElementById(elementId).innerHTML = `<div class="error">${message}</div>`;
};

// Function to fetch data from API
async function fetchData(endpoint, params = {}) {
    const queryString = new URLSearchParams(params).toString();
    try {
        const response = await fetch(`${BASE_URL}/${endpoint}?${queryString}`);
        if (!response.ok) throw new Error('Network response was not ok');
        return await response.json();
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
}

// Load company overview
async function loadOverview(companyId) {
    showLoading('overview');
    try {
        const data = await fetchData('overview.php', { company_id: companyId });
        console.log(data);
        
        if (!data || !data.name) {
            throw new Error('Invalid company data received');
        }
        
        const overviewHtml = `
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <img src="${data.logo_url} alt="${data.name} Logo" class="img-fluid" 
                             onerror="this.src='default-logo.png'">
                    </div>
                    <div class="col-md-9">
                        <h3>${data.name}</h3>
                        <p><strong>Sector:</strong> ${data.sector || 'N/A'}</p>
                        <p><strong>Market Cap:</strong> ${data.market_cap ? '₹' + formatNumber(data.market_cap * 83) : 'N/A'}</p>
                    </div>
                </div>
            </div>
        `;
        
        // Change from querySelector to getElementById for more specific targeting
        const companyInfoElement = document.getElementById('overview');
        if (!companyInfoElement) {
            throw new Error('Company info element not found');
        }
        companyInfoElement.innerHTML = overviewHtml;
    } catch (error) {
        console.error('Overview loading error:', error);
        showError('overview', 'Failed to load company overview. Please try again later.');
    }
}

// Load financial data
async function loadFinancials(companyId, year) {
    // Load Balance Sheet
    try {
        const balanceSheet = await fetchData('balance_sheet.php', { company_id: companyId, year });
        const balanceSheetHtml = `
            <div class="table-responsive">
                <table class="table">
                    <tr><td>Assets</td><td>₹${formatNumber(balanceSheet.assets * 83)}</td></tr>
                    <tr><td>Liabilities</td><td>₹${formatNumber(balanceSheet.liabilities * 83)}</td></tr>
                    <tr><td>Equity</td><td>₹${formatNumber(balanceSheet.equity * 83)}</td></tr>
                </table>
            </div>
        `;
        document.getElementById('balanceSheetData').innerHTML = balanceSheetHtml;
    } catch (error) {
        showError('balanceSheetData', 'Failed to load balance sheet data');
    }

    // Load Profit & Loss
    try {
        const profitLoss = await fetchData('profit_loss.php', { company_id: companyId, year });
        const profitLossHtml = `
            <div class="table-responsive">
                <table class="table">
                    <tr><td>Revenue</td><td>₹${formatNumber(profitLoss.revenue * 83)}</td></tr>
                    <tr><td>Expenses</td><td>₹${formatNumber(profitLoss.expenses * 83)}</td></tr>
                    <tr><td>Net Profit</td><td>₹${formatNumber(profitLoss.net_profit * 83)}</td></tr>
                </table>
            </div>
        `;
        document.getElementById('profitLossData').innerHTML = profitLossHtml;
    } catch (error) {
        showError('profitLossData', 'Failed to load profit & loss data');
    }

    // Load Cash Flow
    try {
        const cashFlow = await fetchData('cash_flow.php', { company_id: companyId, year });
        const cashFlowHtml = `
            <div class="table-responsive">
                <table class="table">
                    <tr><td>Operating Cash Flow</td><td>₹${formatNumber(cashFlow.operating_cash_flow * 83)}</td></tr>
                    <tr><td>Investing Cash Flow</td><td>₹${formatNumber(cashFlow.investing_cash_flow * 83)}</td></tr>
                    <tr><td>Financing Cash Flow</td><td>₹${formatNumber(cashFlow.financing_cash_flow * 83)}</td></tr>
                </table>
            </div>
        `;
        document.getElementById('cashFlowData').innerHTML = cashFlowHtml;
    } catch (error) {
        showError('cashFlowData', 'Failed to load cash flow data');
    }

    // Load Ratios
    try {
        const ratios = await fetchData('ratios.php', { company_id: companyId, year });
        const ratiosHtml = `
            <div class="table-responsive">
                <table class="table">
                    <tr><td>Current Ratio</td><td>${ratios[0].current_ratio}</td></tr>
                    <tr><td>Quick Ratio</td><td>${ratios[0].quick_ratio}</td></tr>
                    <tr><td>Debt/Equity Ratio</td><td>${ratios[0].debt_equity_ratio}</td></tr>
                    <tr><td>ROE</td><td>${ratios[0].roe}%</td></tr>
                    <tr><td>ROA</td><td>${ratios[0].roa}%</td></tr>
                </table>
            </div>
        `;
        document.getElementById('ratiosData').innerHTML = ratiosHtml;
    } catch (error) {
        showError('ratiosData', 'Failed to load financial ratios');
    }
}

// Load stock data
async function loadStockData(companyId, date) {
    showLoading('stockData');
    try {
        const data = await fetchData('stock_prices.php', { company_id: companyId, date });
        const stockHtml = `
            <div class="table-responsive">
                <table class="table">
                    <tr><td>Open</td><td>₹${formatNumber(data[0].open_price * 83)}</td></tr>
                    <tr><td>Close</td><td>₹${formatNumber(data[0].close_price * 83)}</td></tr>
                    <tr><td>High</td><td>₹${formatNumber(data[0].high_price * 83)}</td></tr>
                    <tr><td>Low</td><td>₹${formatNumber(data[0].low_price * 83)}</td></tr>
                    <tr><td>Volume</td><td>${formatNumber(data[0].volume)}</td></tr>
                </table>
            </div>
        `;
        document.getElementById('stockData').innerHTML = stockHtml;
    } catch (error) {
        showError('stockData', 'Failed to load stock data');
    }
}

// Load documents
async function loadDocuments(companyId) {
    showLoading('documentsData');
    try {
        const data = await fetchData('documents.php', { company_id: companyId, document_type: 'Annual Report' });
        const documentsHtml = data.map(doc => `
            <div class="document-item">
                <i class="bi bi-file-earmark-pdf"></i>
                <a href="${doc.document_url}" target="_blank">${doc.document_name}</a>
                <span class="text-muted">(${doc.upload_date})</span>
            </div>
        `).join('');
        document.getElementById('documentsData').innerHTML = documentsHtml;
    } catch (error) {
        showError('documentsData', 'Failed to load documents');
    }
}

// Load media
async function loadMedia(companyId) {
    showLoading('mediaData');
    try {
        const data = await fetchData('media.php', { company_id: companyId, media_type: 'Press Release' });
        const mediaHtml = data.map(item => `
            <div class="media-item">
                <i class="bi bi-play-circle"></i>
                <a href="${item.media_url}" target="_blank">${item.media_name}</a>
                <span class="text-muted">(${item.upload_date})</span>
            </div>
        `).join('');
        document.getElementById('mediaData').innerHTML = mediaHtml;
    } catch (error) {
        showError('mediaData', 'Failed to load media');
    }
}

// Event Listeners
document.addEventListener('DOMContentLoaded', () => {
    const companySelect = document.getElementById('companySelect');
    const yearSelect = document.getElementById('yearSelect');
    const dateSelect = document.getElementById('dateSelect');
    const sidebarLinks = document.querySelectorAll('#sidebar ul li a');

    // Initial load
    loadOverview(companySelect.value);

    // Company selection change
    companySelect.addEventListener('change', (e) => {
        const companyId = e.target.value;
        loadOverview(companyId);
        loadFinancials(companyId, yearSelect.value);
        loadStockData(companyId, dateSelect.value);
        loadDocuments(companyId);
        loadMedia(companyId);
    });

    // Year selection change
    yearSelect.addEventListener('change', (e) => {
        loadFinancials(companySelect.value, e.target.value);
    });

    // Date selection change
    dateSelect.addEventListener('change', (e) => {
        loadStockData(companySelect.value, e.target.value);
    });

    // Navigation
    sidebarLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const section = e.target.getAttribute('data-section');
            
            // Update active states
            document.querySelectorAll('.content-section').forEach(sec => {
                sec.classList.remove('active');
            });
            document.getElementById(section).classList.add('active');
            
            sidebarLinks.forEach(l => l.parentElement.classList.remove('active'));
            link.parentElement.classList.add('active');

            // Load section data if needed
            const companyId = companySelect.value;
            switch(section) {
                case 'overview':
                    loadOverview(companyId);
                    break;
                case 'financials':
                    loadFinancials(companyId, yearSelect.value);
                    break;
                case 'stock':
                    loadStockData(companyId, dateSelect.value);
                    break;
                case 'documents':
                    loadDocuments(companyId);
                    break;
                case 'media':
                    loadMedia(companyId);
                    break;
            }
        });
    });
}); 
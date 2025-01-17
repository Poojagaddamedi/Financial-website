-- Create the database
CREATE DATABASE IF NOT EXISTS financial_data;
USE financial_data;

-- Create tables
CREATE TABLE IF NOT EXISTS overview (
    company_id INT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    sector VARCHAR(50),
    market_cap DECIMAL(20,2),
    logo_url VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS balance_sheet (
    id INT PRIMARY KEY AUTO_INCREMENT,
    company_id INT NOT NULL,
    year INT NOT NULL,
    assets DECIMAL(20,2),
    liabilities DECIMAL(20,2),
    equity DECIMAL(20,2),
    UNIQUE KEY company_year (company_id, year)
);

CREATE TABLE IF NOT EXISTS profit_loss (
    id INT PRIMARY KEY AUTO_INCREMENT,
    company_id INT NOT NULL,
    year INT NOT NULL,
    revenue DECIMAL(20,2),
    expenses DECIMAL(20,2),
    net_profit DECIMAL(20,2),
    UNIQUE KEY company_year (company_id, year)
);

CREATE TABLE IF NOT EXISTS cash_flow (
    id INT PRIMARY KEY AUTO_INCREMENT,
    company_id INT NOT NULL,
    year INT NOT NULL,
    operating_cash_flow DECIMAL(20,2),
    investing_cash_flow DECIMAL(20,2),
    financing_cash_flow DECIMAL(20,2),
    UNIQUE KEY company_year (company_id, year)
);

CREATE TABLE IF NOT EXISTS ratios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    company_id INT NOT NULL,
    year INT NOT NULL,
    current_ratio DECIMAL(10,2),
    quick_ratio DECIMAL(10,2),
    debt_equity_ratio DECIMAL(10,2),
    roe DECIMAL(10,2),
    roa DECIMAL(10,2),
    UNIQUE KEY company_year (company_id, year)
);

CREATE TABLE IF NOT EXISTS shareholding (
    id INT PRIMARY KEY AUTO_INCREMENT,
    company_id INT NOT NULL,
    year INT NOT NULL,
    promoter_holding DECIMAL(5,2),
    institutional_holding DECIMAL(5,2),
    public_holding DECIMAL(5,2),
    UNIQUE KEY company_year (company_id, year)
);

CREATE TABLE IF NOT EXISTS stock_prices (
    id INT PRIMARY KEY AUTO_INCREMENT,
    company_id INT NOT NULL,
    date DATE NOT NULL,
    open_price DECIMAL(10,2),
    close_price DECIMAL(10,2),
    high_price DECIMAL(10,2),
    low_price DECIMAL(10,2),
    volume INT,
    UNIQUE KEY company_date (company_id, date)
);

CREATE TABLE IF NOT EXISTS documents (
    id INT PRIMARY KEY AUTO_INCREMENT,
    company_id INT NOT NULL,
    document_type VARCHAR(50) NOT NULL,
    document_name VARCHAR(100),
    document_url VARCHAR(255),
    upload_date DATE
);

CREATE TABLE IF NOT EXISTS media (
    id INT PRIMARY KEY AUTO_INCREMENT,
    company_id INT NOT NULL,
    media_type VARCHAR(50) NOT NULL,
    media_name VARCHAR(100),
    media_url VARCHAR(255),
    upload_date DATE
);

-- Insert sample data
-- Sample companies
INSERT INTO overview (company_id, name, sector, market_cap, logo_url) VALUES
(1, 'Tech Corp', 'Technology', 1000000000.00, 'https://example.com/logos/techcorp.png'),
(2, 'Finance Plus', 'Financial Services', 750000000.00, 'https://example.com/logos/financeplus.png'),
(3, 'Green Energy Ltd', 'Energy', 500000000.00, 'https://example.com/logos/greenenergy.png');

-- Sample balance sheet data
INSERT INTO balance_sheet (company_id, year, assets, liabilities, equity) VALUES
(1, 2023, 1000000.00, 600000.00, 400000.00),
(1, 2022, 800000.00, 500000.00, 300000.00),
(2, 2023, 1500000.00, 900000.00, 600000.00);

-- Sample profit & loss data
INSERT INTO profit_loss (company_id, year, revenue, expenses, net_profit) VALUES
(1, 2023, 500000.00, 300000.00, 200000.00),
(1, 2022, 400000.00, 250000.00, 150000.00),
(2, 2023, 800000.00, 600000.00, 200000.00);

-- Sample cash flow data
INSERT INTO cash_flow (company_id, year, operating_cash_flow, investing_cash_flow, financing_cash_flow) VALUES
(1, 2023, 250000.00, -50000.00, -100000.00),
(1, 2022, 200000.00, -40000.00, -80000.00),
(2, 2023, 400000.00, -100000.00, -150000.00);

-- Sample ratios data
INSERT INTO ratios (company_id, year, current_ratio, quick_ratio, debt_equity_ratio, roe, roa) VALUES
(1, 2023, 2.5, 1.8, 0.6, 15.5, 8.2),
(1, 2022, 2.3, 1.6, 0.7, 14.2, 7.8),
(2, 2023, 1.8, 1.2, 0.8, 12.5, 6.5);

-- Sample shareholding data
INSERT INTO shareholding (company_id, year, promoter_holding, institutional_holding, public_holding) VALUES
(1, 2023, 45.5, 35.2, 19.3),
(1, 2022, 46.0, 34.8, 19.2),
(2, 2023, 51.2, 30.5, 18.3);

-- Sample stock prices data
INSERT INTO stock_prices (company_id, date, open_price, close_price, high_price, low_price, volume) VALUES
(1, '2023-12-01', 100.50, 102.75, 103.50, 99.75, 1000000),
(1, '2023-12-02', 102.75, 104.25, 105.00, 102.00, 1200000),
(2, '2023-12-01', 75.25, 76.50, 77.25, 74.50, 800000);

-- Sample documents data
INSERT INTO documents (company_id, document_type, document_name, document_url, upload_date) VALUES
(1, 'Annual Report', 'Annual Report 2023', 'https://example.com/docs/annual_report_2023.pdf', '2023-12-01'),
(1, 'Quarterly Report', 'Q3 2023 Report', 'https://example.com/docs/q3_2023.pdf', '2023-10-15'),
(2, 'Annual Report', 'Annual Report 2023', 'https://example.com/docs/fp_annual_2023.pdf', '2023-12-01');

-- Sample media data
INSERT INTO media (company_id, media_type, media_name, media_url, upload_date) VALUES
(1, 'Press Release', 'Q4 Results', 'https://example.com/media/q4_results.pdf', '2023-12-15'),
(1, 'Presentation', 'Investor Day 2023', 'https://example.com/media/investor_day.pptx', '2023-11-30'),
(2, 'Video', 'CEO Interview', 'https://example.com/media/ceo_interview.mp4', '2023-12-10'); 
-- Create users table
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  userName VARCHAR(30) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(40) NOT NULL
) ENGINE=INNODB;

-- Create income transaction table
CREATE TABLE incomeDtl(
incomeid int NOT NULL primary key AUTO_INCREMENT,
description varchar(255),
incometype varchar(255),
amount double(18,2),
user_userID int,
effectivedate date
);

-- Create expense transaction table
CREATE TABLE expenseDtl(
expenseid int NOT NULL primary key AUTO_INCREMENT,
description varchar(255),
amount double(18,2),
expensetype varchar(255),
duedate date,
user_userID int,
createdate date
);

-- Create catagories table
CREATE TABLE category(
categoryid int NOT NULL primary key AUTO_INCREMENT,
description varchar(255)
);

-- INSERT VALUES FOR TESTING

INSERT INTO `users` (`id`, `userName`, `email`, `password`) VALUES
(1, 'PertySlick', 'test@test.com', '3a866a59476fec733575d08d54d870d303e8084e'),
(3, 'Tim Roush', 'perty_slick@outlook.com', '3a866a59476fec733575d08d54d870d303e8084e'),
(4, 'jp', 'jp@jp.com', '0f41a0b3b760b54df703e860e40fef1c388ed2c5');

INSERT INTO `expenseDtl` (`description`, `amount`, `expensetype`, `frequency`, `duedate`, `user_userID`, `createdate`) VALUES
('Safeway Gas', 38.00, 'Gas', 'Monthly', '2017-06-07', 1, '2017-06-08'),
('Target', 123.00, 'Groceries', 'Monthly', '2017-06-05', 1, '2017-06-08'),
('Gamestop', 60.00, 'Recreation', 'Monthly', '2017-06-03', 1, '2017-06-08'),
('WalMart', 32.00, 'Clothing', 'Monthly', '2017-06-05', 1, '2017-06-08'),
('Puget Sound Energy', 125.00, 'Bills', NULL, '2017-06-20', 1, '2017-06-08'),
('King County Sewer', 46.89, 'Bills', NULL, '2017-06-29', 1, '2017-06-08'),
('Visa', 20.00, 'Debt', NULL, '2017-06-20', 1, '2017-06-08'),
('Sears', 380.00, 'Maintenance', NULL, '2017-06-11', 1, '2017-06-11'),
('Home Depot', 435.00, 'Home Improvement', NULL, '2017-06-10', 1, '2017-06-11'),
('Rocklers', 380.00, 'Hobby', NULL, '2017-07-14', 1, '2017-06-12'),
('Gamestop', 60.00, 'Recreation', NULL, '2017-06-10', 3, '2017-06-12');

INSERT INTO `incomeDtl` (`description`, `incometype`, `amount`, `frequency`, `user_userID`, `effectivedate`, `createdate`) VALUES
('Aaron Packaging Inc', 'Paycheck', 300.00, '300.00', 1, '2017-06-05', '2017-06-08'),
('Aaron Packaging Inc', 'Paycheck', 300.00, '300.00', 1, '2017-06-01', '2017-06-08'),
('My Current Job', NULL, 1200.00, NULL, 1, '2017-06-16', '2017-06-08'),
('Debt Repayment', NULL, 300.00, NULL, 1, '2017-06-28', '2017-06-08'),
('My Current Job', NULL, 1400.00, NULL, 1, '2017-06-30', '2017-06-08'),
('My Day Job', 'Paycheck', 3400.00, NULL, 3, '2017-06-17', '2017-06-12'),
('Gamestop', 'Recreation', 59.00, NULL, 1, '2017-07-12', '2017-06-12');
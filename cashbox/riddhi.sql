-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2022 at 08:38 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `riddhi`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill_details`
--

CREATE TABLE `bill_details` (
  `bill_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `bill_description` text NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL COMMENT 'Logged In users Id',
  `salesman_id` int(11) NOT NULL COMMENT 'If the bill is created by a salesman'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bill_details`
--

INSERT INTO `bill_details` (`bill_id`, `customer_id`, `bill_description`, `create_date`, `created_by`, `salesman_id`) VALUES
(56, 10, 'eyJiaWxsSWQiOiIzODIwMjIxODUyMTIiLCJjdXN0b21lcl9pZCI6IjEwIiwiY3VzdG9tZXJfbmFtZSI6ImRlYWxlciBhZGRlZCBieSBTdG9raXN0IiwiY3VzdG9tZXJfYWRkcmVzcyI6ImtvbGthdGEiLCJjdXN0b21lcl9nc3Rpbl9ubyI6IjAwMDAwMDAwIiwiZW1haWxfaWQiOiJkZWFsZWUxQGdtYWlsLmNvbSIsInBob25lX251bWJlciI6IjY2NjY2NjY2NjYiLCJndWVzdFVzZXJQaG9uZSI6IiIsImZpbmVJdGVtcyI6W3siZmluZV9pdGVtX29iaiI6OTgsInNsbm8iOjEsIml0ZW1faWQiOiIyMCIsInByb2R1Y3RzIjoiUmVkIENoaWxsaSBwb3dkZXIgUnMuMTAvLSIsImhzX2NvZGUiOiIyMDAwMSIsInF0eSI6IjUiLCJyYXRlIjoiNy41MCIsImFtb3VudCI6IjM3LjUwIiwidGF4X3ZhbHVlIjoiMS44OCIsImNnc3RfcmF0ZSI6IjIuNTAiLCJjZ3N0X2Ftb3VudCI6IjAuOTQiLCJzZ3N0X3JhdGUiOiIyLjUwIiwic2dzdF9hbW91bnQiOiIwLjk0IiwibmV0X3ZhbHVlIjoiMzkuMzgifV0sImZpbmVJdGVtc1N1YlRvdGFsIjoiMzkuMzgiLCJwYXltZW50VHlwZSI6ImNhc2giLCJzdWJUb3RhbFF0eSI6NSwic3ViVG90YWxBbW91bnQiOiIzNy41MCIsInN1YlRvdGFsVGF4VmFsdWUiOiIxLjg4Iiwic3ViVG90YWxDZ3N0IjoiMC45NCIsInN1YlRvdGFsU2dzdCI6IjAuOTQiLCJyb3VuZGVkVXBGaW5lSXRlbXNTdWJUb3RhbCI6IjM5LjAwIiwidG90YWxDYXNoIjoiMzAuMDAiLCJkdWVDYXNoIjoiOS4wMCIsInRoaXNCaWxsRHVlIjoiMC4wMCIsInJhdGVfdHlwZSI6IjIiLCJyYXRlX3R5cGVfdGV4dCI6ImRlYWxlcl9wcmljZSIsImJfdXNlcl90eXBlIjoiMiJ9', '2022-08-03 13:23:08', 7, 0),
(57, 15, 'eyJiaWxsSWQiOiI1ODIwMjIxOTQ2MTAiLCJjdXN0b21lcl9pZCI6IjE1IiwiY3VzdG9tZXJfbmFtZSI6IlN0b2tpc3Qgb2YgQmFnbmFuIiwiY3VzdG9tZXJfYWRkcmVzcyI6IkJhZ25hbl9Ib3dyYWgiLCJjdXN0b21lcl9nc3Rpbl9ubyI6IjAwMDAwMDAwIiwiZW1haWxfaWQiOiJzdW1hbl9zdG9raXN0QG1haWwuY29tIiwicGhvbmVfbnVtYmVyIjoiODUyNDU2OTUxMiIsImd1ZXN0VXNlclBob25lIjoiIiwiZmluZUl0ZW1zIjpbeyJmaW5lX2l0ZW1fb2JqIjozOSwic2xubyI6MSwiaXRlbV9pZCI6IjIwIiwicHJvZHVjdHMiOiJSZWQgQ2hpbGxpIHBvd2RlciBScy4xMC8tIiwiaHNfY29kZSI6IjIwMDAxIiwicXR5IjoiMTAiLCJyYXRlIjoiNy4wMCIsImFtb3VudCI6IjcwLjAwIiwidGF4X3ZhbHVlIjoiMy41MCIsImNnc3RfcmF0ZSI6IjIuNTAiLCJjZ3N0X2Ftb3VudCI6IjEuNzUiLCJzZ3N0X3JhdGUiOiIyLjUwIiwic2dzdF9hbW91bnQiOiIxLjc1IiwibmV0X3ZhbHVlIjoiNzMuNTAifV0sImZpbmVJdGVtc1N1YlRvdGFsIjoiNzMuNTAiLCJwYXltZW50VHlwZSI6ImNhc2giLCJzdWJUb3RhbFF0eSI6MTAsInN1YlRvdGFsQW1vdW50IjoiNzAuMDAiLCJzdWJUb3RhbFRheFZhbHVlIjoiMy41MCIsInN1YlRvdGFsQ2dzdCI6IjEuNzUiLCJzdWJUb3RhbFNnc3QiOiIxLjc1Iiwicm91bmRlZFVwRmluZUl0ZW1zU3ViVG90YWwiOiI3NC4wMCIsInRvdGFsQ2FzaCI6Ijc0LjAwIiwiZHVlQ2FzaCI6IjAuMDAiLCJ0aGlzQmlsbER1ZSI6IjAuMDAiLCJyYXRlX3R5cGUiOiIxIiwicmF0ZV90eXBlX3RleHQiOiJzdG9raXN0X3ByaWNlIiwiYl91c2VyX3R5cGUiOiIxIiwiY3JlYXRlZEJ5Ijp7Im9yZ19uYW1lIjoiUmlkZGhpbWEgRW50ZXJwcmlzZSIsImFkZHJlc3MiOiIxNjM3LEJhYmFucHVyIGxvY2sgZ2F0ZSBCZW5nYWwgRW5hbWVsLCAyNCBwZ3MoTikgNzQzMTIyIFdlc3QgQmVuZ2FsLCBJbmRpYSIsImNvbnRhY3Rfbm8iOiI5NzMzOTM1MTYxIiwiZ3N0aW5fbm8iOiIwMDAwMDAwMCIsImVtYWlsIjoic3VtYW5AZ21haWwuY29tIn19', '2022-08-10 12:53:20', 2, 0),
(58, 15, 'eyJiaWxsSWQiOiI2ODIwMjIxNjQ4MjEiLCJjdXN0b21lcl9pZCI6IjE1IiwiY3VzdG9tZXJfbmFtZSI6IlN0b2tpc3Qgb2YgQmFnbmFuIiwiY3VzdG9tZXJfYWRkcmVzcyI6IkJhZ25hbl9Ib3dyYWgiLCJjdXN0b21lcl9nc3Rpbl9ubyI6IjAwMDAwMDAwIiwiZW1haWxfaWQiOiJzdW1hbl9zdG9raXN0QG1haWwuY29tIiwicGhvbmVfbnVtYmVyIjoiODUyNDU2OTUxMiIsImd1ZXN0VXNlclBob25lIjoiIiwiZmluZUl0ZW1zIjpbeyJmaW5lX2l0ZW1fb2JqIjozMCwic2xubyI6MSwiaXRlbV9pZCI6IjIwIiwicHJvZHVjdHMiOiJSZWQgQ2hpbGxpIHBvd2RlciBScy4xMC8tIiwiaHNfY29kZSI6IjIwMDAxIiwicXR5IjoiMTAiLCJyYXRlIjoiNy4wMCIsImFtb3VudCI6IjcwLjAwIiwidGF4X3ZhbHVlIjoiMy41MCIsImNnc3RfcmF0ZSI6IjIuNTAiLCJjZ3N0X2Ftb3VudCI6IjEuNzUiLCJzZ3N0X3JhdGUiOiIyLjUwIiwic2dzdF9hbW91bnQiOiIxLjc1IiwibmV0X3ZhbHVlIjoiNzMuNTAifV0sImZpbmVJdGVtc1N1YlRvdGFsIjoiNzMuNTAiLCJwYXltZW50VHlwZSI6ImNhc2giLCJzdWJUb3RhbFF0eSI6MTAsInN1YlRvdGFsQW1vdW50IjoiNzAuMDAiLCJzdWJUb3RhbFRheFZhbHVlIjoiMy41MCIsInN1YlRvdGFsQ2dzdCI6IjEuNzUiLCJzdWJUb3RhbFNnc3QiOiIxLjc1Iiwicm91bmRlZFVwRmluZUl0ZW1zU3ViVG90YWwiOiI3NC4wMCIsInRvdGFsQ2FzaCI6Ijc0IiwiZHVlQ2FzaCI6IjAuMDAiLCJ0aGlzQmlsbER1ZSI6IjAuMDAiLCJyYXRlX3R5cGUiOiIxIiwicmF0ZV90eXBlX3RleHQiOiJzdG9raXN0X3ByaWNlIiwiYl91c2VyX3R5cGUiOiIxIiwiY3JlYXRlZEJ5Ijp7Im9yZ19uYW1lIjoiUmlkZGhpbWEgRW50ZXJwcmlzZSIsImFkZHJlc3MiOiIxNjM3LEJhYmFucHVyIGxvY2sgZ2F0ZSBCZW5nYWwgRW5hbWVsLCAyNCBwZ3MoTikgNzQzMTIyIFdlc3QgQmVuZ2FsLCBJbmRpYSIsImNvbnRhY3Rfbm8iOiI5NzMzOTM1MTYxIiwiZ3N0aW5fbm8iOiIwMDAwMDAwMCIsImVtYWlsIjoic3VtYW5AZ21haWwuY29tIn19', '2022-08-10 12:52:38', 2, 0),
(59, 15, 'eyJiaWxsSWQiOiI2ODIwMjIxNjQ5MjAiLCJjdXN0b21lcl9pZCI6IjE1IiwiY3VzdG9tZXJfbmFtZSI6IlN0b2tpc3Qgb2YgQmFnbmFuIiwiY3VzdG9tZXJfYWRkcmVzcyI6IkJhZ25hbl9Ib3dyYWgiLCJjdXN0b21lcl9nc3Rpbl9ubyI6IjAwMDAwMDAwIiwiZW1haWxfaWQiOiJzdW1hbl9zdG9raXN0QG1haWwuY29tIiwicGhvbmVfbnVtYmVyIjoiODUyNDU2OTUxMiIsImd1ZXN0VXNlclBob25lIjoiIiwiZmluZUl0ZW1zIjpbeyJmaW5lX2l0ZW1fb2JqIjo2Niwic2xubyI6MSwiaXRlbV9pZCI6IjIwIiwicHJvZHVjdHMiOiJSZWQgQ2hpbGxpIHBvd2RlciBScy4xMC8tIiwiaHNfY29kZSI6IjIwMDAxIiwicXR5IjoiNSIsInJhdGUiOiI3LjAwIiwiYW1vdW50IjoiMzUuMDAiLCJ0YXhfdmFsdWUiOiIxLjc2IiwiY2dzdF9yYXRlIjoiMi41MCIsImNnc3RfYW1vdW50IjoiMC44OCIsInNnc3RfcmF0ZSI6IjIuNTAiLCJzZ3N0X2Ftb3VudCI6IjAuODgiLCJuZXRfdmFsdWUiOiIzNi43NiJ9XSwiZmluZUl0ZW1zU3ViVG90YWwiOiIzNi43NiIsInBheW1lbnRUeXBlIjoiY2FzaCIsInN1YlRvdGFsUXR5Ijo1LCJzdWJUb3RhbEFtb3VudCI6IjM1LjAwIiwic3ViVG90YWxUYXhWYWx1ZSI6IjEuNzYiLCJzdWJUb3RhbENnc3QiOiIwLjg4Iiwic3ViVG90YWxTZ3N0IjoiMC44OCIsInJvdW5kZWRVcEZpbmVJdGVtc1N1YlRvdGFsIjoiMzcuMDAiLCJ0b3RhbENhc2giOiIzNi41MCIsImR1ZUNhc2giOiIwLjUwIiwidGhpc0JpbGxEdWUiOiIwLjAwIiwicmF0ZV90eXBlIjoiMSIsInJhdGVfdHlwZV90ZXh0Ijoic3Rva2lzdF9wcmljZSIsImJfdXNlcl90eXBlIjoiMSIsImNyZWF0ZWRCeSI6eyJvcmdfbmFtZSI6IlJpZGRoaW1hIEVudGVycHJpc2UiLCJhZGRyZXNzIjoiMTYzNyxCYWJhbnB1ciBsb2NrIGdhdGUgQmVuZ2FsIEVuYW1lbCwgMjQgcGdzKE4pIDc0MzEyMiBXZXN0IEJlbmdhbCwgSW5kaWEiLCJjb250YWN0X25vIjoiOTczMzkzNTE2MSIsImdzdGluX25vIjoiMDAwMDAwMDAiLCJlbWFpbCI6InN1bWFuQGdtYWlsLmNvbSJ9fQ==', '2022-08-10 12:51:29', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cashbook_entry`
--

CREATE TABLE `cashbook_entry` (
  `cb_id` int(11) NOT NULL,
  `receive_payment` enum('0','1') NOT NULL COMMENT '0=Receive, 1=Payment',
  `cb_narration` varchar(255) NOT NULL,
  `cb_amount` decimal(10,2) NOT NULL,
  `cb_date` datetime NOT NULL,
  `cb_created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cashbook_entry`
--

INSERT INTO `cashbook_entry` (`cb_id`, `receive_payment`, `cb_narration`, `cb_amount`, `cb_date`, `cb_created_by`) VALUES
(1, '0', 'Cash in Hand', '10000.00', '2022-08-09 00:00:00', 2),
(3, '1', 'staff salary', '10000.00', '2022-08-09 00:00:00', 2),
(4, '0', 'Cash Receoved by Bill: 59', '4.00', '2022-08-10 00:00:00', 2),
(5, '1', 'Sale Return by Bill: 58', '52.00', '2022-08-10 00:00:00', 2),
(6, '0', 'Cash Received by Bill: 57', '74.00', '2022-08-10 00:00:00', 2),
(7, '0', 'Cash Received by Bill Number: 58', '75.00', '2022-08-11 00:00:00', 2),
(8, '0', 'Cash Received by Bill: 57', '70.00', '2022-08-10 00:00:00', 2),
(9, '0', 'Cash Received by Bill: 111', '70.00', '2022-08-10 00:00:00', 2),
(10, '1', 'staff salary payment', '6700.00', '2022-08-10 00:00:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `customer_master`
--

CREATE TABLE `customer_master` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `customer_gstin_no` varchar(25) NOT NULL,
  `customer_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_master`
--

INSERT INTO `customer_master` (`customer_id`, `customer_name`, `phone_number`, `customer_address`, `customer_gstin_no`, `customer_email`) VALUES
(1, 'Sarkar Enterprise', '9563111173', 'Maynaguri 735224', '19ERDPS0703L1ZJ', 'customer@mail.com'),
(3, 'sumanjnaa', '9733935161', 'beltala agunshi', '0000', 'sumanjana.6@gmail.com'),
(4, 'Trishaan', '8420359853', 'uluberia', '000000', 'trishaan@mail.com'),
(5, 'sumanjnaa', '9733935161', 'beltala agunshi', '123', 'email@suman.com');

-- --------------------------------------------------------

--
-- Table structure for table `item_master`
--

CREATE TABLE `item_master` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `hs_code` varchar(20) NOT NULL,
  `cgst_rate` decimal(10,2) NOT NULL,
  `sgst_rate` decimal(10,2) NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `stokist_price` decimal(10,2) NOT NULL,
  `dealer_price` decimal(10,2) NOT NULL,
  `wholesaler_price` decimal(10,2) NOT NULL,
  `retailer_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item_master`
--

INSERT INTO `item_master` (`item_id`, `item_name`, `hs_code`, `cgst_rate`, `sgst_rate`, `item_quantity`, `stokist_price`, `dealer_price`, `wholesaler_price`, `retailer_price`) VALUES
(19, 'Turmaric Powder Rs.5/-', '10001', '2.50', '2.50', 0, '2.50', '3.00', '3.50', '4.00'),
(20, 'Red Chilli powder Rs.10/-', '20001', '2.50', '2.50', 0, '7.00', '7.50', '8.00', '8.50');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `login_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_type` enum('0','1','2','3','4','5') NOT NULL COMMENT '0=superadmin, 1=Stockist, 2=Dealer, 3=Wholesaler, 4=Retailer, 5=SalesMan',
  `user_data` text NOT NULL,
  `salesman_id` int(11) NOT NULL COMMENT 'login_id is the salesman id',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `stock_quantity` text NOT NULL,
  `net_due_amount` decimal(10,2) NOT NULL,
  `bank_ac_info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `username`, `password`, `user_type`, `user_data`, `salesman_id`, `created_by`, `created_on`, `stock_quantity`, `net_due_amount`, `bank_ac_info`) VALUES
(2, '9733935161', '9733935161', '0', '{\"org_name\":\"Riddhima Enterprise\",\"contact_person\":\"Rajesh Biswash\",\"phone_number\":\"9733935161\",\"whatsapp_number\":\"9733935161\",\"email_id\":\"suman@gmail.com\",\"address\":\"1637,Babanpur lock gate Bengal Enamel, 24 pgs(N) 743122 West Bengal, India\",\"pin_code\":\"700110\",\"gstin_no\":\"00000000\"}', 0, 0, '2022-08-10 18:23:04', '[{\"hs_code\":\"10001\",\"item_quantity\":525,\"item_id\":19},{\"hs_code\":\"20001\",\"item_quantity\":515,\"item_id\":20}]', '0.00', '{\"bank_name\":\"State Bank of India\",\"branch_name\":\"Anandamath, Icchapore\",\"acc_no\":\"40015926141\",\"ac_name\":\"Ms Riddhima Enterprise\",\"ifsc_code\":\"SBIN0017370\",\"branch_code\":\"17370\"}'),
(7, '9999999999', '9999999999', '1', '{\"org_name\":\"SuperAdmins stockis\",\"contact_person\":\"suman\",\"phone_number\":\"9999999999\",\"whatsapp_number\":\"9999999999\",\"email_id\":\"suman@ordering.co\",\"address\":\"ichhapore\",\"pin_code\":\"700110\",\"gstin_no\":\"00000000\"}', 0, 2, '2022-08-04 20:06:21', '[{\"hs_code\":\"20001\",\"item_quantity\":-5,\"item_id\":\"20\"}]', '1035.00', '{\"bank_name\":\"\",\"branch_name\":\"\",\"acc_no\":\"\",\"ac_name\":\"\",\"ifsc_code\":\"\",\"branch_code\":\"\"}'),
(8, '8888888888', '8888888888', '5', '{\"org_name\":\"Superadmins salesMan\",\"contact_person\":\"Sales Man 1\",\"phone_number\":\"8888888888\",\"whatsapp_number\":\"8888888888\",\"email_id\":\"suman@ordering.co\",\"address\":\"beltala agunshi\",\"pin_code\":\"711303\",\"gstin_no\":\"00000000\"}', 0, 2, '2022-08-03 19:16:01', '', '0.00', '{\"bank_name\":\"\",\"branch_name\":\"\",\"acc_no\":\"\",\"ac_name\":\"\",\"ifsc_code\":\"\",\"branch_code\":\"\"}'),
(9, '7777777777', '7777777777', '2', '{\"org_name\":\"dealer of super admin\",\"contact_person\":\"added by salesman\",\"phone_number\":\"7777777777\",\"whatsapp_number\":\"7777777777\",\"email_id\":\"sealer@superadmin.com\",\"address\":\"kolkata\",\"pin_code\":\"700110\",\"gstin_no\":\"00000000\"}', 8, 2, '2022-08-03 19:16:04', '[{\"hs_code\":\"20001\",\"item_quantity\":0,\"item_id\":\"20\"}]', '0.00', '{\"bank_name\":\"\",\"branch_name\":\"\",\"acc_no\":\"\",\"ac_name\":\"\",\"ifsc_code\":\"\",\"branch_code\":\"\"}'),
(10, '6666666666', '6666666666', '2', '{\"org_name\":\"dealer added by Stokist\",\"contact_person\":\"Dealer of stokist\",\"phone_number\":\"6666666666\",\"whatsapp_number\":\"6666666666\",\"email_id\":\"dealee1@gmail.com\",\"address\":\"kolkata\",\"pin_code\":\"700110\",\"gstin_no\":\"00000000\"}', 0, 7, '2022-08-03 18:53:08', '[{\"hs_code\":\"20001\",\"item_quantity\":5,\"item_id\":\"20\"}]', '88.00', ''),
(11, '5555555555', '5555555555', '5', '{\"org_name\":\"New salesman of stokist\",\"contact_person\":\"salesman 2\",\"phone_number\":\"5555555555\",\"whatsapp_number\":\"5555555555\",\"email_id\":\"salesman2@gmail.com\",\"address\":\"kolkata\",\"pin_code\":\"700110\",\"gstin_no\":\"00000000\"}', 0, 7, '2022-08-03 19:16:07', '', '0.00', '{\"bank_name\":\"\",\"branch_name\":\"\",\"acc_no\":\"\",\"ac_name\":\"\",\"ifsc_code\":\"\",\"branch_code\":\"\"}'),
(12, '4444444444', '4444444444', '3', '{\"org_name\":\"Wholesaler added by Salesman\",\"contact_person\":\"wholesaler 1\",\"phone_number\":\"4444444444\",\"whatsapp_number\":\"4444444444\",\"email_id\":\"wholesaler@gmail.com\",\"address\":\"kolkata\",\"pin_code\":\"700110\",\"gstin_no\":\"00000000\"}', 11, 7, '2022-08-03 19:16:11', '', '0.00', '{\"bank_name\":\"\",\"branch_name\":\"\",\"acc_no\":\"\",\"ac_name\":\"\",\"ifsc_code\":\"\",\"branch_code\":\"\"}'),
(13, '3333333333', '3333333333', '4', '{\"org_name\":\"New Retailer\",\"contact_person\":\"by Super admin\",\"phone_number\":\"3333333333\",\"whatsapp_number\":\"3333333333\",\"email_id\":\"retailer@gmail.com\",\"address\":\"kolkata\",\"pin_code\":\"700110\",\"gstin_no\":\"00000000\"}', 0, 2, '2022-08-04 20:06:35', '[{\"hs_code\":\"20001\",\"item_quantity\":-90,\"item_id\":\"20\"}]', '94.00', '{\"bank_name\":\"\",\"branch_name\":\"\",\"acc_no\":\"\",\"ac_name\":\"\",\"ifsc_code\":\"\",\"branch_code\":\"\"}'),
(14, '9674614071', '9674614071', '4', '{\"org_name\":\"Aruna Enterprise\",\"contact_person\":\"Aruna Jana\",\"phone_number\":\"9674614071\",\"whatsapp_number\":\"9674614071\",\"email_id\":\"aruna@gmail.com\",\"address\":\"Bhuarah, agunshi, bagnan, Howrah. Pin 711303\",\"pin_code\":\"711303\",\"gstin_no\":\"00000000\"}', 0, 2, '2022-08-04 20:06:44', '[{\"hs_code\":\"20001\",\"item_quantity\":-95,\"item_id\":\"20\"},{\"hs_code\":\"10001\",\"item_quantity\":-20,\"item_id\":\"19\"}]', '932.00', '{\"bank_name\":\"\",\"branch_name\":\"\",\"acc_no\":\"\",\"ac_name\":\"\",\"ifsc_code\":\"\",\"branch_code\":\"\"}'),
(15, '8524569512', '8524569512', '1', '{\"org_name\":\"Stokist of Bagnan\",\"contact_person\":\"Suman jana\",\"phone_number\":\"8524569512\",\"whatsapp_number\":\"8524569512\",\"email_id\":\"suman_stokist@mail.com\",\"address\":\"Bagnan Howrah\",\"pin_code\":\"711303\",\"gstin_no\":\"00000000\"}', 0, 2, '2022-08-10 18:23:20', '[{\"hs_code\":\"20001\",\"item_quantity\":25,\"item_id\":\"20\"}]', '0.50', '{\"bank_name\":\"\",\"branch_name\":\"\",\"acc_no\":\"\",\"ac_name\":\"\",\"ifsc_code\":\"\",\"branch_code\":\"\"}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill_details`
--
ALTER TABLE `bill_details`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `cashbook_entry`
--
ALTER TABLE `cashbook_entry`
  ADD PRIMARY KEY (`cb_id`);

--
-- Indexes for table `customer_master`
--
ALTER TABLE `customer_master`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `item_master`
--
ALTER TABLE `item_master`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill_details`
--
ALTER TABLE `bill_details`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `cashbook_entry`
--
ALTER TABLE `cashbook_entry`
  MODIFY `cb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customer_master`
--
ALTER TABLE `customer_master`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `item_master`
--
ALTER TABLE `item_master`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

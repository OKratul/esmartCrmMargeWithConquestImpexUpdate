-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2024 at 02:11 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esmart_crm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `conquest_accounts`
--

CREATE TABLE `conquest_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `total_cash_in` varchar(255) DEFAULT NULL,
  `total_cash_out` varchar(255) DEFAULT NULL,
  `balance` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conquest_accounts`
--

INSERT INTO `conquest_accounts` (`id`, `account_name`, `account_number`, `total_cash_in`, `total_cash_out`, `balance`, `created_at`, `updated_at`) VALUES
(1, 'dbbl', '01254365987458', NULL, NULL, '130000', '2024-02-13 10:27:06', '2024-02-13 12:29:01');

-- --------------------------------------------------------

--
-- Table structure for table `conquest_customers`
--

CREATE TABLE `conquest_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email2` varchar(255) NOT NULL,
  `address` longtext NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `contact_person_number` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conquest_customers`
--

INSERT INTO `conquest_customers` (`id`, `name`, `phone`, `email`, `email2`, `address`, `contact_person`, `contact_person_number`, `created_at`, `updated_at`) VALUES
(1, 'omar khaiyam', '01647667927', 'omarkhaiyamratul@gmail.com', 'okratul21@gmail.com', 'bashundhara house353', 'omar khaiyam', '01703064636', '2024-02-13 08:57:43', '2024-02-13 08:57:43');

-- --------------------------------------------------------

--
-- Table structure for table `conquest_expense_names`
--

CREATE TABLE `conquest_expense_names` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conquest_histories`
--

CREATE TABLE `conquest_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `historable_id` bigint(20) UNSIGNED NOT NULL,
  `historable_type` varchar(255) NOT NULL,
  `previous_stock` int(11) NOT NULL,
  `updated_stock` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conquest_histories`
--

INSERT INTO `conquest_histories` (`id`, `historable_id`, `historable_type`, `previous_stock`, `updated_stock`, `created_at`, `updated_at`) VALUES
(1, 1, 'App\\Models\\conquest\\ConquestProductStock', -40, 65, '2024-02-13 10:43:49', '2024-02-13 10:43:49'),
(2, 1, 'App\\Models\\conquest\\ConquestProduct', -40, 65, '2024-02-13 10:43:49', '2024-02-13 10:43:49'),
(3, 1, 'App\\Models\\conquest\\ConquestProductStock', 10, 69, '2024-02-13 10:51:10', '2024-02-13 10:51:10'),
(4, 1, 'App\\Models\\conquest\\ConquestProduct', 10, 69, '2024-02-13 10:51:10', '2024-02-13 10:51:10'),
(5, 1, 'App\\Models\\conquest\\ConquestProductStock', -16, 119, '2024-02-14 10:39:05', '2024-02-14 10:39:05'),
(6, 1, 'App\\Models\\conquest\\ConquestProduct', -16, 119, '2024-02-14 10:39:05', '2024-02-14 10:39:05'),
(7, 1, 'App\\Models\\conquest\\ConquestProductStock', 34, 129, '2024-02-14 10:39:34', '2024-02-14 10:39:34'),
(8, 1, 'App\\Models\\conquest\\ConquestProduct', 34, 129, '2024-02-14 10:39:34', '2024-02-14 10:39:34');

-- --------------------------------------------------------

--
-- Table structure for table `conquest_invoices`
--

CREATE TABLE `conquest_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `unit_price` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL,
  `all_total_price` varchar(255) NOT NULL,
  `delivery_charge` varchar(255) NOT NULL,
  `paid` varchar(255) NOT NULL,
  `due` varchar(255) NOT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `extra_name` varchar(255) DEFAULT NULL,
  `extra_price` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `warranty` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conquest_invoices`
--

INSERT INTO `conquest_invoices` (`id`, `invoice_number`, `customer_id`, `product_id`, `quantity`, `unit_price`, `total_price`, `all_total_price`, `delivery_charge`, `paid`, `due`, `discount`, `extra_name`, `extra_price`, `status`, `warranty`, `date`, `created_at`, `updated_at`) VALUES
(3, '2305506213', 1, 'NP-4637+NP-4637', '10+10', '8000+7000', '70000+80000', '70000', '200', '70000', '0', '300', NULL, NULL, 'not sent', NULL, '2024-02-13', '2024-02-13 10:57:15', '2024-02-13 12:29:01');

-- --------------------------------------------------------

--
-- Table structure for table `conquest_payments`
--

CREATE TABLE `conquest_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pay_amount` varchar(255) NOT NULL,
  `pay_type` varchar(255) NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conquest_payments`
--

INSERT INTO `conquest_payments` (`id`, `customer_id`, `invoice_id`, `pay_amount`, `pay_type`, `invoice_no`, `date`, `created_at`, `updated_at`) VALUES
(4, 1, 3, '50000', 'Bank Transfer', '2305506213', '2024-02-13', '2024-02-13 12:29:01', '2024-02-13 12:29:01');

-- --------------------------------------------------------

--
-- Table structure for table `conquest_products`
--

CREATE TABLE `conquest_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `buying_price` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conquest_products`
--

INSERT INTO `conquest_products` (`id`, `product_code`, `name`, `size`, `quantity`, `buying_price`, `created_at`, `updated_at`) VALUES
(1, 'NP-4637', 'new product', 'pcs', '44', '5000', '2024-02-13 08:59:01', '2024-02-14 10:39:34');

-- --------------------------------------------------------

--
-- Table structure for table `conquest_product_stocks`
--

CREATE TABLE `conquest_product_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `add_qty` varchar(255) NOT NULL,
  `added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conquest_product_stocks`
--

INSERT INTO `conquest_product_stocks` (`id`, `product_id`, `add_qty`, `added`, `created_at`, `updated_at`) VALUES
(1, 1, '129', '2024-02-14 10:39:34', '2024-02-13 08:59:01', '2024-02-14 10:39:34');

-- --------------------------------------------------------

--
-- Table structure for table `conquest_transections`
--

CREATE TABLE `conquest_transections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `transection_note` varchar(255) DEFAULT NULL,
  `amount` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `conquest_transections`
--

INSERT INTO `conquest_transections` (`id`, `account_id`, `invoice_id`, `status`, `transection_note`, `amount`, `created_at`, `updated_at`) VALUES
(2, 1, 3, 'Cash In', NULL, '50000', '2024-02-13 12:29:01', '2024-02-13 12:29:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conquest_accounts`
--
ALTER TABLE `conquest_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conquest_customers`
--
ALTER TABLE `conquest_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conquest_expense_names`
--
ALTER TABLE `conquest_expense_names`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conquest_histories`
--
ALTER TABLE `conquest_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conquest_invoices`
--
ALTER TABLE `conquest_invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `conquest_invoices_invoice_number_unique` (`invoice_number`),
  ADD KEY `conquest_invoices_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `conquest_payments`
--
ALTER TABLE `conquest_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conquest_payments_customer_id_foreign` (`customer_id`),
  ADD KEY `conquest_payments_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `conquest_products`
--
ALTER TABLE `conquest_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conquest_product_stocks`
--
ALTER TABLE `conquest_product_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conquest_product_stocks_product_id_foreign` (`product_id`);

--
-- Indexes for table `conquest_transections`
--
ALTER TABLE `conquest_transections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conquest_transections_account_id_foreign` (`account_id`),
  ADD KEY `conquest_transections_invoice_id_foreign` (`invoice_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `conquest_accounts`
--
ALTER TABLE `conquest_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `conquest_customers`
--
ALTER TABLE `conquest_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `conquest_expense_names`
--
ALTER TABLE `conquest_expense_names`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conquest_histories`
--
ALTER TABLE `conquest_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `conquest_invoices`
--
ALTER TABLE `conquest_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `conquest_payments`
--
ALTER TABLE `conquest_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `conquest_products`
--
ALTER TABLE `conquest_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `conquest_product_stocks`
--
ALTER TABLE `conquest_product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `conquest_transections`
--
ALTER TABLE `conquest_transections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `conquest_invoices`
--
ALTER TABLE `conquest_invoices`
  ADD CONSTRAINT `conquest_invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `conquest_customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `conquest_payments`
--
ALTER TABLE `conquest_payments`
  ADD CONSTRAINT `conquest_payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `conquest_customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conquest_payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `conquest_invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `conquest_product_stocks`
--
ALTER TABLE `conquest_product_stocks`
  ADD CONSTRAINT `conquest_product_stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `conquest_products` (`id`);

--
-- Constraints for table `conquest_transections`
--
ALTER TABLE `conquest_transections`
  ADD CONSTRAINT `conquest_transections_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `conquest_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conquest_transections_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `conquest_invoices` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

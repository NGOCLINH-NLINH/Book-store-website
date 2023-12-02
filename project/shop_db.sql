-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2022 at 01:54 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--


CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE products CHANGE COLUMN productId product_id int(100) NOT NULL AUTO_INCREMENT;


CREATE TABLE users (
	user_id INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `user_type` VARCHAR(20) NOT NULL,
    `address` VARCHAR(500),
    `phone` VARCHAR(5)
);

ALTER TABLE orders 
ADD CONSTRAINT fk_orders_users FOREIGN KEY (user_id)
REFERENCES users (user_id);

SELECT o.*,
(SELECT u.name
FROM users u
WHERE u.user_id = o.user_id) AS name,
(SELECT u.phone
FROM users u
WHERE u.user_id = o.user_id) AS phone,
(SELECT u.email
FROM users u
WHERE u.user_id = o.user_id) AS email,
(SELECT u.address
FROM users u
WHERE u.user_id = o.user_id) AS address
FROM orders o;

CREATE TABLE cart (
	cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    CONSTRAINT fk_cart_products FOREIGN KEY (product_id)
    REFERENCES products (product_id)
);

ALTER TABLE cart
ADD CONSTRAINT fk_cart_users FOREIGN KEY (user_id)
REFERENCES users (user_id);

SELECT * FROM orders;

SELECT c.cart_id, c.quantity,
(SELECT p.name
FROM products p
WHERE p.product_id = c.product_id) AS name,
(SELECT p.image
FROM products p
WHERE p.product_id = c.product_id) AS image,
(SELECT p.price
FROM products p
WHERE p.product_id = c.product_id) AS price
FROM cart c;

SELECT c.cart_id, c.quantity,
(SELECT p.name
FROM products p
WHERE p.product_id = c.product_id) AS name,
(SELECT p.image
FROM products p
WHERE p.product_id = c.product_id) AS image,
(SELECT p.price
FROM products p
WHERE p.product_id = c.product_id) AS price
FROM cart c;

SELECT c.*
FROM cart c
JOIN products p ON c.product_id  = p.product_id
JOIN users u ON c.user_id = u.user_id 
WHERE p.name ='Python Object-Oriented Programming'
AND c.user_id = 1;

ALTER TABLE orders
ADD COLUMN cart_id INT;
ALTER TABLE orders
ADD CONSTRAINT fk_orders_cart FOREIGN KEY (cart_id)
REFERENCES cart (cart_id);

ALTER TABLE orders
DROP COLUMN cart_id;

ALTER TABLE orders
ADD CONSTRAINT fk_orders_products 
FOREIGN KEY (product_id) REFERENCES products (product_id);

ALTER TABLE orders
ADD COLUMN required_date DATE;

CREATE TABLE orders_temp LIKE orders;

ALTER TABLE orders_temp
ADD COLUMN placed_on DATE NOT NULL;

DELETE FROM orders WHERE user_id = 1;

INSERT INTO orders VALUE
('10', '1', 'cash on delivery', ', Probability Theory (2) , Fundamentals of Physics (10th edition) (1) , Fundamentals of Database Systems (1) ', '190', 'completed', NULL, NULL, '2023-11-29', '2023-12-3'),
('11', '1', 'cash on delivery', ', Discrete Mathemetics and Its Applications (1) , Fundamentals of Database Systems (1) ', '100', 'pending', NULL, NULL, '2023-11-30', '2023-12-5');

INSERT INTO orders
SELECT * FROM orders_temp;


INSERT INTO orders_temp
SELECT * FROM orders;

CREATE TABLE orders
(
	id INT auto_increment,
    user_id int,
    method VARCHAR(50) NOT NULL,
    payment_status VARCHAR(20),
    product_id INT,
    quantity INT not null,
    placed_on DATE not null,
    required_date DATE not null,
    PRIMARY KEY(id, user_id, product_id),
    CONSTRAINT fk_orders_users FOREIGN KEY (user_id) REFERENCES users(user_id),
    CONSTRAINT fk_orders_product FOREIGN KEY (product_id) REFERENCES products(product_id)
);

INSERT INTO orders
VALUE ('10', '1', 'cash on delivery', 'completed', '5', '2', '2023-11-29', '2023-12-03'),
('10', '1', 'cash on delivery', 'completed', '3', '1', '2023-11-29', '2023-12-03'),
('10', '1', 'cash on delivery', 'completed', '2', '1', '2023-11-29', '2023-12-03'),
('11', '1', 'cash on delivery', 'pending', '1', '1', '2023-11-30', '2023-12-05'),
('11', '1', 'cash on delivery', 'pending', '2', '1', '2023-11-30', '2023-12-05'),
('12', '3', 'cash on delivery', 'pending', '6', '3', '2023-12-01', '2023-12-08');


SET sql_mode = '';
SELECT o.*, u.name, u.phone, u.email, u.address,
SUM(p.price * o.quantity) AS total_price,
GROUP_CONCAT(CONCAT(p.name, ' (', o.quantity, ')') SEPARATOR ', ') AS total_products
FROM orders o
JOIN products p ON o.product_id = p.product_id
JOIN users u ON u.user_id = o.user_id
GROUP BY o.id;


SELECT
SUM(p.price * o.quantity) AS total_price
FROM orders o
JOIN products p ON o.product_id = p.product_id
WHERE o.payment_status = 'pending';







CREATE DATABASE IF NOT EXISTS robocart;

USE robocart;

-- Drop existing tables if they exist
DROP TABLE IF EXISTS `admin`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `contact_us`;
DROP TABLE IF EXISTS `pages`;
DROP TABLE IF EXISTS `password_resets`;
DROP TABLE IF EXISTS `bookings`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `product_categories`;

-- Table structure for table `admin`
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample admin user
INSERT INTO `admin` (`UserName`, `Password`) VALUES
('admin', '$2y$10$rd1xWmcPp2ECp7nYwimO0e41w6bCZKpfUqOHnYOkilU5gVlc7Xxh2');

-- Table structure for table `users`
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` ENUM('user', 'admin') DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE users ADD COLUMN name VARCHAR(255) NOT NULL;
ALTER TABLE users ADD COLUMN contact VARCHAR(255) NOT NULL;
ALTER TABLE users ADD COLUMN address VARCHAR(255) NOT NULL;
ALTER TABLE users ADD COLUMN state VARCHAR(255) NOT NULL;
ALTER TABLE users ADD COLUMN mobile VARCHAR(20) NOT NULL;
ALTER TABLE users ADD COLUMN phone VARCHAR(20) NOT NULL;
ALTER TABLE users ADD COLUMN pin VARCHAR(10) NOT NULL;

-- Insert sample admin user
INSERT INTO `users` (`username`, `password`, `email`, `role`) VALUES
('admin', '$2y$10$rd1xWmcPp2ECp7nYwimO0e41w6bCZKpfUqOHnYOkilU5gVlc7Xxh2', 'admin@robocart.com', 'admin');

-- Table structure for table `products`
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE products ADD discount DECIMAL(5, 2) DEFAULT 0;

-- Insert sample data into `products` table
INSERT INTO `products` (`name`, `description`, `price`, `image`) VALUES
('Beginner Kit', 'Perfect for those new to robotics, this kit includes all the essentials to get started.', 2184.00, 'assets/img/begginerskit.png');

-- Table structure for table `orders`
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Create a view to calculate total orders for user-specific data
CREATE OR REPLACE VIEW total_orders AS
SELECT user_id, COUNT(*) AS total_orders
FROM orders
GROUP BY user_id;

-- Verify total orders for a specific user
SELECT * FROM total_orders WHERE user_id = 1;

-- If no data is shown, insert sample data into `orders` table with multiple products
INSERT INTO orders (user_id, product_id, quantity, payment_method, address, total_price, status)
VALUES 
(1, 1, 2, 'Credit Card', '123 Main St, City, State, 12345', 4368.00, 'Pending'),
(2, 1, 1, 'PayPal', '456 Elm St, City, State, 67890', 2184.00, 'Shipped'),
(3, 2, 3, 'Debit Card', '789 Oak St, City, State, 11223', 6540.00, 'Delivered');

-- Create a table for order management in the admin dashboard
CREATE TABLE IF NOT EXISTS order_management (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  user_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  total_price DECIMAL(10, 2) NOT NULL,
  status VARCHAR(50) DEFAULT 'Pending',
  order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Add a trigger to automatically store orders in the order management table
DELIMITER //
CREATE TRIGGER after_order_insert
AFTER INSERT ON orders
FOR EACH ROW
BEGIN
  INSERT INTO order_management (order_id, user_id, product_id, quantity, total_price, status, order_date)
  VALUES (NEW.id, NEW.user_id, NEW.product_id, NEW.quantity, NEW.total_price, NEW.status, NEW.order_date);
END;
//
DELIMITER ;

-- Allow admin to update the status of orders in the order management table
UPDATE order_management
SET status = 'Shipped'
WHERE id = 1;

-- Verify the updated order management table
SELECT * FROM order_management;


-- Verify again
SELECT * FROM total_orders;

-- Table structure for table `contact_us`
CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `posting_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `contact_us_page`
CREATE TABLE contact_us_page (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_title VARCHAR(255) NOT NULL,
    page_content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Modify the `contact_us_page` table to store user-submitted details
ALTER TABLE contact_us_page
ADD COLUMN user_name VARCHAR(255),
ADD COLUMN user_email VARCHAR(255),
ADD COLUMN user_message TEXT;

-- Create a trigger to automatically insert `contact_us` data into `contact_us_page`
DELIMITER //
CREATE TRIGGER after_contact_us_insert
AFTER INSERT ON contact_us
FOR EACH ROW
BEGIN
  INSERT INTO contact_us_page (page_title, page_content, user_name, user_email, user_message)
  VALUES ('Contact Us', 'This is the contact us page content.', NEW.name, NEW.email, NEW.message);
END;
//
DELIMITER ;

-- Insert sample data into `contact_us_page` table
INSERT INTO contact_us_page (page_title, page_content) VALUES
('Contact Us', 'This is the contact us page content.');

-- Table structure for table `pages`
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `detail` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `password_resets`
CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `bookings`
CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('Pending', 'Confirmed', 'Canceled') DEFAULT 'Pending',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `categories`
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `product_categories`
CREATE TABLE `product_categories` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`, `category_id`),
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`),
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `sales`
CREATE TABLE `sales` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table structure for table `shops`
CREATE TABLE IF NOT EXISTS shops (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact_name VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    location VARCHAR(255) NOT NULL,
    social_media TEXT NOT NULL,
    image VARCHAR(255) NOT NULL
);

-- Table structure for table `projects`
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    seller_id INT NOT NULL,
    zip_folder VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    status ENUM('Pending', 'Accepted', 'Rejected') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES users(id)
);

-- Table structure for table `payments`
CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    payment_method VARCHAR(255) NOT NULL,
    status VARCHAR(255) DEFAULT 'Completed',
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Table structure for table `tblcontactusinfo`
CREATE TABLE tblcontactusinfo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Address VARCHAR(255) NOT NULL,
    EmailId VARCHAR(255) NOT NULL,
    ContactNo VARCHAR(15) NOT NULL
);

-- Table structure for table `custom_orders`
CREATE TABLE custom_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('Pending', 'Confirmed', 'Rejected') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Table structure for table `sell_projects`
CREATE TABLE IF NOT EXISTS sell_projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    project_name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    zip_folder VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
);
-- Removed duplicate CREATE TABLE sell_projects statement


-- Insert sample data into `pages` table
INSERT INTO `pages` (`page_name`, `type`, `detail`) VALUES
('Terms and Conditions', 'terms', 'Your terms and conditions content here.'),
('Privacy Policy', 'privacy', 'Your privacy policy content here.'),
('About Us', 'aboutus', 'Your about us content here.');

-- Insert sample data into `contact_us` table
INSERT INTO `contact_us` (`name`, `email`, `message`) VALUES
('John Doe', 'john@example.com', 'I would like to know more about your products.'),
('Jane Smith', 'jane@example.com', 'Do you offer international shipping?');

-- Insert sample data into `categories` table
INSERT INTO `categories` (`name`) VALUES
('Kits'), ('Microcontrollers'), ('Modules'), ('Sensors');

-- Insert sample data into `product_categories` table
INSERT INTO `product_categories` (`product_id`, `category_id`) VALUES
(1, 1), (2, 1), (3, 2), (4, 3);

COMMIT;
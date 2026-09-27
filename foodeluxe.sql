-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2025 at 06:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodeluxe`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(4, 'kachhatiya himanshu', 'himanshu@gmail.com', '$2y$10$NuP/AFx4Qu5LnZMCbWZe0uszzvjgmo1dwyhNGeni8Wn6ZzP.0vnyW', 'superadmin', '2025-10-14 16:26:23');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(3, 'himanshu', 'himanshu1@gmail.com', 'nice foods', '2025-09-09 17:15:46'),
(4, 'himanshu', 'himanshu1@gmail.com', 'fjwdnfkdjsvcnsdakjcbxakcabcdkjwdkbdvkdvdjkvdkvjd vksd vkdjwdkjvnwdolnkljd vkdjv sdjvdkjvdkjvbd vkjwdvkjdbvkdjvsdkjvb skj dkdakjsdbvwdkjvbdkvbdkjvbdkjvbdkvjbadjadbk d kjb dkjv dkjv dkvbedkjvdvkjbwdvbdvd', '2025-09-09 17:16:28'),
(5, 'amit', 'amit@gmail.com', 'nice food', '2025-09-12 04:30:05');

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`id`, `name`, `description`, `price`, `image`, `category`, `available`) VALUES
(1, 'Veggie Gourmet Burger', '', 90.00, 'images/burger item 1.jpeg', 'Burger', 1),
(2, 'Halloumi Sandwich Burger', '', 120.00, 'images/burger item 2.jpeg', 'Burger', 1),
(3, 'Veg Burger', NULL, 140.00, 'images/burger item 3.jpeg', 'Burger', 1),
(4, 'Garden Glory Burger', NULL, 149.00, 'images/burger item 4.jpeg', 'Burger', 1),
(5, 'Hot Honey Halloumi', NULL, 179.00, 'images/burger item 5.jpeg', 'Burger', 1),
(6, 'Herb Grilled Burger', NULL, 179.00, 'images/burger item 6.jpeg', 'Burger', 1),
(7, 'Avocado Crunch Burger', NULL, 189.00, 'images/burger item 7.jpeg', 'Burger', 1),
(8, 'Double Trouble Bacon Melt', NULL, 249.00, 'images/burger item 8.jpeg', 'Burger', 1),
(9, 'Paneer Tandoori Burger', NULL, 159.00, 'images/burger item 9.jpeg', 'Burger', 1),
(10, 'Mushroom Melt Burger', NULL, 199.00, 'images/burger item 10.jpeg', 'Burger', 1),
(46, 'Veg Hakka Noodles', 'Delicious stir fried noodles with veggies and sauces', 149.00, 'images/chinese item 1.jpeg', 'Chinese', 1),
(47, 'Spring Rolls', 'Crispy fried rolls stuffed with vegetables', 129.00, 'images/chinese item 3.jpeg', 'Chinese', 1),
(48, 'Veg Chowmein', 'Classic Indian-Chinese style chowmein noodles', 139.00, 'images/chinese item 4.jpeg', 'Chinese', 1),
(49, 'Schezwan Noodles', 'Spicy noodles tossed with schezwan sauce', 159.00, 'images/chinese item 5.jpeg', 'Chinese', 1),
(50, 'Hot & Sour Soup', 'Spicy and tangy soup with vegetables', 119.00, 'images/chinese item 6.jpeg', 'Chinese', 1),
(51, 'Veg Momos', 'Steamed dumplings served with spicy chutney', 99.00, 'images/chinese item 7.jpeg', 'Chinese', 1),
(52, 'Spicy Meatball Curry', 'Delicious spicy curry with tender meatballs cooked in rich gravy.', 180.00, 'images/chinese item 8.jpeg', 'Chinese', 1),
(53, 'Chicken Manchurian', 'Crispy chicken balls tossed in tangy Manchurian sauce.', 160.00, 'images/chinese item 9.jpeg', 'Chinese', 1),
(54, 'Chili Paneer', 'Paneer cubes sautéed with capsicum, onion, and spicy chili sauce.', 150.00, 'images/chinese item 10.jpeg', 'Chinese', 1),
(55, 'Taco Fiesta', 'Crispy corn tortillas filled with spicy beans, veggies, and cheese.', 120.00, 'images/mexican item 1.jpeg', 'Mexican', 1),
(56, 'Cheesy Nachos', 'Loaded nachos topped with melted cheese, jalapeños, and salsa.', 110.00, 'images/mexican item 2.jpeg', 'Mexican', 1),
(57, 'Veg Quesadilla', 'Grilled tortilla stuffed with sautéed vegetables and gooey cheese.', 130.00, 'images/mexican item 3.jpeg', 'Mexican', 1),
(58, 'Chicken Burrito', 'Soft wrap filled with spicy chicken, rice, beans, and sauce.', 150.00, 'images/mexican item 4.jpeg', 'Mexican', 1),
(59, 'Mexican Rice Bowl', 'Flavored rice served with beans, veggies, and tangy dressing.', 140.00, 'images/mexican item 5.jpeg', 'Mexican', 1),
(60, 'Bean Enchiladas', 'Rolled tortillas stuffed with beans and baked in spicy sauce.', 135.00, 'images/mexican item 6.jpeg', 'Mexican', 1),
(61, 'Loaded Tostadas', 'Crunchy base topped with refried beans, veggies, and sour cream.', 125.00, 'images/mexican item 7.jpeg', 'Mexican', 1),
(62, 'Spicy Fajita Wrap', 'Grilled veggies and chicken wrapped in a soft tortilla.', 145.00, 'images/mexican item 8.jpeg', 'Mexican', 1),
(63, 'Mexican Corn Salad', 'Sweet corn tossed with lime, chili, and herbs.', 100.00, 'images/mexican item 9.jpeg', 'Mexican', 1),
(64, 'Churros with Dip', 'Crispy fried dough sticks served with chocolate sauce.', 90.00, 'images/mexican item 10.jpeg', 'Mexican', 1),
(65, 'Paneer Tikka Masala', 'Grilled paneer cubes simmered in rich tomato-based Punjabi gravy.', 180.00, 'images/punjabi item 1.jpeg', 'Punjabi', 1),
(66, 'Shahi Paneer', 'Creamy and mildly spiced paneer curry with royal flavors.', 170.00, 'images/punjabi item 2.jpeg', 'Punjabi', 1),
(67, 'Kadai Paneer', 'Paneer cooked with bell peppers and onions in spicy kadai masala.', 160.00, 'images/punjabi item 3.jpeg', 'Punjabi', 1),
(68, 'Dal Makhani', 'Slow-cooked black lentils in buttery tomato gravy, topped with cream.', 140.00, 'images/punjabi item 4.jpeg', 'Punjabi', 1),
(69, 'Paneer Butter Masala', 'Soft paneer cubes in buttery tomato gravy with aromatic spices.', 150.00, 'images/punjabi item 5.jpeg', 'Punjabi', 1),
(70, 'Matar Paneer', 'Paneer cubes cooked with green peas in a rich tomato gravy.', 160.00, 'images/punjabi item 6.jpeg', 'Punjabi', 1),
(71, 'Garlic Naan', 'Soft tandoori naan brushed with garlic butter and herbs.', 50.00, 'images/punjabi item 7.jpeg', 'Punjabi', 1),
(72, 'Herb Naan', 'Fluffy naan topped with fresh herbs and served with chutney.', 45.00, 'images/punjabi item 8.jpeg', 'Punjabi', 1),
(73, 'Palak Paneer', 'Spinach-based gravy with tender paneer cubes and mild spices.', 155.00, 'images/punjabi item 9.jpeg', 'Punjabi', 1),
(74, 'Shahi Paneer', 'Creamy paneer curry with cashews, cream, and aromatic spices.', 170.00, 'images/punjabi item 10.jpeg', 'Punjabi', 1),
(79, 'Crispy French Fries', 'Golden fries tossed in salt and served with ketchup.', 60.00, 'images/snacks item 1.jpeg', 'Snack', 1),
(80, 'Classic Samosa Plate', 'Deep-fried pastries filled with spiced potatoes and peas.', 35.00, 'images/snacks item 2.jpeg', 'Snack', 1),
(81, 'Cheese Croquettes', 'Golden-fried cheese balls served with creamy dip.', 70.00, 'images/snacks item 3.jpeg', 'Snack', 1),
(82, 'Loaded Nachos Supreme', 'Tortilla chips topped with cheese, beans, jalapeños, and salsa.', 110.00, 'images/snacks item 4.jpeg', 'Snack', 1),
(83, 'Paneer Pakora Platter', 'Paneer slices stuffed with chutney and deep-fried to perfection.', 75.00, 'images/snacks item 5.jpeg', 'Snack', 1),
(84, 'Aloo Tikki Duo', 'Spiced potato patties garnished with chutney and herbs.', 50.00, 'images/snacks item 6.jpeg', 'Snack', 1),
(85, 'Cheesy Garlic Toast', 'Toasted bread topped with melted cheese and garlic butter.', 65.00, 'images/snacks item 7.jpeg', 'Snack', 1),
(86, 'Masala Corn Salad', 'Spicy corn salad with onions, tomatoes, and fresh herbs.', 55.00, 'images/snacks item 8.jpeg', 'Snack', 1),
(87, 'Spinach Cheese Puff', 'Flaky puff pastry filled with spinach and melted cheese.', 70.00, 'images/snacks item 9.jpeg', 'Snack', 1),
(88, 'Masala Dosa', 'Crispy dosa filled with spiced potato masala, served with chutneys and sambar.', 100.00, 'images/south-indain item 1.jpeg', 'South-Indian', 1),
(89, 'Idli Sambar Combo', 'Soft steamed idlis served with hot sambar and coconut chutney.', 90.00, 'images/south-indain item 2.jpeg', 'South-Indian', 1),
(90, 'Medu Vada Plate', 'Crispy lentil fritters served with sambar and coconut chutney.', 85.00, 'images/south-indain item 3.jpeg', 'South-Indian', 1),
(91, 'Veg Uttapam', 'Thick rice-lentil pancake topped with onions, tomatoes, and chilies.', 95.00, 'images/south-indain item 4.jpeg', 'South-Indian', 1),
(92, 'Upma with Chutney', 'Savory semolina dish garnished with mustard seeds and curry leaves.', 80.00, 'images/south-indain item 5.jpeg', 'South-Indian', 1),
(93, 'Sambar Bowl', 'Tangy lentil-based vegetable stew with drumsticks, radish, and spices.', 70.00, 'images/south-indain item 6.jpeg', 'South-Indian', 1),
(94, 'Curd Rice', 'Creamy rice mixed with curd, tempered with mustard seeds and curry leaves.', 65.00, 'images/south-indain item 7.jpeg', 'South-Indian', 1),
(95, 'Puttu', 'Steamed cylinders of ground rice and coconut served on banana leaf.', 75.00, 'images/south-indain item 8.jpeg', 'South-Indian', 1),
(96, 'Paniyaram', 'Golden-brown rice-lentil balls served with coconut chutney.', 85.00, 'images/south-indain item 9.jpeg', 'South-Indian', 1),
(97, 'Chocolate Brownie', 'Rich, fudgy chocolate brownies topped with melted chocolate drizzle.', 90.00, 'images/dessert item 1.jpeg', 'Dessert', 1),
(98, 'Strawberry Cheesecake', 'Creamy layered cheesecake topped with strawberry sauce and fresh berries.', 120.00, 'images/dessert item 2.jpeg', 'Dessert', 1),
(99, 'Vanilla Ice Cream', 'Classic vanilla scoops served chilled with a smooth creamy texture.', 70.00, 'images/dessert item 3.jpeg', 'Dessert', 1),
(100, 'Chocolate Lava Cake', 'Molten chocolate cake with gooey center, garnished with strawberries and mint.', 110.00, 'images/dessert item 4.jpeg', 'Dessert', 1),
(101, 'Oreo Cupcake', 'Chocolate cupcake topped with cookies & cream frosting and a whole Oreo.', 95.00, 'images/dessert item 5.jpeg', 'Dessert', 1),
(102, 'Gulab Jamun', 'Soft fried milk dumplings soaked in cardamom-infused sugar syrup.', 60.00, 'images/dessert item 6.jpeg', 'Dessert', 1),
(103, 'Ras Malai', 'Spongy cheese balls soaked in sweetened milk, garnished with nuts and rose petals.', 80.00, 'images/dessert item 7.jpeg', 'Dessert', 1),
(104, 'Fruit Custard', 'Creamy vanilla custard topped with fresh seasonal fruits.', 70.00, 'images/dessert item 8.jpeg', 'Dessert', 1),
(105, 'Strawberry Donut', 'Pink-frosted donut topped with white sprinkles and served with fresh strawberries.', 65.00, 'images/dessert item 9.jpeg', 'Dessert', 1),
(106, 'Vanilla Sundae', 'Scoops of vanilla ice cream topped with chocolate syrup, whipped cream, and cherry.', 75.00, 'images/dessert item 10.jpeg', 'Dessert', 1),
(107, 'Coca-Cola Can', 'Chilled original Coca-Cola served in a 355ml can over ice.', 40.00, 'images/drinks-item-1.jpeg', 'Drink', 1),
(108, 'Iced Lemon Tea', 'Refreshing iced tea infused with lemon and mint, perfect for summer.', 50.00, 'images/drinks-item-2.jpeg', 'Drink', 1),
(109, 'Fresh Limeon', 'Cool lime drink served in a mason jar with ice and fresh lime slices.', 45.00, 'images/drinks-item-4.jpeg', 'Drink', 1),
(110, 'Mango Smoothie', 'Thick mango smoothie served chilled with a hint of mint.', 60.00, 'images/drinks-item-5.jpeg', 'Drink', 1),
(111, 'Strawberry Smoothie', 'Thick blend of strawberries, bananas, and peaches served chilled.', 65.00, 'images/drinks-item-6.jpeg', 'Drink', 1),
(112, 'Masala Chai', 'Traditional Indian spiced tea brewed with milk and aromatic spices.', 40.00, 'images/drinks-item-7.jpeg', 'Drink', 1),
(113, 'Spiced Buttermilk', 'Refreshing yogurt-based drink with mint, cumin, and herbs.', 35.00, 'images/drinks-item-8.jpeg', 'Drink', 1),
(115, 'Bisleri Mineral Water', 'Premium bottled water – Bisleri Rock Star edition (355ml).', 30.00, 'images/drinks-item-10.jpeg', 'Drink', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `gst` decimal(10,2) NOT NULL,
  `delivery_fee` decimal(10,2) NOT NULL,
  `packing_fee` decimal(10,2) NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(20) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `address`, `phone`, `subtotal`, `gst`, `delivery_fee`, `packing_fee`, `grand_total`, `created_at`, `payment_method`, `status`) VALUES
(1, 1, '', '', '', 478.00, 23.90, 0.00, 100.00, 601.90, '2025-09-02 04:19:42', 'COD', 'pending'),
(2, 1, 'Prashant ', 'Rajkot\r\nRajkot', '09824582755', 159.00, 7.95, 0.00, 100.00, 266.95, '2025-09-02 05:06:25', 'QR', 'pending'),
(3, 1, 'Prashant gaming', 'Rajkot\r\nRajkot', '09824582755', 318.00, 15.90, 0.00, 100.00, 433.90, '2025-09-02 05:32:11', 'COD', 'pending'),
(4, 1, '', '', '', 0.00, 0.00, 120.00, 100.00, 220.00, '2025-09-02 09:05:47', 'COD', 'pending'),
(5, 1, '', '', '', 0.00, 0.00, 120.00, 100.00, 220.00, '2025-09-02 09:05:52', 'COD', 'pending'),
(6, 1, '', '', '', 0.00, 0.00, 120.00, 100.00, 220.00, '2025-09-02 09:05:57', 'COD', 'pending'),
(7, 1, '', '', '', 0.00, 0.00, 120.00, 100.00, 220.00, '2025-09-02 09:16:28', 'COD', 'pending'),
(8, 1, 'Prashant ', 'Rajkot', '09824582755', 159.00, 7.95, 0.00, 100.00, 266.95, '2025-09-02 09:31:00', '<br />\r\n<b>Warning</', 'pending'),
(9, 1, 'Prashant ', 'Rajkot', '09824582755', 0.00, 0.00, 120.00, 100.00, 220.00, '2025-09-02 09:33:09', '<br />\r\n<b>Warning</', 'pending'),
(10, 1, 'Prashant ', 'Rajkot', '09824582755', 0.00, 0.00, 120.00, 100.00, 220.00, '2025-09-02 09:36:38', '<br />\r\n<b>Warning</', 'pending'),
(11, 1, 'Prashant gaming', 'Rajkot\r\nRajkot', '09824582755', 159.00, 7.95, 0.00, 100.00, 266.95, '2025-09-02 09:37:42', 'COD', 'pending'),
(12, 1, 'Prashant gaming', 'Rajkot\r\nRajkot', '09824582755', 0.00, 0.00, 120.00, 100.00, 220.00, '2025-09-02 09:41:00', 'COD', 'pending'),
(13, 1, 'Prashant gaming', 'Rajkot\r\nRajkot', '09824582755', 0.00, 0.00, 120.00, 100.00, 220.00, '2025-09-02 09:41:21', 'COD', 'pending'),
(14, 1, '', '', '', 0.00, 0.00, 120.00, 100.00, 220.00, '2025-09-02 09:42:48', 'COD', 'pending'),
(15, 1, '', '', '', 0.00, 0.00, 120.00, 100.00, 220.00, '2025-09-02 09:47:05', 'COD', 'pending'),
(16, 1, 'Prashant ', 'Rajkot', '09824582755', 199.00, 11.94, 0.00, 100.00, 310.94, '2025-09-02 09:53:47', 'COD', 'pending'),
(17, 1, 'Prashant', 'Rajkot\r\n', '09824582755', 1653.00, 99.18, 0.00, 100.00, 1852.18, '2025-09-02 09:58:32', 'COD', 'pending'),
(18, 1, 'Prashant gaming', 'Rajkot', '09824582755', 1653.00, 99.18, 0.00, 100.00, 1852.18, '2025-09-02 10:08:13', 'COD', 'pending'),
(19, 1, 'Prashant ', 'Rajkot\r\n', '9824582755', 249.00, 14.94, 0.00, 100.00, 363.94, '2025-09-02 16:49:19', 'UPI', 'Cancelled'),
(20, 1, 'Prashant gaming', 'Rajkot\r\nRajkot', '09824582755', 540.00, 32.40, 0.00, 100.00, 672.40, '2025-09-02 17:00:59', 'COD', 'Delivered'),
(21, 1, 'Prashant gaming', 'Rajkot\r\nRajkot', '09824582755', 358.00, 21.48, 0.00, 100.00, 479.48, '2025-09-04 03:56:37', 'COD', 'Delivered'),
(22, 1, 'Prashant gaming', 'Rajkot\r\nRajkot', '09824582755', 378.00, 22.68, 0.00, 100.00, 500.68, '2025-09-04 04:39:45', 'COD', 'Cancelled'),
(23, 1, 'Prashant gaming', 'Rajkot\r\nRajkot', '09824582755', 438.00, 26.28, 0.00, 100.00, 564.28, '2025-09-04 04:44:43', 'COD', 'Delivered'),
(24, 1, 'Prashant gaming', 'Rajkot\r\nRajkot', '09824582755', 897.00, 53.82, 0.00, 100.00, 1050.82, '2025-09-04 18:49:33', 'COD', 'Delivered'),
(25, 1, 'Prashant gaming', 'Rajkot\r\nRajkot', '09824582755', 8142.00, 488.52, 0.00, 100.00, 8730.52, '2025-09-07 16:37:07', 'COD', 'Pending'),
(26, 4, 'Prashant gaming', 'Rajkot\r\nRajkot', '09824582755', 159.00, 9.54, 0.00, 100.00, 268.54, '2025-09-07 17:54:43', 'COD', 'Cancelled'),
(27, 4, 'Prashant gaming', 'Rajkot\r\nRajkot', '09824582755', 398.00, 23.88, 0.00, 100.00, 521.88, '2025-09-07 17:56:07', 'COD', 'Delivered'),
(28, 6, 'urvish', 'rajkot', '4904432091', 1229.00, 73.74, 0.00, 100.00, 1402.74, '2025-09-07 18:01:50', 'COD', 'Delivered'),
(29, 7, 'himanshu', 'rajkot', '8548548543', 448.00, 26.88, 0.00, 100.00, 574.88, '2025-09-09 16:43:13', 'COD', 'Pending'),
(30, 7, 'Prashant gaming', 'Rajkot\r\nRajkot', '09824582755', 199.00, 11.94, 0.00, 20.00, 230.94, '2025-09-09 16:47:33', 'COD', 'Pending'),
(31, 8, 'ashish', 'rajkot', '3439043332', 398.00, 23.88, 0.00, 20.00, 441.88, '2025-09-09 16:54:30', 'COD', 'Cancelled'),
(32, 1, 'Prashant gaming', 'Rajkot\r\nRajkot', '09824582755', 249.00, 14.94, 0.00, 20.00, 283.94, '2025-09-11 03:58:31', 'COD', 'Pending'),
(33, 9, 'Prashant gaming', 'Rajkot\r\nRajkot', '09824582755', 657.00, 39.42, 0.00, 20.00, 716.42, '2025-09-12 04:14:02', 'COD', 'Pending'),
(34, 10, 'amit', 'sarvodaya college', '2819412755', 598.00, 35.88, 0.00, 20.00, 653.88, '2025-09-12 04:28:02', 'COD', 'Cancelled'),
(35, 1, 'Prashant gaming', 'Rajkot\r\nRajkot', '09824582755', 179.00, 10.74, 0.00, 20.00, 209.74, '2025-09-13 18:21:14', 'COD', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `item_name`, `price`, `quantity`, `subtotal`) VALUES
(1, 1, 'Halloumi Sandwich Burger', 120.00, 1, 120.00),
(2, 1, 'Paneer Tandoori Burger', 159.00, 1, 159.00),
(3, 1, 'Mushroom Melt Burger', 199.00, 1, 199.00),
(4, 2, 'Paneer Tandoori Burger', 159.00, 1, 159.00),
(5, 3, 'Paneer Tandoori Burger', 159.00, 2, 318.00),
(6, 8, 'Paneer Tandoori Burger', 159.00, 1, 159.00),
(7, 11, 'Paneer Tandoori Burger', 159.00, 1, 159.00),
(8, 16, 'Mushroom Melt Burger', 199.00, 1, 199.00),
(9, 17, 'Paneer Tandoori Burger', 159.00, 1, 159.00),
(10, 17, 'Mushroom Melt Burger', 199.00, 1, 199.00),
(11, 17, 'Double Trouble Bacon Melt', 249.00, 1, 249.00),
(12, 17, 'Avocado Crunch Burger', 189.00, 1, 189.00),
(13, 17, 'Hot Honey Halloumi', 179.00, 1, 179.00),
(14, 17, 'Herb Grilled Burger', 179.00, 1, 179.00),
(15, 17, 'Garden Glory Burger', 149.00, 1, 149.00),
(16, 17, 'Veg Burger', 140.00, 1, 140.00),
(17, 17, 'Veggie Gourmet Burger', 90.00, 1, 90.00),
(18, 17, 'Halloumi Sandwich Burger', 120.00, 1, 120.00),
(19, 18, 'Mushroom Melt Burger', 199.00, 1, 199.00),
(20, 18, 'Paneer Tandoori Burger', 159.00, 1, 159.00),
(21, 18, 'Avocado Crunch Burger', 189.00, 1, 189.00),
(22, 18, 'Double Trouble Bacon Melt', 249.00, 1, 249.00),
(23, 18, 'Hot Honey Halloumi', 179.00, 1, 179.00),
(24, 18, 'Herb Grilled Burger', 179.00, 1, 179.00),
(25, 18, 'Veg Burger', 140.00, 1, 140.00),
(26, 18, 'Garden Glory Burger', 149.00, 1, 149.00),
(27, 18, 'Veggie Gourmet Burger', 90.00, 1, 90.00),
(28, 18, 'Halloumi Sandwich Burger', 120.00, 1, 120.00),
(29, 19, 'Double Trouble Bacon Melt', 249.00, 1, 249.00),
(30, 20, 'Veggie Gourmet Burger', 90.00, 2, 180.00),
(31, 20, 'Halloumi Sandwich Burger', 120.00, 3, 360.00),
(32, 21, 'Herb Grilled Burger', 179.00, 2, 358.00),
(33, 22, 'Avocado Crunch Burger', 189.00, 2, 378.00),
(34, 23, 'Double Trouble Bacon Melt', 249.00, 1, 249.00),
(35, 23, 'Avocado Crunch Burger', 189.00, 1, 189.00),
(36, 24, 'Veggie Gourmet Burger', 90.00, 5, 450.00),
(37, 24, 'Garden Glory Burger', 149.00, 3, 447.00),
(38, 25, 'Bisleri Mineral Water', 20.00, 1, 20.00),
(39, 25, 'Spiced Buttermilk', 35.00, 1, 35.00),
(40, 25, 'Masala Chai', 40.00, 1, 40.00),
(41, 25, 'Strawberry Smoothie', 65.00, 1, 65.00),
(42, 25, 'Mango Smoothie', 60.00, 1, 60.00),
(43, 25, 'Fresh Limeon', 45.00, 1, 45.00),
(44, 25, 'Ras Malai', 80.00, 1, 80.00),
(45, 25, 'Strawberry Donut', 65.00, 1, 65.00),
(46, 25, 'Fruit Custard', 70.00, 1, 70.00),
(47, 25, 'Vanilla Sundae', 75.00, 1, 75.00),
(48, 25, 'Coca-Cola Can', 40.00, 1, 40.00),
(49, 25, 'Iced Lemon Tea', 50.00, 1, 50.00),
(50, 25, 'Gulab Jamun', 60.00, 1, 60.00),
(51, 25, 'Oreo Cupcake', 95.00, 1, 95.00),
(52, 25, 'Chocolate Lava Cake', 110.00, 1, 110.00),
(53, 25, 'Vanilla Ice Cream', 70.00, 1, 70.00),
(54, 25, 'Strawberry Cheesecake', 120.00, 1, 120.00),
(55, 25, 'Chocolate Brownie', 90.00, 1, 90.00),
(56, 25, 'Cheesy Garlic Toast', 65.00, 1, 65.00),
(57, 25, 'Masala Corn Salad', 55.00, 2, 110.00),
(58, 25, 'Spinach Cheese Puff', 70.00, 1, 70.00),
(59, 25, 'Masala Dosa', 100.00, 1, 100.00),
(60, 25, 'Idli Sambar Combo', 90.00, 1, 90.00),
(61, 25, 'Medu Vada Plate', 85.00, 1, 85.00),
(62, 25, 'Paniyaram', 85.00, 1, 85.00),
(63, 25, 'Puttu', 75.00, 1, 75.00),
(64, 25, 'Curd Rice', 65.00, 1, 65.00),
(65, 25, 'Sambar Bowl', 70.00, 1, 70.00),
(66, 25, 'Upma with Chutney', 80.00, 1, 80.00),
(67, 25, 'Veg Uttapam', 95.00, 1, 95.00),
(68, 25, 'Crispy French Fries', 60.00, 1, 60.00),
(69, 25, 'Classic Samosa Plate', 35.00, 1, 35.00),
(70, 25, 'Cheese Croquettes', 70.00, 1, 70.00),
(71, 25, 'Loaded Nachos Supreme', 110.00, 1, 110.00),
(72, 25, 'Paneer Pakora Platter', 75.00, 1, 75.00),
(73, 25, 'Aloo Tikki Duo', 50.00, 1, 50.00),
(74, 25, 'Shahi Paneer', 170.00, 1, 170.00),
(75, 25, 'Palak Paneer', 155.00, 1, 155.00),
(76, 25, 'Herb Naan', 45.00, 1, 45.00),
(77, 25, 'Garlic Naan', 50.00, 1, 50.00),
(78, 25, 'Matar Paneer', 160.00, 1, 160.00),
(79, 25, 'Paneer Butter Masala', 150.00, 1, 150.00),
(80, 25, 'Veg Quesadilla', 130.00, 1, 130.00),
(81, 25, 'Chicken Burrito', 150.00, 1, 150.00),
(82, 25, 'Mexican Rice Bowl', 140.00, 1, 140.00),
(83, 25, 'Bean Enchiladas', 135.00, 1, 135.00),
(84, 25, 'Loaded Tostadas', 125.00, 1, 125.00),
(85, 25, 'Spicy Fajita Wrap', 145.00, 1, 145.00),
(86, 25, 'Dal Makhani', 140.00, 1, 140.00),
(87, 25, 'Kadai Paneer', 160.00, 1, 160.00),
(88, 25, 'Shahi Paneer', 170.00, 1, 170.00),
(89, 25, 'Paneer Tikka Masala', 180.00, 1, 180.00),
(90, 25, 'Churros with Dip', 90.00, 1, 90.00),
(91, 25, 'Mexican Corn Salad', 100.00, 1, 100.00),
(92, 25, 'Mushroom Melt Burger', 199.00, 1, 199.00),
(93, 25, 'Veg Hakka Noodles', 149.00, 1, 149.00),
(94, 25, 'Spring Rolls', 129.00, 1, 129.00),
(95, 25, 'Veg Chowmein', 139.00, 1, 139.00),
(96, 25, 'Schezwan Noodles', 159.00, 1, 159.00),
(97, 25, 'Hot & Sour Soup', 119.00, 1, 119.00),
(98, 25, 'Cheesy Nachos', 110.00, 1, 110.00),
(99, 25, 'Taco Fiesta', 120.00, 1, 120.00),
(100, 25, 'Chili Paneer', 150.00, 1, 150.00),
(101, 25, 'Chicken Manchurian', 160.00, 1, 160.00),
(102, 25, 'Spicy Meatball Curry', 180.00, 1, 180.00),
(103, 25, 'Veg Momos', 99.00, 1, 99.00),
(104, 25, 'Garden Glory Burger', 149.00, 1, 149.00),
(105, 25, 'Hot Honey Halloumi', 179.00, 1, 179.00),
(106, 25, 'Herb Grilled Burger', 179.00, 1, 179.00),
(107, 25, 'Avocado Crunch Burger', 189.00, 1, 189.00),
(108, 25, 'Double Trouble Bacon Melt', 249.00, 1, 249.00),
(109, 25, 'Paneer Tandoori Burger', 159.00, 1, 159.00),
(110, 25, 'Veg Burger', 140.00, 1, 140.00),
(111, 25, 'Halloumi Sandwich Burger', 120.00, 1, 120.00),
(112, 25, 'Veggie Gourmet Burger', 90.00, 1, 90.00),
(113, 26, 'Paneer Tandoori Burger', 159.00, 1, 159.00),
(114, 27, 'Mushroom Melt Burger', 199.00, 2, 398.00),
(115, 28, 'Double Trouble Bacon Melt', 249.00, 1, 249.00),
(116, 28, 'Spicy Meatball Curry', 180.00, 1, 180.00),
(117, 28, 'Spicy Fajita Wrap', 145.00, 1, 145.00),
(118, 28, 'Palak Paneer', 155.00, 1, 155.00),
(119, 28, 'Herb Naan', 45.00, 1, 45.00),
(120, 28, 'Aloo Tikki Duo', 50.00, 1, 50.00),
(121, 28, 'Masala Dosa', 100.00, 1, 100.00),
(122, 28, 'Idli Sambar Combo', 90.00, 1, 90.00),
(123, 28, 'Vanilla Sundae', 75.00, 1, 75.00),
(124, 28, 'Strawberry Donut', 65.00, 1, 65.00),
(125, 28, 'Spiced Buttermilk', 35.00, 1, 35.00),
(126, 28, 'Coca-Cola Can', 40.00, 1, 40.00),
(127, 29, 'Mushroom Melt Burger', 199.00, 1, 199.00),
(128, 29, 'Double Trouble Bacon Melt', 249.00, 1, 249.00),
(129, 30, 'Mushroom Melt Burger', 199.00, 1, 199.00),
(130, 31, 'Mushroom Melt Burger', 199.00, 2, 398.00),
(131, 32, 'Double Trouble Bacon Melt', 249.00, 1, 249.00),
(132, 33, 'Avocado Crunch Burger', 189.00, 1, 189.00),
(133, 33, 'Herb Grilled Burger', 179.00, 1, 179.00),
(134, 33, 'Veg Momos', 99.00, 1, 99.00),
(135, 33, 'Spicy Fajita Wrap', 145.00, 1, 145.00),
(136, 33, 'Herb Naan', 45.00, 1, 45.00),
(137, 34, 'Spicy Meatball Curry', 180.00, 2, 360.00),
(138, 34, 'Hot & Sour Soup', 119.00, 2, 238.00),
(139, 35, 'Herb Grilled Burger', 179.00, 1, 179.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `created_at`) VALUES
(1, 'Prashant ', 'prashantbavliya4@gmail.com', '09824582755', '$2y$10$pWwC5AC6ODx1Gdz9uBQlGugLYOoeEdZIooI9WD3pDuKN4QG0vFMry', '2025-09-01 07:15:49'),
(4, 'xyz', 'cvbh@gmail.com', '4380943841', '$2y$10$H8jOlNSXgKLUo6dQdvQ4E.f1vqI8j.L9J0k.mmHWjBA8VJ9m6APAe', '2025-09-07 17:40:49'),
(6, 'urvish', 'urvish@gmail.com', '389384938', '$2y$10$LQ109YSVEkr60ZL3B/3CC.W2azFpcsgVu8xDg9odqR6Ainp5mLFkG', '2025-09-07 18:00:28'),
(7, 'himanshu', 'himanshu1@gmail.com', '8866215331', '$2y$10$cdZEDZwnlK/C3iux8CnBYe9BsT1qg7LNYvAwpJsGlRPp8AIay15di', '2025-09-09 16:41:49'),
(8, 'ashish', 'ashish@gmail.com', '4589435843', '$2y$10$Exwc96veXelP9WP8Iv9.mebNJ9WCOIlQtOb6GJJkANg5QGGJAyC1y', '2025-09-09 16:48:49'),
(9, 'bhargav', 'bhago@1206', '1234565432', '$2y$10$PNDjcvWiPxYTw/kbdoG4m.iitGGhBe5TTm99iqRGokOCwH3BbJVDq', '2025-09-12 04:10:40'),
(10, 'amit', 'amit@gmail.com', '239091409', '$2y$10$99R7HcxpG7mjyfqbQMUb7eCoKXF08UIZePgPRUGxUz1N3/1IIuPle', '2025-09-12 04:26:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2026 at 07:43 AM
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
-- Database: `quick_bite`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_delivery`
--

CREATE TABLE `admin_delivery` (
  `delivery_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `delivery_partner_name` varchar(100) DEFAULT 'Not Assigned',
  `delivery_partner_phone` varchar(20) DEFAULT 'N/A',
  `status` enum('pending','picked','on_the_way','delivered') DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_food_items`
--

CREATE TABLE `admin_food_items` (
  `food_id` int(11) NOT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `category` enum('Veg','Non-Veg') DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('available','unavailable') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_food_items`
--

INSERT INTO `admin_food_items` (`food_id`, `hotel_id`, `admin_id`, `name`, `description`, `price`, `category`, `image`, `status`, `created_at`) VALUES
(1, 1, 1, 'Idli [2Pcs]', 'Idli Soft, fluffy steamed idlis served with smooth coconut chutney and hot, aromatic sambar — a true South Indian classic.', 100.00, 'Veg', 'idli.jpg', 'available', '2026-04-22 17:16:18'),
(2, 1, 1, ' Paneer Bhurji', 'Crumbled paneer sautéed with onions, tomatoes, and spices. Spicy, hearty, and perfect with roti or paratha!', 250.00, 'Veg', 'paneer bhurji.jpg', 'available', '2026-04-23 05:13:19'),
(3, 1, 1, 'Palak Paneer', 'Soft paneer cubes cooked in a smooth and creamy spinach gravy, seasoned with mild spices.', 279.00, 'Veg', 'palak panner.jpg', 'available', '2026-04-25 07:08:09'),
(4, 1, 1, ' Kaju Paneer Masala', 'Soft paneer and crunchy cashews cooked together in a rich, mildly spiced tomato-based gravy.', 285.00, 'Veg', 'kaju panner.jpg', 'available', '2026-04-25 07:10:24'),
(5, 1, 1, ' Rajasthani Kofta', 'Spicy gram flour dumplings cooked in a rich, traditional Rajasthani curry. Bold, flavorful, and truly authentic.', 300.00, 'Veg', 'Rajasthani kofta.jpg', 'available', '2026-04-25 07:12:31'),
(6, 1, 1, 'Aloo Paratha', 'Hot and crispy aloo paratha stuffed with flavourful spiced potato, served with spicy chutney, tangy pickles and rai vala marcha.', 120.00, 'Veg', 'aloo paratha.jpg', 'available', '2026-04-25 07:14:35'),
(7, 1, 1, 'Dal Makhani', 'Creamy black lentils slow-cooked in a rich, buttery tomato gravy.', 312.00, 'Veg', 'dal makhani.jpg', 'available', '2026-04-25 07:16:52'),
(8, 1, 1, 'Veg Handi Biryani', 'Aromatic basmati rice slow-cooked with fresh vegetables, herbs, and spices in a traditional handi. Flavorful, wholesome, and truly satisfying!', 248.00, 'Veg', 'handi biryani.jpg', 'available', '2026-04-25 07:20:40'),
(9, 1, 1, 'Nargis Kofta', 'Delicate paneer and vegetable koftas with a creamy center, simmered in a rich, aromatic Mughlai-style gravy. A royal vegetarian delight!', 300.00, 'Veg', 'nargis kofta.jpg', 'available', '2026-04-25 07:23:03'),
(10, 1, 1, 'Paneer Handi', 'Soft paneer cubes cooked in a clay pot-style rich and spicy gravy with traditional Indian spices.', 279.00, 'Veg', 'panner handi.jpg', 'available', '2026-04-25 07:25:33'),
(11, 2, 1, 'Veg Manchurian Dry', '- Crispy vegetable balls tossed in a flavorful Indo-Chinese sauce, perfectly \r\nseasoned with garlic, ginger', 385.00, 'Veg', 'manchurian.jpg', 'available', '2026-04-25 07:29:02'),
(12, 2, 1, 'Punjabi Thal', '- Veg Sabji + Paneer Sabji + 2 Tandoori Roti + Dal Fried + Sweet + \r\nButtermilk + Rice + Salad + Papad + Pan + Pickle.', 395.00, 'Veg', 'punjabi lunch box.jpg', 'available', '2026-04-25 07:31:23'),
(13, 2, 1, 'Paneer Butter Masala', 'Made with fresh in house prepared paneer.', 428.00, 'Veg', 'panner butter masala2.jpg', 'available', '2026-04-25 07:34:31'),
(14, 2, 1, 'Veg Fried Rice', '- A classic rice dish stir-fried with fresh vegetables, aromatic spices, and \r\nlight seasoning.', 196.00, 'Veg', 'veg fried rice.jpg', 'available', '2026-04-25 07:37:07'),
(15, 2, 1, 'Kathiyawadi Thali', '- 2 kathiyawadi Sabji+ 5 Chapati + Khichdi + Curry + 1 sweet + Buttermilk \r\n+ Papad + Salad + Pickle + Pan.', 398.00, 'Veg', 'bhojan thali.jpg', 'available', '2026-04-25 07:41:46'),
(16, 2, 1, ' Schezwan Fried Rice', '- Spicy and flavorful fried rice cooked with vegetables and authentic \r\nSchezwan sauce, giving it a bold, fiery taste.', 200.00, 'Veg', 'schezwan fried rice.jpg', 'available', '2026-04-25 07:46:47'),
(17, 2, 1, 'Paneer Tikka Masala', 'Made with fresh in house prepared paneer.', 422.00, 'Veg', 'Panner tikka masala1.jpg', 'available', '2026-04-25 07:49:40'),
(18, 2, 1, 'Masala Dosa', '- A crispy golden dosa filled with a spiced potato mixture, served with \r\nchutney and sambar.', 348.00, 'Veg', 'masala dosa.jpg', 'available', '2026-04-25 07:54:36'),
(19, 2, 1, 'Kaju Butter Masala', 'Rich and creamy curry made with cashew nuts cooked in a buttery \r\ntomato-based gravy.', 501.00, 'Veg', 'kaju butter masala.jpg', 'available', '2026-04-25 07:57:27'),
(20, 2, 1, 'South Indian Thali', 'Masala Dosa + Mixed Uttapam + Idli mendu wada + coconut chutney + \r\nSambhar.', 694.00, 'Veg', 'south indain combo.jpeg', 'available', '2026-04-25 07:59:39'),
(21, 3, 1, 'Manchurian Fried Rice', '- Fried rice mixed with Manchurian flavors, tossed in a spicy Indo-Chinese \r\nsauce.', 250.00, 'Veg', 'manchurian fired rice.jpg', 'available', '2026-04-25 08:11:57'),
(22, 3, 1, 'Chinese Meal Pack', 'Manchurian Dry + Manchurian Fried Rice + Hakka', 338.00, 'Veg', 'chinese meal pack1.jpeg', 'available', '2026-04-25 08:14:52'),
(23, 3, 1, ' Dragon Potato', 'Crispy fried potato strips coated in a spicy, tangy, and slightly sweet \r\nsauce.', 325.00, 'Veg', 'dragon patoto.jpg', 'available', '2026-04-25 08:20:37'),
(24, 3, 1, ' Paneer Handi Combo', 'Paneer Handi + 2 Butter Tandoori Roti', 275.00, 'Veg', 'panner handi combo.jpg', 'available', '2026-04-25 08:22:25'),
(25, 3, 1, ' Hyderabadi Biryani', 'Aromatic basmati rice cooked with rich spices in traditional Hyderabadi \r\nstyle.', 263.00, 'Veg', 'hyderabadi biryani.jpg', 'available', '2026-04-25 08:25:00'),
(26, 3, 1, 'Veg Kolhapuri Combo', 'veg Kolhapuri + 2 Butter Tandoori Roti + O', 250.00, 'Veg', 'veg kohlapuri combo.jpg', 'available', '2026-04-25 08:27:31'),
(27, 3, 1, ' Paneer Bhurji', 'Scrambled paneer cooked with onions, tomatoes, and flavorful Indian \r\nspices.', 325.00, 'Veg', 'paneer bhurji1.jpg', 'available', '2026-04-25 08:29:21'),
(28, 3, 1, 'Veg Pulao', '- Fragrant rice cooked with mixed vegetables and mild spices for a light \r\nmeal.', 213.00, 'Veg', 'veg pulao.jpg', 'available', '2026-04-25 08:30:54'),
(29, 3, 1, ' Chinese Bhel', 'Crunchy noodles tossed with vegetables and spicy Chinese sauces for a \r\ntangy snack.', 250.00, 'Veg', 'chinese bhel.jpg', 'available', '2026-04-25 08:32:32'),
(30, 3, 1, ' Veg Biryani Combo', 'Veg Biryani + Papad + Buttermilk + Salad.', 238.00, 'Veg', 'veg biryani combo.jpg', 'available', '2026-04-25 08:35:27'),
(31, 4, 1, 'Kaju Butter Masala Combo', 'kaju butter masala + 2 Tandoori Roti/1 Naan + Salad', 398.00, 'Veg', 'kajubutter masala combo.jpg', 'available', '2026-04-25 08:41:22'),
(32, 4, 1, ' Paneer Tikka Masala Combo', '- paneer tikka masala + 2 Tandoori Roti/1 Naan + Salad', 380.00, 'Veg', 'panner tikka masala combo.jpg', 'available', '2026-04-25 08:45:40'),
(33, 4, 1, 'Mysore Masala Dosa', '- Crispy South Indian dosa smeared with spicy red chutney and stuffed \r\nwith flavorful potato masala.', 230.00, 'Veg', 'maysore masala dosa.jpg', 'available', '2026-04-25 08:48:09'),
(34, 4, 1, 'Masala Dosa', '- Served with Sambhar and Chutney.', 220.00, 'Veg', 'masala dosa1.jpg', 'available', '2026-04-25 08:49:57'),
(35, 4, 1, ' Punjabi Thali', '- Mixed veg + shahi paneer + Dal Fry + Jeera Rice + Naan/Roti + Salad + \r\nPickle + Papad + Gulab Jamun + Buttermilk.', 400.00, 'Veg', 'punjabi thali.jpg', 'available', '2026-04-25 08:51:40'),
(36, 4, 1, ' Chole Bhature', 'Chole + Bhature + Salad', 270.00, 'Veg', 'chole bhutre.jpg', 'available', '2026-04-25 08:53:31'),
(37, 4, 1, ' Hyderabadi Hot Pot Biryani', '- Aromatic layered Biryani slow-cooked in dum style with ruch hyderabadi \r\nspices for a bold, flavorful hot pot experience.', 330.00, 'Veg', 'Hyderabadi Hot Pot Biryani.jpg', 'available', '2026-04-25 08:55:33'),
(38, 4, 1, 'Bombay Masala Dosa', 'Crispy dosa filled with spicy tangy Mumbai- style potato masala for a \r\nflavorful street style twist.', 220.00, 'Veg', 'Bombay Masala Dosa.jpg', 'available', '2026-04-25 08:57:42'),
(39, 4, 1, 'Dal Khichdi', 'Comforting blend of lentils and rice cooked with mild spices for a simple, \r\nwholesome meal.', 280.00, 'Veg', 'dal khichidi.jpg', 'available', '2026-04-25 08:59:26'),
(40, 4, 1, 'Paneer Masala Dosa', 'Crispy South Indian Dosa stuffed with a spicy flavorful paneer masala \r\nfillings.', 260.00, 'Veg', 'panner masala dosa.jpg', 'available', '2026-04-25 09:01:32'),
(41, 5, 1, ' Corporate Thali', '2 punjabi sabji [Veg, Paneer] + Dal Fry + Jeera Rice + Gulab Jamun [2 \r\npiece] + Pickle + Buttermilk + 3 Roti', 330.00, 'Veg', 'corprorate thali.jpg', 'available', '2026-04-25 09:03:52'),
(42, 5, 1, ' Chinese Thali', 'Veg Fried Rice + Dragon Potato + Veg Manchurian Gravy + Hakka \r\nNoodles + Salsa Sauce + Gulab Jamun [2 Piece].', 412.00, 'Veg', 'chinese thali.jpg', 'available', '2026-04-25 09:05:36'),
(43, 5, 1, 'Mexican Thali', 'Mexican Rice + Mexican Taquitos + Red Sauce Pasta + Bean Enchiladas \r\n+ Mexican Gravy + Salsa Sauce + Gulab Jamun [2 Piece].', 447.00, 'Veg', 'mexican thali.jpg', 'available', '2026-04-25 09:07:20'),
(44, 5, 1, 'North Indian Meal', 'Kaju Butter Masala + 2 Tawa Roti + Buttermilk + Salad.', 296.00, 'Veg', 'north indian meal.jpg', 'available', '2026-04-25 09:09:11'),
(45, 5, 1, ' Paneer Butter Masala Combo', 'Paneer Butter Masala + Pulao + 2 Butter Roti + Buttermilk.', 354.00, 'Veg', 'panner butter masala combo.jpg', 'available', '2026-04-25 09:10:59'),
(46, 5, 1, 'Chole Bhature Combo', 'Punjabi chole + 2 Bhature + Buttermilk + Salad', 290.00, 'Veg', 'chole bhutre.jpg', 'available', '2026-04-25 09:12:09'),
(47, 5, 1, ' Paneer Butter Masala', 'A classic dish of paneer and cheese cubes simmered in rich tomato gravy \r\ninfused with cream and butter.', 430.00, 'Veg', 'Paneer butter masala1.jpg', 'available', '2026-04-25 09:13:45'),
(48, 5, 1, 'Kaju Curry', 'A rich creamy and flavorful North Indian dish featuring roasted cashews in \r\na thick tomato based gravy', 450.00, 'Veg', 'kaju curry.jpg', 'available', '2026-04-25 09:16:02'),
(49, 5, 1, 'Punjabi Friendly Combo', 'Veg Sabji + 3 Tawa Roti + Salad', 255.00, 'Veg', 'punjabi thali.jpg', 'available', '2026-04-25 09:17:11'),
(50, 5, 1, ' Veg Hyderabadi Biryani Combo', 'Veg Hyderabadi Biryani + Raita + Kachumber.', 296.00, 'Veg', 'hyderabadi biryani.jpg', 'available', '2026-04-25 09:18:11'),
(51, 6, 1, ' Cheese Paneer Mix Paratha', '- Soft paratha stuffed with paneer, cheese, and flavorful spices', 175.00, 'Veg', 'paneer paratha.jpg', 'available', '2026-04-25 09:42:44'),
(52, 6, 1, ' Paneer Butter Masala', 'Paneer cubes in a rich, creamy, buttery tomato gravy.', 270.00, 'Veg', 'panner butter masala2.jpg', 'available', '2026-04-25 09:52:48'),
(53, 6, 1, ' Dal Khichdi', '- Comforting mix of rice and lentils cooked with mild spices', 220.00, 'Veg', 'dal khichidi.jpg', 'available', '2026-04-25 09:53:44'),
(54, 6, 1, '. Aloo Cheese Paratha', 'Paratha stuffed with spiced potatoes and melted cheese.', 140.00, 'Veg', 'aloo chese paratha.jpg', 'available', '2026-04-25 09:55:55'),
(55, 6, 1, 'Paneer Biryani', 'Fragrant basmati rice cooked with paneer and aromatic spices.', 220.00, 'Veg', 'paneer biryani.jpg', 'available', '2026-04-25 09:57:43'),
(56, 6, 1, 'Paneer Paratha', 'Soft paratha filled with spiced paneer stuffing', 150.00, 'Veg', 'panner paratha.jpg', 'available', '2026-04-25 10:00:53'),
(57, 6, 1, 'Palak Paneer', ' Paneer cubes in a smooth, spiced spinach gravy', 250.00, 'Veg', 'palak panner.jpg', 'available', '2026-04-25 10:02:02'),
(58, 6, 1, 'Matar Paneer', 'Paneer and green peas cooked in a rich tomato-based curry', 250.00, 'Veg', 'matar panner.jpg', 'available', '2026-04-25 10:04:07'),
(59, 6, 1, 'Mix Veg', 'Assorted vegetables cooked with traditional Indian spices.', 250.00, 'Veg', 'mix veg.jpg', 'available', '2026-04-25 10:05:40'),
(60, 6, 1, 'Aloo Palak', 'Potatoes cooked with spinach and mild spices.', 220.00, 'Veg', 'aloo palak.jpg', 'available', '2026-04-25 10:07:52'),
(61, 7, 1, 'Tandoori chicken', 'Juicy chicken marinated in spiced yogurt and roasted in a tandoor for a smoky, flavorful taste.', 630.00, 'Non-Veg', 'tandoori chicken.jpg', 'available', '2026-04-26 05:02:50'),
(62, 7, 1, 'mutton biryani ', 'Fragrant basmati rice layered with tender mutton and rich, aromatic spices.', 770.00, 'Non-Veg', 'mutton biryani.jpg', 'available', '2026-04-26 05:05:14'),
(63, 7, 1, 'chicken biryani', 'Aromatic basmati rice cooked with tender chicken and flavorful spices.', 680.00, 'Non-Veg', 'chicken biryani.jpg', 'available', '2026-04-26 05:06:59'),
(64, 7, 1, ' Butter chicken', 'Tender chicken cooked in a rich, creamy, buttery tomato gravy.', 550.00, 'Non-Veg', 'Butter chicken.jpg', 'available', '2026-04-26 05:09:18'),
(65, 7, 1, 'mughlai chicken', 'Rich and creamy chicken cooked in a mildly spiced gravy with nuts and aromatic flavors.', 540.00, 'Non-Veg', 'mughlai chicken.jpg', 'available', '2026-04-26 05:11:16'),
(66, 7, 1, 'mutton rara gosht', 'A rich dish made with tender mutton pieces and minced meat cooked in spicy, flavorful gravy.', 680.00, 'Non-Veg', 'mutton rara ghost.jpg', 'available', '2026-04-26 05:13:19'),
(67, 7, 1, 'mustard fish tikka', 'Fish pieces marinated in mustard spices and grilled to a smoky, tangy perfection.', 630.00, 'Non-Veg', 'mustard fish tikka.jpg', 'available', '2026-04-26 05:16:22'),
(68, 7, 1, 'egg curry', 'Boiled eggs cooked in a spiced, flavorful onion-tomato gravy.', 390.00, 'Non-Veg', 'egg curry.jpg', 'available', '2026-04-26 05:18:10'),
(69, 7, 1, 'mutton korma', 'Tender mutton cooked in a rich, creamy gravy with aromatic spices and a hint of sweetness.', 680.00, 'Non-Veg', 'mutton korma.jpg', 'available', '2026-04-26 05:19:47'),
(70, 7, 1, 'chicken chilli dry', 'Crispy chicken tossed in a spicy Indo-Chinese sauce with garlic, peppers, and bold flavors.', 540.00, 'Non-Veg', 'chicken chilli dry.jpg', 'available', '2026-04-26 05:21:39'),
(71, 8, 1, 'chicken Afghani tandoori', 'Juicy chicken marinated in a creamy, mildly spiced yogurt blend and roasted for a rich, smoky flavor.', 190.00, 'Non-Veg', 'chicken Afghani tandoori.jpg', 'available', '2026-04-26 05:23:51'),
(72, 8, 1, 'chicken tandoori', 'Juicy chicken marinated in spiced yogurt and roasted in a tandoor for a smoky, flavorful taste.', 160.00, 'Non-Veg', 'tandoori chicken.jpg', 'available', '2026-04-26 05:24:51'),
(73, 8, 1, ' chicken biryani', 'Aromatic basmati rice cooked with tender chicken and flavorful spices.', 210.00, 'Non-Veg', 'chicken biryani.jpg', 'available', '2026-04-26 05:25:43'),
(74, 8, 1, 'boneless butter chicken', 'Tender boneless chicken cooked in a rich, creamy, buttery tomato gravy.', 270.00, 'Non-Veg', 'boneless butter chicken.jpg', 'available', '2026-04-26 05:27:37'),
(75, 8, 1, 'mutton biryani', 'Fragrant basmati rice cooked with tender mutton and aromatic spices.', 240.00, 'Non-Veg', 'mutton biryani.jpg', 'available', '2026-04-26 05:28:37'),
(76, 8, 1, 'chicken masala', 'Tender chicken cooked in a rich, spiced onion-tomato gravy full of bold flavors.', 220.00, 'Non-Veg', 'chicken masala.jpg', 'available', '2026-04-26 05:30:56'),
(77, 8, 1, 'chicken roasted fried rice', 'Fried rice tossed with roasted chicken, vegetables, and savory sauces for a smoky, flavorful taste.', 210.00, 'Non-Veg', 'chicken roasted fried rice.jpg', 'available', '2026-04-26 05:32:27'),
(78, 8, 1, 'boneless chicken Lahori', 'Tender boneless chicken cooked in a rich, spicy Lahori-style gravy with bold, aromatic flavors.', 270.00, 'Non-Veg', 'boneless chicken Lahori.jpg', 'available', '2026-04-26 05:34:20'),
(79, 8, 1, 'egg biryani', 'Fragrant basmati rice cooked with boiled eggs and aromatic spices.', 200.00, 'Non-Veg', 'egg biryani.jpg', 'available', '2026-04-26 05:35:57'),
(80, 8, 1, 'prawns biryani', 'Fragrant basmati rice cooked with juicy prawns and aromatic spices for a rich, coastal flavor.', 290.00, 'Non-Veg', 'prawns biryani.jpg', 'available', '2026-04-26 05:38:06'),
(81, 13, 1, 'chicken biryani', 'Aromatic basmati rice cooked with tender chicken and flavorful spices.', 288.00, 'Non-Veg', 'chicken biryani.jpg', 'available', '2026-04-26 05:39:27'),
(82, 13, 1, 'chicken handi dum biryani', 'Aromatic basmati rice and tender chicken slow-cooked in a sealed handi for rich, authentic dum flavor.', 300.00, 'Non-Veg', 'chicken biryani.jpg', 'available', '2026-04-26 05:40:38'),
(83, 13, 1, 'mutton handi dum biryani', 'Fragrant basmati rice and tender mutton slow-cooked in a sealed handi for deep, authentic dum flavors.', 311.00, 'Non-Veg', 'mutton biryani.jpg', 'available', '2026-04-26 05:41:43'),
(84, 13, 1, 'chicken tandoori ', 'Juicy chicken marinated in spiced yogurt and roasted in a tandoor for a smoky, flavorful taste.', 230.00, 'Non-Veg', 'tandoori chicken.jpg', 'available', '2026-04-26 05:42:46'),
(85, 13, 1, 'chicken Dana', 'Juicy chicken cooked in a flavorful, mildly spiced gravy with rich aromatic taste.', 253.00, 'Non-Veg', 'chicken Dana.jpg', 'available', '2026-04-26 05:44:23'),
(86, 13, 1, 'chicken Afghani', 'Juicy chicken cooked in a creamy, mildly spiced gravy with rich, aromatic flavors.', 265.00, 'Non-Veg', 'chicken Afghani.jpg', 'available', '2026-04-26 05:46:06'),
(87, 13, 1, 'mutton curry', 'Tender mutton cooked in a rich, spiced gravy with bold, traditional flavors.', 230.00, 'Non-Veg', 'mutton curry.jpg', 'available', '2026-04-26 05:48:09'),
(88, 13, 1, 'chicken masala', 'Tender chicken cooked in a rich, spiced onion-tomato gravy full of bold flavors.', 253.00, 'Non-Veg', 'chicken masala.jpg', 'available', '2026-04-26 05:49:28'),
(89, 13, 1, 'egg biryani', 'Fragrant basmati rice cooked with boiled eggs and aromatic spices.', 217.00, 'Non-Veg', 'egg biryani.jpg', 'available', '2026-04-26 05:50:16'),
(90, 13, 1, 'prawns masala ', 'Juicy prawns cooked in a rich, spiced onion-tomato gravy with bold flavors.', 357.00, 'Non-Veg', 'prawns masala .jpg', 'available', '2026-04-26 05:51:36'),
(91, 9, 1, ' chicken biryani', 'Aromatic basmati rice cooked with tender chicken and flavorful spices.', 156.00, 'Non-Veg', 'chicken biryani.jpg', 'available', '2026-04-26 05:55:21'),
(92, 9, 1, 'chicken fried rice', 'Fried rice tossed with tender chicken, vegetables, and savory sauces for a flavorful meal.', 120.00, 'Non-Veg', 'chicken fried rice.jpg', 'available', '2026-04-26 05:57:40'),
(93, 9, 1, 'prawns masala ', 'Juicy prawns cooked in a rich, spiced onion-tomato gravy with bold flavors.', 200.00, 'Non-Veg', 'prawns masala .jpg', 'available', '2026-04-26 05:59:07'),
(94, 9, 1, 'mutton biryani', 'Fragrant basmati rice layered with tender mutton and rich, aromatic spices.', 234.00, 'Non-Veg', 'mutton biryani.jpg', 'available', '2026-04-26 06:00:16'),
(95, 9, 1, 'egg mughlai', 'Boiled eggs cooked in a rich, creamy Mughlai-style gravy with aromatic spices.', 350.00, 'Non-Veg', 'egg mughlai.jpg', 'available', '2026-04-26 06:01:44'),
(96, 9, 1, 'butter chicken', 'Tender chicken cooked in a rich, creamy, buttery tomato gravy.', 180.00, 'Non-Veg', 'Butter chicken.jpg', 'available', '2026-04-26 06:07:18'),
(97, 9, 1, 'chicken masala', 'Tender chicken cooked in a rich, spiced onion-tomato gravy full of bold flavors.', 150.00, 'Non-Veg', 'chicken masala.jpg', 'available', '2026-04-26 06:08:15'),
(98, 9, 1, 'egg curry', 'Boiled eggs cooked in a spiced, flavorful onion-tomato gravy.', 70.00, 'Non-Veg', 'egg curry.jpg', 'available', '2026-04-26 06:09:05'),
(99, 9, 1, 'chicken mughlai', 'Tender chicken cooked in a rich, creamy Mughlai-style gravy with aromatic spices.', 203.00, 'Non-Veg', 'mughlai chicken.jpg', 'available', '2026-04-26 06:10:26'),
(100, 9, 1, 'egg biryani', 'Fragrant basmati rice cooked with boiled eggs and aromatic spices.', 110.00, 'Non-Veg', 'egg biryani.jpg', 'available', '2026-04-26 06:13:03'),
(101, 12, 1, 'mutton korma', 'Tender mutton cooked in a rich, creamy gravy with aromatic spices and a hint of sweetness.', 455.00, 'Non-Veg', 'mutton korma.jpg', 'available', '2026-04-26 06:32:02'),
(102, 12, 1, 'mutton masala', 'Tender mutton cooked in a rich, spicy masala gravy with bold flavors.', 235.00, 'Non-Veg', 'mutton masala.jpg', 'available', '2026-04-26 06:34:17'),
(103, 12, 1, 'mutton kaleji masala', 'Tender mutton kaleji cooked in a spicy, aromatic masala with rich, bold flavors.', 390.00, 'Non-Veg', 'mutton kaleji masala.jpg', 'available', '2026-04-26 06:35:48'),
(104, 12, 1, 'chicken tikka masala', 'Grilled chicken tikka cooked in a rich, creamy tomato-based gravy with aromatic spices.', 310.00, 'Non-Veg', 'chicken tikka masala.jpg', 'available', '2026-04-26 06:37:07'),
(105, 12, 1, 'chicken mughlai', 'Tender chicken cooked in a rich, creamy Mughlai-style gravy with aromatic spices.', 390.00, 'Non-Veg', 'mughlai chicken.jpg', 'available', '2026-04-26 06:38:18'),
(106, 12, 1, 'chicken Korma', 'Tender chicken cooked in a rich, creamy gravy with mild spices and aromatic flavors.', 390.00, 'Non-Veg', 'chicken Korma.jpg', 'available', '2026-04-26 06:40:22'),
(107, 12, 1, 'chicken masala', 'Tender chicken cooked in a rich, spiced onion-tomato gravy full of bold flavors.', 130.00, 'Non-Veg', 'chicken masala.jpg', 'available', '2026-04-26 06:41:16'),
(108, 12, 1, 'chicken Angara', 'Smoky, spicy chicken cooked in a rich gravy with bold, fiery flavors.', 375.00, 'Non-Veg', 'chicken Angara.jpg', 'available', '2026-04-26 06:42:49'),
(109, 12, 1, 'white chicken Angara', 'Creamy, mildly spiced chicken with a smoky flavor, cooked in a rich white gravy.', 415.00, 'Non-Veg', 'white chicken Angara.jpg', 'available', '2026-04-26 06:44:39'),
(110, 12, 1, 'chicken tangadi', 'Juicy chicken drumsticks marinated in spices and roasted to a smoky, flavorful finish.', 390.00, 'Non-Veg', 'chicken tangadi.jpg', 'available', '2026-04-26 06:46:31'),
(111, 11, 1, 'Hyderabadi chicken biryani dum', 'Fragrant basmati rice and tender chicken slow-cooked on dum with rich, authentic Hyderabadi spices.', 200.00, 'Non-Veg', 'chicken biryani.jpg', 'available', '2026-04-26 06:49:00'),
(112, 11, 1, 'chicken chilli', 'Crispy chicken tossed in a spicy, tangy Indo-Chinese sauce with garlic and peppers.', 290.00, 'Non-Veg', 'chicken chilli dry.jpg', 'available', '2026-04-26 06:50:31'),
(113, 11, 1, 'chicken tikka masala', 'Grilled chicken tikka cooked in a rich, creamy tomato-based gravy with aromatic spices.', 210.00, 'Non-Veg', 'chicken tikka masala.jpg', 'available', '2026-04-26 06:52:04'),
(114, 11, 1, 'Butter chicken', 'Tender chicken cooked in a rich, creamy, buttery tomato gravy.', 210.00, 'Non-Veg', 'Butter chicken.jpg', 'available', '2026-04-26 06:53:02'),
(115, 11, 1, 'egg curry', 'Boiled eggs cooked in a spiced, flavorful onion-tomato gravy.', 130.00, 'Non-Veg', 'egg curry.jpg', 'available', '2026-04-26 06:53:55'),
(116, 11, 1, 'panner Manchurian', 'Crispy paneer tossed in a spicy, tangy Indo-Chinese sauce with garlic and peppers.', 200.00, 'Veg', 'panner Manchurian.jpg', 'available', '2026-04-26 06:55:16'),
(117, 11, 1, 'Paneer chilli', 'Crispy paneer tossed in a spicy, tangy Indo-Chinese sauce with garlic and peppers.', 200.00, 'Veg', 'panner chilli.jpg', 'available', '2026-04-26 06:57:25'),
(118, 11, 1, ' Dragon patato', 'Crispy fried potato strips coated in a spicy, tangy, and slightly sweet \r\nsauce.', 160.00, 'Veg', 'dragon patoto.jpg', 'available', '2026-04-26 06:58:15'),
(119, 11, 1, 'panner masala', 'Soft paneer cubes cooked in a rich, spiced onion-tomato gravy with bold flavors.', 180.00, 'Veg', 'panner masala.jpg', 'available', '2026-04-26 07:00:06'),
(120, 11, 1, 'panner butter masala', 'Paneer cubes in a rich, creamy, buttery tomato gravy.', 180.00, 'Veg', 'Paneer butter masala.jpg', 'available', '2026-04-26 07:01:32'),
(121, 16, 1, 'mac spicy panner burger', 'A crispy paneer patty layered with fresh veggies and zesty sauces, packed in a soft bun for a bold, spicy, and satisfying bite.', 164.00, 'Veg', 'mac spicy panner burger.jpg', 'available', '2026-04-26 07:04:52'),
(122, 16, 1, 'veg maharaja mac ', 'A double-layered burger loaded with crispy veg patties, fresh lettuce, cheese, and creamy sauces for a rich and satisfying meal.', 181.00, 'Veg', 'veg maharaja mac.jpg', 'available', '2026-04-26 07:08:14'),
(123, 16, 1, 'big spicy paneer wrap', 'Soft wrap filled with spicy paneer, fresh veggies, and zesty sauces for a bold, flavorful bite.', 203.00, 'Veg', 'big spicy paneer wrap.jpg', 'available', '2026-04-26 07:09:55'),
(124, 16, 1, 'corn and cheese burger', 'Crispy corn and cheese patty with fresh veggies and creamy sauces in a soft bun.', 133.00, 'Veg', 'corn and cheese burger.jpg', 'available', '2026-04-26 07:11:42'),
(125, 16, 1, 'mc spicy chicken burger', 'Juicy, spicy chicken patty layered with lettuce and creamy sauce in a soft bun.', 169.00, 'Non-Veg', 'mc spicy chicken burger.jpg', 'available', '2026-04-26 07:13:35'),
(126, 16, 1, 'chicken nuggets ', 'Crispy, bite-sized chicken pieces, golden fried and perfect for snacking.', 443.00, 'Non-Veg', 'chicken nuggets 20 pieces.jpg', 'available', '2026-04-26 07:15:26'),
(127, 16, 1, 'chicken Maharaja mac burger', 'Double chicken patties stacked with cheese, fresh veggies, and rich sauces for a hearty meal.', 272.00, 'Non-Veg', 'chicken Maharaja mac burger.jpg', 'available', '2026-04-26 07:16:37'),
(128, 16, 1, ' big spicy chicken wrap', 'Soft wrap filled with spicy chicken, fresh veggies, and zesty sauces for a bold flavor.', 220.00, 'Non-Veg', 'big spicy chicken wrap.jpg', 'available', '2026-04-26 07:18:08'),
(129, 16, 1, 'mac aloo tikki burger', 'Crispy spiced potato patty with fresh veggies and tangy sauces in a soft bun.', 150.00, 'Veg', 'mac aloo tikki burger.jpg', 'available', '2026-04-26 07:19:22'),
(130, 16, 1, 'cheese fries', 'Crispy fries topped with melted cheese for a rich, indulgent snack.', 133.00, 'Veg', 'cheese fries.jpg', 'available', '2026-04-26 07:20:40'),
(131, 15, 1, 'panner tikka masala', 'Made with fresh in house prepared paneer.', 400.00, 'Veg', 'Panner tikka masala1.jpg', 'available', '2026-04-26 07:22:47'),
(132, 15, 1, 'veg biryani', 'Fragrant basmati rice cooked with mixed vegetables and aromatic spices for a flavorful meal.', 350.00, 'Veg', 'veg biryani.jpg', 'available', '2026-04-26 07:26:28'),
(133, 15, 1, 'veg club sandwich', 'Layered sandwich with fresh veggies, cheese, and sauces, grilled for a crispy, tasty bite.', 300.00, 'Veg', 'veg club sandwich.jpg', 'available', '2026-04-26 07:28:26'),
(134, 15, 1, 'tandoori soya chaap', 'Juicy soya chaap marinated in spiced yogurt and roasted for a smoky, tandoori flavor.', 280.00, 'Veg', 'tandoori soya chaap.jpg', 'available', '2026-04-26 07:29:43'),
(135, 15, 1, 'chilli panner with fried rice', 'Spicy chilli paneer served with flavorful veg fried rice for a perfect combo.', 250.00, 'Veg', 'chilli panner with fried rice.jpg', 'available', '2026-04-26 07:31:26'),
(136, 15, 1, 'kadhai chicken', 'Chicken cooked with bell peppers and bold spices in a rich, aromatic gravy.', 550.00, 'Non-Veg', 'kadhai chicken.jpg', 'available', '2026-04-26 07:32:42'),
(137, 15, 1, 'Hyderabadi chicken dum  biryani', 'Fragrant basmati rice and tender chicken slow-cooked on dum with authentic Hyderabadi spices.', 650.00, 'Non-Veg', 'chicken biryani.jpg', 'available', '2026-04-26 07:34:06'),
(138, 15, 1, 'laal maas', 'Spicy Rajasthani mutton curry cooked with red chilies and rich, bold flavors.', 650.00, 'Non-Veg', 'laal maas.jpg', 'available', '2026-04-26 07:35:20'),
(139, 15, 1, 'mutton Rogan Josh', 'Tender mutton cooked in a rich, aromatic gravy with traditional Kashmiri spices.', 650.00, 'Non-Veg', 'mutton Rogan Josh.jpg', 'available', '2026-04-26 07:36:22'),
(140, 15, 1, ' chicken 65', 'Crispy, spicy fried chicken tossed with bold South Indian flavors and curry leaves.', 500.00, 'Non-Veg', 'chicken 65.jpg', 'available', '2026-04-26 07:37:27'),
(141, 17, 1, 'corn and cheese pizza', 'A cheesy delight topped with sweet corn and rich melted cheese on a crispy crust.', 230.00, 'Veg', 'corn and cheese pizza.jpg', 'available', '2026-04-26 07:43:05'),
(142, 17, 1, 'veggie feast pizza', 'Loaded with a variety of fresh vegetables and melted cheese on a crispy crust.', 270.00, 'Veg', 'veggie feast pizza.jpg', 'available', '2026-04-26 07:44:50'),
(143, 17, 1, 'veggie supreme', 'A delicious pizza topped with premium veggies, rich cheese, and flavorful seasoning.', 380.00, 'Veg', 'veggie supreme.jpg', 'available', '2026-04-26 07:47:27'),
(144, 17, 1, 'tandoori paneer pizza', 'Spicy tandoori paneer with veggies and melted cheese on a crispy crust.', 330.00, 'Veg', 'tandoori paneer pizza.jpg', 'available', '2026-04-26 07:49:31'),
(145, 17, 1, 'mexican fiesta ', 'Loaded with zesty Mexican flavors, veggies, and cheesy goodness.', 330.00, 'Veg', 'mexican fiesta.jpg', 'available', '2026-04-26 07:51:12'),
(146, 17, 1, 'chicken tikka pizza', 'Smoky chicken tikka with rich spices and melted cheese on a crisp base.', 400.00, 'Non-Veg', 'chicken tikka pizza.jpg', 'available', '2026-04-26 07:53:03'),
(147, 17, 1, 'chicken paproni pizza', 'Classic pizza topped with juicy chicken pepperoni and melted cheese.', 380.00, 'Non-Veg', 'chicken paproni pizza.jpg', 'available', '2026-04-26 07:54:52'),
(148, 17, 1, 'masala kema garlic bread', 'Garlic bread topped with spiced keema and herbs for a rich, savory bite.', 190.00, 'Non-Veg', 'masala kema garlic bread.jpg', 'available', '2026-04-26 07:57:54'),
(149, 17, 1, 'chicken sausage pizza', 'Juicy chicken sausage with melted cheese on a crispy pizza base.', 260.00, 'Non-Veg', 'chicken sausage pizza.jpg', 'available', '2026-04-26 07:59:40'),
(150, 17, 1, 'nawabi murgh makhani pizza', 'Creamy butter chicken flavors topped with cheese on a rich, indulgent pizza crust.', 400.00, 'Non-Veg', 'nawabi murgh makhani pizza.jpg', 'available', '2026-04-26 08:03:24'),
(151, 18, 1, 'panner tikka masala', 'Made with fresh in house prepared paneer.', 290.00, 'Veg', 'Panner tikka masala1.jpg', 'available', '2026-04-26 08:04:50'),
(152, 18, 1, 'dal fry ', 'Tempered lentils cooked with spices for a simple, flavorful dish.', 110.00, 'Veg', 'dal fry.jpg', 'available', '2026-04-26 08:06:28'),
(153, 18, 1, 'panner butter masala', 'Paneer cubes in a rich, creamy, buttery tomato gravy.', 130.00, 'Veg', 'panner butter masala2.jpg', 'available', '2026-04-26 08:07:30'),
(154, 18, 1, 'panner bhurji ', 'Scrambled paneer cooked with onions, tomatoes, and spices.', 130.00, 'Veg', 'panner bhurji.jpg', 'available', '2026-04-26 08:11:27'),
(155, 18, 1, 'panner kaju', 'Paneer cooked in a rich, creamy cashew-based gravy.', 180.00, 'Veg', 'panner kaju.jpg', 'available', '2026-04-26 08:13:13'),
(156, 18, 1, 'Egg kadhai', 'Boiled eggs cooked with peppers and spices in a flavorful kadhai-style gravy.', 150.00, 'Non-Veg', 'Egg kadhai.jpg', 'available', '2026-04-26 08:15:47'),
(157, 18, 1, 'chicken Afghani', 'Juicy chicken cooked in a creamy, mildly spiced gravy with rich flavors.', 220.00, 'Non-Veg', 'chicken Afghani.jpg', 'available', '2026-04-26 08:16:53'),
(158, 18, 1, 'chicken kadhai', 'Chicken cooked with bell peppers and bold spices in a rich, aromatic gravy.', 230.00, 'Non-Veg', 'chicken kadhai.jpg', 'available', '2026-04-26 08:19:37'),
(159, 18, 1, 'chicken kaju masala', 'Tender chicken cooked in a rich, creamy cashew-based gravy.', 220.00, 'Non-Veg', 'chicken kaju masala.jpg', 'available', '2026-04-26 08:20:59'),
(160, 18, 1, 'chicken Angara', 'Smoky, spicy chicken cooked in a rich gravy with bold, fiery flavors.', 180.00, 'Non-Veg', 'chicken Angara.jpg', 'available', '2026-04-26 08:22:18'),
(161, 10, 1, 'Veggie Delite sub', 'A light and refreshing sub loaded with lettuce, tomatoes, cucumbers, olives, onions, and sauces. Perfect if you want a healthy, low-calorie option with crunchy freshness', 220.00, 'Veg', 'Veggie Delite.jpg', 'available', '2026-04-26 08:29:21'),
(162, 10, 1, 'Paneer Tikka', 'Soft paneer cubes marinated in Indian spices (tandoori style), giving a smoky, spicy flavor with veggies and sauces one of the most loved Indian-style subs', 250.00, 'Veg', 'panner tikka sub.jpg', 'available', '2026-04-26 08:31:14'),
(163, 10, 1, 'Aloo Patty Sub', 'Crispy potato patty seasoned with herbs and spices, paired with fresh veggies. It tastes like a desi burger-style sandwich in sub form', 250.00, 'Veg', 'Aloo Patty.jpg', 'available', '2026-04-26 08:34:33'),
(164, 10, 1, 'Chilli Bean Patty', 'A flavorful mix of red & black beans shaped into a patty, giving a protein-rich, slightly spicy and smoky taste with sauces and veggies.', 260.00, 'Veg', 'Chilli Bean Patty.jpg', 'available', '2026-04-26 08:37:04'),
(165, 10, 1, 'Corn & Peas Sub', 'Sweet corn and green peas filling with mild seasoning—this sub is slightly sweet, creamy, and very balanced for those who prefer less spice', 240.00, 'Veg', 'Corn & Peas.jpg', 'available', '2026-04-26 08:38:49'),
(166, 10, 1, 'Tandoori Chicken Tikka', 'Juicy chicken marinated in yogurt, garlic, and Indian spices, baked to perfection. Offers a bold tandoori flavor with smoky richness.', 280.00, 'Non-Veg', 'Tandoori Chicken Tikka.jpg', 'available', '2026-04-26 08:42:21'),
(167, 10, 1, 'Chicken Teriyaki Sub', 'Tender chicken coated in sweet teriyaki sauce. A perfect mix of sweet + savory taste with soft texture.', 280.00, 'Non-Veg', 'Chicken Teriyaki.jpg', 'available', '2026-04-26 08:44:30'),
(168, 10, 1, 'Peri Peri Chicken Sub', 'Spicy African peri-peri flavored chicken with veggies. Ideal for those who love extra spicy and tangy taste.', 290.00, 'Non-Veg', 'Peri Peri Chicken.jpg', 'available', '2026-04-26 08:46:23'),
(169, 10, 1, 'Chicken Meatball Sub', 'Soft chicken meatballs in rich tomato sauce, topped with veggies and cheese. A juicy, saucy, and filling comfort sub', 270.00, 'Non-Veg', 'Chicken Meatball.jpg', 'available', '2026-04-26 08:47:55'),
(170, 10, 1, 'Italian B.M.T', 'Loaded with chicken pepperoni, smoked chicken, and sauces his is a protein-packed, flavorful, and slightly smoky classic sub.', 310.00, 'Non-Veg', 'italian.jpg', 'available', '2026-04-26 08:51:56'),
(171, 14, 1, 'Chicken Kabab', ' Leg piece of chicken marinated in curd with Indian spices\r\n', 555.00, 'Non-Veg', 'chicken kabab.jpg', 'available', '2026-04-27 07:59:05'),
(172, 14, 1, 'Mutton Handi', 'Tender mutton slow-cooked in a clay pot with rich spices and gravy.', 880.00, 'Non-Veg', 'mutton handi.jpg', 'available', '2026-04-27 08:00:29'),
(173, 14, 1, 'Fish Finger', ' crispy golden-fried fish strips coated in seasoned breadcrumbs, soft and flaky inside.\r\n', 650.00, 'Non-Veg', 'fish finger.jpg', 'available', '2026-04-27 08:01:58'),
(174, 14, 1, 'Fish Curry', 'Tender fish simmered in a spiced gravy with aromatic herbs and rich flavors.', 695.00, 'Non-Veg', 'fish curry.jpg', 'available', '2026-04-27 08:03:28'),
(175, 14, 1, 'Grilled Chicken ', 'juicy chicken marinated in spices and grilled to smoky, flavorful perfection.\r\n', 660.00, 'Non-Veg', 'grilled chicken.jpg', 'available', '2026-04-27 08:05:20'),
(176, 14, 1, 'Hara Bhara Kabab', 'Hara Bhara Kabab: soft patties made with spinach, peas, and potatoes, lightly spiced and pan-fried to a crisp outside.\r\n\r\n', 320.00, 'Veg', 'hara bhara kabab.jpg', 'available', '2026-04-27 08:06:56'),
(177, 14, 1, 'Tandoori Chaat', ' smoky tandoori-grilled ingredients tossed with tangy chutneys, spices, and fresh toppings.', 315.00, 'Veg', 'tandoori chat.jpg', 'available', '2026-04-27 08:08:26'),
(178, 14, 1, 'Spring Roll', 'crispy rolled pastry filled with seasoned vegetables, fried to a golden crunch.', 320.00, 'Veg', 'spring roll.jpg', 'available', '2026-04-27 08:10:14'),
(179, 14, 1, 'Basil Potato', ' crispy potatoes tossed with fresh basil, garlic, and light seasoning for a fragrant, savory flavor.', 430.00, 'Veg', 'basil potato.jpg', 'available', '2026-04-27 08:12:28'),
(180, 14, 1, 'Malai Kofta', 'soft paneer and potato dumplings served in a rich, creamy, mildly spiced gravy.\r\n', 435.00, 'Veg', 'malai kofta.jpg', 'available', '2026-04-27 08:13:54');

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `log_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `action` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `notification_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_notifications`
--

INSERT INTO `admin_notifications` (`notification_id`, `order_id`, `admin_id`, `message`, `status`, `created_at`) VALUES
(1, 5, 1, '🛒 New Order #5 received', 'read', '2026-04-28 07:54:10'),
(2, 6, 1, '🛒 New Order #6 received', 'read', '2026-04-28 08:44:22');

-- --------------------------------------------------------

--
-- Table structure for table `admin_orders`
--

CREATE TABLE `admin_orders` (
  `admin_order_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `updated_status` enum('pending','confirmed','preparing','out_for_delivery','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_restaurants`
--

CREATE TABLE `admin_restaurants` (
  `hotel_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` enum('veg','nonveg','both') DEFAULT 'both',
  `open_time` enum('06:00 AM','07:00 AM','08:00 AM','09:00 AM','10:00 AM') DEFAULT NULL,
  `close_time` enum('06:00 PM','07:00 PM','08:00 PM','09:00 PM','10:00 PM','11:00 PM') DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_restaurants`
--

INSERT INTO `admin_restaurants` (`hotel_id`, `admin_id`, `name`, `description`, `category`, `open_time`, `close_time`, `address`, `phone`, `image`, `created_at`) VALUES
(1, 1, 'The Bethak Restaurant & Parcel Point', 'Chinese, Beverages, Biryani, North Indian, Fast Food, Gujarati, Indo-Chinese, South Indian', 'veg', '10:00 AM', '11:00 PM', 'Shop 2, Ranjit Sagar Road, Near Goti Complex, Green City, Jamnagar', '1234567890', 'bethak restrarant.jpg', '2026-04-22 09:07:33'),
(2, 1, 'Hotel Aaram', 'Hotel Aram in Jamnagar is an award-winning 3-star heritage hotel with over 50 years of history, located in a Victorian-style building with lush gardens. ', 'veg', '10:00 AM', '11:00 PM', 'Hotel Aram is located at Nand Niwas, Opposite DKV College, Pandit Nehru Marg, Jamnagar, Gujarat 361008, India', '12345678', 'hotel aram.jpeg', '2026-04-25 04:50:20'),
(3, 1, 'Krishna Fast Food', 'Krishna Fast Food, particularly the popular outlet in Ranjitnagar, Jamnagar, is a well-regarded vegetarian fast-food spot known for its diverse menu, including Indo-Chinese dishes, South Indian items, and chaat. ', 'veg', '10:00 AM', '11:00 PM', 'Harsiddhi Mata Road, Near Shak Market HUDCO, Jamnagar Locality, Jamnagar', '1234567890', 'krishina fast food.jpg', '2026-04-25 04:57:01'),
(4, 1, 'Kitchen Age Eatery', 'Kitchen Age Eatery in Jamnagar (Patel Colony/Saru Section Road) is a highly-rated, casual, pure vegetarian restaurant known for its diverse menu, including North Indian, Chinese, Italian, and fast food', 'veg', '10:00 AM', '11:00 PM', '11 NUMBER, PATEL COLONY, CORNER, Jamnagar', '1234567890', 'kitchen age eatery.jpg', '2026-04-25 05:03:06'),
(5, 1, 'Hotel Kalatit International – Rajbhog Restaurant', 'Rajbhog Restaurant, located within Hotel Kalatit International in Jamnagar, is a popular pure-vegetarian, multi-cuisine dining venue known for its authentic Gujarati thalis and global cuisine, including Punjabi, Italian, and Pan-Asian dishes.', 'veg', '10:00 AM', '11:00 PM', 'Nr, DSP Bunglow Rd, Maheswari Nagar, Kadiawad, Jamnagar', '1234567890', 'hotel kalawati.jpg', '2026-04-25 05:09:11'),
(6, 1, 'Meredian Food Corner', 'Meridian Food Corner is a popular local eatery in Jamnagar, particularly known for its diverse vegetarian menu and dedicated breakfast service', 'veg', '10:00 AM', '11:00 PM', '10, next to Vahanvati hospital, Patel Colony, Jamnagar', '1234567890', 'merdian food corner.jpg', '2026-04-25 05:13:02'),
(7, 1, 'Spicy Bite Multicuisine Restaurant', 'Spicy Bite Multicuisine Restaurant in Jamnagar is a premium dining destination known for its diverse menu, aesthetic ambiance, and specialized mocktail bar. ', 'nonveg', '10:00 AM', '11:00 PM', 'Vinayak Plaza, Near Digjam Circle, Khodiyar Colony, Jamnagar', '1234567890', 'spice bite multicuisne.jpg', '2026-04-25 05:17:26'),
(8, 1, 'SK Restaurant', 'SK Restaurant (Family) in Jamnagar is a highly-rated dining spot (approx. 4.1 stars) recognized for its non-vegetarian specialties, including Chicken Malai Tikka, tandoori dishes, andbiryani', 'nonveg', '10:00 AM', '11:00 PM', 'Patni Wad, Panch Hatadi, Main Chowk, Jamnagar Locality, Jamnagar', '1234567890', 'SK Restaurant.jpg', '2026-04-25 05:20:42'),
(9, 1, 'Indian Restaurant', 'North Indian, Chinese, Mughlai, Biryani, Seafood, Street Food', 'nonveg', '10:00 AM', '11:00 PM', 'Raj Park Society, Near Reliance Pump, Rajkot Road, Jamnagar Locality, Jamnagar\r\n', '1234567890', 'Indian Restaurant.jpg', '2026-04-25 05:25:21'),
(10, 1, 'Subway', 'Healthy Food, Fast Food, Sandwich, Salad', 'both', '10:00 AM', '11:00 PM', 'Shop 1, 2, 3, Street 7, Patel Colony, Silver Plaza, Pandit Nehru Marg, Jamnagar Locality, Jamnagar', '1234567890', 'subway.jpg', '2026-04-25 05:29:06'),
(11, 1, 'Hot Stuff', 'In Jamnagar, there are a couple of locations for Hot Stuff (sometimes listed as Hotstuff), primarily known for North Indian and Mughlai takeaway and delivery', 'both', '10:00 AM', '11:00 PM', 'Shop 4, Gauni Tower, Saru Section Road, Bedeswar, Khodiyar Colony, Jamnagar\r\n', '1234567890', 'chicken biryani.jpg', '2026-04-25 05:35:05'),
(12, 1, ' Rajdhani Family Restaurant ', 'This is a popular spot for fast food and North Indian non-veg specials.', 'nonveg', '10:00 AM', '11:00 PM', 'Plot 74, Noori Chokadi, Mahaprabhuji, Bethak Road, Jamnagar Locality, Jamnagar', '1234567890', 'Rajdhani Restaurant.jpg', '2026-04-25 05:39:36'),
(13, 1, 'Cafe Paradise Restaurant', 'North Indian, Chinese', 'nonveg', '10:00 AM', '11:00 PM', 'Bedi Rd, Kadiawad, Jamnagar,\r\n', '1234567890', 'cafe paradise.jpg', '2026-04-25 05:44:07'),
(14, 1, 'Hotel Vishal International', 'South Indian, North Indian, Chinese, Fast Food', 'both', '10:00 AM', '11:00 PM', 'Hotel Vishal International, Airport Road, near Mehul Cinemax, Ajanta Society, Jamnagar', '1234567890', 'vishal hotel.jpg', '2026-04-25 05:46:58'),
(15, 1, 'Lords Eco Inn ', 'North Indian Chinese Salad Continental Beverages', 'both', '10:00 AM', '11:00 PM', 'GIDC  Phase-3 Apple Gate 1 Green City, Jamnagar', '1234567890', 'lord eco inn.jpg', '2026-04-25 05:53:59'),
(16, 1, 'McDonalds', 'McDonalds is the worlds leading global food service retailer operating over 45000 restaurants in more than 100 countries While famously known for burgers and fries', 'both', '10:00 AM', '11:00 PM', 'Survey 44 Reliance Mall, Ground Floor Satyam Colony Jamnagar', '1234567890', 'mac donald.jpg', '2026-04-25 06:02:34'),
(17, 1, 'Pizza Hut', 'Pizza Hut is one of the worlds most iconic pizza chains, famous for its Signature Pan Pizza and the invention of the Stuffed Crust.', 'both', '10:00 AM', '11:00 PM', 'Shop No 1 Ground Floor HB Empire, Pandit Nehru Marg, opposite Dhanvantri Ground, Jamnagar, Gujarat 361006', '1234567890', 'pizza hut.jpg', '2026-04-25 06:05:22'),
(18, 1, 'Delhi Darbar Restaurant', 'Delhi Darbar is a popular family-run restaurant in Jamnagar, especially known for its non-vegetarian Mughlai and Punjabi cuisine. It has been a local staple since 2009.', 'both', '10:00 AM', '11:00 PM', ' Jamnagar-Rajkot Highway, Opp. Gulabnagar Police Chowki, Gulabnagar, Jamnagar, Gujarat 361007.', '1234567890', 'delhi darbar.jpg', '2026-04-25 06:09:00');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`admin_id`, `name`, `email`, `password`, `phone`, `profile_image`, `created_at`) VALUES
(1, 'taksh', 'jiyanshutaksh@gmail.com', '$2y$10$zLRUO8e3btPUpUZ8cg9xhO/31slX.NENbPeEzpXCcONVYiOYzKiD.', '1234567890', 'profile.png', '2026-04-22 06:15:50');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `food_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` int(11) NOT NULL,
  `variant` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `message_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_complaints`
--

CREATE TABLE `delivery_complaints` (
  `complaint_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `issue_type` enum('late','rude','wrong_order','other') DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `food_id` int(11) NOT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `category` enum('Veg','Non-Veg') DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('available','unavailable') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food_reviews`
--

CREATE TABLE `food_reviews` (
  `review_id` int(11) NOT NULL,
  `food_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food_variants`
--

CREATE TABLE `food_variants` (
  `id` int(11) NOT NULL,
  `food_id` int(11) DEFAULT NULL,
  `variant_name` enum('Half','Full','Regular','Large') NOT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_variants`
--

INSERT INTO `food_variants` (`id`, `food_id`, `variant_name`, `price`) VALUES
(1, 2, 'Half', 200.00),
(2, 2, 'Full', 300.00),
(3, 3, 'Half', 140.00),
(4, 3, 'Full', 300.00),
(5, 4, 'Half', 142.00),
(6, 4, 'Full', 290.00),
(7, 5, 'Half', 250.00),
(8, 5, 'Full', 310.00),
(9, 8, 'Half', 250.00),
(10, 8, 'Full', 348.00),
(11, 10, 'Half', 280.00),
(12, 10, 'Full', 348.00),
(13, 141, 'Regular', 200.00),
(14, 141, 'Large', 300.00),
(15, 142, 'Regular', 200.00),
(16, 142, 'Large', 350.00),
(17, 143, 'Regular', 300.00),
(18, 143, 'Large', 400.00),
(19, 144, 'Regular', 400.00),
(20, 144, 'Large', 500.00),
(21, 145, 'Regular', 400.00),
(22, 145, 'Large', 500.00),
(23, 146, 'Regular', 450.00),
(24, 146, 'Large', 550.00),
(25, 147, 'Regular', 400.00),
(26, 147, 'Large', 500.00),
(27, 149, 'Regular', 300.00),
(28, 149, 'Large', 400.00),
(29, 150, 'Regular', 500.00),
(30, 150, 'Large', 600.00);

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `hotel_id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `order_status` enum('pending','confirmed','preparing','out_for_delivery','delivered','cancelled') DEFAULT 'pending',
  `payment_method` enum('COD','ONLINE') DEFAULT NULL,
  `payment_status` enum('pending','paid') DEFAULT 'pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `hotel_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `gst` decimal(10,2) DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `order_status`, `payment_method`, `payment_status`, `order_date`, `hotel_id`, `created_at`, `gst`, `grand_total`, `address`) VALUES
(1, 1, 0.00, 'pending', 'ONLINE', 'pending', '2026-04-28 06:30:58', NULL, '2026-04-28 06:30:58', 115.38, 756.38, 'Jamnagar'),
(2, 1, 641.00, 'pending', 'ONLINE', 'pending', '2026-04-28 06:31:31', NULL, '2026-04-28 06:31:31', 115.38, 756.38, 'Jamnagar'),
(3, 1, 641.00, 'pending', 'ONLINE', 'pending', '2026-04-28 06:33:25', NULL, '2026-04-28 06:33:25', 115.38, 756.38, 'Jamnagar'),
(4, 1, 641.00, 'pending', 'ONLINE', 'pending', '2026-04-28 06:35:10', NULL, '2026-04-28 06:35:10', 115.38, 756.38, 'Jamnagar'),
(5, 1, 100.00, 'pending', 'COD', 'pending', '2026-04-28 07:54:10', NULL, '2026-04-28 07:54:10', 18.00, 118.00, 'Jamnagar'),
(6, 1, 100.00, 'pending', 'COD', 'pending', '2026-04-28 08:44:22', NULL, '2026-04-28 08:44:22', 18.00, 118.00, 'Jamnagar');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `food_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `variant` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `food_id`, `name`, `quantity`, `price`, `variant`, `created_at`) VALUES
(2, 4, 1, 'Idli [2Pcs]', 1, 100.00, '', '2026-04-28 06:35:10'),
(3, 4, 11, 'Veg Manchurian Dry', 1, 385.00, '', '2026-04-28 06:35:10'),
(4, 4, 91, ' chicken biryani', 1, 156.00, '', '2026-04-28 06:35:10'),
(5, 5, 1, 'Idli [2Pcs]', 1, 100.00, '', '2026-04-28 07:54:10'),
(6, 6, 1, 'Idli [2Pcs]', 1, 100.00, '', '2026-04-28 08:44:22');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `page_id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_method` enum('COD','ONLINE') DEFAULT NULL,
  `payment_status` enum('pending','success','failed') DEFAULT 'pending',
  `transaction_id` varchar(100) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL DEFAULT 1,
  `site_name` varchar(100) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `logo`, `contact_email`, `contact_phone`) VALUES
(1, 'Quick Bite', 'logo.jpeg', 'admin@quickbite.com', '9999999999');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','blocked') DEFAULT 'active',
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone`, `address`, `created_at`, `status`, `image`) VALUES
(1, 'Taksh', 'jiyanshutaksh@gmail.com', '$2y$10$SjtQO3mfq.tw4OUXmNb0EunKFHLGp/9n1L169uUgZJkX7yf3E3cg.', '1234567890', 'Jamnagar', '2026-04-28 05:39:18', 'active', '1777354758_profile.png'),
(2, 'Taksh', 'takshbarot38@gamil.com', '$2y$10$YftkumiRJF./yDxmRl2fB.bWdEmw8cHghNxR.6uGyC0LfkDb8Rzim', '1234567890', 'Jamnagar\r\n', '2026-04-29 05:22:46', 'active', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_delivery`
--
ALTER TABLE `admin_delivery`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `admin_food_items`
--
ALTER TABLE `admin_food_items`
  ADD PRIMARY KEY (`food_id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `fk_food_restaurant` (`hotel_id`);

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `admin_orders`
--
ALTER TABLE `admin_orders`
  ADD PRIMARY KEY (`admin_order_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `admin_restaurants`
--
ALTER TABLE `admin_restaurants`
  ADD PRIMARY KEY (`hotel_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cart_food_fk` (`food_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `delivery_complaints`
--
ALTER TABLE `delivery_complaints`
  ADD PRIMARY KEY (`complaint_id`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`food_id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `food_reviews`
--
ALTER TABLE `food_reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `food_variants`
--
ALTER TABLE `food_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_id` (`food_id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`hotel_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `fk_order_food` (`food_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_delivery`
--
ALTER TABLE `admin_delivery`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_food_items`
--
ALTER TABLE `admin_food_items`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_orders`
--
ALTER TABLE `admin_orders`
  MODIFY `admin_order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_restaurants`
--
ALTER TABLE `admin_restaurants`
  MODIFY `hotel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_complaints`
--
ALTER TABLE `delivery_complaints`
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food_reviews`
--
ALTER TABLE `food_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food_variants`
--
ALTER TABLE `food_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `hotel_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_delivery`
--
ALTER TABLE `admin_delivery`
  ADD CONSTRAINT `admin_delivery_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_delivery_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin_users` (`admin_id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_food_items`
--
ALTER TABLE `admin_food_items`
  ADD CONSTRAINT `admin_food_items_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin_users` (`admin_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_food_restaurant` FOREIGN KEY (`hotel_id`) REFERENCES `admin_restaurants` (`hotel_id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD CONSTRAINT `admin_logs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin_users` (`admin_id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD CONSTRAINT `admin_notifications_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_notifications_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin_users` (`admin_id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_orders`
--
ALTER TABLE `admin_orders`
  ADD CONSTRAINT `admin_orders_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_orders_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin_users` (`admin_id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_restaurants`
--
ALTER TABLE `admin_restaurants`
  ADD CONSTRAINT `admin_restaurants_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin_users` (`admin_id`) ON DELETE SET NULL;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_food_fk` FOREIGN KEY (`food_id`) REFERENCES `admin_food_items` (`food_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `food_items`
--
ALTER TABLE `food_items`
  ADD CONSTRAINT `food_items_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`) ON DELETE CASCADE;

--
-- Constraints for table `food_variants`
--
ALTER TABLE `food_variants`
  ADD CONSTRAINT `food_variants_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `admin_food_items` (`food_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_food` FOREIGN KEY (`food_id`) REFERENCES `admin_food_items` (`food_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

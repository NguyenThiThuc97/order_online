--
-- Database: `dborderonline`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addNewCus` (IN `cusName` VARCHAR(100), IN `phone` INT(15), IN `address` VARCHAR(100), IN `pass` VARCHAR(100))  BEGIN

insert into customer(customerName, phone, address, pass) VALUES(cusName, phone, address, pass);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `addNewEmp` (IN `names` VARCHAR(100), IN `passs` VARCHAR(100))  BEGIN
insert into employee(name, pass) values(names, passs);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `addNewOrders` (IN `shipDate` DATETIME, `shipComID` INT(15), `discount` INT(15), `user_buy` INT(15), `address` VARCHAR(150), `sumOrders` INT(15))  BEGIN
	insert into orders(orderID, shipDate, shipCompanyID, discounnt, user_buy, address, sumOrders) value(now(), shipDate, shipComID, discount, user_buy, address, 0);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_new_category` (IN `name` VARCHAR(100))  BEGIN
insert into productcategory(productcategory.categoryName) values(name);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_new_product` (IN `name` VARCHAR(100), IN `cateID` INT(15), IN `unitNames` VARCHAR(50), IN `unitScales` INT(15), IN `discontinueds` INT(1), IN `discontinuedPrices` INT(15), IN `empIds` INT(15), IN `prices` INT(15), IN `images` VARCHAR(100))  BEGIN
insert into product(productName, categoryID, unitName, unitScale, discontinued, discontinuedPrice, empId, dateCreate, price, product_image) values(name, cateID, unitNames, unitScales, discontinueds, discontinuedPrices, empIds, now(), prices, images);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteCus` (IN `ids` INT(15), IN `name` VARCHAR(100), IN `cateID` INT(15), IN `unitNames` VARCHAR(50), IN `unitScales` INT(15), IN `discontinueds` INT(1), IN `discontinuedPrices` INT(15), IN `prices` INT(15), IN `images` VARCHAR(100))  BEGIN
update product set productName=name, categoryID=cateID, unitName=unitNames, unitScale=unitScales, discontinued=discontinueds, discontinuedPrice=discontinuedPrices,price=prices, product_image=images where productID=ids;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteEmployee` (IN `ids` INT(15))  BEGIN
 delete from employee where id=ids;
 END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_category` (IN `ids` INT(15))  BEGIN
delete from productcategory where productcategory.categoryID=ids;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_product` (IN `ids` INT(15))  BEGIN
delete from product where product.productID=ids;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCus` (IN `ids` INT(15), IN `name` VARCHAR(100), IN `cusPhone` INT(15), IN `cusAdd` VARCHAR(100))  BEGIN
	update customer set customer.customerName=name, customer.phone=cusPhone, customer.address=cusAdd where customer.customerID=ids;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateEmp` (IN `ids` INT(15), IN `names` VARCHAR(100))  BEGIN
update employee set name=names where id=ids;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_category` (IN `ids` INT(15), IN `name` VARCHAR(100))  BEGIN
update productcategory set productcategory.categoryName=name where productcategory.categoryID=ids;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_product` (IN `ids` INT(15), IN `name` VARCHAR(100), IN `cateID` INT(15), IN `unitNames` VARCHAR(50), IN `unitScales` INT(15), IN `discontinueds` INT(1), IN `discontinuedPrices` INT(15), IN `prices` INT(15), IN `images` VARCHAR(100))  BEGIN
update product set productName=name, categoryID=cateID, unitName=unitNames, unitScale=unitScales, discontinued=discontinueds, discontinuedPrice=discontinuedPrices,price=prices, product_image=images where productID=ids;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `view_all_product` ()  BEGIN
select tb1.productID, tb1.productName, tb1.unitName, tb1.price, tb1.product_image, tb1.unitScale, tb1.discontinued, tb1.discontinuedPrice, tb2.name, tb1.dateCreate, tb1.categoryName from (select product.productID, product.productName, product.unitName, product.unitScale, product.discontinued, product.discontinuedPrice, product.empId, product.dateCreate, product.price, productcategory.categoryName, product.product_image from product left join productcategory on productcategory.categoryID=product.categoryID) as tb1, (select product.productID, employee.name from product left join employee on product.empId=employee.ID) as tb2  where tb1.productID=tb2.productID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `view_product_with_id` (IN `ids` INT(15))  BEGIN
select tb1.productID, tb1.productName, tb1.price, tb1.unitName, tb1.product_image, tb1.unitScale, tb1.discontinued, tb1.discontinuedPrice, tb2.name, tb1.dateCreate, tb1.categoryName from (select product.productID, product.productName, product.price, product.product_image, product.unitName, product.unitScale, product.discontinued, product.discontinuedPrice, product.empId, product.dateCreate, productcategory.categoryName from product left join productcategory on productcategory.categoryID=product.categoryID) as tb1, (select product.productID, employee.name from product left join employee on product.empId=employee.ID) as tb2  where tb1.productID=tb2.productID and tb1.productID=ids;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `companyID` int(15) NOT NULL,
  `companyName` varchar(100) DEFAULT NULL,
  `web` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`companyID`, `companyName`, `web`, `email`, `address`, `phone`) VALUES
(1, 'proship', 'http://proship.vn/', 'cskh@proship.vn', 'Số 4, ngõ 26, Nguyên Hồng, Đống Đa, Hà Nội', 939999247),
(2, 'Shopee', 'https://shopee.vn/', 'support@shopee.vn', 'Tầng 29, Tòa nhà trung tâm Lotte Hà Nội, 54 Liễu Giai, phường Cống Vị, Ba Đình, Hà Nội', 19001221),
(3, 'Công ty cổ phần chuyển phát nhanh Thăng Long', 'http://shipthanglong.com/', 'Thanglongship@gmail.com', '145 Thái Thịnh 1, Đống Đa, Hà Nội', 439113366);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerID` int(15) NOT NULL,
  `customerName` varchar(100) DEFAULT NULL,
  `phone` int(15) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `pass` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerID`, `customerName`, `phone`, `address`, `pass`) VALUES
(2, 'nguyen_van_vu', 1232726842, 'Quan 7', '202cb962ac59075b964b07152d234b70'),
(3, 'nguyen_thi_thuc', 1248100138, 'Thu Duc', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `ID` int(15) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `pass` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`ID`, `name`, `pass`) VALUES
(29, 'a', '3b0663d5a3863cf44d1d7d8223e9c7f4'),
(30, 'b', '3b0663d5a3863cf44d1d7d8223e9c7f4'),
(31, 'c', '305a95788b9dc200057e25f3d27a5c6c'),
(32, 'ten_tao_la_gi', 'eab4b9c4fb1ee29552b671652010dac5'),
(39, 'tuongvu2508', '3f088ebeda03513be71d34d214291986'),
(44, 'abc', 'c4ca4238a0b923820dcc509a6f75849b');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

CREATE TABLE `orderdetail` (
  `orderID` int(15) DEFAULT NULL,
  `productID` int(15) DEFAULT NULL,
  `price` int(15) DEFAULT NULL,
  `quantity` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `orderdetail`
--
DELIMITER $$
CREATE TRIGGER `SumOfOrders` AFTER INSERT ON `orderdetail` FOR EACH ROW BEGIN
    UPDATE orders  SET orders.sumOrders= orders.sumOrders + new.price*new.quantity
    WHERE orders.orderID = new.orderID;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(15) NOT NULL,
  `orderDate` datetime DEFAULT NULL,
  `shipDate` datetime DEFAULT NULL,
  `shipCompanyID` int(15) DEFAULT NULL,
  `discounnt` int(15) DEFAULT NULL,
  `user_buy` int(15) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `sumOrders` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productID` int(15) NOT NULL,
  `productName` varchar(100) DEFAULT NULL,
  `categoryID` int(15) DEFAULT NULL,
  `unitName` varchar(50) DEFAULT NULL,
  `unitScale` int(15) DEFAULT NULL,
  `discontinued` tinyint(1) DEFAULT NULL,
  `discontinuedPrice` int(15) DEFAULT NULL,
  `empId` int(15) DEFAULT NULL,
  `dateCreate` datetime DEFAULT NULL,
  `price` int(15) DEFAULT NULL,
  `product_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `productName`, `categoryID`, `unitName`, `unitScale`, `discontinued`, `discontinuedPrice`, `empId`, `dateCreate`, `price`, `product_image`) VALUES
(1, 'romeo and juliet', 9, 'Cuốn', 20, 1, 99000, 44, '2018-08-16 11:52:46', 100000, NULL),
(2, 'Ông lão đánh cá và con cá vàng', 9, 'Cuốn', 20, 0, 0, 44, '2018-08-16 23:30:51', 75000, NULL),
(3, 'Sách giải toán 1', 1, 'Bộ', 500, 1, 1243, 44, '2018-08-17 12:10:31', 240000, NULL),
(5, 'toán lớp 1', 1, 'Cuốn', 0, 0, 24000, 44, '2018-08-17 12:11:44', 25000, NULL),
(6, 'Ăn khế trả vàng', 4, 'Cuốn', 25, 0, 0, 44, '2018-08-17 12:14:56', 20000, NULL),
(8, 'bộ sách lớp 1', 1, 'Bộ', 0, 0, 0, 44, '2018-08-17 12:17:19', 1000000, NULL),
(9, 'ngàn lẻ 1 đêm', 1, 'Bộ', 150, 0, 0, 44, '2018-08-17 12:20:40', 150000, NULL),
(10, 'giải toán 1', 2, 'Cuốn', 0, 0, 0, 44, '2018-08-17 12:21:19', 58000, NULL),
(11, 'Trầu Cau', 1, 'Bộ', 150, 0, 0, 39, '2018-08-20 22:01:29', 250000, NULL),
(20, 't', 1, 'Cuốn', 2, 1, 2, 39, '2018-08-28 14:52:23', 2, NULL),
(26, 't', 9, 'Cuốn', 4, 1, 2, 39, '2018-08-28 14:58:15', 5, '27067585_2225769447709705_3425220375861657851_n.jpg'),
(27, 't', 1, 'Bộ', 2, 1, 243, 39, '2018-08-28 15:00:18', 3, '308378.jpg'),
(28, 't', 1, 'Bộ', 2, 1, 243, 39, '2018-08-28 15:31:09', 3, '308378.jpg'),
(29, 't', 1, 'Bộ', 2, 1, 243, 39, '2018-08-28 15:31:23', 3, '308378.jpg'),
(30, 't', 1, 'Bộ', 2, 1, 243, 39, '2018-08-28 15:31:47', 3, '308378.jpg'),
(31, 't', 1, 'Bộ', 2, 1, 243, 39, '2018-08-28 15:31:59', 3, '308378.jpg'),
(32, 't', 1, 'Bộ', 2, 1, 243, 39, '2018-08-28 15:33:42', 3, '308378.jpg'),
(33, 't', 1, 'Bộ', 5, 1, 5, 39, '2018-08-28 15:33:57', 5, '27067585_2225769447709705_3425220375861657851_n.jpg'),
(34, 's', 1, 'Cuốn', 1, 1, 1, 39, '2018-08-28 23:17:29', 1, '308378.jpg'),
(35, 's', 1, 'Cuốn', 1, 1, 1, 39, '2018-08-28 23:18:14', 1, '308378.jpg'),
(36, 's', 1, 'Cuốn', 1, 1, 1, 39, '2018-08-28 23:19:15', 1, '308378.jpg'),
(37, 's', 1, 'Cuốn', 1, 1, 1, 39, '2018-08-28 23:21:16', 1, '308378.jpg'),
(38, 'y', 1, 'Bộ', 6, 1, 8, 39, '2018-08-28 23:33:47', 6, '27067585_2225769447709705_3425220375861657851_n.jpg'),
(39, 'y', 1, 'Bộ', 6, 1, 8, 39, '2018-08-28 23:42:09', 6, '27067585_2225769447709705_3425220375861657851_n.jpg'),
(40, 'y', 1, 'Bộ', 6, 1, 8, 39, '2018-08-28 23:43:50', 6, '27067585_2225769447709705_3425220375861657851_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `productcategory`
--

CREATE TABLE `productcategory` (
  `categoryID` int(15) NOT NULL,
  `categoryName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `productcategory`
--

INSERT INTO `productcategory` (`categoryID`, `categoryName`) VALUES
(1, 'Sách giáo khoa'),
(2, 'Sách tham khảo'),
(3, 'Truyện tranh hiện đại'),
(4, 'Truyện cổ tích'),
(5, 'Truyện Trẻ Em'),
(8, 'Chính Trị'),
(9, 'Truyện Nước Ngoài');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`companyID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD KEY `orderID_detail` (`orderID`),
  ADD KEY `productID_detail` (`productID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `ship_order` (`shipCompanyID`),
  ADD KEY `user_order` (`user_buy`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `categoryID` (`categoryID`),
  ADD KEY `empCreate` (`empId`);

--
-- Indexes for table `productcategory`
--
ALTER TABLE `productcategory`
  ADD PRIMARY KEY (`categoryID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `companyID` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerID` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `ID` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productID` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `productcategory`
--
ALTER TABLE `productcategory`
  MODIFY `categoryID` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `orderID_detail` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`),
  ADD CONSTRAINT `productID_detail` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `ship_order` FOREIGN KEY (`shipCompanyID`) REFERENCES `company` (`companyID`),
  ADD CONSTRAINT `user_order` FOREIGN KEY (`user_buy`) REFERENCES `customer` (`customerID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `categoryID` FOREIGN KEY (`categoryID`) REFERENCES `productcategory` (`categoryID`),
  ADD CONSTRAINT `empCreate` FOREIGN KEY (`empId`) REFERENCES `employee` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

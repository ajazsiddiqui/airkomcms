-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 31, 2021 at 04:23 PM
-- Server version: 5.6.48
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `airkomcms`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

DROP TABLE IF EXISTS `branch`;
CREATE TABLE IF NOT EXISTS `branch` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Mumbai', 1, 1, '2021-06-22 10:16:17'),
(2, 'Pune', 1, 1, '2021-06-22 10:16:43'),
(3, 'HO Direct', 1, 2, '2021-07-27 16:01:17'),
(4, 'HO Projects', 1, 2, '2021-07-27 16:01:33'),
(5, 'Alibag', 1, 2, '2021-07-27 16:23:43');

-- --------------------------------------------------------

--
-- Table structure for table `call_type`
--

DROP TABLE IF EXISTS `call_type`;
CREATE TABLE IF NOT EXISTS `call_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `call_type`
--

INSERT INTO `call_type` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Cold Call', 1, 1, '2021-05-17 17:22:32'),
(2, 'Prospect', 1, 1, '2021-05-17 17:22:48'),
(3, 'OEM', 1, 1, '2021-05-17 17:22:55'),
(4, 'Consultant', 1, 1, '2021-05-17 17:23:05'),
(5, 'Order', 1, 1, '2021-05-17 17:23:24'),
(6, 'Payment', 1, 1, '2021-05-17 17:23:32'),
(7, 'Dealer', 1, 2, '2021-07-27 16:03:03');

-- --------------------------------------------------------

--
-- Table structure for table `contacted_type`
--

DROP TABLE IF EXISTS `contacted_type`;
CREATE TABLE IF NOT EXISTS `contacted_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(10) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacted_type`
--

INSERT INTO `contacted_type` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Phone', 1, 1, '2021-05-17 15:56:24'),
(2, 'Email', 1, 1, '2021-05-17 16:45:59'),
(3, 'Whatsapp', 1, 1, '2021-05-17 16:46:08'),
(4, 'Visit', 1, 1, '2021-05-17 16:46:15');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` text,
  `telephone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `designation`, `company`, `city`, `address`, `telephone`, `email`, `website`, `created_by`, `date_created`) VALUES
(6, 'Ashok Kashid', 'Director', 'Bright Sight a/c GE Chakan', 'Pune', '-', '1', 'test@gmail.com', '-', 1, '2021-05-24 15:38:11'),
(7, 'G.N.Attar', 'Director', 'Prasa Infocom ', 'Pune', '-', '1', 'test@gmail.com', '1', 1, '2021-05-24 15:39:07'),
(8, 'Shantanu Meher ', 'Properitor', 'Yash Agro Fresh ', 'Bhivandi ', 'L-8,9.10, Jai Shree Ram Complex, Dapode, Anjur Phata, Bhivandi ', '9324648262', 'yashagro26@gmail.com', '', 1, '2021-06-01 17:00:03'),
(9, 'KASHINATH KANDEKAR', 'Properitor', 'Parvati Engineering Works', 'Daman ', 'Survey No 168, Plot No 12, Dabhel Industrial Estate, MG Udyog Nagar. Dabhel, Daman 396 210', '9824503455', 'parvati_eng_works1@yahoo.com', '', 1, '2021-06-01 18:55:59'),
(10, 'Eruch Subawala', 'Properitor', 'Hoshner Engineering Works ', 'Mumbai ', 'C/o Cyrus Subawalla , Tukaram Javaji Road, Next To Bhola Classes, Grant Road Mumbai 400 007', '022 23866013 / 23860314', 'subawah03@yahoo.com', '', 1, '2021-06-01 19:10:24'),
(11, 'Munir Bondre', 'GM - Materials ', ' Scantech Laser Pvt Ltd', 'Navi Mumbai ', 'A-517 TTC Industrial Area, MIDC Mahape, Ghansoli, Navi Mumbai - 400710', '022-4142 9100, 9321917035', 'munir.b@scantechlaser.com', 'www.scantechlaser.com', 1, '2021-06-02 12:45:01'),
(12, 'Siddhesh Deshmukh', 'Site Incharge ', 'Shree Sai Realtors', 'Mumbai ', 'Shop No 3, Aster A Evershien Park, Prathamesh Complex, Veera Desai Road, Near Country Club, Andheri West Mumbai 400 053', '97697 09912', 'shreesai@hotmail.com', '', 1, '2021-06-02 12:48:53'),
(13, 'Sanjay Lokahnde ', 'Purchase Manager ', 'Technocraft Industries ( India) Limited ', 'Mumbai ', 'Opus Centre,47, In front of Hotel Tunga Paradise, Second Floor, Central Road, Andheri East Mumbai ', '9769266529', 'sanjay.lokhande@technocraftgroup.com', 'www.technocraftgroup.com', 1, '2021-06-02 13:08:00'),
(14, 'Gunsagar Madke', 'Properitor', 'Sky Net Services ', 'Raipur (CG) ', 'Shop No . 34 , Pagariya complex , Near hotel ganapati,pandri Raipur', '09753117234', 'skynetservices1911@gmail.com', 'www.skynetservices.in', 1, '2021-06-02 13:15:33'),
(15, 'Mr. Vijay', 'Purchase Incharge', 'Hari Om Enterprises', 'Kolhapur', 'W -50, MIDC Shiroli, Tal: Hatkanangale, Dist: Kolhapur', '7350477277', 'sales@hariomtech.in', '', 1, '2021-06-02 13:44:24'),
(16, 'Mr. Japtap', 'Purchase Incharge', 'SBRS Machines Pvt. Ltd', 'Pune', '624/8, Kuruli Industrial Area, Pune -Nashik Highway, Near Japtech Company, Kuruli (Chakan) Tal: Khed, Dist;- Pune - 410501', '02135 - 684570', 'purchase@sbrmachines.com', '', 1, '2021-06-02 13:53:35'),
(17, 'Mr. Umesh Bhosgi', 'Partner', 'Basava Tooling', 'Pune', 'Sr. No:45/2, A-3, Near Priyadarshni School, Indrayani nagar, Bhosari, Pune - 411 026.', '9921375510', 'basavatooling@gmail.com', '', 1, '2021-06-02 14:08:44'),
(18, 'Mr. Prashant Biradar', 'Partner', 'Shree Balaji Enterprises', 'Pune', 'Sector No:10, Plot No; 221, PCNTDA, MIDC Bhosari, Pune -26.', '9028734610', 'shreebalaji.vmc@gmail.com', '', 1, '2021-06-02 14:19:46'),
(19, 'Mr. Surryakant Jadhav', 'Proprietor', 'Kedar Engineers', 'Pune', 'B-49, T-106/2, Rajgurunagar Ind.Co.Op. Soc. Ltd., Pimpri - Bhosari Road, MIDC, Bhosari, Pune - 411 026.', '9822746874', 'kedarengg@gmail.com', 'www.kadarengineers.com', 1, '2021-06-02 14:28:31'),
(20, 'Mr. Promoth Kumar', 'Partner', 'Omega Technocraft', 'Pune', '\'S\' Block, Plot No.10/3/4, MIDC, Bhosari, Pune - 411 026', '9850459390', 'omegatechnocraft@gmail.com', 'www.omegatechnocraft.com', 1, '2021-06-02 14:32:15'),
(21, 'A.Z. Azad', 'Proprietor', 'Modern Metal Works', 'Pune', 'Gat No: 18/2, Plot No: 16 &17, Birdhwadi, Ambethan Road, Opp. M/s. S.K.S. Fastnor, Chakan, Tal: Khed, Dist. Pune - 410 501.', '9370144408', 'modernmetalazad@yahoo.com', '', 1, '2021-06-02 14:38:11'),
(22, 'Bhavesh Ranka ', 'Partner ', 'G.K.CASTING PVT.LTD', 'Valsad ', 'PLOT NO:-408 NEW GIDC GUNDLAV VALSAD 396035', '8108472345   02632-236677', 'gkdiecasting@gmail.com', '', 1, '2021-06-02 14:39:22'),
(23, 'Pooja Chhaparia', 'Executive Assistant', 'P P Bafna Ventures', 'Pune', '101 -111, Tower 1, World Trade Center, 1 khardi, Pune - 411 014.', '020-46984698, 8308825348', 'c.pooja@ppbafnaventures.com', 'www.bafnagroup.com', 1, '2021-06-02 14:43:40'),
(24, 'Mr. Tushar B. Retawade', 'Proprietor', 'R K Industries', 'Pune', 'Sr. No.138/8, Mahadevnagar Landge Estate, Chakrapani Vasahat, Bhosari, Pune - 411 039.', '9975536768', 'rkindustries313@gmail.com', '', 1, '2021-06-02 14:46:56'),
(25, 'Mr. Masab Ahmed', 'Manager PPC & Purchase', 'Essem Industries', 'Pune', 'Gat No: 261/7, Plot No:2, Somwanshi Industrial Area, Behind Yashika Company, Kharabwadi,Chakan, Pune - 410 501.', '9028032604', 'masab@essemindustries.com', '', 1, '2021-06-02 14:52:27'),
(26, 'Hiten Parmar', 'Sales Manager ', 'Sapatrshi Tech ', 'Mumbai ', 'Sector-1, 8-2 Plot No.122, Ankit CHS, Road No RSC 17, Charkop, Kandivali (W) Mumbai 400067', '0889833012', 'saptarishi_tech@yahoo.com', '', 1, '2021-06-02 15:55:00'),
(27, 'Tejal Sawant ', 'Sales Co-Ordinator', 'Accutech Power Soutions Pvt Ltd ', 'Mumbai ', 'Accutech House, S. V. Road,Amboli,Opp. Chunawal Timber Mart,  Near Andheri Subway,Andheri (W)-400058', '022-67090638', 'tejal@accutech.co.in', '', 1, '2021-06-02 16:01:23'),
(28, 'Shrutika Sawant', 'Sr. Engineer â€“ Estimation', 'Listenlights Pvt. Ltd. ', 'Mumbai ', '01, Acme Plaza, Andheri-Kurla Road,  Opp. Sangam Cinema, Andheri (E), Mumbai - 400059', '022 67080916 / +91-22 28265110 / 11 / 8369205686', 'estimation@listenlights.com', 'www.listenlights.com', 1, '2021-06-02 18:28:37'),
(29, 'Prataprao Kanawade', 'Assistant Manager ', 'Vertive Energy Pvt Ltd', 'Mumbai ', 'Plot No C20, Road No 19, Wagale Industrial Estate, Thane ( W)', '022 49754500, 9545308842', 'Prataprao.kanawade@vertiveco.com', 'www.vertiveco.com', 1, '2021-06-03 12:44:53'),
(30, 'Pankaj Vora ', 'CEO', 'Streamline Exports ', 'Mumbai ', '46, Suprabhat Bldg, Office no 2249, Gandhinagar, Bandra (East), Mumbai 400051', '9820088557', 'pankaj.vora@streamline-exports.com', '', 1, '2021-06-03 12:50:33'),
(31, 'Bhavesh Nerkar', 'Sr Engineer- Sales ', 'Jyoti CNC Automation Ltd', 'Thane ', 'Office No 314, 3rd Floor, Puranik Capitol, Kasarwadavali, Ghodbunder Road, Thane (W) 400607', '9619959892', 'bhavesh.nerkar@jyoti.co.in', 'www.jypti.co.in', 1, '2021-06-03 12:57:29'),
(32, 'Nilesh Shingavi', 'Sales Manager ', 'Sunnen India Pvt Ltd ', 'Navi Mumbai ', 'Plot No W-255, TTC Industrial Area, Thane Belapur Road, MIDC Kaiarane 400 701', '9324969898', 'nshingavi@sunnen.in', 'www.sunnen.in', 1, '2021-06-03 13:20:48'),
(33, 'Ganesh Gharat ', 'Properitor', 'Star Enterprises', 'Alibag ', 'At- Piranche Deul, Alibag-Revdanda Road, Sagmalaa, Po Chaul,Alibag, Dist Raigad ', '7057416123', 'responsstar@gmail.com', '', 1, '2021-06-03 13:27:57'),
(34, ' Vinod Kakade ', 'Purchase Manager ', 'VARROC ENGINEERING PVT LTD', 'Aurangabd', 'M=191/3, MIDC, Vaunj MIDC, Aurangabad, 431 136.', '9673007806', 'vinod.kakade@varroc.com', 'www.varroc.com', 1, '2021-06-03 13:34:54'),
(35, 'Mr. Anil Pawar', 'Proprietor', 'P.S. Control & Switchgear', 'Pune', 'S.No: 124/1, II Line Sadguru nagar, Pune Nashik Highway, Pune.', '9822037987', 'anil@pscontrol.com', '', 1, '2021-06-03 14:04:56'),
(36, 'Mr. Manohar Rananavare', 'Managing Partner', 'S.M Biosystems', 'Pune', 'Gat No: 108/1, Shivapur-Kondhanpur Road, Village- Ranje, Tal-Bhor, Dist: Pune. Pin â€“ 412205.', '9822016803 / 020 - 64701545', 'smbiosystems@gmail.com', 'www.smbiosystems.com', 1, '2021-06-03 14:10:12'),
(37, 'Mr. Vijay Jadhav', 'Purchase Incharge', 'Trio Enterprises', 'Kolhapur', 'B-4, Shiroli MIDC, Kolhapur.', '9673993434', 'vijay.jadhav@trioenter.com', '', 1, '2021-06-03 14:16:41'),
(38, 'Mr. Madhukar Bandgar', 'Partner', 'Trimurti Industries', 'Pune', 'Gat No: 1145, Ghotwade Phata, Pirangut, Tal- Mulshi, Dist: Pune. Pin â€“ 412 115.', '9604324605', 'trimurtiindus1@gmail.com', '', 1, '2021-06-03 14:35:37'),
(39, 'Mr. Shashikant patil', 'Proprietor', 'S.P. Engineers & Suppliers', 'Ichalkaranji', '12/581, Dr. Sakharpe Hospital Chowk, Ichalkaranji â€“ 416 115.', '09822080349', 'heerasp@gmail.com', '', 1, '2021-06-03 14:38:07'),
(40, 'Mr. Ganesh Patil', 'Maintenance Incharge', 'Technovision Auto Components Pvt. Ltd', 'Jaysignpur', 'Plot No: 15, L.K. Akiwate Co.Op. Indus. Estate, Udyamnagar, Tal: Shirol. Dist: Kolhapur.', '9730656550', 'tv.maint@etgroupindia.com', '', 1, '2021-06-03 14:44:40'),
(41, 'Mr. Satyajeet V. Patil,', 'Proprietor', 'Vishal Engineering ', 'Karad', 'Patil Mala, Near Hotel Greenland, P.B. Road, Malkapur, karad-415 110', '7262951565', 'vishal.engineering11@gmail.com', '', 1, '2021-06-03 14:48:30'),
(42, 'Mr. Shashikant Jagtap', 'Maintenance Manager', 'Alfa Laval (India) Pvt. Ltd', 'Pune', 'Mumbai â€“ Pune Road, Dapodi, Pune- 411 012.', '8605611200 / 020 - 66119476', 'shashikant.jagtap@alfalaval.com', 'www.alfalaval.com', 1, '2021-06-03 14:54:01'),
(43, 'Mr. Mohan Prakash', 'Partner', 'SSO Electricals', 'Pune', 'Plot no: PAP J-180, MIDC Bhosari, Pimpri Industrial Area, Pune â€“ 411 026.', '7057152820', 'ssoelectricals@gmail.com', '', 1, '2021-06-03 14:58:59'),
(44, 'Mr. Rajendra Banejwade', 'Maintenance Incharge', 'Mahabal Metals', 'Miraj', 'Miraj MIDC', '9923700030', 'rajendra.b@mahabal.in', '', 1, '2021-06-03 16:49:00'),
(45, 'Mr. Milind Kale', 'Partner', 'Vortex Pet Packaging Solutions', 'Pune', 'Plot No: 212, Sector No: 7, Bhosari MIDC, Pune - 412106', '9028305225', 'milind.kale@vortextechno.com', '', 1, '2021-06-03 17:27:03'),
(46, 'Murali Raja ', 'Plant head ', 'Echaar Equipments Pvt. Ltd.', 'Thane ', ' Plot No.F-32,Anand Nagar  Additional MIDC Industrial Estate,  Ambernath(E) â€“ 421506, Thane (Dist)', '7010059280', 'muraliraja@echaar.com', 'www.echaar.com', 1, '2021-06-03 18:06:34'),
(47, 'Rahul Gharatkar ', 'Admin', 'Keyur kitchenware ', 'Vasai ', 'Gala No.5 & 6, Kunal Industrial Estate, Near State Bank Of India, Gauraipada,', '9967301780', 'admin@kessentials.com', '', 1, '2021-06-03 18:25:14'),
(48, 'Sanjay Savadi ', 'Maintenance Manager ', 'Printografik Packagng Pvt Ltd', 'Navi Mumbai ', 'GEN-42,TTC INDUSTRIAL AREA,, MIDC, MAHAPE, NAVI MUMBAI ', ',Tel: 9820263065      ', 'sanjay.savadi@printografik.com', '', 1, '2021-06-03 18:37:39'),
(49, 'Mr. Amod Sathe ', '', 'Brisk Electronics ', 'Pune', '', '7030407698', 'amodsathe@briskelectronics.com', '', 1, '2021-06-04 23:38:10'),
(50, 'Mr. Rakesh,', 'Proprietor', 'Shrinivas Industries', 'Nanded', 'Sr. No: 23/3, Umerkhed Road. Hadegaon,  Nanded.', '9637656767', 'rakesh.damkondwar@gmail.com', '', 1, '2021-06-04 23:43:00'),
(51, 'Mr. Shital Vankundre', 'Proprietor', 'Parshwa Finish Tech', 'Ichalkaranji', 'Paravati Industrial Estate, Ichalkaranji, Kolhapur', '8007640955', 'parshwafinishtech@gmail.com', '', 1, '2021-06-05 00:03:52'),
(52, 'Mr. Pankaj Kshirsagar', 'Purchase Incharge', 'Vaibhav Electricals', 'Pune', 'S.No:33/1A, Jambhulwadi Road, Ambegaon Khurd, Pune  - 411 046.', '8412827700', 'purchase@vaibhavelectricals.com', '', 1, '2021-06-05 00:26:26'),
(53, 'Mr. G. K. Swamy', 'Proprietor', 'Swamy Electricals & Consultants', 'Pune', 'Mangal Arcade, Shop No: 44/49, Ground Floor, S. No: 127, Mohan Nagar, Chichwad, Pune - 411 019', '9822148043', 'swamyelectric@yahoo.in', '', 1, '2021-06-05 17:09:03'),
(54, 'Mr. Shashikant Joshi', 'Proprietor', 'Joshi Associates', 'Kolhapur', 'C -8, 2nd Floor, Sterling Tower, Gavat Mandai Road, Kolhapur - 416 001.', '9822277665, 0231-2665974', 'joshishashi63@gmail.com', '', 1, '2021-06-05 17:11:10'),
(55, 'Mr. Chandrakant Narkhade', 'Partner', 'Sadhana Electriclas', 'Pune', 'Gat No:248, Plot No: 10, Near Old Toll Plaza, Talegaon Chakan Road, Kharabwadi, Chakan', '8600147039', 'sadhanaelectricals@gmail.com', '', 1, '2021-06-05 17:14:03'),
(56, 'Balasaheb Kale', 'Proprietor', 'Rutuja Electricals Engineers', 'Pune', '1184/4, Office No:1, 2nd Floor, Gokul Nagar, F.C. Road, Dyneshwar Paduka Chowk, Opp. IDBI Bank, Shivaji Nagar, Pune - 411 006.', '8888024455, 020 -25533411', 'rutuja_electricals@yahoo.co.in', 'www.rutuja-electricals.com', 1, '2021-06-05 17:18:36'),
(57, 'Mr. Patil G.V.', 'Partner', 'Bhagyashri Enterprises', 'Pune', 'Gat No: 1607, Plot No: 16, Opp. More Patil Lawns, Dehu - Alandi Road, Patilnagar, Chikhali, Pune - 411 062', '9822670963', 'bhagyshrienterprises@hotmail.com', 'www.bhagyashrienters.com', 1, '2021-06-05 17:22:05'),
(58, 'Mr. Mihir Porwal', 'Proprietor', 'Suprat Source Supply Service', 'Pune', 'F-5, Super Mall, Salunkhe Vihar Road, Kondhwa, Pune - 411 048.', '9822998533', 'supratsales@gmail.com', '', 1, '2021-06-05 17:24:22'),
(59, 'Swapnil Bhosale', 'Asst. Manager Sales', 'Jyoti CNC', 'Pune', ' Plot No: 4/8, Adhar Sahakari Industrial Premises Society Ltd., Sector No: 10, PCNTDA, Bhosari, Pune -411 026.', '9923600897', 'swapnil.bhosale@jyoti.co.in', 'www.jyoti.co.in', 1, '2021-06-05 17:42:16'),
(60, 'Balaji Devkate', 'Asst. Manager Sales', 'BHARAT FRITZWERNER LTD, ( BFW)', 'Pune', 'BFW House, 124 A, H-Block, MIDC, Pimpri, Pune - 411 018.', '9168613458', 'balaji.d@bfv.co.in', 'www.bfwindia.com', 1, '2021-06-05 17:47:36'),
(61, 'Vishwas Salvi', 'Manager - Admin & HR', 'Mazak inda', 'Pune', '115, Pune - Nagar Road, Sanaswadi, Pune - 412 208', '9970002047, 2137-668829', 'vishwas_salvi@mazakindia.com', 'www.mazakindai.in', 1, '2021-06-05 17:53:00'),
(62, 'Rana Pratap Singh', 'Sales Manager', 'Laser Technologies Pvt. Ltd', 'Pune', 'Indrayani Nagar, Bhosari, Pune', '9673108525', 'rana@lasertechnologies.co.in', 'www.lasertechnologies.co.in', 1, '2021-06-05 17:55:52'),
(63, 'Sanjay Sawant', 'Purchase Manager ', 'Subhadra Metals Pvt Ltd ', 'Rasayani ', 'Plot No.18 V.R.I.D Complex, At Post Lohap, Takula: â€“ Khalapur, District: â€“ Raigad, Pincode : 410202,', '9967730242, 022 27692533/32', 'purchase@subhadra.co.in', 'www.subhadra.co.in', 1, '2021-06-07 12:52:44'),
(64, 'Jitendra Rokadia', '', 'Vikas laboratories Pvt Ltd ', 'Navi Mumbai ', 'R-489, TTC industrial Area, Near Golden Garage, MIDC Rabale, Navi Mumbai 400701', '022 2769 4627', 'jiten.vikaslab@gmail.com', '', 3, '2021-07-28 13:44:24'),
(65, 'Shankar Nair', 'Properitor', 'Sneha Enterprises ', 'Navi Mumbai ', 'D-1201, The Springs, Plot No. 4, Sector 20, Roadpali,Kalamboli, navi Mumbai 400218', '9322325500', 'nairshankar2011@gmail.com', '', 3, '2021-07-28 13:55:09'),
(66, 'Satish Chheda', 'Partner ', 'Amrapali Group', 'Mumbai ', '4, Kesar Indl. Estate,Off Aarey Road, Peru Baug, Opp. Topmost Furniture Shop', '9867233969', 'satish@amrapaligroup.com', '', 3, '2021-07-28 13:59:58'),
(67, 'Arsalan Khan ', 'Plant head ', 'La-sani Fluid Power LLP', 'Navi Mumbai ', '1219 T Kalamboli Steel Market, Near Khedupada Marathi School, KALAMBOLI, Navi Mumbai 400218', '8976337049', 'arsalan.khan@la-sani.com', 'www.la-sani.com', 3, '2021-07-28 16:54:26'),
(68, 'Ritesh Mistry', 'Director', 'Weldon Engineers Pvt Ltd', 'Navi Mumbai ', 'R-460, TTC Industrial Area, MIDC Rabale, Navi Mubai 400701', '022- 27607704', 'rmistry@weldon.co.in', 'www.weldon.co.in', 3, '2021-07-28 17:03:10'),
(69, 'Sunil Waghmare ', 'Properitor', 'RS Enterprises', 'Navi Mumbai ', 'E51, Near SDV Scool, Sector 4, Airoli Navi Mubai 400708', '7738332570; 8169084329', 'rs_enterprises2020@yahoo.com', '', 3, '2021-07-28 17:23:42'),
(70, 'Bhaskar Rao ', 'Asst. General Manager', 'Vasai Vikas Bank Ltd', 'Vasai ', 'Vasai Vikas Bank Bldg., Opp. G. G. College, Near Vasai Bus Depot, Vasai, Dist. Palghar â€“ 401201', '0250-2323270', 'bhaskar.rao@vasaivikasbank.co.in', 'www.vasaivikasbank.co.in', 3, '2021-07-28 18:33:18'),
(71, 'Purav Raveshia', 'Director', 'Doms Industries Pvt Ltd', 'Umbaergam', 'Plot No. 117, G.I.D.C., 52 Hector Expansion Area, Umbergam, Valsad-396171', '7573024844/7573024744/7434888445/7434888446', 'purav@domsindia.com', 'www.domsindia.com', 3, '2021-07-28 19:09:43'),
(72, 'Rashmi Menon', 'Purchase Executive', 'Vivid Electromech Pvt Ltd', 'Navi Mumbai ', 'VIVID HOUSE, A-173/7, TTC Industrial Area, MIDC,  Busways IEC61439   Khairne, Navi Mumbai 400705', ' 022-68175555', 'purchasevepl@vividgroup.in', ' http://vividgroup.in', 3, '2021-07-29 13:17:54'),
(73, 'Ladhu Kapai ', 'Director', 'Friends Engineering Industries Pvt Ltd ', 'Navi Mumbai ', 'R-894, TTC Industrial Area, Rabale Navii Mumbai 400705', '9820146546', 'kapai@friendsengineering.net', '', 3, '2021-07-29 13:28:37'),
(74, 'Ketan Jadhav.', 'Asst. Manager Utility', 'Gelnova Laboratories Pvt. Ltd.', 'Navi Mumbai ', 'C-125, TTC Industrial Area Mahape ( Pawane), Navi Mumbai 400703', '92235 89550', 'gelnova.engg@gmail.com', '', 3, '2021-07-29 13:57:17'),
(75, 'Rakesh kaul', 'Sales Manager ', 'Delta Power Solutions india Pvt Ltd', 'Navi Mumbai ', 'A-1619, Rupa Solitaire, IT Park, Plot No. MBP-2, Sector 1,MIDC, Mahape, navi Mumbai ', '9930051755', 'rakesh.koul@deltaww.com', '', 3, '2021-07-29 14:07:17'),
(76, 'Munir Bondare', 'Purchase Manager ', 'Scantech Laser Pvt Ltd', 'Navi Mumbai ', 'A-517 TTC Industrial Area, MIDC Mahape, Ghansoli, Navi Mumbai â€“ 400710', '9321917015', 'info@scantechlaser.com', '', 3, '2021-07-29 14:22:17'),
(77, 'Mohemmad Parray ', 'Partner ', 'Valley Packaging ', 'Shrinagar ', '58, SIDCO Industrial Estate Khunmoh Phase II, 191104, Shrinagar, J& K', '9419008537, +91-9419013492', 'parray.parray@gmail.com', '', 3, '2021-07-29 14:31:14'),
(78, 'Shree Jamdar', 'Partner ', 'Kinetic Gears', 'Nagpur', 'E-19, Hingna Industrial Estate, MIDC Area , NAGPUR-440 028', '9823290006', 'kineticgears@gmail.com', '', 3, '2021-07-29 14:36:30'),
(79, 'Arati Madam', 'Purchase Manager ', 'Sharpline Automation Pvt Ltd', 'Navi Mumbai ', 'Plot No. Gen-19/1, TTC Indl Area, Vishnu Nagar, dighe, NAVI MUMBAI-400708', '022-39154157/55', 'arti@sharplinegroup.com', '', 3, '2021-07-29 16:13:21'),
(80, 'Rajiv Chaudhari ', 'Partner ', 'Collins India', 'Vasai ', '609 Shingapore Building, Room No. 13, J.S.S. Lane, 2nd Floor, Marine Lines, Mumbai 400002', '7506494110', 'collinsacs@gmail.com', '', 3, '2021-07-29 16:20:08'),
(81, 'Rajesh ranveria', 'Sales Manager ', 'Varipack Machines Pvt Ltd ', 'Mumbai ', 'Andheri, Mumbai', '9320020676', 'rajesh.ranveria@gmail.com', '', 3, '2021-07-30 14:07:34'),
(82, 'Vinod', 'Purchase Manager ', 'Yesh Engineering Solutions', 'Navi Mumbai ', 'FLAT -101,UTSAVI APARTMENT, PLOT NO A-25, SECTOR -14 , BELAPUR, NAVI MUMBAI-400614', '09867858049', 'vinod@engg-soln.com', '', 3, '2021-07-30 14:11:58'),
(83, 'Mukesh Mehta', 'Properitor', 'Ultra Star Diamonds Pvt Ltd', 'Bhivandi ', 'GALA NO. 101, C-17, PARASNATH, MANKOLI-ANJUR ROAD, TAL-BHIWANDI', '9323974912', 'ultrastardiamond@gmail.com', '', 3, '2021-07-30 16:15:23');

-- --------------------------------------------------------

--
-- Table structure for table `dcr`
--

DROP TABLE IF EXISTS `dcr`;
CREATE TABLE IF NOT EXISTS `dcr` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `visit_date` date NOT NULL,
  `start_period` date NOT NULL,
  `end_period` date NOT NULL,
  `dcr_no` int(10) NOT NULL,
  `travel_type` int(10) NOT NULL,
  `call_type` int(10) NOT NULL,
  `call_count` int(10) NOT NULL DEFAULT '1',
  `contact_id` int(10) NOT NULL,
  `product_series` int(10) NOT NULL,
  `product_model` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quanitity` int(10) NOT NULL,
  `order_value` decimal(10,2) NOT NULL,
  `sales_stage` int(11) NOT NULL,
  `next_action` int(10) NOT NULL,
  `remarks` text NOT NULL,
  `Bike_km_reading_start` int(10) NOT NULL,
  `bike_km_reading_end` int(10) NOT NULL,
  `distance_travelled` int(10) NOT NULL,
  `amount_one` decimal(10,2) NOT NULL,
  `travel_mode` int(10) NOT NULL,
  `amount_two` decimal(10,2) NOT NULL,
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dcr`
--

INSERT INTO `dcr` (`id`, `visit_date`, `start_period`, `end_period`, `dcr_no`, `travel_type`, `call_type`, `call_count`, `contact_id`, `product_series`, `product_model`, `product_id`, `quanitity`, `order_value`, `sales_stage`, `next_action`, `remarks`, `Bike_km_reading_start`, `bike_km_reading_end`, `distance_travelled`, `amount_one`, `travel_mode`, `amount_two`, `created_by`, `date_created`) VALUES
(1, '2021-07-27', '2021-07-27', '2021-07-27', 2, 1, 2, 1, 64, 1, 32, 10, 1, '50000.00', 1, 4, 'New machine expected on 7th August 2021', 0, 0, 0, '0.00', 3, '102.00', 3, '2021-07-28 18:17:24'),
(2, '2021-07-27', '2021-07-27', '2021-07-27', 3, 1, 2, 1, 68, 1, 29, 4, 1, '320000.00', 5, 4, 'Checked old SCVS, NEEL make cant be repair as its old and with Motorised Variac', 0, 0, 0, '0.00', 1, '20.00', 3, '2021-07-28 18:24:02'),
(3, '2021-07-16', '2021-07-16', '2021-07-16', 1, 2, 2, 1, 70, 4, 11, 1, 1, '75000.00', 4, 3, 'They are facing Surge problem; Suggested to go for Isolation Transformer', 0, 0, 0, '0.00', 3, '400.00', 3, '2021-07-28 18:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `lead_source`
--

DROP TABLE IF EXISTS `lead_source`;
CREATE TABLE IF NOT EXISTS `lead_source` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lead_source`
--

INSERT INTO `lead_source` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Direct', 1, 1, '2021-05-18 19:06:44'),
(2, 'Reseller', 1, 1, '2021-05-18 19:06:53'),
(3, 'Contractor', 1, 1, '2021-05-18 19:07:03'),
(4, 'Consultant', 1, 1, '2021-05-18 19:07:14'),
(5, 'OEM', 1, 1, '2021-05-18 19:08:33'),
(6, 'Other', 1, 1, '2021-05-18 19:08:42'),
(7, 'Service Engineer', 1, 2, '2021-07-27 16:04:10'),
(8, 'Office', 1, 2, '2021-07-27 16:04:54');

-- --------------------------------------------------------

--
-- Table structure for table `lead_stage`
--

DROP TABLE IF EXISTS `lead_stage`;
CREATE TABLE IF NOT EXISTS `lead_stage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lead_stage`
--

INSERT INTO `lead_stage` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Early', 1, 2, '2021-05-17 16:54:09'),
(2, 'Active', 1, 1, '2021-05-17 16:54:16'),
(3, 'Close', 1, 2, '2021-05-17 16:54:22'),
(4, 'Offline', 1, 1, '2021-05-17 16:54:29'),
(5, 'Lead', 1, 1, '2021-05-26 12:07:44');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` text NOT NULL,
  `action_name` text NOT NULL,
  `user` varchar(255) NOT NULL,
  `property_id` int(2) DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=365 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `action`, `action_name`, `user`, `property_id`, `date_created`) VALUES
(1, 'Settings Edited', '', 'admin@airkomgroup.com', 0, '2021-05-16 19:25:21'),
(2, 'Settings Edited', '', 'admin@airkomgroup.com', 0, '2021-05-16 19:26:33'),
(3, 'SystemUserType Added', '', 'admin@airkomgroup.com', 0, '2021-05-16 20:17:27'),
(4, 'SystemUserType Edited', 'aa', 'admin@airkomgroup.com', 0, '2021-05-16 20:18:20'),
(5, 'SystemUserType Added', 'Executives', 'admin@airkomgroup.com', 0, '2021-05-17 09:20:05'),
(6, 'ContactedType Added', 'Phone', 'admin@airkomgroup.com', 0, '2021-05-17 15:56:24'),
(7, 'ContactedType Added', 'Email', 'admin@airkomgroup.com', 0, '2021-05-17 16:45:59'),
(8, 'ContactedType Added', 'Whatsapp', 'admin@airkomgroup.com', 0, '2021-05-17 16:46:08'),
(9, 'ContactedType Added', 'Visit', 'admin@airkomgroup.com', 0, '2021-05-17 16:46:15'),
(10, 'ContactedType Edited', 'Emails', 'admin@airkomgroup.com', 0, '2021-05-17 16:46:21'),
(11, 'ContactedType Edited', 'Email', 'admin@airkomgroup.com', 0, '2021-05-17 16:46:28'),
(12, 'LeadStage Added', 'Early', 'admin@airkomgroup.com', 0, '2021-05-17 16:54:09'),
(13, 'LeadStage Added', 'Active', 'admin@airkomgroup.com', 0, '2021-05-17 16:54:16'),
(14, 'LeadStage Added', 'Close', 'admin@airkomgroup.com', 0, '2021-05-17 16:54:22'),
(15, 'LeadStage Added', 'Offline', 'admin@airkomgroup.com', 0, '2021-05-17 16:54:29'),
(16, 'MarketSegment Edited', 'Analytical Equipment', 'admin@airkomgroup.com', 0, '2021-05-17 17:02:59'),
(17, 'NextAction Edited', 'Budget Approval', 'admin@airkomgroup.com', 0, '2021-05-17 17:04:43'),
(18, 'Probability Added', '25', 'admin@airkomgroup.com', 0, '2021-05-17 17:08:14'),
(19, 'Probability Added', '50', 'admin@airkomgroup.com', 0, '2021-05-17 17:08:20'),
(20, 'Probability Added', '75', 'admin@airkomgroup.com', 0, '2021-05-17 17:08:27'),
(21, 'Probability Added', '90', 'admin@airkomgroup.com', 0, '2021-05-17 17:08:33'),
(22, 'Probability Added', '100', 'admin@airkomgroup.com', 0, '2021-05-17 17:08:41'),
(23, 'Products Edited', '1 kVA', 'admin@airkomgroup.com', 0, '2021-05-17 17:10:05'),
(24, 'TravelMode Added', 'Bus', 'admin@airkomgroup.com', 0, '2021-05-17 17:13:30'),
(25, 'TravelMode Added', 'Taxi', 'admin@airkomgroup.com', 0, '2021-05-17 17:13:36'),
(26, 'TravelMode Added', 'Auto', 'admin@airkomgroup.com', 0, '2021-05-17 17:13:45'),
(27, 'TravelMode Added', 'Others', 'admin@airkomgroup.com', 0, '2021-05-17 17:13:51'),
(28, 'TravelType Added', 'Local', 'admin@airkomgroup.com', 0, '2021-05-17 17:14:42'),
(29, 'TravelType Added', 'Outstation', 'admin@airkomgroup.com', 0, '2021-05-17 17:14:50'),
(30, 'CallType Added', 'Cold Call', 'admin@airkomgroup.com', 0, '2021-05-17 17:22:32'),
(31, 'CallType Added', 'Prospect', 'admin@airkomgroup.com', 0, '2021-05-17 17:22:48'),
(32, 'CallType Added', 'OEM', 'admin@airkomgroup.com', 0, '2021-05-17 17:22:55'),
(33, 'CallType Added', 'Consultants', 'admin@airkomgroup.com', 0, '2021-05-17 17:23:05'),
(34, 'CallType Edited', 'Consultant', 'admin@airkomgroup.com', 0, '2021-05-17 17:23:16'),
(35, 'CallType Added', 'Order', 'admin@airkomgroup.com', 0, '2021-05-17 17:23:24'),
(36, 'CallType Added', 'Payment', 'admin@airkomgroup.com', 0, '2021-05-17 17:23:32'),
(37, 'Contact Added', 'Bertha Stark', 'admin@airkomgroup.com', 0, '2021-05-18 15:42:16'),
(38, 'Contact Edited', 'Bertha Starks', 'admin@airkomgroup.com', 0, '2021-05-18 15:52:28'),
(39, 'Contact Deleted', 'Bertha Starks', 'admin@airkomgroup.com', 0, '2021-05-18 15:55:50'),
(40, 'Contact Added', 'Deanna Whitney', 'admin@airkomgroup.com', 0, '2021-05-18 15:56:10'),
(41, 'Contact Deleted', 'Deanna Whitney', 'admin@airkomgroup.com', 0, '2021-05-18 15:56:15'),
(42, 'Contact Added', 'Aladdin Mckay', 'admin@airkomgroup.com', 0, '2021-05-18 15:57:35'),
(43, 'CallType Added', 'aaa', 'admin@airkomgroup.com', 0, '2021-05-18 16:09:15'),
(44, 'CallType Deleted', 'aaa', 'admin@airkomgroup.com', 0, '2021-05-18 16:09:19'),
(45, 'CallType Added', 'aaa', 'admin@airkomgroup.com', 0, '2021-05-18 16:10:01'),
(46, 'CallType Deleted', 'aaa', 'admin@airkomgroup.com', 0, '2021-05-18 16:10:06'),
(47, 'CallType Added', 'aaaa', 'admin@airkomgroup.com', 0, '2021-05-18 16:10:24'),
(48, 'Call Type Deleted', 'aaaa', 'admin@airkomgroup.com', 0, '2021-05-18 16:10:33'),
(49, 'TravelType Added', 'Xander Washington', 'admin@airkomgroup.com', 0, '2021-05-18 16:18:35'),
(50, 'Travel Type Deleted', 'Xander Washington', 'admin@airkomgroup.com', 0, '2021-05-18 16:18:40'),
(51, 'Settings Edited', '', 'admin@airkomgroup.com', 0, '2021-05-18 17:23:19'),
(52, 'Settings Edited', '', 'admin@airkomgroup.com', 0, '2021-05-18 17:23:25'),
(53, 'DCR Added', 'Voluptatem amet su', 'admin@airkomgroup.com', 0, '2021-05-18 17:43:02'),
(54, 'DCR Edited', '0', 'admin@airkomgroup.com', 0, '2021-05-18 17:59:04'),
(55, 'DCR Edited', '0', 'admin@airkomgroup.com', 0, '2021-05-18 17:59:20'),
(56, 'DCR Edited', '5678', 'admin@airkomgroup.com', 0, '2021-05-18 17:59:37'),
(57, 'DCR Edited', '5678', 'admin@airkomgroup.com', 0, '2021-05-18 17:59:47'),
(58, 'DCR Deleted', '0', 'admin@airkomgroup.com', 0, '2021-05-18 18:01:24'),
(59, 'DCR Added', 'Molestias autem aute', 'admin@airkomgroup.com', 0, '2021-05-18 18:01:52'),
(60, 'DCR Deleted', '0', 'admin@airkomgroup.com', 0, '2021-05-18 18:01:56'),
(61, 'LeadSource Added', 'Early', 'admin@airkomgroup.com', 0, '2021-05-18 19:06:44'),
(62, 'LeadSource Added', 'Active', 'admin@airkomgroup.com', 0, '2021-05-18 19:06:53'),
(63, 'LeadSource Added', 'Close', 'admin@airkomgroup.com', 0, '2021-05-18 19:07:03'),
(64, 'LeadSource Added', 'Offline', 'admin@airkomgroup.com', 0, '2021-05-18 19:07:14'),
(65, 'LeadSource Added', 'OEM', 'admin@airkomgroup.com', 0, '2021-05-18 19:08:33'),
(66, 'LeadSource Added', 'Other', 'admin@airkomgroup.com', 0, '2021-05-18 19:08:42'),
(67, 'SPT Added', 'Hanae Coleman', 'admin@airkomgroup.com', 0, '2021-05-18 19:19:57'),
(68, 'SPT Edited', 'Hanae Coleman', 'admin@airkomgroup.com', 0, '2021-05-18 19:39:27'),
(69, 'SPT Edited', 'Hanae Coleman', 'admin@airkomgroup.com', 0, '2021-05-18 19:39:37'),
(70, 'SPT Deleted', 'Hanae Coleman', 'admin@airkomgroup.com', 0, '2021-05-18 19:40:27'),
(71, 'SPT Added', 'Tad Nash', 'admin@airkomgroup.com', 0, '2021-05-18 19:41:05'),
(72, 'Market Segment Deleted', 'Manufacturing - Others (Specifiy)', 'admin@airkomgroup.com', 0, '2021-05-18 19:57:17'),
(73, 'Roadmap Added', 'Dawn Savage', 'admin@airkomgroup.com', 0, '2021-05-18 19:57:41'),
(74, 'Roadmap Edited', 'Dawn Savage', 'admin@airkomgroup.com', 0, '2021-05-18 20:07:06'),
(75, 'Roadmap Deleted', 'Dawn Savage', 'admin@airkomgroup.com', 0, '2021-05-18 20:07:55'),
(76, 'Roadmap Added', 'Camilla Hardin', 'admin@airkomgroup.com', 0, '2021-05-18 20:08:21'),
(77, 'Contact Added', 'Rajendra', 'admin@airkomgroup.com', 0, '2021-05-22 15:09:20'),
(78, 'Contact Added', 'Prem', 'admin@airkomgroup.com', 0, '2021-05-22 15:10:40'),
(79, 'DCR Added', '1', 'admin@airkomgroup.com', 0, '2021-05-22 15:44:35'),
(80, 'DCR Edited', '1', 'admin@airkomgroup.com', 0, '2021-05-22 15:47:59'),
(81, 'Roadmap Added', 'ATC India Pvt Ltd', 'admin@airkomgroup.com', 0, '2021-05-22 15:57:43'),
(82, 'Contact Edited', 'Aladdin Mckay', 'admin@airkomgroup.com', 0, '2021-05-23 05:20:57'),
(83, 'DCR Edited', '5678', 'admin@airkomgroup.com', 0, '2021-05-23 05:21:20'),
(84, 'Contact Edited', 'Aladdin Mckay', 'admin@airkomgroup.com', 0, '2021-05-23 05:21:28'),
(85, 'DCR Edited', '12', 'admin@airkomgroup.com', 0, '2021-05-23 05:21:41'),
(86, 'Roadmap Edited', '3', 'admin@airkomgroup.com', 0, '2021-05-23 05:21:55'),
(87, 'Contact Edited', 'Aladdin Mckay', 'admin@airkomgroup.com', 0, '2021-05-23 05:22:01'),
(88, 'SPT Edited', '3', 'admin@airkomgroup.com', 0, '2021-05-23 05:22:16'),
(89, 'SPT Edited', '3', 'admin@airkomgroup.com', 0, '2021-05-23 05:22:22'),
(90, 'Contact Deleted', 'Aladdin Mckay', 'admin@airkomgroup.com', 0, '2021-05-23 05:28:23'),
(91, 'Contact Added', 'Ashok Kashid', 'admin@airkomgroup.com', 0, '2021-05-24 15:38:11'),
(92, 'Contact Added', 'G.N.Attar', 'admin@airkomgroup.com', 0, '2021-05-24 15:39:07'),
(93, 'SPT Added', '4', 'admin@airkomgroup.com', 0, '2021-05-25 02:29:06'),
(94, 'SPT Edited', '4', 'admin@airkomgroup.com', 0, '2021-05-25 02:29:18'),
(95, 'SPT Edited', '4', 'admin@airkomgroup.com', 0, '2021-05-25 02:29:23'),
(96, 'SPT Edited', '4', 'admin@airkomgroup.com', 0, '2021-05-25 02:29:31'),
(97, 'SPT Deleted', '4', 'admin@airkomgroup.com', 0, '2021-05-25 02:29:33'),
(98, 'LeadStage Added', 'Lead', 'admin@airkomgroup.com', 0, '2021-05-26 12:07:44'),
(99, 'SPT Added', '6', 'admin@airkomgroup.com', 0, '2021-05-26 12:13:43'),
(100, 'SPT Added', '7', 'admin@airkomgroup.com', 0, '2021-05-26 12:17:20'),
(101, 'SPT Edited', '6', 'admin@airkomgroup.com', 0, '2021-05-26 12:17:49'),
(102, 'DCR Edited', '12', 'admin@airkomgroup.com', 0, '2021-05-26 12:19:19'),
(103, 'Roadmap Edited', '4', 'admin@airkomgroup.com', 0, '2021-05-27 21:04:46'),
(104, 'Roadmap Edited', '4', 'admin@airkomgroup.com', 0, '2021-05-27 21:04:55'),
(105, 'SPT Edited', '4', 'admin@airkomgroup.com', 0, '2021-05-27 21:05:19'),
(106, 'DCR Deleted', '5678', 'admin@airkomgroup.com', 0, '2021-06-01 02:05:12'),
(107, 'Contact Added', 'Shantanu Meher ', 'admin@airkomgroup.com', 0, '2021-06-01 17:00:03'),
(108, 'SPT Added', '8', 'admin@airkomgroup.com', 0, '2021-06-01 17:03:20'),
(109, 'Contact Added', 'KASHINATH KANDEKAR', 'admin@airkomgroup.com', 0, '2021-06-01 18:55:59'),
(110, 'SPT Added', '9', 'admin@airkomgroup.com', 0, '2021-06-01 19:00:05'),
(111, 'DCR Added', '1', 'admin@airkomgroup.com', 0, '2021-06-01 19:06:21'),
(112, 'Contact Added', 'Eruch Subawala', 'admin@airkomgroup.com', 0, '2021-06-01 19:10:24'),
(113, 'DCR Added', '2', 'admin@airkomgroup.com', 0, '2021-06-01 19:13:28'),
(114, 'DCR Edited', '1', 'admin@airkomgroup.com', 0, '2021-06-01 19:14:17'),
(115, 'Contact Added', 'Munir Bondre', 'admin@airkomgroup.com', 0, '2021-06-02 12:45:01'),
(116, 'Contact Added', 'Siddhesh Deshmukh', 'admin@airkomgroup.com', 0, '2021-06-02 12:48:53'),
(117, 'Contact Added', 'Sanjay Lokahnde ', 'admin@airkomgroup.com', 0, '2021-06-02 13:08:00'),
(118, 'Contact Added', 'Gunsagar Madke', 'admin@airkomgroup.com', 0, '2021-06-02 13:15:33'),
(119, 'Contact Added', 'Mr. Vijay', 'admin@airkomgroup.com', 0, '2021-06-02 13:44:24'),
(120, 'Contact Added', 'Mr. Japtap', 'admin@airkomgroup.com', 0, '2021-06-02 13:53:35'),
(121, 'Contact Added', 'Mr. Umesh Bhosgi', 'admin@airkomgroup.com', 0, '2021-06-02 14:08:44'),
(122, 'Contact Added', 'Mr. Prashant Biradar', 'admin@airkomgroup.com', 0, '2021-06-02 14:19:46'),
(123, 'Contact Added', 'Mr. Surryakant Jadhav', 'admin@airkomgroup.com', 0, '2021-06-02 14:28:31'),
(124, 'Contact Added', 'Mr. Promoth Kumar', 'admin@airkomgroup.com', 0, '2021-06-02 14:32:15'),
(125, 'Contact Added', 'A.Z. Azad', 'admin@airkomgroup.com', 0, '2021-06-02 14:38:11'),
(126, 'Contact Added', 'Bhavesh Ranka ', 'admin@airkomgroup.com', 0, '2021-06-02 14:39:22'),
(127, 'SPT Added', '22', 'admin@airkomgroup.com', 0, '2021-06-02 14:42:57'),
(128, 'Contact Added', 'Pooja Chhaparia', 'admin@airkomgroup.com', 0, '2021-06-02 14:43:40'),
(129, 'DCR Added', '3', 'admin@airkomgroup.com', 0, '2021-06-02 14:45:38'),
(130, 'Contact Added', 'Mr. Tushar B. Retawade', 'admin@airkomgroup.com', 0, '2021-06-02 14:46:56'),
(131, 'DCR Added', '4', 'admin@airkomgroup.com', 0, '2021-06-02 14:48:26'),
(132, 'Contact Added', 'Mr. Masab Ahmed', 'admin@airkomgroup.com', 0, '2021-06-02 14:52:27'),
(133, 'Contact Added', 'Hiten Parmar', 'admin@airkomgroup.com', 0, '2021-06-02 15:55:00'),
(134, 'Contact Added', 'Tejal Sawant ', 'admin@airkomgroup.com', 0, '2021-06-02 16:01:23'),
(135, 'DCR Added', '5', 'admin@airkomgroup.com', 0, '2021-06-02 16:05:27'),
(136, 'Roadmap Added', '27', 'admin@airkomgroup.com', 0, '2021-06-02 16:09:01'),
(137, 'Roadmap Added', '8', 'admin@airkomgroup.com', 0, '2021-06-02 16:10:52'),
(138, 'SPT Edited', '22', 'admin@airkomgroup.com', 0, '2021-06-02 16:11:20'),
(139, 'SPT Edited', '9', 'admin@airkomgroup.com', 0, '2021-06-02 16:11:42'),
(140, 'SPT Edited', '8', 'admin@airkomgroup.com', 0, '2021-06-02 16:11:58'),
(141, 'SPT Added', '26', 'admin@airkomgroup.com', 0, '2021-06-02 16:14:05'),
(142, 'SPT Added', '27', 'admin@airkomgroup.com', 0, '2021-06-02 16:15:51'),
(143, 'SPT Added', '14', 'admin@airkomgroup.com', 0, '2021-06-02 16:18:48'),
(144, 'DCR Added', '', 'admin@airkomgroup.com', 0, '2021-06-02 16:22:02'),
(145, 'DCR Edited', '7', 'admin@airkomgroup.com', 0, '2021-06-02 16:22:27'),
(146, 'Contact Added', 'Shrutika Sawant', 'admin@airkomgroup.com', 0, '2021-06-02 18:28:37'),
(147, 'SPT Added', '28', 'admin@airkomgroup.com', 0, '2021-06-02 18:32:47'),
(148, 'Contact Added', 'Prataprao Kanawade', 'admin@airkomgroup.com', 0, '2021-06-03 12:44:53'),
(149, 'Roadmap Added', '29', 'admin@airkomgroup.com', 0, '2021-06-03 12:46:50'),
(150, 'Contact Added', 'Pankaj Vora ', 'admin@airkomgroup.com', 0, '2021-06-03 12:50:33'),
(151, 'Roadmap Added', '30', 'admin@airkomgroup.com', 0, '2021-06-03 12:53:14'),
(152, 'Contact Added', 'Bhavesh Nerkar', 'admin@airkomgroup.com', 0, '2021-06-03 12:57:29'),
(153, 'Roadmap Added', '31', 'admin@airkomgroup.com', 0, '2021-06-03 12:59:12'),
(154, 'Roadmap Edited', '29', 'admin@airkomgroup.com', 0, '2021-06-03 12:59:36'),
(155, 'DCR Added', '8', 'admin@airkomgroup.com', 0, '2021-06-03 13:05:05'),
(156, 'DCR Edited', '8', 'admin@airkomgroup.com', 0, '2021-06-03 13:05:21'),
(157, 'DCR Added', '9', 'admin@airkomgroup.com', 0, '2021-06-03 13:09:13'),
(158, 'DCR Edited', '9', 'admin@airkomgroup.com', 0, '2021-06-03 13:10:24'),
(159, 'Roadmap Added', '28', 'admin@airkomgroup.com', 0, '2021-06-03 13:15:33'),
(160, 'Contact Added', 'Nilesh Shingavi', 'admin@airkomgroup.com', 0, '2021-06-03 13:20:48'),
(161, 'Roadmap Added', '32', 'admin@airkomgroup.com', 0, '2021-06-03 13:22:00'),
(162, 'Contact Added', 'Ganesh Gharat ', 'admin@airkomgroup.com', 0, '2021-06-03 13:27:57'),
(163, 'Roadmap Added', '33', 'admin@airkomgroup.com', 0, '2021-06-03 13:29:52'),
(164, 'Contact Added', ' Vinod Kakade ', 'admin@airkomgroup.com', 0, '2021-06-03 13:34:54'),
(165, 'Contact Added', 'Mr. Anil Pawar', 'admin@airkomgroup.com', 0, '2021-06-03 14:04:56'),
(166, 'Contact Added', 'Mr. Manohar Rananavare', 'admin@airkomgroup.com', 0, '2021-06-03 14:10:12'),
(167, 'Contact Added', 'Mr. Vijay Jadhav', 'admin@airkomgroup.com', 0, '2021-06-03 14:16:41'),
(168, 'Contact Added', 'Mr. Madhukar Bandgar', 'admin@airkomgroup.com', 0, '2021-06-03 14:35:37'),
(169, 'Contact Added', 'Mr. Shashikant patil', 'admin@airkomgroup.com', 0, '2021-06-03 14:38:07'),
(170, 'Contact Added', 'Mr. Ganesh Patil', 'admin@airkomgroup.com', 0, '2021-06-03 14:44:40'),
(171, 'Contact Added', 'Mr. Satyajeet V. Patil,', 'admin@airkomgroup.com', 0, '2021-06-03 14:48:30'),
(172, 'Contact Added', 'Mr. Shashikant Jagtap', 'admin@airkomgroup.com', 0, '2021-06-03 14:54:01'),
(173, 'Contact Edited', 'Mr. Ganesh Patil', 'admin@airkomgroup.com', 0, '2021-06-03 14:55:44'),
(174, 'Contact Added', 'Mr. Mohan Prakash', 'admin@airkomgroup.com', 0, '2021-06-03 14:58:59'),
(175, 'Contact Added', 'Mr. Rajendra Banejwade', 'admin@airkomgroup.com', 0, '2021-06-03 16:49:00'),
(176, 'Contact Added', 'Mr. Milind Kale', 'admin@airkomgroup.com', 0, '2021-06-03 17:27:03'),
(177, 'Contact Added', 'Murali Raja ', 'admin@airkomgroup.com', 0, '2021-06-03 18:06:34'),
(178, 'SPT Added', '4', 'admin@airkomgroup.com', 0, '2021-06-03 18:18:38'),
(179, 'Contact Added', 'Rahul Gharatkar ', 'admin@airkomgroup.com', 0, '2021-06-03 18:25:14'),
(180, 'SPT Added', '47', 'admin@airkomgroup.com', 0, '2021-06-03 18:28:21'),
(181, 'SPT Added', '35', 'admin@airkomgroup.com', 0, '2021-06-03 18:31:37'),
(182, 'Contact Added', 'Sanjay Savadi ', 'admin@airkomgroup.com', 0, '2021-06-03 18:37:39'),
(183, 'SPT Added', '36', 'admin@airkomgroup.com', 0, '2021-06-03 18:40:25'),
(184, 'SPT Added', '48', 'admin@airkomgroup.com', 0, '2021-06-03 18:40:42'),
(185, 'SPT Added', '13', 'admin@airkomgroup.com', 0, '2021-06-03 18:55:22'),
(186, 'SPT Added', '38', 'admin@airkomgroup.com', 0, '2021-06-03 18:55:39'),
(187, 'SPT Added', '27', 'admin@airkomgroup.com', 0, '2021-06-03 18:57:59'),
(188, 'SPT Added', '24', 'admin@airkomgroup.com', 0, '2021-06-04 19:14:40'),
(189, 'SPT Added', '15', 'admin@airkomgroup.com', 0, '2021-06-04 19:18:07'),
(190, 'SPT Added', '15', 'admin@airkomgroup.com', 0, '2021-06-04 19:19:44'),
(191, 'SPT Added', '16', 'admin@airkomgroup.com', 0, '2021-06-04 19:22:30'),
(192, 'SPT Added', '35', 'admin@airkomgroup.com', 0, '2021-06-04 19:25:47'),
(193, 'SPT Added', '15', 'admin@airkomgroup.com', 0, '2021-06-04 19:29:40'),
(194, 'SPT Added', '41', 'admin@airkomgroup.com', 0, '2021-06-04 19:35:06'),
(195, 'SPT Added', '42', 'admin@airkomgroup.com', 0, '2021-06-04 19:46:25'),
(196, 'Contact Added', 'Mr. Amod Sathe ', 'admin@airkomgroup.com', 0, '2021-06-04 23:38:10'),
(197, 'Contact Added', 'Mr. Rakesh,', 'admin@airkomgroup.com', 0, '2021-06-04 23:43:00'),
(198, 'Contact Added', 'Mr. Shital Vankundre', 'admin@airkomgroup.com', 0, '2021-06-05 00:03:52'),
(199, 'Contact Added', 'Mr. Pankaj Kshirsagar', 'admin@airkomgroup.com', 0, '2021-06-05 00:26:26'),
(200, 'SPT Added', '52', 'admin@airkomgroup.com', 0, '2021-06-05 00:39:24'),
(201, 'Contact Added', 'Mr. G. K. Swamy', 'admin@airkomgroup.com', 0, '2021-06-05 17:09:03'),
(202, 'Contact Added', 'Mr. Shashikant Joshi', 'admin@airkomgroup.com', 0, '2021-06-05 17:11:10'),
(203, 'Contact Added', 'Mr. Chandrakant Narkhade', 'admin@airkomgroup.com', 0, '2021-06-05 17:14:03'),
(204, 'Contact Added', 'Balasaheb Kale', 'admin@airkomgroup.com', 0, '2021-06-05 17:18:36'),
(205, 'Contact Added', 'Mr. Patil G.V.', 'admin@airkomgroup.com', 0, '2021-06-05 17:22:05'),
(206, 'Contact Added', 'Mr. Mihir Porwal', 'admin@airkomgroup.com', 0, '2021-06-05 17:24:22'),
(207, 'Contact Added', 'Swapnil Bhosale', 'admin@airkomgroup.com', 0, '2021-06-05 17:42:16'),
(208, 'Contact Added', 'Balaji Devkate', 'admin@airkomgroup.com', 0, '2021-06-05 17:47:36'),
(209, 'Contact Added', 'Vishwas Salvi', 'admin@airkomgroup.com', 0, '2021-06-05 17:53:00'),
(210, 'Contact Added', 'Rana Pratap Singh', 'admin@airkomgroup.com', 0, '2021-06-05 17:55:52'),
(211, 'Roadmap Added', '55', 'admin@airkomgroup.com', 0, '2021-06-05 18:03:44'),
(212, 'Roadmap Added', '57', 'admin@airkomgroup.com', 0, '2021-06-05 18:05:11'),
(213, 'Roadmap Added', '43', 'admin@airkomgroup.com', 0, '2021-06-05 18:37:16'),
(214, 'Roadmap Added', '56', 'admin@airkomgroup.com', 0, '2021-06-05 18:38:27'),
(215, 'Roadmap Added', '59', 'admin@airkomgroup.com', 0, '2021-06-05 18:39:27'),
(216, 'Roadmap Added', '4', 'admin@airkomgroup.com', 0, '2021-06-05 18:40:18'),
(217, 'Roadmap Added', '61', 'admin@airkomgroup.com', 0, '2021-06-05 18:41:39'),
(218, 'Roadmap Added', '62', 'admin@airkomgroup.com', 0, '2021-06-05 18:42:33'),
(219, 'Contact Added', 'Sanjay Sawant', 'admin@airkomgroup.com', 0, '2021-06-07 12:52:44'),
(220, 'SPT Added', '63', 'admin@airkomgroup.com', 0, '2021-06-07 12:55:10'),
(221, 'SPT Edited', '63', 'admin@airkomgroup.com', 0, '2021-06-07 12:56:49'),
(222, 'SPT Edited', '63', 'admin@airkomgroup.com', 0, '2021-06-07 12:58:24'),
(223, 'Contact Edited', 'Rajendra', 'admin@airkomgroup.com', 0, '2021-06-19 11:00:30'),
(224, 'SPT Edited', '28', 'admin@airkomgroup.com', 0, '2021-06-19 11:00:39'),
(225, 'DCR Edited', '9', 'admin@airkomgroup.com', 0, '2021-06-19 11:00:47'),
(226, 'Roadmap Edited', '33', 'admin@airkomgroup.com', 0, '2021-06-19 11:00:55'),
(227, 'SPT Edited', '4', 'admin@airkomgroup.com', 0, '2021-06-20 22:36:05'),
(228, 'Contact Edited', 'Rajendra', 'admin@airkomgroup.com', 0, '2021-06-21 21:54:12'),
(229, 'DCR Edited', '1', 'admin@airkomgroup.com', 0, '2021-06-29 14:32:07'),
(230, 'DCR Edited', '2', 'admin@airkomgroup.com', 0, '2021-06-29 14:32:32'),
(231, 'SystemUserType Edited', 'Executives', 'admin@airkomgroup.com', 0, '2021-06-29 15:02:23'),
(232, 'SystemUserType Edited', 'Executives', 'admin@airkomgroup.com', 0, '2021-06-29 15:09:19'),
(233, 'SystemUserType Edited', 'User', 'admin@airkomgroup.com', 0, '2021-06-29 15:09:32'),
(234, 'Settings Edited', '', 'prasanna@airkomgroup.com', 0, '2021-07-27 15:48:58'),
(235, 'Branch Added', 'HO Direct', 'prasanna@airkomgroup.com', 0, '2021-07-27 16:01:17'),
(236, 'Branch Added', 'HO Projects', 'prasanna@airkomgroup.com', 0, '2021-07-27 16:01:33'),
(237, 'Branch Edited', 'HO Direct', 'prasanna@airkomgroup.com', 0, '2021-07-27 16:01:41'),
(238, 'CallType Added', 'Dealer', 'prasanna@airkomgroup.com', 0, '2021-07-27 16:03:03'),
(239, 'LeadSource Added', 'Service Engineer', 'prasanna@airkomgroup.com', 0, '2021-07-27 16:04:10'),
(240, 'LeadSource Added', 'Office', 'prasanna@airkomgroup.com', 0, '2021-07-27 16:04:54'),
(241, 'LeadStage Edited', 'Closed', 'prasanna@airkomgroup.com', 0, '2021-07-27 16:05:40'),
(242, 'LeadStage Edited', 'Early', 'prasanna@airkomgroup.com', 0, '2021-07-27 16:05:49'),
(243, 'TravelMode Added', 'Bike', 'prasanna@airkomgroup.com', 0, '2021-07-27 16:12:36'),
(244, 'Settings Edited', '', 'prasanna@airkomgroup.com', 0, '2021-07-27 16:13:37'),
(245, 'Branch Added', 'Alibag', 'prasanna@airkomgroup.com', 0, '2021-07-27 16:23:43'),
(246, 'Contact Deleted', 'Rajendra', 'prasanna@airkomgroup.com', 0, '2021-07-27 16:26:07'),
(247, 'Contact Deleted', 'Prem', 'prasanna@airkomgroup.com', 0, '2021-07-27 16:26:09'),
(248, 'Roadmap Deleted', '4', 'admin@airkomgroup.com', 0, '2021-07-27 17:07:56'),
(249, 'Roadmap Deleted', '4', 'admin@airkomgroup.com', 0, '2021-07-27 17:07:59'),
(250, 'SPT Deleted', '4', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:04'),
(251, 'SPT Deleted', '6', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:07'),
(252, 'SPT Deleted', '7', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:10'),
(253, 'SPT Deleted', '8', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:12'),
(254, 'SPT Deleted', '9', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:14'),
(255, 'SPT Deleted', '22', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:16'),
(256, 'SPT Deleted', '26', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:18'),
(257, 'SPT Deleted', '27', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:20'),
(258, 'SPT Deleted', '14', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:23'),
(259, 'SPT Deleted', '24', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:28'),
(260, 'SPT Deleted', '28', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:30'),
(261, 'SPT Deleted', '4', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:31'),
(262, 'SPT Deleted', '47', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:33'),
(263, 'SPT Deleted', '35', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:39'),
(264, 'SPT Deleted', '36', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:42'),
(265, 'SPT Deleted', '48', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:43'),
(266, 'SPT Deleted', '13', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:46'),
(267, 'SPT Deleted', '38', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:48'),
(268, 'SPT Deleted', '27', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:50'),
(269, 'SPT Deleted', '15', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:52'),
(270, 'SPT Deleted', '15', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:53'),
(271, 'SPT Deleted', '16', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:54'),
(272, 'SPT Deleted', '35', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:55'),
(273, 'SPT Deleted', '15', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:56'),
(274, 'SPT Deleted', '41', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:58'),
(275, 'SPT Deleted', '42', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:18:59'),
(276, 'SPT Deleted', '52', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:19:00'),
(277, 'SPT Deleted', '63', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:19:01'),
(278, 'DCR Deleted', '12', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:19:50'),
(279, 'DCR Deleted', '1', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:19:52'),
(280, 'DCR Deleted', '2', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:19:53'),
(281, 'DCR Deleted', '3', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:19:55'),
(282, 'DCR Deleted', '4', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:19:56'),
(283, 'DCR Deleted', '5', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:19:57'),
(284, 'DCR Deleted', '7', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:19:58'),
(285, 'DCR Deleted', '8', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:19:59'),
(286, 'DCR Deleted', '9', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:19:59'),
(287, 'Roadmap Deleted', '27', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:20:09'),
(288, 'Roadmap Deleted', '8', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:20:10'),
(289, 'Roadmap Deleted', '29', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:20:12'),
(290, 'Roadmap Deleted', '30', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:20:17'),
(291, 'Roadmap Deleted', '31', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:20:19'),
(292, 'Roadmap Deleted', '28', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:20:20'),
(293, 'Roadmap Deleted', '32', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:20:22'),
(294, 'Roadmap Deleted', '33', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:20:22'),
(295, 'Roadmap Deleted', '55', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:20:24'),
(296, 'Roadmap Deleted', '57', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:20:25'),
(297, 'Roadmap Deleted', '43', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:20:26'),
(298, 'Roadmap Deleted', '56', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:20:27'),
(299, 'Roadmap Deleted', '59', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:20:28'),
(300, 'Roadmap Deleted', '4', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:20:29'),
(301, 'Roadmap Deleted', '61', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:20:31'),
(302, 'Roadmap Deleted', '62', 'prasanna@airkomgroup.com', 0, '2021-07-27 19:20:32'),
(303, 'LeadStage Edited', 'Close', 'prasanna@airkomgroup.com', 0, '2021-07-27 20:17:38'),
(304, 'Contact Added', 'Jitendra Rokadia', 'mumbai@airkomgroup.com', 0, '2021-07-28 13:44:24'),
(305, 'SPT Added', '64', 'mumbai@airkomgroup.com', 0, '2021-07-28 13:47:55'),
(306, 'Contact Added', 'Shankar Nair', 'mumbai@airkomgroup.com', 0, '2021-07-28 13:55:09'),
(307, 'Contact Added', 'Satish Chheda', 'mumbai@airkomgroup.com', 0, '2021-07-28 13:59:58'),
(308, 'SPT Added', '65', 'mumbai@airkomgroup.com', 0, '2021-07-28 14:07:15'),
(309, 'SPT Edited', '65', 'mumbai@airkomgroup.com', 0, '2021-07-28 14:07:34'),
(310, 'SPT Edited', '65', 'mumbai@airkomgroup.com', 0, '2021-07-28 14:08:29'),
(311, 'SPT Edited', '65', 'mumbai@airkomgroup.com', 0, '2021-07-28 14:09:45'),
(312, 'SPT Added', '66', 'mumbai@airkomgroup.com', 0, '2021-07-28 14:12:56'),
(313, 'SPT Edited', '66', 'mumbai@airkomgroup.com', 0, '2021-07-28 14:13:14'),
(314, 'SPT Added', '32', 'mumbai@airkomgroup.com', 0, '2021-07-28 15:02:37'),
(315, 'SPT Edited', '32', 'mumbai@airkomgroup.com', 0, '2021-07-28 15:09:15'),
(316, 'Contact Added', 'Arsalan Khan ', 'mumbai@airkomgroup.com', 0, '2021-07-28 16:54:26'),
(317, 'SPT Added', '67', 'mumbai@airkomgroup.com', 0, '2021-07-28 16:57:51'),
(318, 'Contact Added', 'Ritesh Mistry', 'mumbai@airkomgroup.com', 0, '2021-07-28 17:03:10'),
(319, 'SPT Added', '68', 'mumbai@airkomgroup.com', 0, '2021-07-28 17:05:08'),
(320, 'Contact Added', 'Sunil Waghmare ', 'mumbai@airkomgroup.com', 0, '2021-07-28 17:23:42'),
(321, 'SPT Added', '69', 'mumbai@airkomgroup.com', 0, '2021-07-28 17:25:52'),
(322, 'DCR Added', '1', 'mumbai@airkomgroup.com', 0, '2021-07-28 18:17:24'),
(323, 'DCR Edited', '1', 'mumbai@airkomgroup.com', 0, '2021-07-28 18:19:15'),
(324, 'DCR Added', '2', 'mumbai@airkomgroup.com', 0, '2021-07-28 18:24:02'),
(325, 'DCR Edited', '1', 'mumbai@airkomgroup.com', 0, '2021-07-28 18:25:40'),
(326, 'DCR Edited', '2', 'mumbai@airkomgroup.com', 0, '2021-07-28 18:26:03'),
(327, 'Contact Added', 'Bhaskar Rao ', 'mumbai@airkomgroup.com', 0, '2021-07-28 18:33:18'),
(328, 'DCR Edited', '2', 'mumbai@airkomgroup.com', 0, '2021-07-28 18:33:56'),
(329, 'DCR Edited', '3', 'mumbai@airkomgroup.com', 0, '2021-07-28 18:34:11'),
(330, 'DCR Added', '1', 'mumbai@airkomgroup.com', 0, '2021-07-28 18:37:13'),
(331, 'Contact Added', 'Purav Raveshia', 'mumbai@airkomgroup.com', 0, '2021-07-28 19:09:43'),
(332, 'Contact Added', 'Rashmi Menon', 'mumbai@airkomgroup.com', 0, '2021-07-29 13:17:54'),
(333, 'SPT Added', '72', 'mumbai@airkomgroup.com', 0, '2021-07-29 13:22:06'),
(334, 'Contact Added', 'Ladhu Kapai ', 'mumbai@airkomgroup.com', 0, '2021-07-29 13:28:37'),
(335, 'SPT Added', '73', 'mumbai@airkomgroup.com', 0, '2021-07-29 13:31:51'),
(336, 'SPT Added', '27', 'mumbai@airkomgroup.com', 0, '2021-07-29 13:37:08'),
(337, 'Contact Added', 'Ketan Jadhav.', 'mumbai@airkomgroup.com', 0, '2021-07-29 13:57:17'),
(338, 'SPT Added', '74', 'mumbai@airkomgroup.com', 0, '2021-07-29 14:00:31'),
(339, 'Contact Added', 'Rakesh kaul', 'mumbai@airkomgroup.com', 0, '2021-07-29 14:07:17'),
(340, 'SPT Added', '75', 'mumbai@airkomgroup.com', 0, '2021-07-29 14:09:58'),
(341, 'SPT Edited', '75', 'mumbai@airkomgroup.com', 0, '2021-07-29 14:10:42'),
(342, 'SPT Edited', '75', 'mumbai@airkomgroup.com', 0, '2021-07-29 14:12:45'),
(343, 'Contact Added', 'Munir Bondare', 'mumbai@airkomgroup.com', 0, '2021-07-29 14:22:17'),
(344, 'SPT Added', '11', 'mumbai@airkomgroup.com', 0, '2021-07-29 14:26:52'),
(345, 'Contact Added', 'Mohemmad Parray ', 'mumbai@airkomgroup.com', 0, '2021-07-29 14:31:14'),
(346, 'SPT Added', '77', 'mumbai@airkomgroup.com', 0, '2021-07-29 14:33:51'),
(347, 'Contact Added', 'Shree Jamdar', 'mumbai@airkomgroup.com', 0, '2021-07-29 14:36:30'),
(348, 'SPT Added', '78', 'mumbai@airkomgroup.com', 0, '2021-07-29 14:38:22'),
(349, 'Contact Added', 'Arati Madam', 'mumbai@airkomgroup.com', 0, '2021-07-29 16:13:21'),
(350, 'SPT Added', '79', 'mumbai@airkomgroup.com', 0, '2021-07-29 16:15:38'),
(351, 'Contact Added', 'Rajiv Chaudhari ', 'mumbai@airkomgroup.com', 0, '2021-07-29 16:20:08'),
(352, 'SPT Added', '80', 'mumbai@airkomgroup.com', 0, '2021-07-29 16:24:09'),
(353, 'SPT Added', '28', 'mumbai@airkomgroup.com', 0, '2021-07-30 14:02:59'),
(354, 'Contact Added', 'Rajesh ranveria', 'mumbai@airkomgroup.com', 0, '2021-07-30 14:07:34'),
(355, 'Contact Added', 'Vinod', 'mumbai@airkomgroup.com', 0, '2021-07-30 14:11:58'),
(356, 'SPT Added', '82', 'mumbai@airkomgroup.com', 0, '2021-07-30 14:27:32'),
(357, 'SPT Added', '81', 'mumbai@airkomgroup.com', 0, '2021-07-30 14:30:02'),
(358, 'Contact Added', 'Mukesh Mehta', 'mumbai@airkomgroup.com', 0, '2021-07-30 16:15:23'),
(359, 'SPT Added', '83', 'mumbai@airkomgroup.com', 0, '2021-07-30 16:17:53'),
(360, 'SPT Added', '83', 'admin@airkomgroup.com', 0, '2021-07-31 10:15:24'),
(361, 'SPT Edited', '83', 'admin@airkomgroup.com', 0, '2021-07-31 10:16:00'),
(362, 'SPT Deleted', '83', 'admin@airkomgroup.com', 0, '2021-07-31 10:22:06'),
(363, 'SPT Added', '83', 'admin@airkomgroup.com', 0, '2021-07-31 10:27:25'),
(364, 'SPT Deleted', '83', 'admin@airkomgroup.com', 0, '2021-07-31 10:50:35');

-- --------------------------------------------------------

--
-- Table structure for table `market_segment`
--

DROP TABLE IF EXISTS `market_segment`;
CREATE TABLE IF NOT EXISTS `market_segment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `market_segment`
--

INSERT INTO `market_segment` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Analytical Equipment', 1, 1, '2021-05-17 22:26:20'),
(2, 'Banking/Finance/Insurance', 1, 1, '2021-05-17 22:26:20'),
(3, 'CNC', 1, 1, '2021-05-17 22:26:20'),
(4, 'Consultant', 1, 1, '2021-05-17 22:26:20'),
(5, 'Dealer', 1, 1, '2021-05-17 22:26:20'),
(6, 'Defence', 1, 1, '2021-05-17 22:26:20'),
(7, 'Electrical Contractor', 1, 1, '2021-05-17 22:26:20'),
(8, 'Food Industry', 1, 1, '2021-05-17 22:26:20'),
(9, 'Govt- Public Sector', 1, 1, '2021-05-17 22:26:20'),
(10, 'Hospital', 1, 1, '2021-05-17 22:26:20'),
(11, 'Hospitality / Bangalow', 1, 1, '2021-05-17 22:26:20'),
(12, 'IT Networking', 1, 1, '2021-05-17 22:26:20'),
(13, 'Manufacturing - Corporate', 1, 1, '2021-05-17 22:26:20'),
(15, 'Medical', 1, 1, '2021-05-17 22:26:20'),
(16, 'Multiplex', 1, 1, '2021-05-17 22:26:20'),
(17, 'Pharmaceutical', 1, 1, '2021-05-17 22:26:20'),
(18, 'Printing', 1, 1, '2021-05-17 22:26:20'),
(19, 'Railway', 1, 1, '2021-05-17 22:26:20'),
(20, 'Real Estate', 1, 1, '2021-05-17 22:26:20'),
(21, 'Reseller', 1, 1, '2021-05-17 22:26:20'),
(22, 'Retail Chain', 1, 1, '2021-05-17 22:26:20'),
(23, 'Textile', 1, 1, '2021-05-17 22:26:20'),
(24, 'Warehouse / Cold Storage', 1, 1, '2021-05-17 22:26:20');

-- --------------------------------------------------------

--
-- Table structure for table `next_action`
--

DROP TABLE IF EXISTS `next_action`;
CREATE TABLE IF NOT EXISTS `next_action` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `next_action`
--

INSERT INTO `next_action` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Lead Verification', 1, 1, '2021-05-17 22:34:33'),
(2, 'First Stage Meeting', 1, 1, '2021-05-17 22:34:33'),
(3, 'Technical Meeting', 1, 1, '2021-05-17 22:34:33'),
(4, 'Commercial Meeting', 1, 1, '2021-05-17 22:34:33'),
(5, 'Budget Approval', 1, 1, '2021-05-17 22:34:33'),
(6, 'Close Deal', 1, 1, '2021-05-17 22:34:33'),
(7, 'Verbal Approval', 1, 1, '2021-05-17 22:34:33'),
(8, 'PO Collection', 1, 1, '2021-05-17 22:34:33'),
(9, 'Contract Signed', 1, 1, '2021-05-17 22:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `name`, `description`, `date_created`) VALUES
(2, 'permission.manage', 'Manage permissions', '2017-08-03 09:14:52'),
(3, 'role.manage', 'Manage roles', '2017-08-03 09:14:52'),
(4, 'profile.any.view', 'View anyone\'s profile', '2017-08-03 09:14:52'),
(5, 'profile.own.view', 'View own profile', '2017-08-03 09:14:52'),
(21, 'settings.manage', 'Manage Settings', '2017-12-16 06:23:21'),
(22, 'masters.manage', 'Manage Masters', '2017-12-16 06:23:40'),
(29, 'password.manage', 'Manage Password', '2018-04-26 15:37:46'),
(31, 'logs.manage', 'Manage Logs', '2018-05-16 15:51:42'),
(40, 'dashboard.manage', 'Manage Dashboard', '2018-06-05 16:38:29'),
(48, 'user.manage', 'Manage Users', '2020-05-11 01:35:12'),
(49, 'spt.manage', 'Manage SPT Forms', '2021-05-17 23:47:44'),
(50, 'dcr.manage', 'Manage DCR Forms', '2021-05-17 23:48:00'),
(51, 'roadmap.manage', 'Manage RoadMaps', '2021-05-17 23:48:23'),
(52, 'reports.manage', 'Manage Reports', '2021-05-17 23:48:38'),
(53, 'contacts.manage', 'Manage Contacts', '2021-05-18 00:33:15'),
(54, 'targets.manage', 'Manage Targets', '2021-06-21 18:41:07'),
(55, 'pipeline.manage', 'Manage Pipeline', '2021-06-21 18:41:19');

-- --------------------------------------------------------

--
-- Table structure for table `pipeline`
--

DROP TABLE IF EXISTS `pipeline`;
CREATE TABLE IF NOT EXISTS `pipeline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spt_id` int(11) NOT NULL,
  `contact` int(11) NOT NULL,
  `stage` int(11) NOT NULL,
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pipeline`
--

INSERT INTO `pipeline` (`id`, `spt_id`, `contact`, `stage`, `created_by`, `date_created`) VALUES
(30, 1, 64, 2, 1, '2021-07-31 10:48:26'),
(31, 2, 65, 3, 1, '2021-07-31 10:48:26'),
(32, 3, 66, 3, 1, '2021-07-31 10:48:26'),
(33, 4, 32, 3, 1, '2021-07-31 10:48:26'),
(34, 5, 67, 2, 1, '2021-07-31 10:48:26'),
(35, 6, 68, 2, 1, '2021-07-31 10:48:26'),
(36, 7, 69, 2, 1, '2021-07-31 10:48:26'),
(37, 8, 72, 2, 1, '2021-07-31 10:48:26'),
(38, 9, 73, 2, 1, '2021-07-31 10:48:26'),
(39, 10, 27, 2, 1, '2021-07-31 10:48:26'),
(40, 11, 74, 3, 1, '2021-07-31 10:48:26'),
(41, 12, 75, 2, 1, '2021-07-31 10:48:26'),
(42, 13, 11, 2, 1, '2021-07-31 10:48:26'),
(43, 14, 77, 2, 1, '2021-07-31 10:48:26'),
(44, 15, 78, 2, 1, '2021-07-31 10:48:26'),
(45, 16, 79, 2, 1, '2021-07-31 10:48:26'),
(46, 17, 80, 2, 1, '2021-07-31 10:48:26'),
(47, 18, 28, 2, 1, '2021-07-31 10:48:26'),
(48, 19, 82, 2, 1, '2021-07-31 10:48:26'),
(49, 20, 81, 2, 1, '2021-07-31 10:48:26'),
(50, 21, 83, 2, 1, '2021-07-31 10:48:26');

-- --------------------------------------------------------

--
-- Table structure for table `probability`
--

DROP TABLE IF EXISTS `probability`;
CREATE TABLE IF NOT EXISTS `probability` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `probability`
--

INSERT INTO `probability` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, '25', 1, 1, '2021-05-17 17:08:14'),
(2, '50', 1, 1, '2021-05-17 17:08:20'),
(3, '75', 1, 1, '2021-05-17 17:08:27'),
(4, '90', 1, 1, '2021-05-17 17:08:33'),
(5, '100', 1, 1, '2021-05-17 17:08:41');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, '1 kVA', 1, 1, '2021-05-17 22:39:55'),
(2, '3 kVA', 1, 1, '2021-05-17 22:39:55'),
(3, '5 kVA', 1, 1, '2021-05-17 22:39:55'),
(4, '6 kVA', 1, 1, '2021-05-17 22:39:55'),
(5, '8 kVA', 1, 1, '2021-05-17 22:39:55'),
(6, '10 kVA', 1, 1, '2021-05-17 22:39:55'),
(7, '12 kVA', 1, 1, '2021-05-17 22:39:55'),
(8, '15 kVA', 1, 1, '2021-05-17 22:39:55'),
(9, '20 kVA', 1, 1, '2021-05-17 22:39:55'),
(10, '25 kVA', 1, 1, '2021-05-17 22:39:55'),
(11, '30 kVA', 1, 1, '2021-05-17 22:39:55'),
(12, '35 kVA', 1, 1, '2021-05-17 22:39:55'),
(13, '40 kVA', 1, 1, '2021-05-17 22:39:55'),
(14, '45 kVA', 1, 1, '2021-05-17 22:39:55'),
(15, '50 kVA', 1, 1, '2021-05-17 22:39:55'),
(16, '55 kVA', 1, 1, '2021-05-17 22:39:55'),
(17, '60 kVA', 1, 1, '2021-05-17 22:39:55'),
(18, '70 kVA', 1, 1, '2021-05-17 22:39:55'),
(19, '75 kVA', 1, 1, '2021-05-17 22:39:55'),
(20, '90 kVA', 1, 1, '2021-05-17 22:39:55'),
(21, '100 kVA', 1, 1, '2021-05-17 22:39:55'),
(22, '110 kVA', 1, 1, '2021-05-17 22:39:55'),
(23, '125 kVA', 1, 1, '2021-05-17 22:39:55'),
(24, '150 kVA', 1, 1, '2021-05-17 22:39:55'),
(25, '200 kVA', 1, 1, '2021-05-17 22:39:55'),
(26, '250 kVA', 1, 1, '2021-05-17 22:39:55'),
(27, '300 kVA', 1, 1, '2021-05-17 22:39:55'),
(28, '400 kVA', 1, 1, '2021-05-17 22:39:55'),
(29, '500 kVA', 1, 1, '2021-05-17 22:39:55'),
(30, '600 kVA', 1, 1, '2021-05-17 22:39:55'),
(31, '750 kVA', 1, 1, '2021-05-17 22:39:55'),
(32, '1000 kVA', 1, 1, '2021-05-17 22:39:55'),
(33, '1250 kVA', 1, 1, '2021-05-17 22:39:55'),
(34, '1500 kVA', 1, 1, '2021-05-17 22:39:55'),
(35, '1600 kVA', 1, 1, '2021-05-17 22:39:55'),
(36, '1750 kVA', 1, 1, '2021-05-17 22:39:55'),
(37, '2000 kVA', 1, 1, '2021-05-17 22:39:55'),
(38, '2200 kVA', 1, 1, '2021-05-17 22:39:55'),
(39, '2500 kVA', 1, 1, '2021-05-17 22:39:55');

-- --------------------------------------------------------

--
-- Table structure for table `product_models`
--

DROP TABLE IF EXISTS `product_models`;
CREATE TABLE IF NOT EXISTS `product_models` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_models`
--

INSERT INTO `product_models` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'AT1:1', 1, 1, '2021-05-17 22:40:47'),
(2, 'AT3:1', 1, 1, '2021-05-17 22:40:47'),
(3, 'AT3:3', 1, 1, '2021-05-17 22:40:47'),
(4, 'HFT1:1', 1, 1, '2021-05-17 22:40:47'),
(5, 'HX1:1', 1, 1, '2021-05-17 22:40:47'),
(6, 'HX3:1', 1, 1, '2021-05-17 22:40:47'),
(7, 'HX3:3', 1, 1, '2021-05-17 22:40:47'),
(8, 'HXNS', 1, 1, '2021-05-17 22:40:47'),
(9, 'IT1:1', 1, 1, '2021-05-17 22:40:47'),
(10, 'IT3:1', 1, 1, '2021-05-17 22:40:47'),
(11, 'IT3:3', 1, 1, '2021-05-17 22:40:47'),
(12, 'IX1:1', 1, 1, '2021-05-17 22:40:47'),
(13, 'IX3:1', 1, 1, '2021-05-17 22:40:47'),
(14, 'IX3:3', 1, 1, '2021-05-17 22:40:47'),
(15, 'IXNS', 1, 1, '2021-05-17 22:40:47'),
(16, 'LIFTUPS1:1', 1, 1, '2021-05-17 22:40:47'),
(17, 'LIFTUPS3:3', 1, 1, '2021-05-17 22:40:47'),
(18, 'Off-grid', 1, 1, '2021-05-17 22:40:47'),
(19, 'On-grid ', 1, 1, '2021-05-17 22:40:47'),
(20, 'SI1:1', 1, 1, '2021-05-17 22:40:47'),
(21, 'SI3:1', 1, 1, '2021-05-17 22:40:47'),
(22, 'SI3:3', 1, 1, '2021-05-17 22:40:47'),
(23, 'SIPCU1:1', 1, 1, '2021-05-17 22:40:47'),
(24, 'SIPCU3:1', 1, 1, '2021-05-17 22:40:47'),
(25, 'SIPCU3:3', 1, 1, '2021-05-17 22:40:47'),
(26, 'SP7070', 1, 1, '2021-05-17 22:40:47'),
(27, 'SPNS', 1, 1, '2021-05-17 22:40:47'),
(28, 'SPWR', 1, 1, '2021-05-17 22:40:47'),
(29, 'TPAC1080', 1, 1, '2021-05-17 22:40:47'),
(30, 'TPAC1080', 1, 1, '2021-05-17 22:40:47'),
(31, 'TPAC4080', 1, 1, '2021-05-17 22:40:47'),
(32, 'TPAC4080', 1, 1, '2021-05-17 22:40:47'),
(33, 'TPAC5070', 1, 1, '2021-05-17 22:40:47'),
(34, 'TPAC5070', 1, 1, '2021-05-17 22:40:47'),
(35, 'TPAC6060', 1, 1, '2021-05-17 22:40:47'),
(36, 'TPAC6060', 1, 1, '2021-05-17 22:40:47'),
(37, 'TPAC8080', 1, 1, '2021-05-17 22:40:47'),
(38, 'TPAC8080', 1, 1, '2021-05-17 22:40:47'),
(39, 'TPACNS', 1, 1, '2021-05-17 22:40:47'),
(40, 'TPACNS', 1, 1, '2021-05-17 22:40:47'),
(41, 'TPACXWR', 1, 1, '2021-05-17 22:40:47'),
(42, 'TPACXWR', 1, 1, '2021-05-17 22:40:47'),
(43, 'TPAR', 1, 1, '2021-05-17 22:40:47'),
(44, 'TPAR', 1, 1, '2021-05-17 22:40:47'),
(45, 'TPOC1080', 1, 1, '2021-05-17 22:40:47'),
(46, 'TPOC4080', 1, 1, '2021-05-17 22:40:47'),
(47, 'TPOC5070', 1, 1, '2021-05-17 22:40:47'),
(48, 'TPOC6060', 1, 1, '2021-05-17 22:40:47'),
(49, 'TPOC8080', 1, 1, '2021-05-17 22:40:47'),
(50, 'TPOCNS', 1, 1, '2021-05-17 22:40:47'),
(51, 'TPOCXWR', 1, 1, '2021-05-17 22:40:47'),
(52, 'TPOR', 1, 1, '2021-05-17 22:40:47');

-- --------------------------------------------------------

--
-- Table structure for table `product_series`
--

DROP TABLE IF EXISTS `product_series`;
CREATE TABLE IF NOT EXISTS `product_series` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_series`
--

INSERT INTO `product_series` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'SCVS', 1, 1, '2021-05-17 22:41:38'),
(2, 'AVR', 1, 1, '2021-05-17 22:41:38'),
(3, 'UPS', 1, 1, '2021-05-17 22:41:38'),
(4, 'IT', 1, 1, '2021-05-17 22:41:38'),
(5, 'AT', 1, 1, '2021-05-17 22:41:38'),
(6, 'Solar Inverter', 1, 1, '2021-05-17 22:41:38'),
(7, 'SolarRTS', 1, 1, '2021-05-17 22:41:38');

-- --------------------------------------------------------

--
-- Table structure for table `roadmap`
--

DROP TABLE IF EXISTS `roadmap`;
CREATE TABLE IF NOT EXISTS `roadmap` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `week` varchar(255) NOT NULL,
  `market_segment` int(10) NOT NULL,
  `prospect_name` varchar(255) NOT NULL,
  `prospect_city` varchar(255) NOT NULL,
  `propspect_machine` varchar(255) NOT NULL,
  `product_series` int(10) NOT NULL,
  `product_model` int(10) NOT NULL,
  `product` int(10) NOT NULL,
  `next_action` int(10) NOT NULL,
  `expected_quanitity` int(10) NOT NULL,
  `expected_potential_order_value` int(10) NOT NULL,
  `created_by` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` text,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `description`, `date_created`) VALUES
(1, 'Administrator', 'A person who manages users, roles, etc.', '2017-08-03 09:14:52'),
(2, 'User', 'Users Only', '2018-04-13 17:34:20'),
(3, 'Executives', 'Executives Roles', '2021-05-17 14:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `role_hierarchy`
--

DROP TABLE IF EXISTS `role_hierarchy`;
CREATE TABLE IF NOT EXISTS `role_hierarchy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_role_id` int(11) NOT NULL,
  `child_role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_role_id` (`parent_role_id`),
  UNIQUE KEY `child_role_id` (`child_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE IF NOT EXISTS `role_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_id` (`permission_id`),
  KEY `permission_id_2` (`permission_id`),
  KEY `role_id` (`role_id`),
  KEY `permission_id_3` (`permission_id`),
  KEY `role_id_2` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1202 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`) VALUES
(1122, 1, 53),
(1123, 1, 40),
(1124, 1, 50),
(1125, 1, 31),
(1126, 1, 22),
(1127, 1, 29),
(1128, 1, 2),
(1129, 1, 55),
(1130, 1, 4),
(1131, 1, 5),
(1132, 1, 52),
(1133, 1, 51),
(1134, 1, 3),
(1135, 1, 21),
(1136, 1, 49),
(1137, 1, 54),
(1138, 1, 48),
(1145, 2, 40),
(1146, 2, 29),
(1194, 3, 53),
(1195, 3, 40),
(1196, 3, 50),
(1197, 3, 29),
(1198, 3, 55),
(1199, 3, 5),
(1200, 3, 51),
(1201, 3, 49);

-- --------------------------------------------------------

--
-- Table structure for table `sales_stage`
--

DROP TABLE IF EXISTS `sales_stage`;
CREATE TABLE IF NOT EXISTS `sales_stage` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_stage`
--

INSERT INTO `sales_stage` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Recent Lead', 1, 1, '2021-05-17 22:43:04'),
(2, 'Initial Contact', 1, 1, '2021-05-17 22:43:04'),
(3, 'Product Analysis', 1, 1, '2021-05-17 22:43:04'),
(4, 'Solution Development', 1, 1, '2021-05-17 22:43:04'),
(5, 'Offer Discussion', 1, 1, '2021-05-17 22:43:04'),
(6, 'Negotiation', 1, 1, '2021-05-17 22:43:04'),
(7, 'Contract Signing', 1, 1, '2021-05-17 22:43:04');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `company_brief` text NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `page_keywords` text NOT NULL,
  `page_description` text NOT NULL,
  `distance_travel_percentage` decimal(10,2) NOT NULL,
  `name_emailer` varchar(255) DEFAULT NULL,
  `email_emailer` varchar(255) DEFAULT NULL,
  `sms_enabled` int(10) DEFAULT NULL,
  `sms_api` varchar(255) DEFAULT NULL,
  `sendgrid_api` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `company_name`, `company_brief`, `contact`, `email`, `page_title`, `page_keywords`, `page_description`, `distance_travel_percentage`, `name_emailer`, `email_emailer`, `sms_enabled`, `sms_api`, `sendgrid_api`, `created_by`, `date_created`) VALUES
(1, 'Airkom Electronics Pvt Ltd', 'Airkom Electronics Pvt. Ltd (AEPL) is a young and rapidly growing company & it is a part of the AIRKOM GROUP. It has its Head Office & Factory at Mahape, Navi Mumbai. AIRKOM was incorporated in 1987. Started under the entrepreneurship of a young electronics engineer, AIRKOM today boasts of a multimillion turnovers. ', '+91  9323863405', 'prasanna@airkomgroup.com', 'Airkom Group', 'Power Conditioning, Power Back-up, Solar Power Generation', '-', '3.00', 'Airkomgroup.com', 'admin@airkomgroup.com', 1, 'http://103.233.79.246//submitsms.jsp?user=Atat777&key=c85d97574fXX&mobile={mobile}&message={message}&senderid=infosm&accusage=1', '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', '2', '2017-11-21 07:33:15');

-- --------------------------------------------------------

--
-- Table structure for table `spt`
--

DROP TABLE IF EXISTS `spt`;
CREATE TABLE IF NOT EXISTS `spt` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `stage` int(10) NOT NULL,
  `propect_name` int(10) NOT NULL,
  `lead_source` int(10) NOT NULL,
  `executive` int(10) NOT NULL,
  `offer_no` varchar(255) NOT NULL,
  `sales_stage` int(10) NOT NULL,
  `product_series` int(10) NOT NULL,
  `product_model` int(10) NOT NULL,
  `actual_product` int(10) NOT NULL,
  `forecasted_booking_value` decimal(10,2) NOT NULL,
  `quanitity` int(10) NOT NULL,
  `discount_offered` decimal(10,2) DEFAULT NULL,
  `expected_close_date` date NOT NULL,
  `expected_month` int(10) NOT NULL,
  `close_probability` int(11) NOT NULL,
  `next_action` int(10) NOT NULL,
  `last_contacted_date` date NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `contacted_type` int(10) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `spt`
--

INSERT INTO `spt` (`id`, `stage`, `propect_name`, `lead_source`, `executive`, `offer_no`, `sales_stage`, `product_series`, `product_model`, `actual_product`, `forecasted_booking_value`, `quanitity`, `discount_offered`, `expected_close_date`, `expected_month`, `close_probability`, `next_action`, `last_contacted_date`, `remarks`, `contacted_type`, `contact`, `created_by`, `date_created`) VALUES
(1, 2, 64, 7, 3, 'MUM/098/21-22', 5, 1, 31, 10, '50000.00', 1, '35.00', '2021-07-30', 7, 5, 4, '2021-07-28', 'Will finalise within 2 days required SCVS in first week of July', 4, 'Jitendra Rokadia', 3, '2021-07-28 13:47:55'),
(2, 3, 65, 1, 3, 'MUM/099/21-22', 7, 1, 33, 15, '52000.00', 1, '57.00', '2021-07-25', 7, 5, 9, '2021-07-28', 'Need SCVS within weeks Time ', 1, 'Shankar Nair', 3, '2021-07-28 14:07:15'),
(3, 3, 66, 1, 3, 'MUM/055/21-22', 7, 1, 32, 9, '62000.00', 1, '100.00', '2021-07-26', 7, 5, 9, '2021-07-26', '', 1, 'Satish Chheda', 3, '2021-07-28 14:12:56'),
(4, 3, 32, 1, 3, 'MUM/04/21-22', 7, 1, 31, 24, '392600.00', 2, '45.00', '2021-07-09', 7, 5, 9, '2021-07-09', 'Received PO, Stabiliser with Isolation Transformer ', 1, 'Nilesh Shingavi', 3, '2021-07-28 15:02:37'),
(5, 2, 67, 1, 3, 'MUM/096/21-22', 5, 1, 31, 9, '45000.00', 1, '35.00', '2021-07-31', 7, 3, 4, '2021-07-27', 'Required SCVS with input Protection', 1, 'Arsalan Khan ', 3, '2021-07-28 16:57:51'),
(6, 2, 68, 1, 3, 'MUM/095/21-22', 5, 1, 1, 1, '0.00', 1, '0.00', '2021-08-04', 8, 3, 4, '2021-07-27', '', 1, 'Ritesh Mistry', 3, '2021-07-28 17:05:08'),
(7, 2, 69, 1, 3, 'MUM/092/21-22', 5, 1, 1, 1, '170000.00', 1, '42.00', '2021-08-05', 8, 4, 4, '2021-07-26', '', 1, 'Sunil Waghmare ', 3, '2021-07-28 17:25:52'),
(8, 2, 72, 8, 3, 'MUM/099/21-22', 5, 1, 31, 4, '32000.00', 1, '40.00', '2021-07-29', 8, 2, 4, '2021-07-29', '', 1, 'Rashmi Menon', 3, '2021-07-29 13:22:06'),
(9, 2, 73, 8, 3, 'MUM/093/21-22', 5, 1, 31, 21, '181000.00', 1, '100.00', '2021-08-10', 8, 1, 4, '2021-07-29', '', 1, 'Ladhu Kapai ', 3, '2021-07-29 13:31:51'),
(10, 2, 27, 1, 3, 'MUM/094/21-22', 5, 4, 11, 13, '168000.00', 4, '40.00', '2021-08-13', 8, 4, 4, '2021-08-18', '', 1, 'Tejal Sawant ', 3, '2021-07-29 13:37:08'),
(11, 3, 74, 1, 3, 'VP/HO/SALES/OFFER/SCVS/20-21/189', 7, 1, 29, 1, '30000.00', 1, '0.00', '2021-07-20', 7, 5, 9, '2021-07-20', '', 1, 'Ketan Jadhav.', 3, '2021-07-29 14:00:31'),
(12, 2, 75, 1, 3, 'MUM/081/21-22', 5, 4, 11, 24, '280000.00', 3, '35.00', '2021-07-15', 8, 4, 4, '2021-07-29', 'Quoted for tender', 1, 'Rakesh kaul', 3, '2021-07-29 14:09:58'),
(13, 2, 11, 1, 3, 'VP/HO/SALES/OFFER/SCVS/20-21/102', 5, 4, 11, 8, '35000.00', 1, '0.00', '2021-08-10', 8, 3, 4, '2021-07-29', 'looking for lowest price, sent revised offer for Aluminium  wound IT ', 1, 'Munir Bondre', 3, '2021-07-29 14:26:52'),
(14, 2, 77, 1, 3, 'MUM/080/21-22/r01/R01', 6, 1, 51, 21, '472700.00', 1, '0.00', '2021-07-29', 8, 5, 4, '2021-07-29', '', 1, 'Mohemmad Parray ', 3, '2021-07-29 14:33:51'),
(15, 2, 78, 1, 3, 'MUM/078/21-22', 5, 1, 32, 12, '65000.00', 1, '0.00', '2021-08-18', 8, 5, 4, '2021-07-29', '', 1, 'Shree Jamdar', 3, '2021-07-29 14:38:22'),
(16, 2, 79, 1, 3, 'MUM/077/21-22', 5, 4, 11, 1, '350000.00', 1, '0.00', '2021-08-17', 8, 4, 4, '2021-07-29', '', 1, 'Arati Madam', 3, '2021-07-29 16:15:38'),
(17, 2, 80, 1, 3, 'MUM/042/21-22 R05', 7, 1, 31, 19, '200000.00', 2, '0.00', '2021-07-17', 7, 5, 9, '2021-07-26', '', 1, 'Rajiv Chaudhari ', 3, '2021-07-29 16:24:09'),
(18, 2, 28, 1, 3, 'MUM/0100/21-22', 5, 1, 11, 25, '540600.00', 1, '0.00', '2021-07-30', 7, 2, 3, '2021-07-30', 'Project requirement', 1, 'Shrutika Sawant', 3, '2021-07-30 14:02:59'),
(19, 2, 82, 1, 3, 'MUM/082/21-22', 5, 1, 31, 10, '45000.00', 1, '0.00', '2021-08-11', 8, 3, 4, '2021-07-30', '', 1, 'Vinod', 3, '2021-07-30 14:27:32'),
(20, 2, 81, 1, 3, 'MUM/090/2', 5, 1, 26, 6, '31000.00', 1, '0.00', '2021-07-12', 8, 4, 4, '2021-07-30', '', 1, 'Rajesh ranveria', 3, '2021-07-30 14:30:02'),
(21, 2, 83, 1, 3, 'MUM/073/21-22', 5, 1, 32, 8, '32000.00', 1, '0.00', '2021-08-06', 8, 3, 4, '2021-07-08', '', 1, 'Mukesh Mehta', 3, '2021-07-30 16:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `system_user_type`
--

DROP TABLE IF EXISTS `system_user_type`;
CREATE TABLE IF NOT EXISTS `system_user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `confidential` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_user_type`
--

INSERT INTO `system_user_type` (`id`, `name`, `status`, `confidential`, `created_by`, `date_created`) VALUES
(1, 'Administrator', 0, 1, 1, '2017-12-08 12:24:13'),
(2, 'User', 1, 1, 1, '2017-12-08 12:23:18'),
(3, 'Executives', 1, 0, 1, '2021-05-17 09:20:05');

-- --------------------------------------------------------

--
-- Table structure for table `targets`
--

DROP TABLE IF EXISTS `targets`;
CREATE TABLE IF NOT EXISTS `targets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `call_type` int(11) NOT NULL,
  `target` decimal(10,0) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `targets`
--

INSERT INTO `targets` (`id`, `user_id`, `call_type`, `target`, `created_by`, `date_created`) VALUES
(1, 1, 1, '10', 1, '2021-06-18 13:40:22'),
(2, 1, 2, '2', 1, '2021-06-18 13:40:22'),
(3, 1, 3, '1', 1, '2021-06-18 13:40:22'),
(4, 1, 4, '1', 1, '2021-06-18 13:40:22'),
(5, 1, 5, '1', 1, '2021-06-18 13:40:22'),
(6, 1, 6, '1', 1, '2021-06-18 13:40:22'),
(7, 1, 97, '100', 1, '2021-06-18 13:40:22'),
(8, 1, 98, '100', 1, '2021-06-18 13:40:22'),
(9, 1, 99, '6000000', 1, '2021-06-18 13:40:22'),
(10, 1, 100, '2000000', 1, '2021-06-18 13:40:22'),
(11, 7, 1, '10', 1, '2021-06-18 13:40:22'),
(12, 7, 2, '2', 1, '2021-06-18 13:40:22'),
(13, 7, 3, '1', 1, '2021-06-18 13:40:22'),
(14, 7, 4, '1', 1, '2021-06-18 13:40:22'),
(15, 7, 5, '1', 1, '2021-06-18 13:40:22'),
(16, 7, 6, '1', 1, '2021-06-18 13:40:22'),
(17, 7, 97, '100', 1, '2021-06-18 13:40:22'),
(18, 7, 98, '100', 1, '2021-06-18 13:40:22'),
(19, 7, 99, '6000000', 1, '2021-06-18 13:40:22'),
(20, 7, 100, '2000000', 1, '2021-06-18 13:40:22'),
(41, 2, 1, '10', 1, '2021-06-18 13:40:22'),
(42, 2, 2, '2', 1, '2021-06-18 13:40:22'),
(43, 2, 3, '1', 1, '2021-06-18 13:40:22'),
(44, 2, 4, '1', 1, '2021-06-18 13:40:22'),
(45, 2, 5, '1', 1, '2021-06-18 13:40:22'),
(46, 2, 6, '1', 1, '2021-06-18 13:40:22'),
(47, 2, 97, '100', 1, '2021-06-18 13:40:22'),
(48, 2, 98, '100', 1, '2021-06-18 13:40:22'),
(49, 2, 99, '6000000', 1, '2021-06-18 13:40:22'),
(50, 2, 100, '2000000', 1, '2021-06-18 13:40:22'),
(51, 6, 1, '10', 1, '2021-06-18 13:40:22'),
(52, 6, 2, '2', 1, '2021-06-18 13:40:22'),
(53, 6, 3, '1', 1, '2021-06-18 13:40:22'),
(54, 6, 4, '1', 1, '2021-06-18 13:40:22'),
(55, 6, 5, '1', 1, '2021-06-18 13:40:22'),
(56, 6, 6, '1', 1, '2021-06-18 13:40:22'),
(57, 6, 97, '100', 1, '2021-06-18 13:40:22'),
(58, 6, 98, '100', 1, '2021-06-18 13:40:22'),
(59, 6, 99, '6000000', 1, '2021-06-18 13:40:22'),
(60, 6, 100, '2000000', 1, '2021-06-18 13:40:22'),
(107, 5, 0, '5', 2, '2021-07-27 16:00:28'),
(108, 5, 1, '120', 2, '2021-07-27 16:00:28'),
(109, 5, 2, '30', 2, '2021-07-27 16:00:28'),
(110, 5, 3, '20', 2, '2021-07-27 16:00:28'),
(111, 5, 4, '20', 2, '2021-07-27 16:00:28'),
(112, 5, 5, '0', 2, '2021-07-27 16:00:28'),
(113, 5, 6, '0', 2, '2021-07-27 16:00:28'),
(114, 5, 99, '4500000', 2, '2021-07-27 16:00:28'),
(115, 5, 100, '1500000', 2, '2021-07-27 16:00:28'),
(126, 3, 0, '3', 2, '2021-07-27 16:14:40'),
(127, 3, 1, '50', 2, '2021-07-27 16:14:40'),
(128, 3, 2, '30', 2, '2021-07-27 16:14:40'),
(129, 3, 3, '20', 2, '2021-07-27 16:14:40'),
(130, 3, 4, '20', 2, '2021-07-27 16:14:40'),
(131, 3, 5, '0', 2, '2021-07-27 16:14:40'),
(132, 3, 6, '0', 2, '2021-07-27 16:14:40'),
(133, 3, 7, '0', 2, '2021-07-27 16:14:40'),
(134, 3, 99, '4500000', 2, '2021-07-27 16:14:40'),
(135, 3, 100, '1500000', 2, '2021-07-27 16:14:40'),
(136, 4, 0, '4', 2, '2021-07-27 16:14:57'),
(137, 4, 1, '50', 2, '2021-07-27 16:14:57'),
(138, 4, 2, '30', 2, '2021-07-27 16:14:57'),
(139, 4, 3, '20', 2, '2021-07-27 16:14:57'),
(140, 4, 4, '20', 2, '2021-07-27 16:14:57'),
(141, 4, 5, '0', 2, '2021-07-27 16:14:57'),
(142, 4, 6, '0', 2, '2021-07-27 16:14:57'),
(143, 4, 7, '0', 2, '2021-07-27 16:14:57'),
(144, 4, 99, '4500000', 2, '2021-07-27 16:14:57'),
(145, 4, 100, '1500000', 2, '2021-07-27 16:14:57');

-- --------------------------------------------------------

--
-- Table structure for table `travel_mode`
--

DROP TABLE IF EXISTS `travel_mode`;
CREATE TABLE IF NOT EXISTS `travel_mode` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_mode`
--

INSERT INTO `travel_mode` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Bus', 1, 1, '2021-05-17 17:13:30'),
(2, 'Taxi', 1, 1, '2021-05-17 17:13:36'),
(3, 'Auto', 1, 1, '2021-05-17 17:13:45'),
(4, 'Others', 1, 1, '2021-05-17 17:13:51'),
(5, 'Bike', 1, 2, '2021-07-27 16:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `travel_type`
--

DROP TABLE IF EXISTS `travel_type`;
CREATE TABLE IF NOT EXISTS `travel_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_by` int(10) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `travel_type`
--

INSERT INTO `travel_type` (`id`, `name`, `status`, `created_by`, `date_created`) VALUES
(1, 'Local', 1, 1, '2021-05-17 17:14:42'),
(2, 'Outstation', 1, 1, '2021-05-17 17:14:50');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `full_name` varchar(512) NOT NULL,
  `password` varchar(256) NOT NULL,
  `status` int(11) NOT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `branch` int(10) NOT NULL DEFAULT '1',
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `pwd_reset_token` varchar(32) DEFAULT NULL,
  `pwd_reset_token_creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_idx` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `full_name`, `password`, `status`, `contact_no`, `user_type`, `profile_pic`, `branch`, `date_created`, `pwd_reset_token`, `pwd_reset_token_creation_date`) VALUES
(1, 'admin@airkomgroup.com', 'Administrator -', '$2y$10$xDR3ovnlXF.hApOxOO05Bu/it8VxkKJHRflYEQSyYMsB7WZPSYaY2', 1, '9876543210', '1', '35b953eca69b0e192c42c0d3dac37563.png', 1, '2017-08-03 09:14:52', NULL, NULL),
(2, 'prasanna@airkomgroup.com', 'Prasanna M', '$2y$10$fRb2./6GQCZn3eEjaWQnEOeEPihB6u6mW8jcT3EFQH4qDQR5zgWHK', 1, '9323863405', '1', '', 1, '2021-05-17 20:15:30', NULL, NULL),
(3, 'mumbai@airkomgroup.com', 'Vishnu Parab', '$2y$10$WMo20PbRw4KSDTfFO4vX2exQl/dE94nPwXwpwLJVUCRKQIWn3kKrG', 1, '9323716861', '3', '', 1, '2021-05-17 20:48:46', NULL, NULL),
(4, 'pune@airkomgroup.com', 'Kamal Kumar', '$2y$10$G65x7KWc9/ZfKpyJMnZWiuDyi4TT.IQTIRogiWR0TcU7MxVOtF1y6', 1, '9320314782', '3', '', 2, '2021-05-17 20:51:24', NULL, NULL),
(5, 'pune.sm@airkomgroup.com', 'Nitin Yewale', '$2y$10$EBSEXxQL16ak/QtQEL5O1udbIRXv39cv/QmPttzLxagspKK1iOrqy', 1, '9321182515', '3', '', 2, '2021-05-17 20:52:02', NULL, NULL),
(6, 'vegalights@gmail.com', 'Vega', '$2y$10$JeN4kNNBkHomSp4xmKtYb.ceNwv68488hp08yqBgVULGp6YBNPS5m', 1, '9372211834', '3', '', 5, '2021-05-17 20:52:31', NULL, NULL),
(7, 'ajay@airkomgroup.com', 'Ajay', '$2y$10$02FP7rNSk7NKyikqpRW3V.9gEFVSXStUtMPIw1kDvY3jJr8byGxzW', 1, '9876543210', '3', '', 1, '2021-05-24 08:40:29', NULL, NULL),
(8, 'marketing@airkomgroup.com', 'Sunil Kumar', '$2y$10$3ZSYxZtShYHjmDCC3taRzeRnBM4DizoZfVjZIFcAyPtYrVuIII2Bq', 1, '9320314783', '3', '', 3, '2021-07-27 09:22:36', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role_id`, `user_id`) VALUES
(1, 1, 1),
(28, 3, 7),
(29, 1, 2),
(31, 3, 3),
(32, 3, 4),
(33, 3, 5),
(35, 3, 8),
(36, 3, 6);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_hierarchy`
--
ALTER TABLE `role_hierarchy`
  ADD CONSTRAINT `role_role_child_role_id_fk` FOREIGN KEY (`child_role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_role_parent_role_id_fk` FOREIGN KEY (`parent_role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `role_permission_permission_id_fk` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`),
  ADD CONSTRAINT `role_permission_role_id_fk` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_role_id_fk` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_role_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

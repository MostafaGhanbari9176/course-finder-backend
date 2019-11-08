-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2019 at 08:12 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `city_need`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `course_id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`course_id`, `user_id`) VALUES
(3, 'godhelot1@gmail.com'),
(3, 'mehri_rajayi@yahoo.com'),
(5, 'godhelot1@gmail.com'),
(8, 'godhelot1@gmail.com'),
(9, 'godhelot1@gmail.com'),
(9, 'mehri_rajayi@yahoo.com'),
(20, 'godhelot1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `buy`
--

CREATE TABLE `buy` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `buy_date` varchar(10) NOT NULL,
  `end_buy_date` varchar(10) NOT NULL,
  `ref_id` varchar(11) NOT NULL,
  `remaining_courses` int(11) NOT NULL DEFAULT '0',
  `subscribe_id` int(11) NOT NULL,
  `vaziat` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `buy`
--

INSERT INTO `buy` (`id`, `user_id`, `buy_date`, `end_buy_date`, `ref_id`, `remaining_courses`, `subscribe_id`, `vaziat`) VALUES
(10, 'segroyek3@gmail.com', '1397-04-13', '1397-05-13', 'هدیه', 4, 4, 1),
(11, 'malihe.mir.13566@gmail.com', '1397-04-13', '1397-05-13', 'هدیه', 4, 4, 1),
(12, 'mehri_rajayi@yahoo.com', '1397-04-17', '1397-06-07', 'هدیه', 3, 4, 1),
(16, 'godhelot1@gmail.com', '1397-04-17', '1397-06-07', 'هدیه', 1, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cource`
--

CREATE TABLE `cource` (
  `cource_id` int(11) NOT NULL,
  `teacher_id` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `teacher_name` varchar(50) NOT NULL DEFAULT 'مشخص نشده',
  `tabaghe_id` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `capacity` int(11) NOT NULL,
  `mony` int(20) NOT NULL,
  `sharayet` varchar(500) NOT NULL,
  `tozihat` varchar(1000) NOT NULL,
  `definition_date` varchar(10) NOT NULL,
  `start_date` varchar(10) NOT NULL,
  `end_date` varchar(10) NOT NULL,
  `day` varchar(65) NOT NULL,
  `hours` varchar(10) NOT NULL,
  `min_old` int(2) NOT NULL,
  `max_old` int(2) NOT NULL,
  `state` int(4) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `vaziat` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `cource`
--

INSERT INTO `cource` (`cource_id`, `teacher_id`, `subject`, `teacher_name`, `tabaghe_id`, `type`, `capacity`, `mony`, `sharayet`, `tozihat`, `definition_date`, `start_date`, `end_date`, `day`, `hours`, `min_old`, `max_old`, `state`, `is_deleted`, `vaziat`) VALUES
(1, 'godhelot1@gmail.com', 'اندروید مقدماتی', '', 20, 0, 20, 500000, 'آشنایی با شیع گرایی', 'در این دوره محصلین با برنامه نویسی اندروید آشنا شده و دوره با ساخت یک برنامه اندرویدی به پایان می رسد', '1397-04-10', '1397-02-24', '1397-03-24', 'شنبه-دوشنبه-چهار شنبه', '16:0', 15, 30, 1, 0, 1),
(3, 'godhelot1@gmail.com', 'اندروید پیشرفته', '', 20, 0, 20, 500000, 'کار با سی شارپ', 'در این دوره محصل با برنامه نویسی سرور کاملا آشنا شده و دوره با ساخت یک اپ فروشگاهی به پایان می رسد', '1397-04-10', '1396-06-01', '1396-06-31', 'شنبه-چهار شنبه-جمعه', '15:0', 15, 30, 1, 0, 1),
(5, 'godhelot1@gmail.com', 'آردوینو', 'مصطفی قنبری', 54, 0, 20, 50000, 'هیچ', 'در این دوره محصل با ماژول آردوینو آشنا شده و دوره با ساخت یک ربات مسیریاب به پایان می رسد', '1397-04-10', '1397-05-19', '1397-05-23', 'چهار شنبه-پنجشنبه', '18:0', 10, 50, 1, 0, 1),
(7, 'segroyek3@gmail.com', 'کاربر ICDL', '', 26, 0, 10, 300000, 'پیش نیازندارد', 'دوره هفت مهارت ویژه استخدامی ،شامل مبانی، ویندوز ، اینترنت، ورد،اکسل، اکسس ، پاورپوینت', '1397-04-13', '1397-04-16', '1397-05-30', 'شنبه-دوشنبه-چهار شنبه', '18:0', 13, 60, 1, 0, 1),
(8, 'malihe.mir.13566@gmail.com', 'تربیت مربی هنر و کودک', '', 47, 0, 12, 450000, 'مربیان و مدرسین مهدها و پیش دبستانی ها دانشجویان رشته علوم تربیتی و امور تربیتی', 'مباحثی در مورد شیوه صحیح آموزش برای کودک در مهدها پیش دبستانی ها پرستاران کودک', '1397-04-13', '1397-04-30', '1397-05-21', 'شنبه-یکشنبه', '9:0', 16, 50, 1, 0, 1),
(9, 'mehri_rajayi@yahoo.com', 'کلاس مجازی محاسبه سریع با چرتکه ژاپنی', '', 31, 0, 2000, 38000, 'آشنایی با مفهوم اعداد', 'با نصب این اپلیکیشن از کافه بازار می توانید با هزینه اندک علاوه بر آموزش محاسبه ذهنی با چرتکه، با تمرینهای ذهنی قدرت ذهن و اعتماد فرزندتان را افزایش دهید\nبشتابید و فرصت را از دست ندهید', '1397-04-17', '1397-05-09', '1398-04-17', 'مشخص نشده', 'مشخص نشده', 5, 132, 1, 0, 1),
(10, 'godhelot1@gmail.com', 'h', '', 50, 0, 6, 3, 'h', 'h', '1397-04-24', '1397-04-24', '1397-04-31', 'شنبه', '2:2', 3, 6, 1, 0, 0),
(11, 'mehri_rajayi@yahoo.com', 'تست', 'ت', 39, 0, 30, 50000, 'ب', 'لل', '1397-05-01', '1397-05-15', '1397-05-31', 'مشخص نشده', 'مشخص نشده', 5, 12, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `download_object`
--

CREATE TABLE `download_object` (
  `d_o_id` int(11) NOT NULL,
  `small_description` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `big_description` varchar(2000) COLLATE utf8_persian_ci NOT NULL,
  `down_link` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `picture_id` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `page_id` varchar(25) COLLATE utf8_persian_ci NOT NULL,
  `attach_link` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `grouping` int(11) NOT NULL,
  `subject` varchar(50) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `download_object`
--

INSERT INTO `download_object` (`d_o_id`, `small_description`, `big_description`, `down_link`, `picture_id`, `page_id`, `attach_link`, `grouping`, `subject`) VALUES
(1, 'TESTSMALDESCRIPTION', 'TESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTIONTESTBIGDESCRIPTION', 'HttpLink', 'pictureid3', 'home', 'HttpLinkHttpLinkHttpLink', 1, 'TODO First Test');

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `teacher_id` varchar(100) NOT NULL,
  `user_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `favorite`
--

INSERT INTO `favorite` (`teacher_id`, `user_id`) VALUES
('godhelot1@gmail.com', 'godhelot@gmail.com'),
('godhelot@gmail.com', 'godhelot1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `feed_back`
--

CREATE TABLE `feed_back` (
  `id` int(11) NOT NULL,
  `feed_back_text` varchar(500) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `feed_back_date` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gift`
--

CREATE TABLE `gift` (
  `gift_code` varchar(50) NOT NULL,
  `subscribe_id` int(11) NOT NULL,
  `end_date` varchar(10) NOT NULL,
  `end_hours` varchar(2) NOT NULL,
  `counter` int(11) NOT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gift`
--

INSERT INTO `gift` (`gift_code`, `subscribe_id`, `end_date`, `end_hours`, `counter`, `state`) VALUES
('start', 4, '1397-07-05', '12', 44, 1);

-- --------------------------------------------------------

--
-- Table structure for table `like_saver`
--

CREATE TABLE `like_saver` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `is_liked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `like_saver`
--

INSERT INTO `like_saver` (`id`, `user_id`, `comment_id`, `is_liked`) VALUES
(1, 'godhelot1@gmail.com', 2, 1),
(2, 'godhelot1@gmail.com', 5, 0),
(3, 'godhelot1@gmail.com', 5, 1),
(4, 'godhelot1@gmail.com', 5, 1),
(5, 'godhelot1@gmail.com', 5, 1),
(6, 'godhelot1@gmail.com', 5, 1),
(7, 'godhelot1@gmail.com', 5, 1),
(8, 'godhelot@gmail.com', 7, 1),
(9, 'mmotahary75@gmail.com', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mahoor_app`
--

CREATE TABLE `mahoor_app` (
  `app_name` varchar(50) NOT NULL,
  `picture_id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mahoor_app`
--

INSERT INTO `mahoor_app` (`app_name`, `picture_id`, `url`) VALUES
('چرتکه', 1, 'https://cafebazaar.ir/app/ir.mahoorsoft.game.fastcal/?l=fa'),
('اتوسرویس من', 2, 'https://cafebazaar.ir/app/com.example.m_gh.myautoservice/?l=fa'),
('بانک سوالات راهنمایی و رانندگی', 3, 'https://cafebazaar.ir/app/ir.mahoorsoft.app.drivingquestions/?l=fa'),
('شهر بازی1', 4, 'https://cafebazaar.ir/app/ir.mahoorsoft.game.learngame/?l=fa'),
('شهر بازی 2', 5, 'https://cafebazaar.ir/app/ir.mahoorsoft.app.learngame2/?l=fa'),
('بانک سوالات دروس عمومی دانشگاه', 6, 'https://cafebazaar.ir/app/ir.mahoorsoft.app.questionbank/?l=fa'),
('آموزش جدول ضرب برای کودکان', 7, 'https://cafebazaar.ir/app/ir.mahoorsoft.game.zarb/?l=fa');

-- --------------------------------------------------------

--
-- Table structure for table `notify`
--

CREATE TABLE `notify` (
  `user_id` varchar(100) NOT NULL,
  `course_id` int(11) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `start_date` varchar(10) NOT NULL,
  `end_date` varchar(10) NOT NULL,
  `days` varchar(65) NOT NULL DEFAULT 'a',
  `start_notify` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notify`
--

INSERT INTO `notify` (`user_id`, `course_id`, `subject`, `start_date`, `end_date`, `days`, `start_notify`) VALUES
('godhelot1@gmail.com', 5, 'آردوینو', '1397-05-19', '1397-05-23', 'چهار شنبه-پنجشنبه', 0),
('godhelot1@gmail.com', 9, 'کلاس مجازی محاسبه سریع با چرتکه ژاپنی', '1397-05-09', '1398-04-17', 'a', 1),
('godhelot@gmail.com', 5, 'آردوینو', '1397-05-19', '1397-05-23', 'چهار شنبه-پنجشنبه', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rating_comment`
--

CREATE TABLE `rating_comment` (
  `id` int(11) NOT NULL,
  `comment_text` varchar(500) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `teacher_id` varchar(100) NOT NULL,
  `course_rat` float NOT NULL DEFAULT '0',
  `teacher_rat` float NOT NULL DEFAULT '0',
  `like_num` int(11) NOT NULL DEFAULT '0',
  `dislike_num` int(11) NOT NULL DEFAULT '0',
  `cm_date` varchar(10) NOT NULL,
  `vaziat` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rating_comment`
--

INSERT INTO `rating_comment` (`id`, `comment_text`, `course_id`, `user_id`, `teacher_id`, `course_rat`, `teacher_rat`, `like_num`, `dislike_num`, `cm_date`, `vaziat`) VALUES
(1, 'عالی', 5, 'godhelot1@gmail.com', 'godhelot1@gmail.com', 3, 4, 0, 0, '1397-05-01', 0),
(2, 'عالی حتما امتحان کمید', 9, 'mehri_rajayi@yahoo.com', 'mehri_rajayi@yahoo.com', 0, 5, 2, 0, '1397-04-17', 1),
(3, 'خیلی خوبه', 5, 'godhelot1@gmail.com', 'godhelot1@gmail.com', 0, 5, 0, 0, '1397-04-17', 0),
(4, 'goooooooooooooooooooood', 9, 'godhelot1@gmail.com', 'mehri_rajayi@yahoo.com', 4, 5, 0, 0, '1397-06-04', 0),
(5, 'متوسط', -1, 'godhelot1@gmail.com', 'mehri_rajayi@yahoo.com', 0, 1, 5, 1, '1397-05-01', 0),
(6, 'خیلی خوبه', 7, 'godhelot1@gmail.com', 'segroyek3@gmail.com', 0, 3, 0, 0, '1397-05-01', 0),
(7, 'بسیار عالی و کاربردی', 7, 'godhelot@gmail.com', 'segroyek3@gmail.com', 0, 5, 1, 0, '1397-05-03', 0),
(8, 'عالی', -1, 'mmotahary75@gmail.com', 'mehri_rajayi@yahoo.com', 0, 4, 0, 0, '1397-05-22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `sign_text` varchar(10) NOT NULL,
  `report_text` varchar(500) NOT NULL,
  `spam_id` int(11) NOT NULL,
  `spamer_id` varchar(100) NOT NULL,
  `reporter_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `sign_text`, `report_text`, `spam_id`, `spamer_id`, `reporter_id`) VALUES
(1, 'sms', 'aaa', 42, 'godhelot1@gmail.com', 'godhelot1@gmail.com'),
(2, 'sms', 'aaa', 38, 'godhelot1@gmail.com', 'godhelot1@gmail.com'),
(3, 'comment', 'aaa', 2, 'mehri_rajayi@yahoo.com', 'godhelot1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `sabtnam`
--

CREATE TABLE `sabtnam` (
  `id` int(11) NOT NULL,
  `cource_id` int(11) NOT NULL,
  `teacher_id` varchar(100) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `vaziat` tinyint(1) NOT NULL,
  `date` varchar(10) NOT NULL,
  `is_canceled` tinyint(1) NOT NULL DEFAULT '0',
  `for_teacher` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sabtnam`
--

INSERT INTO `sabtnam` (`id`, `cource_id`, `teacher_id`, `user_id`, `vaziat`, `date`, `is_canceled`, `for_teacher`) VALUES
(2, 9, 'mehri_rajayi@yahoo.com', 'godhelot1@gmail.com', 1, '1397-04-17', 0, 0),
(3, 5, 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, '1397-04-17', 2, 0),
(4, 9, 'mehri_rajayi@yahoo.com', 'mehri_rajayi@yahoo.com', 0, '1397-04-17', 2, 0),
(5, 8, 'malihe.mir.13566@gmail.com', 'godhelot1@gmail.com', 0, '1397-04-19', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sms_box`
--

CREATE TABLE `sms_box` (
  `id` int(11) NOT NULL,
  `text` varchar(500) NOT NULL,
  `ts_id` varchar(100) NOT NULL,
  `rs_id` varchar(100) NOT NULL,
  `seen_flag` tinyint(1) NOT NULL,
  `course_id` int(11) NOT NULL,
  `how_sending` tinyint(1) NOT NULL COMMENT '0-->student & 1-->teacher',
  `time` varchar(5) NOT NULL,
  `date` varchar(10) NOT NULL,
  `vaziat` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sms_box`
--

INSERT INTO `sms_box` (`id`, `text`, `ts_id`, `rs_id`, `seen_flag`, `course_id`, `how_sending`, `time`, `date`, `vaziat`) VALUES
(1, 'جهت تکمیل ثبت نام به آموزشگاه مراجعه کنید', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-11', 1),
(2, 'ثبت نام شما تایید شد.', 'mehri_rajayi@yahoo.com', 'godhelot1@gmail.com', 1, 9, 1, '00:00', '1397-04-17', 1),
(3, 'ثبت نام شما تایید نشد', 'mehri_rajayi@yahoo.com', 'mehri_rajayi@yahoo.com', 1, 9, 1, '00:00', '1397-04-17', 1),
(4, 'جهت تکمیل ثبت نام به آموزشگاه مراجعه کنید', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-17', 1),
(5, 'ثبت نام شما تایید شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-17', 1),
(6, 'جهت تکمیل ثبت نام به آموزشگاه مراجعه کنید', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-17', 1),
(7, 'ثبت نام شما تایید شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-17', 1),
(8, 'ثبت نام شما لغو شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-17', 1),
(9, 'جهت تکمیل ثبت نام به آموزشگاه مراجعه کنید', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-17', 1),
(10, 'جهت تکمیل ثبت نام به آموزشگاه مراجعه کنید', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-17', 1),
(11, 'باشه', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-17', 1),
(12, 'تست نوتیفیکیشن', 'godhelot1@gmail.com', 'mehri_rajayi@yahoo.com', 1, 9, 1, '00:00', '1397-04-18', 1),
(13, 'ثبت نام شما تایید شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-18', 1),
(14, 'ثبت نام شما تایید شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-18', 1),
(15, 'سلام خوبین گزارشکارو غروبی فرستادی ماهه بدست بیارم تغیرات دیتابیسو سه تاریخ شروع دورو داریم وبپرس قبلی ورژن براتی خوبین', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-18', 1),
(16, 'سلام خوبین گزارشکارو غروبی فرستادی ماهه بدست بیارم تغیرات دیتابیسو سه تاریخ شروع دورو داریم وبپرس قبلی ورژن براتی خوبین', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-18', 1),
(17, 'جهت تکمیل ثبت نام به آموزشگاه مراجعه کنید', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-18', 1),
(18, 'ثبت نام شما تایید شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-18', 1),
(19, 'جهت تکمیل ثبت نام به آموزشگاه مراجعه کنید', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-18', 1),
(20, 'ثبت نام شما لغو شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-18', 1),
(21, 'ثبت نام شما تایید شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-18', 1),
(22, 'جهت تکمیل ثبت نام به آموزشگاه مراجعه کنید', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-18', 1),
(23, 'ثبت نام شما لغو شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-18', 1),
(24, 'ثبت نام شما لغو شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-18', 1),
(25, 'ثبت نام شما لغو شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-18', 1),
(26, 'ثبت نام شما لغو شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-18', 0),
(27, 'نوتیفیکیشن دریافت شد', 'mehri_rajayi@yahoo.com', 'godhelot1@gmail.com', 1, 9, 1, '00:00', '1397-04-19', 0),
(28, 'جهت تکمیل ثبت نام به آموزشگاه مراجعه کنید', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-19', 0),
(29, 'جهت تکمیل ثبت نام به آموزشگاه مراجعه کنید', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-19', 0),
(30, 'جهت تکمیل ثبت نام به آموزشگاه مراجعه کنید', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-20', 1),
(31, 'جهت تکمیل ثبت نام به آموزشگاه مراجعه کنید', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-21', 1),
(32, 'ثبت نام شما تایید شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-21', 1),
(33, 'ثبت نام شما لغو شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-21', 1),
(34, 'jjjjjj', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-21', 1),
(35, 'ffffffffffffff', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-21', 1),
(36, 'جهت تکمیل ثبت نام به آموزشگاه مراجعه کنید', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-21', 1),
(37, 'جهت تکمیل ثبت نام به آموزشگاه مراجعه کنید', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-21', 1),
(38, 'ثبت نام شما تایید شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '00:00', '1397-04-24', 1),
(39, 'ثبت نام شما لغو شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '10', '1397-05-01', 0),
(40, 'ثبت نام شما تایید شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '10', '1397-05-01', 0),
(41, 'جهت تکمیل ثبت نام به آموزشگاه مراجعه کنید', 'mehri_rajayi@yahoo.com', 'godhelot1@gmail.com', 1, 9, 1, '16', '1397-05-02', 1),
(42, 'ثبت نام شما لغو شد.', 'godhelot1@gmail.com', 'godhelot1@gmail.com', 1, 5, 1, '21', '1397-05-20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subscribe`
--

CREATE TABLE `subscribe` (
  `id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `period` tinyint(4) NOT NULL,
  `subject` varchar(10) NOT NULL,
  `description` varchar(110) NOT NULL,
  `remaining_courses` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `subscribe`
--

INSERT INTO `subscribe` (`id`, `price`, `period`, `subject`, `description`, `remaining_courses`) VALUES
(1, 20000, 3, 'طلایی', 'با خرید این اشتراک شما می توانید 20 دوره در مدت 3 ماه ثبت کنید.', 20),
(2, 15000, 2, 'نقره ایی', 'با خرید این اشتراک شما می توانید 10 دوره در مدت 2 ماه ثبت کنید.', 10),
(3, 10000, 1, 'برونزی', 'با خرید این اشتراک شما می توانید 5 دوره در مدت 1 ماه ثبت کنید.', 5),
(4, 0, 1, 'هدیه', 'به پاس قدردانی, شما می توانید به مدت یک ماه پنج دوره ثبت کنید.', 5),
(5, 2000, 1, 'تک دوره', 'با خرید این اشتراک شما می توانید 1 دوره در مدت 1 ماه ثبت کنید.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tabaghe`
--

CREATE TABLE `tabaghe` (
  `id` int(11) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `uper_id` int(11) NOT NULL DEFAULT '-1',
  `root_id` int(11) NOT NULL,
  `final` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tabaghe`
--

INSERT INTO `tabaghe` (`id`, `subject`, `uper_id`, `root_id`, `final`) VALUES
(1, 'ورزشی', -1, -1, 0),
(2, 'دروس مدرسه', -1, -1, 0),
(3, 'هنری', -1, -1, 0),
(4, 'خلاقیت', -1, -1, 0),
(5, 'کامپیوتر', -1, -1, 0),
(6, 'زبان', -1, -1, 0),
(7, 'روانشناسی', -1, -1, 0),
(8, 'مکانیک', -1, -1, 0),
(9, 'حسابداری', -1, -1, 0),
(10, 'فوتبال', 1, 1, 1),
(11, 'بسکتبال', 1, 1, 1),
(12, 'تنیس', 1, 1, 1),
(13, 'رزمی', 1, 1, 0),
(14, 'کاراته', 13, 1, 1),
(15, 'بوکس', 13, 1, 1),
(16, 'نرم افزار', 5, 5, 0),
(17, 'ADSL', 5, 5, 1),
(18, 'سی پلاس پلاس', 16, 5, 1),
(19, 'سی شارپ', 16, 5, 1),
(20, 'جاوا', 16, 5, 1),
(21, 'سی', 16, 5, 1),
(22, 'متفرقه', 1, 1, 1),
(26, 'متفرقه', 5, 5, 1),
(31, 'ابتدایی', 2, 2, 1),
(32, 'راهنمایی', 2, 2, 1),
(33, 'دبیرستان', 2, 2, 1),
(34, 'آبرنگ', 3, 3, 1),
(35, 'خوش نویسی', 3, 3, 1),
(36, 'مجسمه سازی', 3, 3, 1),
(37, 'گل سازی', 3, 3, 1),
(38, 'عربی', 6, 6, 1),
(39, 'انگلیسی', 6, 6, 1),
(40, 'روسی', 6, 6, 1),
(41, 'آلمانی', 6, 6, 1),
(42, 'هندی', 6, 6, 1),
(43, 'تعویض روغن', 8, 8, 1),
(44, 'تعمیر و نگهداری', 8, 8, 1),
(45, 'اقتصاد', 9, 9, 1),
(46, 'متفرقه', 2, 2, 1),
(47, 'متفرقه', 3, 3, 1),
(48, 'متفرقه', 4, 4, 1),
(49, 'متفرقه', 6, 6, 1),
(50, 'متفرقه', 7, 7, 1),
(51, 'متفرقه', 8, 8, 1),
(52, 'متفرقه', 9, 9, 1),
(53, 'رباتیک', -1, -1, 0),
(54, 'مکانیک مقدماتی', 53, 53, 1),
(55, 'متفرقه', 53, 53, 1),
(56, 'اداری', -1, -1, 0),
(57, 'متفرقه', 56, 56, 1),
(58, 'ICDL', 16, 5, 1),
(59, 'متفرقه', 13, 1, 1),
(60, 'تربیت مربی', -1, -1, 0),
(61, 'متفرقه', 60, 60, 1),
(62, 'رباتیک پیشرفته', 53, 53, 1),
(63, 'مکانیک پیشرفته', 53, 53, 0),
(65, 'متفرقه', 16, 5, 1),
(66, 'مربی مهد کودک', 60, 60, 1),
(67, 'مربی قرآن', 60, 60, 1),
(68, 'مربی نقاشی', 60, 60, 1);

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `phone` varchar(100) NOT NULL,
  `land_phone` varchar(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `madrak` tinyint(3) NOT NULL DEFAULT '0',
  `subject` varchar(200) NOT NULL,
  `definition_date` varchar(10) NOT NULL,
  `taied_date` varchar(10) DEFAULT NULL,
  `end_date` varchar(10) DEFAULT NULL,
  `tozihat` varchar(1000) NOT NULL,
  `lat` varchar(30) NOT NULL,
  `lon` varchar(30) NOT NULL,
  `picture_id` varchar(200) NOT NULL,
  `address` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`phone`, `land_phone`, `type`, `madrak`, `subject`, `definition_date`, `taied_date`, `end_date`, `tozihat`, `lat`, `lon`, `picture_id`, `address`) VALUES
('godhelot1@gmail.com', '05431132499', 0, 2, 'ماهور', '1397-04-10', '1397-04-15', NULL, 'برگزاری دوره های آموزش برنامه نویسی از مقدماتی تا پیشرفته', '29.470935', '60.858509', 'a5m9g6@113t4o9l1e4h0d3o5g1', 'دانشگاه سیستان و بلوچستان مجتمع فناوری ونوآوری واحد 118'),
('malihe.mir.13566@gmail.com', '09158408696', 0, 2, 'نگارخانه رادنقش', '1397-04-13', '1397-04-16', NULL, 'مرکز هنر تفکر خلاقیت، مشاوره کودک و والدین، برگزاری دوره های تربیت مربی هنر کودک،  هنر درون', '29.462343442156133', '60.84324236959218', '3814.6r2i9m8.2e9h6i0l3a5m1', 'مقابل دانشجو ۴ پارک علم و فناوری'),
('mehri_rajayi@yahoo.com', '05431132499', 0, 2, 'کلاس مجازی محاسبه سریع با چرتکه ژاپنی', '1397-04-17', '1397-04-17', NULL, 'با نصب این اپلیکیشن از کافه بازار به راحتی می توانید به کودکان ۵ تا ۱۳ سال محاسبات سریع با چرتکه ژاپنی آموزش دهید', '29.4892550', '60.8612360', '@6i9y4a2j6a9r5_3i0r1h3e5m1', 'کافه بازار اپلیکیشن کلاس مجازی محاسبه سریع با چرتکه'),
('segroyek3@gmail.com', '05433429235', 0, 2, 'صفرویک', '1397-04-13', '1397-04-16', NULL, 'دوره های مقدماتی تا پیشرفته بامربیان مجرب وحرفه ای باارائه مدرک فنی وحرفه ای\n1-	فناوری اطلاعات\n2-	امور مالی و بازرگانی(مدیریت و حسابداری)\n3-	مهندسی صنایع\n4-	مهندسی کشاورزی\n5-	خدمات آموزشی\n6-	زبان انگلیسی\n7-	عمران ومعماری\n8-	هنرهای تجسمی\n9-	موسیقی\n', '29.467720', '60.853647', 'a5m3g2@639k0e7y8o6r0g3e5s1', 'خیابان دانشگاه .دانشگاه 25 ابتدای میلان  سمت راست ساختمان پرنیان طبقه دوم مجتمع صفر و یک طبقه فوقانی خشک شویی');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `phone` varchar(100) NOT NULL,
  `cell_phone` varchar(11) NOT NULL DEFAULT 'مشخص نشده',
  `pass` varchar(50) NOT NULL DEFAULT '-1',
  `name` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `api_code` varchar(200) DEFAULT NULL,
  `join_date` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`phone`, `cell_phone`, `pass`, `name`, `status`, `type`, `api_code`, `join_date`) VALUES
('g', 'مشخص نشده', '-1', 'moka', 1, 0, 'g1', ''),
('godhelot1@gmail.com', '09157474088', 'mosi', 'مصطفی قنبری', 1, 1, 'a3m3g1m614t0o6l2e6h5d3o5g1', ''),
('godhelot@gmail.com', '09157474087', 'wxrvymi.lohvrssxyt456ybf4', 'مصطفی', 1, 0, 'i9a6m8g2m9t1o0l1e3h5d3o5g1', ''),
('godhelot۱@gmail.com', 'مشخص نشده', '!@', 'a', 1, 0, 'm0g6m1?6?1t0o6l4e7h5d3o5g1', ''),
('jk', 'مشخص نشده', '-1', 'mokajkjk', 1, 0, 'k5j1', '1397-06-09'),
('malihe.mir.13566@gmail.com', '0', '1531299513068', 'ملیحه میر', 1, 1, '3814.6r2i9m8.2e9h6i0l3a5m1', ''),
('mehri_rajayi@yahoo.com', '0', '1531299513069', 'مهری رجایی', 1, 1, '@3i6y2a8j1a2r1_1i2r1h3e5m1', ''),
('mmotahary75@gmail.com', 'مشخص نشده', 'wxrvymi.lohvrssxyt456ybf4', 'منصوه', 1, 0, 'g1@55579y8r8a0h7a3t3o3m5m1', ''),
('mobin1net@gmail.com', 'مشخص نشده', '!@', 'mobin', 1, 0, 'a1m1g7m2t1e0n714n7i5b3o5m1', '1397-06-09'),
('mostafa.balouchzehi1995@gmail.com', '0', 'wxrvymi.lohvrssxyt456ybf4', 'مصطفی بلوچ زهی', 0, 0, 'u3o2l8a7b5.0a0f6a5t1s3o5m1', ''),
('mostafa.strong674@gmail.com', 'مشخص نشده', '!@', 'مصطفی شه بخش', 1, 0, 'n3o5r6t2s4b7a0f4a0t5s3o5m1', ''),
('mostafa@gmail.com', 'مشخص نشده', '!@222222222222222222', 'mobin', 1, 0, 'l3i9a6m7g5m1a7f4a7t5s3o5m1', ''),
('motahari.mansoureh@gmail.com', 'مشخص نشده', '123456789', 'منصوره مطهری نژاد', 1, 0, 's5n6a7m6b7i0r0a6h3a5t3o5m1', ''),
('segroyek3@gmail.com', '0', '1531299513070', 'ندا گلشاهی', 1, 1, 'a5m3g2@639k0e7y8o6r0g3e5s1', ''),
('zahra.azade.1984@gmail.com', 'مشخص نشده', 'wxrvymi.lohvrssxyt456ybf4', 'زهرا آزاده', 1, 0, '19.1e4d8a1z6a1.9a5r2h3a5z1', '');

-- --------------------------------------------------------

--
-- Table structure for table `verify_code`
--

CREATE TABLE `verify_code` (
  `phone` varchar(100) NOT NULL,
  `code` int(11) NOT NULL DEFAULT '0',
  `sending_day` varchar(10) NOT NULL,
  `counter` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `verify_code`
--

INSERT INTO `verify_code` (`phone`, `code`, `sending_day`, `counter`) VALUES
('godhelot1@gmail.com', 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `version_name`
--

CREATE TABLE `version_name` (
  `version_name` varchar(10) NOT NULL,
  `v_date` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `version_name`
--

INSERT INTO `version_name` (`version_name`, `v_date`) VALUES
('1.0.7', '1397-05-19'),
('1.0.9', '1397-06-03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`course_id`,`user_id`);

--
-- Indexes for table `buy`
--
ALTER TABLE `buy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cource`
--
ALTER TABLE `cource`
  ADD PRIMARY KEY (`cource_id`);

--
-- Indexes for table `download_object`
--
ALTER TABLE `download_object`
  ADD PRIMARY KEY (`d_o_id`,`page_id`,`grouping`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`teacher_id`,`user_id`);

--
-- Indexes for table `feed_back`
--
ALTER TABLE `feed_back`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gift`
--
ALTER TABLE `gift`
  ADD PRIMARY KEY (`gift_code`);

--
-- Indexes for table `like_saver`
--
ALTER TABLE `like_saver`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mahoor_app`
--
ALTER TABLE `mahoor_app`
  ADD PRIMARY KEY (`picture_id`);

--
-- Indexes for table `notify`
--
ALTER TABLE `notify`
  ADD PRIMARY KEY (`user_id`,`course_id`);

--
-- Indexes for table `rating_comment`
--
ALTER TABLE `rating_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sabtnam`
--
ALTER TABLE `sabtnam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_box`
--
ALTER TABLE `sms_box`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribe`
--
ALTER TABLE `subscribe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabaghe`
--
ALTER TABLE `tabaghe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`phone`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`phone`);

--
-- Indexes for table `verify_code`
--
ALTER TABLE `verify_code`
  ADD PRIMARY KEY (`phone`);

--
-- Indexes for table `version_name`
--
ALTER TABLE `version_name`
  ADD PRIMARY KEY (`version_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buy`
--
ALTER TABLE `buy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `cource`
--
ALTER TABLE `cource`
  MODIFY `cource_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `download_object`
--
ALTER TABLE `download_object`
  MODIFY `d_o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `feed_back`
--
ALTER TABLE `feed_back`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `like_saver`
--
ALTER TABLE `like_saver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `mahoor_app`
--
ALTER TABLE `mahoor_app`
  MODIFY `picture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `rating_comment`
--
ALTER TABLE `rating_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sabtnam`
--
ALTER TABLE `sabtnam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `sms_box`
--
ALTER TABLE `sms_box`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `subscribe`
--
ALTER TABLE `subscribe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tabaghe`
--
ALTER TABLE `tabaghe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

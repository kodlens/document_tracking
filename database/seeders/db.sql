/*
SQLyog Ultimate v12.14 (64 bit)
MySQL - 10.4.28-MariaDB : Database - doc_tracking
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`doc_tracking` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `doc_tracking`;

/*Table structure for table `document_tracks` */

DROP TABLE IF EXISTS `document_tracks`;

CREATE TABLE `document_tracks` (
  `document_track_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `document_id` bigint(20) unsigned NOT NULL,
  `prev_doc_track_id` bigint(20) unsigned DEFAULT 0,
  `route_id` bigint(20) unsigned NOT NULL,
  `route_detail_id` bigint(20) unsigned NOT NULL,
  `office_id` bigint(20) unsigned NOT NULL,
  `order_no` int(11) NOT NULL DEFAULT 0,
  `is_origin` tinyint(4) NOT NULL DEFAULT 0,
  `is_last` tinyint(4) NOT NULL DEFAULT 0,
  `is_forward_from` tinyint(4) NOT NULL DEFAULT 0,
  `is_received` tinyint(4) NOT NULL DEFAULT 0,
  `datetime_received` datetime DEFAULT NULL,
  `receive_remarks` varchar(255) DEFAULT NULL,
  `is_process` tinyint(4) NOT NULL DEFAULT 0,
  `datetime_process` datetime DEFAULT NULL,
  `process_remarks` varchar(255) DEFAULT NULL,
  `is_done` tinyint(4) NOT NULL DEFAULT 0,
  `datetime_done` datetime DEFAULT NULL,
  `done_remarks` varchar(255) DEFAULT NULL,
  `is_forwarded` tinyint(4) NOT NULL DEFAULT 0,
  `datetime_forwarded` datetime DEFAULT NULL,
  `forward_remarks` varchar(255) DEFAULT NULL,
  `back_remarks` text DEFAULT NULL,
  `back_datetime` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`document_track_id`),
  KEY `document_tracks_document_id_foreign` (`document_id`),
  KEY `document_tracks_route_id_foreign` (`route_id`),
  KEY `document_tracks_route_detail_id_foreign` (`route_detail_id`),
  KEY `document_tracks_office_id_foreign` (`office_id`),
  CONSTRAINT `document_tracks_document_id_foreign` FOREIGN KEY (`document_id`) REFERENCES `documents` (`document_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `document_tracks_office_id_foreign` FOREIGN KEY (`office_id`) REFERENCES `offices` (`office_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `document_tracks_route_detail_id_foreign` FOREIGN KEY (`route_detail_id`) REFERENCES `route_details` (`route_detail_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `document_tracks_route_id_foreign` FOREIGN KEY (`route_id`) REFERENCES `routes` (`route_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `document_tracks` */

insert  into `document_tracks`(`document_track_id`,`document_id`,`prev_doc_track_id`,`route_id`,`route_detail_id`,`office_id`,`order_no`,`is_origin`,`is_last`,`is_forward_from`,`is_received`,`datetime_received`,`receive_remarks`,`is_process`,`datetime_process`,`process_remarks`,`is_done`,`datetime_done`,`done_remarks`,`is_forwarded`,`datetime_forwarded`,`forward_remarks`,`back_remarks`,`back_datetime`,`created_at`,`updated_at`) values 
(4,2,0,4,5,4,1,0,0,1,1,'2023-12-08 19:23:40',NULL,1,'2023-12-08 19:23:51',NULL,0,NULL,NULL,1,'2023-12-08 19:25:27',NULL,NULL,NULL,'2023-12-08 19:05:25','2023-12-08 19:25:27'),
(5,2,0,4,6,9,2,0,0,1,0,NULL,NULL,0,NULL,NULL,0,NULL,NULL,0,NULL,NULL,NULL,NULL,'2023-12-08 19:05:25','2023-12-08 19:25:27'),
(6,2,0,4,7,10,3,0,1,0,0,NULL,NULL,0,NULL,NULL,0,NULL,NULL,0,NULL,NULL,NULL,NULL,'2023-12-08 19:05:25','2023-12-08 19:05:25'),
(7,3,0,4,5,4,1,0,0,1,0,NULL,NULL,0,NULL,NULL,0,NULL,NULL,0,NULL,NULL,'adaw','2023-12-10 13:08:00','2023-12-08 19:28:20','2023-12-10 13:08:45'),
(8,3,0,4,6,9,2,0,0,0,0,NULL,NULL,0,NULL,NULL,0,NULL,NULL,0,NULL,NULL,NULL,NULL,'2023-12-08 19:28:20','2023-12-08 19:28:20'),
(9,3,0,4,7,10,3,0,1,0,0,NULL,NULL,0,NULL,NULL,0,NULL,NULL,0,NULL,NULL,NULL,NULL,'2023-12-08 19:28:20','2023-12-08 19:28:20');

/*Table structure for table `documents` */

DROP TABLE IF EXISTS `documents`;

CREATE TABLE `documents` (
  `document_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `tracking_no` varchar(255) DEFAULT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `route_id` bigint(20) unsigned NOT NULL,
  `is_done` tinyint(4) NOT NULL,
  `datetime_done` datetime NOT NULL,
  `is_forwarded` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`document_id`),
  KEY `documents_user_id_foreign` (`user_id`),
  KEY `documents_route_id_foreign` (`route_id`),
  CONSTRAINT `documents_route_id_foreign` FOREIGN KEY (`route_id`) REFERENCES `routes` (`route_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `documents` */

insert  into `documents`(`document_id`,`user_id`,`tracking_no`,`document_name`,`route_id`,`is_done`,`datetime_done`,`is_forwarded`,`created_at`,`updated_at`) values 
(2,2,'E702DEA99A4C6A2','PAYROL dec 1-15',4,0,'0000-00-00 00:00:00',1,'2023-12-08 19:05:25','2023-12-08 19:05:25'),
(3,2,'5B1C0F0C78B8C33','payroll nov 15-31',4,0,'0000-00-00 00:00:00',1,'2023-12-08 19:28:20','2023-12-08 19:28:20');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(10,'2014_10_12_000000_create_users_table',1),
(11,'2014_10_12_100000_create_password_resets_table',1),
(12,'2019_08_19_000000_create_failed_jobs_table',1),
(13,'2019_12_14_000001_create_personal_access_tokens_table',1),
(14,'2023_03_16_204449_create_routes_table',1),
(15,'2023_03_16_205144_create_offices_table',1),
(16,'2023_03_16_211315_create_route_details_table',1),
(17,'2023_03_17_061653_create_documents_table',1),
(18,'2023_03_17_061717_create_document_tracks_table',1);

/*Table structure for table `offices` */

DROP TABLE IF EXISTS `offices`;

CREATE TABLE `offices` (
  `office_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `office` varchar(100) DEFAULT NULL,
  `incharge` varchar(100) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`office_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `offices` */

insert  into `offices`(`office_id`,`office`,`incharge`,`designation`,`created_at`,`updated_at`) values 
(1,'IBFS','','',NULL,NULL),
(2,'ICJE','','',NULL,NULL),
(3,'ICS','','',NULL,NULL),
(4,'TCGC ACCOUNTING','','',NULL,'2023-12-08 15:44:36'),
(5,'CISO','FRITZIE ANN FLORIDA','CISO HEAD',NULL,NULL),
(6,'REGISTRAR','','',NULL,NULL),
(7,'OSA','','',NULL,NULL),
(8,'GUIDANCE','BERNICE SUMALINOG','GUIDANCE COUNCILOR',NULL,NULL),
(9,'CITY ACCOUNTING',NULL,NULL,'2023-12-08 15:44:20','2023-12-08 15:44:20'),
(10,'CITY TREASURER',NULL,NULL,'2023-12-08 15:44:27','2023-12-08 15:44:27');

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `route_details` */

DROP TABLE IF EXISTS `route_details`;

CREATE TABLE `route_details` (
  `route_detail_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` int(11) NOT NULL DEFAULT 0,
  `route_id` bigint(20) unsigned NOT NULL,
  `office_id` bigint(20) unsigned NOT NULL,
  `is_origin` tinyint(4) NOT NULL DEFAULT 0,
  `is_last` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`route_detail_id`),
  KEY `route_details_route_id_foreign` (`route_id`),
  KEY `route_details_office_id_foreign` (`office_id`),
  CONSTRAINT `route_details_office_id_foreign` FOREIGN KEY (`office_id`) REFERENCES `offices` (`office_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `route_details_route_id_foreign` FOREIGN KEY (`route_id`) REFERENCES `routes` (`route_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `route_details` */

insert  into `route_details`(`route_detail_id`,`order_no`,`route_id`,`office_id`,`is_origin`,`is_last`,`created_at`,`updated_at`) values 
(1,3,1,2,0,0,NULL,NULL),
(2,4,1,4,0,1,NULL,NULL),
(5,1,4,4,0,0,'2023-12-08 15:51:46','2023-12-08 15:51:46'),
(6,2,4,9,0,0,'2023-12-08 15:51:46','2023-12-08 15:51:46'),
(7,3,4,10,0,1,'2023-12-08 15:51:46','2023-12-08 15:52:03');

/*Table structure for table `routes` */

DROP TABLE IF EXISTS `routes`;

CREATE TABLE `routes` (
  `route_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `route_name` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`route_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `routes` */

insert  into `routes`(`route_id`,`route_name`,`remarks`,`created_at`,`updated_at`) values 
(1,'GADTC Payroll','',NULL,NULL),
(2,'Sample 1','',NULL,NULL),
(3,'Sample 2','',NULL,NULL),
(4,'GADTC PAYROLL 2023',NULL,'2023-12-08 15:51:46','2023-12-08 15:51:46');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) DEFAULT NULL,
  `suffix` varchar(20) DEFAULT NULL,
  `sex` varchar(20) DEFAULT NULL,
  `office_id` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`user_id`,`username`,`lname`,`fname`,`mname`,`suffix`,`sex`,`office_id`,`contact_no`,`role`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(1,'admin','PUCOT','MARJHON','','','MALE','0','09655138165','ADMINISTRATOR','$2y$10$qshqI1g00REEM8u6OK6T1e68GkLvDCEG3sN7SN/O992.3j1KqwHRm',NULL,NULL,NULL),
(2,'arnel','SELATONA','ARNEL','','','MALE','0','09655138165','LIAISON','$2y$10$ZwMvB400Hgqpkqka9bebG.3Clv6A/1QWDmIWqr22GADXVAcjif/OC',NULL,NULL,NULL),
(3,'liason','SELATONA','ARNEL','','','MALE','0','09655138165','STAFF','$2y$10$ndDJ2d.tdthTJD3nUz0UEubJYyLTo1FsanIHtHv1S/x5OF8YE3mGe',NULL,NULL,NULL),
(4,'tcgc-accounting','ACCOUNTING','ACCOUNTING','','','MALE','4','1234','STAFF','$2y$10$8XZAhGuV2QoBYl/E4ze6Z.bHGIPewwPeJEZJDUxAlg54XwZPOMYl2',NULL,'2023-12-08 19:07:56','2023-12-08 19:07:56'),
(5,'cityaccounting','CITYACCOUNTING','CITYACCOUNTING','','','MALE','9','1234','STAFF','$2y$10$mm3alCTjf3mP8CT2vywXbOh6mATXz3xSc3HTIlJUYEgNKVFBE3ZVW',NULL,'2023-12-08 19:22:28','2023-12-08 19:22:28');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

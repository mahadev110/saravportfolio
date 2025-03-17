/*
SQLyog Community v13.3.0 (64 bit)
MySQL - 10.4.32-MariaDB : Database - saravportfolio
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Data for the table `access_logs` */

insert  into `access_logs`(`id`,`passcode_id`,`access_time`,`ip_address`,`user_agent`) values 
(1,3,'2025-03-17 10:10:15','192.168.0.200','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36');

/*Data for the table `email_logs` */

insert  into `email_logs`(`id`,`passcode_id`,`email`,`sent_time`,`status`) values 
(1,2,'sugumar@actechsoft.com','2025-03-15 13:20:02','failed'),
(2,2,'sugumar@actechsoft.com','2025-03-15 13:22:11','failed'),
(3,2,'test@gmail.com','2025-03-15 13:24:37','failed'),
(4,2,'recruiter@jobportal.com','2025-03-15 13:25:02','failed'),
(5,2,'recruiter@jobportal.com','2025-03-15 13:25:11','failed'),
(6,3,'dzyte.py@gmail.com','2025-03-17 09:49:46','failed');

/*Data for the table `passcodes` */

insert  into `passcodes`(`id`,`passcode`,`is_active`,`created_at`,`created_by`,`description`) values 
(1,'031917',1,'2025-03-15 13:08:25','admin',''),
(2,'167161',1,'2025-03-15 13:10:39','admin',''),
(3,'986451',1,'2025-03-15 13:27:18','admin','for dev');

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`) values 
(2,'admin','admin123');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

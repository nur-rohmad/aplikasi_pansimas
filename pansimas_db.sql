/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.4.21-MariaDB : Database - pansimas_bintoyo_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pansimas_bintoyo_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `pansimas_bintoyo_db`;

/*Table structure for table `pelanggan` */

DROP TABLE IF EXISTS `pelanggan`;

CREATE TABLE `pelanggan` (
  `id_pelanggan` varchar(10) NOT NULL,
  `name_pelanggan` varchar(50) DEFAULT NULL,
  `rw_pelanggan` int(11) DEFAULT NULL,
  `rt_pelanggan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pelanggan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `pelanggan` */

/*Table structure for table `stand_meter_pelanggan` */

DROP TABLE IF EXISTS `stand_meter_pelanggan`;

CREATE TABLE `stand_meter_pelanggan` (
  `id_pelanggan` varchar(6) DEFAULT NULL,
  `start_meter` int(11) DEFAULT 0,
  `end_meter` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `stand_meter_pelanggan` */

/*Table structure for table `tagihan` */

DROP TABLE IF EXISTS `tagihan`;

CREATE TABLE `tagihan` (
  `id_tagihan` varchar(20) NOT NULL,
  `name_tagihan` varchar(50) DEFAULT NULL,
  `jumlah_tagihan` double DEFAULT NULL,
  PRIMARY KEY (`id_tagihan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tagihan` */

insert  into `tagihan`(`id_tagihan`,`name_tagihan`,`jumlah_tagihan`) values 
('TG1','biaya per metter',2000),
('TG2','Biaya Abunemen',5000);

/*Table structure for table `transaksi` */

DROP TABLE IF EXISTS `transaksi`;

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(10) NOT NULL,
  `id_pelanggan` varchar(6) DEFAULT NULL,
  `jumlah_meteran` int(11) DEFAULT NULL,
  `total_bayar` double DEFAULT NULL,
  `tanggal_transaksi` date DEFAULT NULL,
  `start_meter` int(11) DEFAULT NULL,
  `end_meter` int(11) DEFAULT NULL,
  `biaya_pemakaian` double DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `transaksi` */

/*Table structure for table `user_table` */

DROP TABLE IF EXISTS `user_table`;

CREATE TABLE `user_table` (
  `user_id` varchar(5) NOT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `user_pass` varchar(50) DEFAULT NULL,
  `user_photo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_table` */

insert  into `user_table`(`user_id`,`user_name`,`user_pass`,`user_photo`) values 
('1','operator','operator123','avatar5.png'),
('2','rohmad','r123','avatar.png');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- --------------------------------------------------------

--
-- Table structure for table `razor_vida_active_user`
--

CREATE TABLE IF NOT EXISTS `razor_vida_active_user` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`deviceid` varchar(200) NOT NULL,
`productkey` varchar(50) NOT NULL,
`version` varchar(50) NOT NULL,
`platform` varchar(50) NOT NULL,
`language` varchar(50) NOT NULL,
`resolution` varchar(50) NOT NULL,
`devicename` varchar(50) NOT NULL,
`wifimac` varchar(50) NOT NULL,
`service_supplier` varchar(64) NOT NULL,
`sessioncount` int(11) NOT NULL DEFAULT '0',
`activedate` datetime NOT NULL,
`updatedate` datetime NOT NULL,
`insertdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
UNIQUE KEY `deviceid` (`deviceid`),
KEY `productkey` (`productkey`,`version`),
KEY `activedate` (`activedate`),
KEY `updatedate` (`updatedate`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `razor_vida_report_daily_product`
--

CREATE TABLE IF NOT EXISTS `razor_vida_report_daily_product` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`product_id` int(11) NOT NULL,
`period` datetime NOT NULL,
`activeuser` int(11) NOT NULL,
`updateuser` int(11) NOT NULL,
`totaluser` int(11) NOT NULL,
`totalsession` int(11) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `period_product_id_index` (`period`,`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `razor_vida_report_daily_user`
--

CREATE TABLE IF NOT EXISTS `razor_vida_report_daily_user` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`product_id` int(11) NOT NULL,
`period` datetime NOT NULL,
`channel` varchar(255) NOT NULL,
`version` varchar(50) NOT NULL,
`activeuser` int(11) NOT NULL,
`updateuser` int(11) NOT NULL,
`totaluser` int(11) NOT NULL,
`totalsession` int(11) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `period_channel_version_index` (`period`,`channel`,`version`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `razor_vida_report_hourly_product`
--

CREATE TABLE IF NOT EXISTS `razor_vida_report_hourly_product` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`product_id` int(11) NOT NULL,
`period` datetime NOT NULL,
`activeuser` int(11) NOT NULL,
`updateuser` int(11) NOT NULL,
`totaluser` int(11) NOT NULL,
`totalsession` int(11) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `product_id_period_index` (`product_id`,`period`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `razor_vida_report_hourly_user`
--

CREATE TABLE IF NOT EXISTS `razor_vida_report_hourly_user` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`product_id` int(11) NOT NULL,
`period` datetime NOT NULL,
`channel` varchar(255) NOT NULL,
`version` varchar(50) NOT NULL,
`activeuser` int(11) NOT NULL,
`updateuser` int(11) NOT NULL,
`totaluser` int(11) NOT NULL,
`totalsession` int(11) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `period_channel_version_index` (`period`,`channel`,`version`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `razor_vida_report_monthly_user`
--

CREATE TABLE IF NOT EXISTS `razor_vida_report_monthly_user` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`product_id` int(11) NOT NULL,
`period` datetime NOT NULL,
`channel` varchar(255) NOT NULL,
`version` varchar(50) NOT NULL,
`activeuser` int(11) NOT NULL,
`updateuser` int(11) NOT NULL,
`totaluser` int(11) NOT NULL,
`totalsession` int(11) NOT NULL,
PRIMARY KEY (`id`),
UNIQUE KEY `period_channel_version_index` (`period`,`channel`,`version`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


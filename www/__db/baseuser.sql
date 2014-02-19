CREATE TABLE `pgtradeuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pguser_id` int(11) NOT NULL,
  `pgedit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pgcreate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pgstore_id` int(11) NOT NULL,
  `pgcreateuser_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
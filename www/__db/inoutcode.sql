CREATE TABLE `pginoutcode` (
  `id` tinyint(1) NOT NULL,
  `pgmaxnhap` int(11) NOT NULL DEFAULT '0',
  `pgmaxxuat` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
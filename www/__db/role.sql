CREATE TABLE `pgrole` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pguser_id` int(11) NOT NULL,
  `pgraadmin` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrauser` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrastore` tinyint(4) NOT NULL DEFAULT '-1',
  `pgranhomthietbi` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrathietbi` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrachitietthietbi` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrainout` tinyint(4) NOT NULL DEFAULT '-1',
  `pgramoneytransfer` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrareport` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrbnhapradio` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrbxuatradio` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrbnhapkho` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrbthuhoi` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrbxuatkho` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrbxuatcuahang` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrbxuatdoitac` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrbxuatkhachle` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrbthanhtoan` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrptinout` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrpmoney` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrpcongnocuahang` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrpcongnodoitac` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrptonkho` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrlchitietthietbi` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrlinout` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrlinout_details` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrlmoneytransfer` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrlnhomthietbi` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrlrole` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrlstore` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrlthietbi` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrluser` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrlv_inout` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrlv_moneytransfer` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrbnhaptien` tinyint(4) NOT NULL DEFAULT '-1',
  `pgrbxuattien` tinyint(4) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
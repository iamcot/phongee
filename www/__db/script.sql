/* home 31/12*/
ALTER TABLE  `pginout` ADD  `pguser_id` INT NOT NULL;

/*home 04/01*/
/*[7:23:56 PM][1224 ms]*/ ALTER TABLE `pgmoneytransfer` ADD COLUMN `pginfo` TEXT not NULL AFTER `pgdate`;
/*home 08/01*/
/*[10:31:10 PM][440 ms]*/ ALTER TABLE `pgchitietthietbi` ADD COLUMN `pgimei` VARCHAR(50) NOT NULL AFTER `pgthietbi_code`, ADD COLUMN `pgpartno` VARCHAR(50) NOT NULL AFTER `pgimei`;
ALTER TABLE `pgstore`
  ADD COLUMN `pgtype` VARCHAR(20) NOT NULL AFTER `pgcreateuser_id`;
  ALTER TABLE `pginout`
  ADD COLUMN `pghanthanhtoan` INT(11) NOT NULL AFTER `pgcreateuser_id`;

 ALTER TABLE `pginout`
  ADD COLUMN `pgtypedichvu` VARCHAR(20) NOT NULL AFTER `pghanthanhtoan`;
  ALTER TABLE `pgmoneytransfer`
  ADD COLUMN `pgstore_id` INT NOT NULL AFTER `pginfo`;

  /* home 16/1 */
  ALTER TABLE `pgmoneytransfer`
  ADD COLUMN `pguser_id` INT(11) NOT NULL AFTER `pgstore_id`;

  /**
  home 13/2/14
   */
   /*[1:04:39 AM][260 ms]*/ ALTER TABLE `pgmoneytransfer` ADD COLUMN `pgmoneytype` VARCHAR(20) NULL AFTER `pguser_id`;
   /*[1:04:39 AM][260 ms]*/ ALTER TABLE `pgmoneytransfer` ADD COLUMN `pgmoneyrate` VARCHAR(20) NULL AFTER `pgmoneytype`;

  //tanner 14/2
  /* 2:07:34 PM localhost */ ALTER TABLE `pgmoneytransfer` CHANGE `pgmoneytype` `pgmoneytype` VARCHAR(20)  CHARACTER SET utf8  COLLATE utf8_general_ci  NOT NULL  DEFAULT 'tm';
  /* 2:07:36 PM localhost */ ALTER TABLE `pgmoneytransfer` CHANGE `pgmoneyrate` `pgmoneyrate` VARCHAR(20)  CHARACTER SET utf8  COLLATE utf8_general_ci  NOT NULL  DEFAULT '1';
  /*[3:11:51 PM][1073 ms]*/ ALTER TABLE `pgrole` CHANGE `pgrbxuatcuahang` `pgrbcuahang` TINYINT(4) DEFAULT -1 NOT NULL, CHANGE `pgrbxuatdoitac` `pgrbkhachhang` TINYINT(4) DEFAULT -1 NOT NULL, CHANGE `pgrbxuatkhachle` `pgrbkhachle` TINYINT(4) DEFAULT -1 NOT NULL;
  /*[5:31:50 PM][264 ms]*/ ALTER TABLE `pgthietbi` ADD COLUMN `pgdvt` VARCHAR(20) DEFAULT 'cái' NULL AFTER `pgcreateuser_id`, ADD COLUMN `pgtgbh` VARCHAR(50) DEFAULT '12 tháng' NULL AFTER `pgdvt`;
 ALTER TABLE `pgchitietthietbi`
  ADD COLUMN `pgdvt` VARCHAR(20) DEFAULT 'cái'   NULL AFTER `pgpartno`,
  ADD COLUMN `pgtgbh` VARCHAR(50) DEFAULT '12 tháng'   NULL AFTER `pgdvt`;

/*16/2*/
  /* 2:40:47 PM localhost */ ALTER TABLE `pgmoneytransfer` ADD `pgstore_idall` INT  NOT NULL  DEFAULT '0'  AFTER `pgstore_id`;
ALTER TABLE  `pginoutcode` ADD  `id` INT NOT NULL FIRST ,
ADD PRIMARY KEY (  `id` ) ;


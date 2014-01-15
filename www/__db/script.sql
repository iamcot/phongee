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


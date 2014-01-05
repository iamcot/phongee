/* home 31/12*/
ALTER TABLE  `pginout` ADD  `pguser_id` INT NOT NULL;

/*home 04/01*/
/*[7:23:56 PM][1224 ms]*/ ALTER TABLE `pgmoneytransfer` ADD COLUMN `pginfo` TEXT not NULL AFTER `pgdate`;
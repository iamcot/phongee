DROP PROCEDURE IF EXISTS `buildinoutcode`$$
     CREATE PROCEDURE buildinoutcode (IN pgtype VARCHAR(5),OUT inoutcode INT )
     BEGIN
     DECLARE vcrrnum INT(11);
     IF pgtype != 'nhap' THEN
     SELECT xuat INTO vcrrnum FROM pginoutcode LIMIT 0,1;
     SET inoutcode = vcrrnum + 1;
     UPDATE pginoutcode SET xuat = inoutcode LIMIT 1;
     ELSE
     SELECT nhap INTO vcrrnum FROM pginoutcode LIMIT 0,1;
     SET inoutcode = vcrrnum + 1;
     UPDATE pginoutcode SET nhap = inoutcode LIMIT 1;
     END IF;
     END$$
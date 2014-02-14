DELIMITER $$
CREATE PROCEDURE buildinoutcode (IN pgtype VARCHAR(5),OUT inoutcode int )
BEGIN
DECLARE vcrrnum INT(11);
IF pgtype != 'nhap' THEN
SELECT nhap into vcrrnum FROM pginoutcode;  
SET inoutcode = vcrrnum + 1;
UPDATE pginoutcode SET nhap = inoutcode;
ELSE 
SELECT xuat into vcrrnum FROM pginoutcode;
SET inoutcode = vcrrnum + 1;
UPDATE pginoutcode SET xuat = inoutcode;
END IF;
END$$

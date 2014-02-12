CREATE OR REPLACE VIEW v_congno_user
AS
SELECT 
m.user_id,
SUM((CASE WHEN (m.pgtype='nhap') THEN (m.pgamount) ELSE 0 END)) sumnhap,
SUM((CASE WHEN (m.pgtype='xuat') THEN (m.pgamount) ELSE 0 END)) sumxuat
FROM v_moneytransfer m
WHERE m.pgdeleted=0 AND m.user_id > 0
group by m.user_id

//new
CREATE OR REPLACE VIEW v_congno_user
AS
SELECT
m.user_id,
(SUM((CASE WHEN (m.pgtype='nhap') THEN (m.pgamount) ELSE 0 END)) - SUM((CASE WHEN (m.pgtype='xuat') THEN (m.pgamount) ELSE 0 END))) sumtien
FROM v_moneytransfer m
WHERE m.pgdeleted=0 AND m.user_id > 0
group by m.user_id
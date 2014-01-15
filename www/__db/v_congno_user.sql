CREATE OR REPLACE VIEW v_congno_user
AS
SELECT 
m.user_id,
(CASE WHEN (m.pgtype='nhap') THEN (m.pgamount) ELSE 0 END) sumnhap,
(CASE WHEN (m.pgtype='xuat') THEN (m.pgamount) ELSE 0 END) sumxuat
FROM v_moneytransfer m
WHERE m.pgdeleted=0 AND m.user_id > 0
CREATE OR REPLACE VIEW v_tienquy
AS
SELECT m1.pgdate,m1.pginfo,(CASE WHEN (m1.pgtype='nhap') THEN (pgamount) ELSE ( 0 ) END) moneyin, 
(CASE WHEN (m1.pgtype='xuat') THEN (-1*pgamount) ELSE ( 0 ) END) moneyout,
0 AS inout_id,m1.pgcreateuser_id 
FROM pgmoneytransfer m1 
WHERE m1.pgdeleted=0 AND m1.pginout_id=0 
UNION ALL 
SELECT m2.pgdate,m2.pginfo,(CASE WHEN (i.pgxuattype='khachhang' OR i.pgxuattype='khachle') THEN (pgamount) ELSE ( 0 ) END) moneyin, 
(CASE WHEN (m2.pgtype='nhap') THEN (-1*pgamount) ELSE ( 0 ) END) moneyout,
i.id,m2.pgcreateuser_id 
FROM pgmoneytransfer m2, pginout i 
WHERE m2.pgdeleted=0 AND m2.pginout_id > 0 AND i.id = m2.pginout_id 
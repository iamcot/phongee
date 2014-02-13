CREATE OR REPLACE VIEW v_tienquy
AS
SELECT m1.pgdate,m1.pginfo,m1.pgtype,(m1.pgamount * m1.pgmoneyrate) pgamount,m1.pgamount amountorg, m1.pgmoneyrate,m1.pgmoneytype,
0 AS inout_id,m1.pgcreateuser_id,m1.pgstore_id,
m1.inoutfrom,m1.inoutto,m1.inouttype,m1.inoutxuattype,m1.username,m1.user_id
FROM v_moneytransfer m1
WHERE m1.pgdeleted=0 AND m1.pginout_id=0
UNION ALL
SELECT m2.pgdate,m2.pginfo,m2.pgtype,(m2.pgamount * m2.pgmoneyrate) pgamount,m2.pgamount amountorg,m2.pgmoneyrate,m2.pgmoneytype,
i.id,m2.pgcreateuser_id,m2.pgstore_id,
m2.inoutfrom,m2.inoutto,m2.inouttype,m2.inoutxuattype,m2.username,m2.user_id
FROM v_moneytransfer m2, pginout i
WHERE m2.pgdeleted=0 AND m2.pginout_id > 0 AND i.id = m2.pginout_id









(CASE WHEN (m1.pgtype='nhap') THEN (pgamount) ELSE ( 0 ) END) moneyin,
(CASE WHEN (m1.pgtype='xuat') THEN (-1*pgamount) ELSE ( 0 ) END) moneyout,

(CASE WHEN (i.pgxuattype='khachhang' OR i.pgxuattype='khachle') THEN (pgamount) ELSE ( 0 ) END) moneyin,
(CASE WHEN (m2.pgtype='nhap') THEN (-1*pgamount) ELSE ( 0 ) END) moneyout,
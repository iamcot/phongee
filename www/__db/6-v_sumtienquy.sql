CREATE OR REPLACE VIEW
v_sumtienquy
AS 
SELECT
SUM((CASE WHEN ( inoutxuattype = 'khachhang' ) THEN (pgamount) ELSE ( 0 ) END)) moneyin,
SUM((CASE WHEN ( inouttype='nhap' ) THEN (pgamount * -1) ELSE ( 0 ) END)) moneyout,
inout_id
FROM v_tienquy
WHERE inouttype='nhap' OR inoutxuattype = 'khachhang'
GROUP BY inout_id
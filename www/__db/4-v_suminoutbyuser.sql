CREATE OR REPLACE VIEW
v_suminout
AS
SELECT 
j.id,
j.pginout_id,
j.inouttype,
j.pgxuattype,
j.inoutfrom,
j.inoutto,
j.pghanthanhtoan,
j.inoutdate,
j.inoutcode,
j.pgdeleted,
j.pgcreateuser_id,
SUM(CASE WHEN (j.inouttype='nhap') THEN (j.pgcount*j.pgprice) ELSE ( 0 ) END) sumphaitra,
SUM(CASE WHEN (j.inouttype='xuat') THEN (j.pgcount*j.pgprice) ELSE ( 0 ) END) sumduocnhan,
(SELECT SUM(m.pgamount*m.pgmoneyrate) FROM pgmoneytransfer m WHERE m.pginout_id = j.pginout_id ) sumthanhtoan
 FROM  v_inout j
GROUP BY j.pginout_id
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
SUM(CASE WHEN (j.pgxuattype='nhapkho') THEN (j.pgcount*j.pgprice) ELSE ( 0 ) END) sumphaitra,
SUM(CASE WHEN (j.pgxuattype='khachhang') THEN (j.pgcount*j.pgprice) ELSE ( 0 ) END) sumduocnhan
 FROM  v_inout j
GROUP BY j.pginout_id
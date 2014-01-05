CREATE OR REPLACE VIEW
v_congno
AS
SELECT u.id,u.`pglname`,u.pgfname, COALESCE(SUM(q.moneyin),0) danhan,COALESCE(SUM(q.moneyout*-1),0) datra ,
 SUM(i.sumphaitra) sumphaitra,
 SUM(i.sumduocnhan) sumduocnhan,
u.`pgrole`
 FROM pguser AS u
  JOIN v_suminout AS i
 ON ( (i.`inouttype`='nhap' AND u.id = i.`inoutfrom`) OR ( i.`pgxuattype`='khachhang' AND u.id = i.`inoutto`) )
 LEFT JOIN v_sumtienquy q
 ON i.`pginout_id` = q.inout_id  

WHERE
u.pgdeleted = 0
GROUP BY u.id


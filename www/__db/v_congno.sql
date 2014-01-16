CREATE OR REPLACE VIEW
v_congno
AS
SELECT u.id,u.`pglname`,u.pgfname, COALESCE(SUM(q.moneyin),0) danhan,COALESCE(SUM(q.moneyout*-1),0) datra ,
 SUM(i.sumphaitra) sumphaitra,
 SUM(i.sumduocnhan) sumduocnhan,
 MIN(io.pghanthanhtoan) hanthanhtoannhap,
  MIN(io2.pghanthanhtoan) hanthanhtoanxuat,
  (t.sumnhap) tiennhap,
  (t.sumxuat) tienxuat,
u.`pgrole`
 FROM pguser AS u
 LEFT JOIN v_suminout AS i
 ON ( (i.pgxuattype = 'nhapkho' AND u.id = i.`inoutfrom`) OR ( i.`pgxuattype`='khachhang' AND u.id = i.`inoutto`) )
 LEFT JOIN v_sumtienquy q
 ON i.`pginout_id` = q.inout_id  
LEFT JOIN pginout io
ON io.id = i.`pginout_id` AND io.pghanthanhtoan >= UNIX_TIMESTAMP() AND io.pgxuattype = 'nhapkho'
LEFT JOIN pginout io2
ON io2.id = i.`pginout_id` AND io2.pghanthanhtoan >= UNIX_TIMESTAMP() AND io2.pgtype = 'xuat'
LEFT JOIN v_congno_user t
ON t.user_id = u.id 
WHERE
u.pgdeleted = 0 AND ( (i.pgxuattype = 'nhapkho' AND u.id = i.`inoutfrom`) OR ( i.`pgxuattype`='khachhang' AND u.id = i.`inoutto`) OR t.user_id > 0)
GROUP BY u.id


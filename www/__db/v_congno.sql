CREATE OR REPLACE VIEW
v_congno
AS
SELECT u.tradeid,u.`pglname`,u.pgfname, COALESCE(SUM(q.moneyin),0) danhan,COALESCE(SUM(q.moneyout*-1),0) datra ,
 SUM(i.sumphaitra) sumphaitra,
 SUM(i.sumduocnhan) sumduocnhan,
 MIN(CASE WHEN (i.pghanthanhtoan >= UNIX_TIMESTAMP() AND i.pgxuattype = 'nhapkho' AND (i.sumthanhtoan<i.sumphaitra OR i.sumthanhtoan IS NULL)) THEN i.pghanthanhtoan ELSE 9999999999 END ) hanthanhtoannhap,
  MIN(CASE WHEN (i.pghanthanhtoan >= UNIX_TIMESTAMP() AND i.inouttype = 'xuat' AND (i.sumthanhtoan<i.sumduocnhan OR i.sumthanhtoan IS NULL)) THEN i.pghanthanhtoan ELSE 9999999999 END ) hanthanhtoanxuat,
  (t.sumnhap) tiennhap,
  (t.sumxuat) tienxuat,
u.`pgrole`,
u.tradestore_id
 FROM v_tradeuser AS u
 LEFT JOIN v_suminout AS i
 ON ( (i.pgxuattype = 'nhapkho' AND u.tradeid = i.`inoutfrom`) OR ( i.`pgxuattype`='khachhang' AND u.tradeid = i.`inoutto`) )
 LEFT JOIN v_sumtienquy q
 ON i.`pginout_id` = q.inout_id
LEFT JOIN v_congno_user t
ON t.user_id = u.tradeid
WHERE
 ( (i.pgxuattype = 'nhapkho' AND u.tradeid = i.`inoutfrom`) OR ( i.`pgxuattype`='khachhang' AND u.tradeid = i.`inoutto`) OR t.user_id > 0)
GROUP BY u.tradeid
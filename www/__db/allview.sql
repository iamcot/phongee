
CREATE OR REPLACE
    VIEW `v_inout`
    AS
SELECT
d.*,
(CASE WHEN (d.pgsaleunit = 'percent') THEN (d.pgprice - d.pgsaleamount*d.pgprice/100) ELSE (d.pgprice - d.pgsaleamount) END) saleprice,
i.pgcode inoutcode,
i.pgtype inouttype,
i.pgxuattype,
i.pgfrom inoutfrom,
i.pgto inoutto,
i.pghanthanhtoan,
i.pgtypedichvu,
c.pglong_name thietbiname,
n.id nhomthietbi_id,
n.pglong_name nhomthietbiname,
u.pgfname,
u.pglname,
i.pgdate inoutdate,
c.pgdvt,
c.pgtgbh
FROM pginout_details d
LEFT JOIN pginout i
ON  d.pginout_id = i.id
LEFT JOIN pgthietbi t
ON  d.pgthietbi_id = t.id
LEFT JOIN pgnhomthietbi n
ON t.pgnhomthietbi_id = n.id
LEFT JOIN pgchitietthietbi c
ON c.pgcode = d.pgseries
LEFT JOIN pguser u
ON  d.pgcreateuser_id = u.id
AND d.pgdeleted = 0

ORDER BY d.pginout_id;


CREATE OR REPLACE VIEW v_tradeuser
AS
SELECT
t.id tradeid,
t.pgstore_id tradestore_id,
s.pglong_name,
u.*
FROM pgtradeuser t
LEFT JOIN pguser u
ON u.id = t.pguser_id
LEFT JOIN pgstore s
ON s.id = t.pgstore_id;
CREATE OR REPLACE VIEW v_moneytransfer
AS
SELECT m.*,s.pglong_name storename,
s2.pglong_name storenameall ,
u.pgfname, u.pglname,
concat(u2.pglname,' ',u2.pgfname) username,
u2.tradeid user_id,
i.pgcode inoutcode,
i.pgfrom inoutfrom,
i.pgto inoutto,
i.pgtype inouttype,
i.pgxuattype inoutxuattype
FROM pgmoneytransfer m
LEFT JOIN pgstore s
ON s.id = m.pgstore_id
LEFT JOIN pgstore s2
ON s2.id = m.pgstore_idall
LEFT JOIN pguser u
ON u.id = m.pgcreateuser_id
LEFT JOIN v_tradeuser u2
ON u2.tradeid = m.pguser_id
LEFT JOIN pginout i
ON i.id = m.pginout_id;

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
GROUP BY j.pginout_id;

CREATE OR REPLACE VIEW v_tienquy
AS
SELECT m1.pgdate,m1.pginfo,m1.pgtype,(m1.pgamount * m1.pgmoneyrate) pgamount,m1.pgamount amountorg, m1.pgmoneyrate,m1.pgmoneytype,
0 AS inout_id,m1.pgcreateuser_id,m1.pgstore_id,
m1.inoutfrom,m1.inoutto,m1.inouttype,m1.inoutxuattype,m1.username,m1.user_id,m1.pgstore_idall
FROM v_moneytransfer m1
WHERE m1.pgdeleted=0 AND m1.pginout_id=0
UNION ALL
SELECT m2.pgdate,m2.pginfo,m2.pgtype,(m2.pgamount * m2.pgmoneyrate) pgamount,m2.pgamount amountorg,m2.pgmoneyrate,m2.pgmoneytype,
i.id,m2.pgcreateuser_id,m2.pgstore_id,
m2.inoutfrom,m2.inoutto,m2.inouttype,m2.inoutxuattype,m2.username,m2.user_id,m2.pgstore_idall
FROM v_moneytransfer m2, pginout i
WHERE m2.pgdeleted=0 AND m2.pginout_id > 0 AND i.id = m2.pginout_id;
CREATE OR REPLACE VIEW
v_sumtienquy
AS
SELECT
SUM((CASE WHEN ( inoutxuattype = 'khachhang' ) THEN (pgamount) ELSE ( 0 ) END)) moneyin,
SUM((CASE WHEN ( inouttype='nhap' ) THEN (pgamount * -1) ELSE ( 0 ) END)) moneyout,
inout_id
FROM v_tienquy
WHERE inouttype='nhap' OR inoutxuattype = 'khachhang'
GROUP BY inout_id;

CREATE OR REPLACE VIEW v_tienquy_store
AS
SELECT s.id,
SUM(CASE WHEN (t.inoutxuattype = 'thuhoi') THEN (t.pgamount) ELSE 0 END) traxuat,
SUM(CASE WHEN (t.inoutxuattype = 'xuatkho') THEN (t.pgamount) ELSE 0 END) tranhap
FROM pgstore s
LEFT JOIN v_tienquy t
ON t.pgstore_id = s.id  OR t.pgstore_idall = s.id
WHERE s.pgtype ='cuahang'
GROUP BY s.id
ORDER BY s.pgorder, s.pglong_name;

CREATE OR REPLACE VIEW v_congno_user
AS
SELECT
m.user_id,
SUM((CASE WHEN (m.pgtype='nhap') THEN (m.pgamount*m.pgmoneyrate) ELSE 0 END)) sumnhap,
SUM((CASE WHEN (m.pgtype='xuat') THEN (m.pgamount*m.pgmoneyrate) ELSE 0 END)) sumxuat
FROM v_moneytransfer m
WHERE m.pgdeleted=0 AND m.user_id > 0 AND m.pginout_id = 0
group by m.user_id;
CREATE OR REPLACE VIEW v_congno_store
AS
SELECT s.*,
SUM(CASE WHEN ( i.inoutfrom = s.id) THEN (i.pgprice * i.pgcount) ELSE (0) END ) sumxuat,
SUM(CASE WHEN (i.inoutto = s.id) THEN (i.pgprice * i.pgcount) ELSE (0) END ) sumnhap,
t.traxuat,
t.tranhap
FROM pgstore s
LEFT JOIN v_inout i
ON  i.pgxuattype = 'thuhoi' OR i.pgxuattype = 'xuatkho'
LEFT JOIN v_tienquy_store t
ON t.id = s.id
WHERE s.pgtype='cuahang'
GROUP BY s.id
ORDER BY s.pgorder, s.pglong_name;

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
GROUP BY u.tradeid;
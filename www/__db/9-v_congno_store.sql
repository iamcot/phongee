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
ORDER BY s.pgorder, s.pglong_name

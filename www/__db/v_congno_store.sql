CREATE OR REPLACE VIEW v_congno_store
AS
SELECT s.*,
SUM(CASE WHEN (i.pgxuattype != 'nhapkho' AND i.inoutfrom = s.id) THEN (i.pgprice * i.pgcount) ELSE (0) END ) sumxuat,
SUM(CASE WHEN (i.pgxuattype != 'khachhang' AND i.pgxuattype != 'khachle' AND i.inoutto = s.id) THEN (i.pgprice * i.pgcount) ELSE (0) END ) sumnhap,
t.tiennhap,
t.tienxuat,
t.traxuat,
t.tranhap

FROM pgstore s
LEFT JOIN v_inout i
ON (i.pgxuattype != 'nhapkho' AND i.inoutfrom = s.id) OR (i.pgxuattype != 'khachhang' AND i.pgxuattype != 'khachle' AND i.inoutto = s.id)
LEFT JOIN v_tienquy_store t
ON t.id = s.id
GROUP BY s.id
ORDER BY s.pgorder, s.pglong_name

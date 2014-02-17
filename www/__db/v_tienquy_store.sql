/*
chi kho va cua hang
*/
CREATE OR REPLACE VIEW v_tienquy_store
 */
AS
SELECT s.id,
SUM(CASE WHEN (t.pgtype='nhap' AND t.inoutxuattype is NULL AND t.user_id IS NULL) THEN (t.pgamount) ELSE 0 END) tiennhap,
SUM(CASE WHEN (t.pgtype='xuat' AND t.inoutxuattype is NULL AND t.user_id IS NULL) THEN (t.pgamount) ELSE 0 END) tienxuat,
SUM(CASE WHEN (t.inoutxuattype is not NULL AND t.inoutxuattype != 'nhapkho' AND t.inoutfrom  = s.id) THEN (t.pgamount) ELSE 0 END) traxuat,
SUM(CASE WHEN (t.inoutxuattype is not NULL AND t.inoutxuattype != 'khachhang' AND t.inoutxuattype != 'khachle' AND t.inoutto = s.id) THEN (t.pgamount) ELSE 0 END) tranhap
FROM pgstore s
LEFT JOIN v_tienquy t
ON (t.pgstore_id = s.id ) OR (t.inoutxuattype is not NULL AND t.inoutxuattype != 'nhapkho' AND t.inoutfrom = s.id) OR (t.inoutxuattype is not NULL AND t.inoutxuattype != 'khachhang' AND t.inoutxuattype != 'khachle' AND t.inoutto = s.id)
GROUP BY s.id
ORDER BY s.pgorder, s.pglong_name




/*
full cua hang
*/
CREATE OR REPLACE VIEW v_tienquy_store
 */
AS
SELECT s.id,
SUM(CASE WHEN (t.pgtype='nhap' AND t.inoutxuattype is NULL AND t.user_id IS NULL) THEN (t.pgamount) ELSE 0 END) tiennhap,
SUM(CASE WHEN (t.pgtype='xuat' AND t.inoutxuattype is NULL AND t.user_id IS NULL) THEN (t.pgamount) ELSE 0 END) tienxuat,
SUM(CASE WHEN (t.inoutxuattype is not NULL AND t.inoutxuattype != 'nhapkho' AND t.inoutfrom  = s.id) THEN (t.pgamount) ELSE 0 END) traxuat,
SUM(CASE WHEN (t.inoutxuattype is not NULL AND t.inoutxuattype != 'khachhang' AND t.inoutxuattype != 'khachle' AND t.inoutto = s.id) THEN (t.pgamount) ELSE 0 END) tranhap
FROM pgstore s
LEFT JOIN v_tienquy t
ON (t.pgstore_id = s.id ) OR (t.inoutxuattype is not NULL AND t.inoutxuattype != 'nhapkho' AND t.inoutfrom = s.id) OR (t.inoutxuattype is not NULL AND t.inoutxuattype != 'khachhang' AND t.inoutxuattype != 'khachle' AND t.inoutto = s.id) 
GROUP BY s.id
ORDER BY s.pgorder, s.pglong_name
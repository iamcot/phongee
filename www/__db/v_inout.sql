
CREATE OR REPLACE 
    VIEW `v_inout`
    AS
SELECT 
d.*,
i.pgcode inoutcode,
i.pgtype inouttype,
i.pgxuattype,
i.pgfrom inoutfrom,
i.pgto inoutto,
i.pghanthanhtoan,
i.pgtypedichvu,
t.pglong_name thietbiname,
n.id nhomthietbi_id,
n.pglong_name nhomthietbiname,
u.pgfname,
u.pglname,
i.pgdate inoutdate
FROM pginout_details d
LEFT JOIN pginout i
ON  d.pginout_id = i.id
LEFT JOIN pgthietbi t
ON  d.pgthietbi_id = t.id
LEFT JOIN pgnhomthietbi n
ON t.pgnhomthietbi_id = n.id
LEFT JOIN pguser u
ON  d.pgcreateuser_id = u.id
AND d.pgdeleted = 0

ORDER BY d.pginout_id


CREATE OR REPLACE 
    VIEW `v_inout` 
    AS
SELECT 
d.*,
i.pgtype inouttype,
i.pgxuattype,
i.pgfrom inoutfrom,
i.pgto inouto,
t.pglong_name thietbiname,
n.id nhomthietbi_id,
n.pglong_name nhomthietbiname,
u.pgfname,
u.pglname,
FROM pginout_details d,pginout i, pgchitietthietbi c,pgthietbi t,pgnhomthietbi n,pguser u
WHERE
d.pginout_id = i.id AND d.pgthietbi_id = t.id AND t.pgnhomthietbi_id = n.id AND d.pgcreateuser_id = u.id
AND d.pgdeleted = 0

GROUP BY d.id
ORDER BY d.pginout_id DESC

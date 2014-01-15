CREATE OR REPLACE VIEW v_moneytransfer
AS
SELECT m.*,s.pglong_name storename,
u.pgfname, u.pglname,
concat(u2.pglname,' ',u2.pgfname) username,
u2.id user_id,
i.pgcode inoutcode,
i.pgfrom inoutfrom,
i.pgto inoutto,
i.pgtype inouttype,
i.pgxuattype inoutxuattype
FROM pgmoneytransfer m
LEFT JOIN pgstore s
ON s.id = m.pgstore_id
LEFT JOIN pguser u
ON u.id = m.pgcreateuser_id
LEFT JOIN pguser u2
ON u2.id = m.pguser_id
LEFT JOIN pginout i
ON i.id = m.pginout_id

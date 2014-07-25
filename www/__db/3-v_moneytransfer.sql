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
ON i.id = m.pginout_id

CREATE OR REPLACE VIEW v_tradeuser
AS
SELECT
t.id tradeid,
t.pgstore_id tradestore_id,
u.*
FROM pgtradeuser t
LEFT JOIN pguser u
ON u.id = t.pguser_id
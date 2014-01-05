CREATE OR REPLACE VIEW
v_sumtienquy
AS 
SELECT
SUM(moneyin) moneyin,
SUM(moneyout) moneyout,
inout_id
FROM v_tienquy
GROUP BY inout_id
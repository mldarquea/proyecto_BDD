CREATE OR REPLACE FUNCTION
ocupacion_agrupado (t1 date, t2 date)
RETURNS TABLE (iid int, capacidad int, atraque timestamp) AS $$
BEGIN
RETURN QUERY EXECUTE 'SELECT muelles.iid, instalaciones.capacidad
		FROM muelles, para_m, permisos, instalaciones
		WHERE instalaciones.iid = muelles.iid and muelles.iid = para_m.iid and para_m.per_id = permisos.per_id and permisos.atraque >= $1 and permisos.atraque <= $2 GROUP BY muelles.iid'
	USING t1,t2;
	RETURN;
END
$$ language plpgsql
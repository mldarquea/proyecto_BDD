CREATE OR REPLACE FUNCTION
ocupacion_fechas (t1 date, t2 date)
RETURNS TABLE (muelle.iid int, muelle.capacidad int, permisos.atraque) AS $$
BEGIN
RETURN QUERY EXECUTE 'SELECT muelles.iid, muelles.capacidad, permisos.atraque
		FROM muelles, para_m, permisos
		WHERE muelles.iid = para_m.iid and para_m.per_id = permisos.per_id and permisos.atraque >= t1 and permisos.atraque <= t2'
	USING t1,t2;
	RETURN;
END
$$ language plpgsql
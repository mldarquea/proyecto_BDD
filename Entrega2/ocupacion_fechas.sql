CREATE OR REPLACE FUNCTION
ocupacion (t1 date, t2 date)
RETURNS TABLE (iid int, capacidad int, atraque timestamp) AS $$
DECLARE
	tupla RECORD;
	menor DATE;
	mayor DATE;

BEGIN
	CREATE TEMP TABLE fecha_ocupada(iid int, fecha date, cantidad int);

	FOR tupla in SELECT * FROM (SELECT permisos.per_id, astilleros.iid, instalaciones.capacidad, cast(permisos.atraque as date), cast(permisos_astilleros.salida as date) 
					FROM Permisos, Astilleros, Instalaciones, Para_a, Permisos_astilleros
					WHERE permisos.per_id = permisos_astilleros.per_id and permisos_astilleros.per_id = para_a.per_id and permisos.per_id = para_a.per_id and astilleros.iid = instalaciones.iid and astilleros.iid = para_a.iid and instalaciones.iid =para_a.iid
					and permisos.atraque  >= $1 and permisos_astilleros.salida  >= $1 and permisos.atraque <= $2  and permisos_astilleros.salida <= $2 ) AS Intervalo;

	LOOP
	menor := intervalo.atraque;
	mayor := intervalo.salida;
	while menor <= mayor: 
		INSERT INTO fecha_ocupada VALUES(tupla.iid,tupla.menor, 1);
		menor = DATEADD(day, 1, menor)
	END LOOP;

RETURN QUERY 
SELECT * FROM fecha_ocupada;
DROP TABLE fecha_ocupada;
END;
$$ language plpgsql;
CREATE OR REPLACE FUNCTION
ocupacion_fechas(t1 date, t2 date)
RETURNS TABLE (iid int, fecha date,cantidad int) AS $$
DECLARE
	tupla RECORD;
	menor DATE;
	mayor DATE;

BEGIN
	CREATE TEMP TABLE fecha_ocupada(iid int, fecha date, cantidad int);

	FOR tupla in SELECT * FROM (SELECT A.iid, A.capacidad, permisos.per_id,permisos.atraque,permisos_astilleros.salida
FROM para_a,permisos_astilleros,permisos,(SELECT instalaciones.iid, instalaciones.capacidad
FROM instalaciones, astilleros WHERE instalaciones.iid = astilleros.iid) as A
WHERE para_a.iid = A.iid and permisos_astilleros.per_id = para_a.per_id and permisos.per_id = permisos_astilleros.per_id) AS I
					WHERE I.atraque  >= $1 and I.salida <= $2 
	LOOP
	DECLARE @menor DATE = tupla.atraque;
	DECLARE @mayor DATE = tupla.salida;
	WHILE menor <= mayor
	BEGIN
		INSERT INTO fecha_ocupada VALUES(tupla.iid,tupla.atraque, 1);
		menor = DATEADD(day, 1, menor);
	END;
	END LOOP;

RETURN QUERY 
SELECT * FROM fecha_ocupada;
DROP TABLE fecha_ocupada;
END;
$$ language plpgsql;
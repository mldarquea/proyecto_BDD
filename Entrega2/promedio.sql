CREATE OR REPLACE FUNCTION
promedio(t1 date, t2 date, t3 varchar(50))
RETURNS TABLE (iid int, promedio NUMERIC) AS $$
DECLARE
	tupla RECORD;
	tupla2 RECORD;
	menor DATE;
	mayor DATE;

BEGIN
	CREATE TEMP TABLE fecha_o(iid int, capacidad int, fecha date, cantidad int);

	FOR tupla in SELECT * FROM (SELECT A.iid, A.capacidad, A.nombre, permisos.per_id,permisos.atraque,permisos_astilleros.salida
FROM para_a,permisos_astilleros,permisos,(SELECT instalaciones.iid, instalaciones.capacidad, puertos.nombre
FROM instalaciones, astilleros, pertenece, puertos WHERE puertos.pid = pertenece.pid and  pertenece.iid = instalaciones.iid and instalaciones.iid = astilleros.iid) as A
WHERE para_a.iid = A.iid and permisos_astilleros.per_id = para_a.per_id and permisos.per_id = permisos_astilleros.per_id) AS I
					WHERE I.atraque  >= $1 and I.salida <= $2 and I.nombre = $3
	LOOP
	menor  := tupla.atraque;
	mayor := tupla.salida;
	while menor <= mayor
	LOOP
	INSERT INTO fecha_o VALUES(tupla.iid, tupla.capacidad, menor, 1);
	menor = menor + 1;
	END LOOP;
	END LOOP;

	FOR tupla2 in SELECT * FROM (SELECT M.iid, M.capacidad, M.nombre, permisos.per_id,cast(permisos.atraque as date)
FROM para_m,permisos,(SELECT instalaciones.iid, instalaciones.capacidad, puertos.nombre
FROM instalaciones, muelles, pertenece, puertos WHERE  puertos.pid = pertenece.pid and  pertenece.iid = instalaciones.iid and instalaciones.iid = muelles.iid) as M
WHERE para_m.iid = M.iid  and permisos.per_id = para_m.per_id) AS Inter
					WHERE Inter.atraque  >= $1 and Inter.atraque <= $2 and Inter.nombre = $3
	LOOP
	INSERT INTO fecha_o VALUES(tupla2.iid,tupla2.capacidad, tupla2.atraque, 1);
	END LOOP;

RETURN QUERY 
SELECT prom.iid, AVG(prom.promedio) FROM
(SELECT T.iid, T.capacidad, T.fecha, ( T.suma * 100/T.capacidad ) AS Promedio FROM
(SELECT DISTINCT fecha_o.iid, fecha_o.capacidad, fecha_o.fecha, sum(fecha_o.cantidad) AS suma
FROM fecha_o
GROUP BY fecha_o.iid, fecha_o.capacidad, fecha_o.fecha) AS T
WHERE T.suma < T.capacidad) AS prom
GROUP BY prom.iid,  prom.promedio;
DROP TABLE fecha_o;
END;
$$ language plpgsql;

-- saca promedio entero solo de dias que entran a la consulta
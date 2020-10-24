CREATE OR REPLACE FUNCTION
as_capacidad(t1 date, t2 date, t3 varchar(50), t4 varchar(100)) ---- t3 puerto t4 patente
RETURNS TABLE (iid int, capacidad int, fecha date,cantidad bigint) AS $$
DECLARE
	tupla RECORD;
    tupla2 RECORD;
	menor DATE;
	mayor DATE;
    per_id int;

BEGIN
	CREATE TEMP TABLE a_o(iid int, capacidad int, fecha date, cantidad int);
    CREATE TEMP TABLE a_s(iid int);

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

------- Se muestran todas las instalaciones con capacidad y se registra un permiso para el primero disponible
    FOR tupla2 in (SELECT * FROM
(SELECT DISTINCT fecha_o.iid, fecha_o.capacidad, fecha_o.fecha, sum(fecha_o.cantidad) AS suma
FROM fecha_o
GROUP BY fecha_o.iid, fecha_o.capacidad, fecha_o.fecha) AS T
WHERE T.suma < T.capacidad
LIMIT 1);
    LOOP
    per_id := SELECT FLOOR(RAND()*(3000-900)+900);
    INSERT INTO sobre VALUES(per_id,$4);
    INSERT INTO permisos VALUES(per_id,$1);
    INSERT INTO permisos_astilleros VALUES(per_id,$2);
    INSERT INTO para_a VALUES(per_id,tupla2.iid);
    END LOOP;

RETURN QUERY 
SELECT * FROM
(SELECT DISTINCT fecha_o.iid, fecha_o.capacidad, fecha_o.fecha, sum(fecha_o.cantidad) AS suma
FROM fecha_o
GROUP BY fecha_o.iid, fecha_o.capacidad, fecha_o.fecha) AS T
WHERE T.suma < T.capacidad;
DROP TABLE fecha_o;
END;
$$ language plpgsql;
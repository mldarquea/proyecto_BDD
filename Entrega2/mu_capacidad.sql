CREATE OR REPLACE FUNCTION
mu_capacidad(t1 date, t2 varchar(50), t3 varchar(100)) ---- t2 puerto t3 patente
RETURNS TABLE (iid int, capacidad int, fecha date,cantidad bigint) AS $$
DECLARE
	tupla RECORD;
    tupla2 RECORD;
    tupla_random RECORD;
    per_id int;

BEGIN
	CREATE TEMP TABLE m_o(iid int, capacidad int, fecha date, cantidad int);
    CREATE TEMP TABLE m_s(iid int);

	FOR tupla in SELECT * FROM (SELECT M.iid, M.capacidad, M.nombre, permisos.per_id,cast(permisos.atraque as date)
FROM para_m,permisos,(SELECT instalaciones.iid, instalaciones.capacidad, puertos.nombre
FROM instalaciones, muelles, pertenece, puertos WHERE  puertos.pid = pertenece.pid and  pertenece.iid = instalaciones.iid and instalaciones.iid = muelles.iid) as M
WHERE para_m.iid = M.iid  and permisos.per_id = para_m.per_id) AS Inter
					WHERE Inter.atraque  >= $1 and Inter.atraque <= $1 and Inter.nombre = $2
	LOOP
	INSERT INTO m_o VALUES(tupla2.iid,tupla2.capacidad, tupla2.atraque, 1);
	END LOOP;

    FOR tupla_random in SELECT (FLOOR((RANDOM()*(900)+1000))) as cualquier
    LOOP
    per_id := tupla_random.cualquier;
    END LOOP;
    
------- Se muestran todas las instalaciones con capacidad y se registra un permiso para el primero disponible
    FOR tupla2 in (SELECT * FROM
(SELECT DISTINCT m_o.iid, m_o.capacidad, m_o.fecha, sum(m_o.cantidad) AS suma
FROM m_o
GROUP BY m_o.iid, m_o.capacidad, m_o.fecha) AS T
WHERE T.suma < T.capacidad
LIMIT 1)
    LOOP
    INSERT INTO sobre VALUES(per_id,$3);
    INSERT INTO permisos VALUES(per_id,$1);
    INSERT INTO para_m VALUES(per_id,tupla2.iid);
    END LOOP;

RETURN QUERY 
SELECT * FROM
(SELECT DISTINCT m_o.iid, m_o.capacidad, m_o.fecha, sum(m_o.cantidad) AS suma
FROM m_o
GROUP BY m_o.iid, m_o.capacidad, m_o.fecha) AS T
WHERE T.suma < T.capacidad;
DROP TABLE m_o;
DROP TABLE m_s;
END;
$$ language plpgsql;
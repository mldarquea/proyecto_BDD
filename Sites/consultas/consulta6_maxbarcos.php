<!-- # 6. Muestre el puerto que ha recibido más barcos en Agosto del 2020. -->

<?php include('../templates/header.html');   ?>

<body>
  <body background="mar.jpg">
  <?php
  require("../config/conexion.php"); #Llama a conexión, crea el objeto PDO y obtiene la variable $db

  #$var = $_POST["realizar_consulta"];
  $query = "SELECT MAX(parte3.count) FROM (SELECT parte2.nombre, COUNT (*) FROM 
  (SELECT parte1.iid, parte1.patente, puertos.nombre, parte1.atraque 
  FROM pertenece, puertos, 
  (SELECT upam.iid, barcos.patente, barcos.pais, permisos.per_id, permisos.atraque
  FROM barcos, sobre, permisos, instalaciones,
  (SELECT * FROM para_a UNION SELECT ALL * FROM para_m) 
  AS upam WHERE barcos.patente = sobre.patente and sobre.per_id = permisos.per_id
  and upam.iid = instalaciones.iid and permisos.per_id = upam.per_id 
  and permisos.atraque >= '2020-08-01' and permisos.atraque <= '2020-08-31') AS parte1 
  WHERE parte1.iid = pertenece.iid and pertenece.pid = puertos.pid) AS parte2 GROUP BY parte2.nombre) 
  AS parte3;"; 

  $result = $db -> prepare($query);
  $result -> execute();
  $dataCollected = $result -> fetchAll(); #Obtiene todos los resultados de la consulta en forma de un arreglo
  ?>

  <table>
    <tr>
      <th>Maximo</th>
    </tr>
  <?php

  foreach ($dataCollected as $p) {
    echo "<tr> <td>$p[0]</td> </tr>";
  }
  ?>
  </table>

<?php include('../templates/footer.html'); ?>
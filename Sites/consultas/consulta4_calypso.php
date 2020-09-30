<!-- #4. Muestre todas las veces en que el barco `Calypso' ha atracado en `Arica'. -->

<?php include('../templates/header.html');   ?>

<body>
  <body background="mar.jpg">
  <?php
  require("../config/conexion.php"); #Llama a conexión, crea el objeto PDO y obtiene la variable $db

  #$var = $_POST["realizar_consulta"];
  $query = "SELECT parte1.iid, parte1.patente, parte1.nombre, ubicacion.ciudad, puertos.nombre, parte1.atraque 
  FROM pertenece, puertos, esta, ubicacion, 
  (SELECT upam.iid, barcos.patente, barcos.nombre, barcos.pais, permisos.per_id, permisos.atraque
  FROM barcos, sobre, permisos, instalaciones,
  (SELECT * FROM para_a UNION SELECT ALL * FROM para_m) 
  AS upam WHERE barcos.patente = sobre.patente
  and barcos.nombre = 'Calypso' and sobre.per_id = permisos.per_id
  and upam.iid = instalaciones.iid and permisos.per_id = upam.per_id) AS parte1 
  WHERE parte1.iid = pertenece.iid and pertenece.pid = puertos.pid and puertos.pid = esta.pid
  and esta.ciudad = ubicacion.ciudad and ubicacion.ciudad = 'Arica';"; 

  $result = $db -> prepare($query);
  $result -> execute();
  $dataCollected = $result -> fetchAll(); #Obtiene todos los resultados de la consulta en forma de un arreglo
  ?>

  <table>
    <tr>
      <th>Nombre Barco</th>
      <th>Ciudad</th>
      <th>Número de atraques</th>
    </tr>
  <?php

  foreach ($dataCollected as $p) {
    echo "<tr> <td>$p[2]</td> <td>$p[3]</td> <td>$p[5]</td> </tr>";
  }
  ?>
  </table>

<?php include('../templates/footer.html'); ?>
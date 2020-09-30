<!-- # 6. Muestre el puerto que ha recibido más barcos en Agosto del 2020. -->

<?php include('../templates/header.html');   ?>

<body>
  <body background="mar.jpg">
  <?php
  require("../config/conexion.php"); #Llama a conexión, crea el objeto PDO y obtiene la variable $db

  #$var = $_POST["realizar_consulta"];
  $query = "SELECT * FROM (SELECT  puertos.nombre, COUNT(puertos.pid) as conteo
  FROM Puertos, Pertenece, (SELECT fechaOK.per_id, instalaciones.iid, fechaOK.atraque 
  FROM Instalaciones, (SELECT * FROM para_a UNION SELECT ALL * FROM para_m) AS upam,
  (SELECT * FROM Permisos WHERE permisos.atraque >= '2020-08-01' and permisos.atraque <= '2020-08-31') as fechaOK
  WHERE upam.per_id = fechaOK.per_id and upam.iid=instalaciones.iid) as perOK
  WHERE perOK.iid = pertenece.iid and puertos.pid = pertenece.pid
  GROUP BY puertos.nombre) as contador
  LIMIT 1;"; 

  $result = $db -> prepare($query);
  $result -> execute();
  $dataCollected = $result -> fetchAll(); #Obtiene todos los resultados de la consulta en forma de un arreglo
  ?>

  <table>
    <tr>
      <th>Nombre Puerto</th>
      <th>Cantidad de Barcos</th>
    </tr>
  <?php

  foreach ($dataCollected as $p) {
    echo "<tr> <td>$p[0]</td> <td>$p[1]</td> </tr>";
  }
  ?>
  </table>

<?php include('../templates/footer.html'); ?>
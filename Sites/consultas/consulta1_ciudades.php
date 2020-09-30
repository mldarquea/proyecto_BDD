<!-- 1. Muestre todos los puertos junto la ciudad a la que son asignados. -->

<?php include('../templates/header.html');   ?>

<body>
  <body background="mar.jpg">
  <?php
  require("../config/conexion.php"); #Llama a conexión, crea el objeto PDO y obtiene la variable $db

  $var = $_POST["nombre_puerto"];
  $query = "SELECT puertos.pid, puertos.nombre, esta.ciudad FROM puertos 
  INNER JOIN esta ON puertos.pid = esta.pid 
  WHERE UPPER(puertos.nombre) = UPPER('$var');";

  $result = $db -> prepare($query);
  $result -> execute();
  $dataCollected = $result -> fetchAll(); #Obtiene todos los resultados de la consulta en forma de un arreglo
  ?>

  <table>
    <tr>
      <th>pid</th>
      <th>Nombre</th>
      <th>Ciudad</th>
    </tr>
  <?php

  foreach ($dataCollected as $p) {
    echo "<tr> <td>$p[0]</td> <td>$p[1]</td> <td>$p[2]</td> </tr>";
  }
  ?>
  </table>

<?php include('../templates/footer.html'); ?>

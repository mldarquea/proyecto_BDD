<!-- # 3. Muestre todos los puertos que tienen al menos un astillero. -->

<?php include('../templates/header.html');   ?>

<body>
  <body background="mar.jpg">
  <?php
  
  require("../config/conexion.php"); #Llama a conexión, crea el objeto PDO y obtiene la variable $db

  #$var = $_POST["realizar_consulta"];
  $query = "SELECT DISTINCT Puertos.pid, Puertos.nombre
  FROM Astilleros, Pertenece, Puertos
  WHERE Astilleros.iid = pertenece.iid and puertos.pid = pertenece.pid;;"; 

  $result = $db -> prepare($query);
  $result -> execute();
  $dataCollected = $result -> fetchAll(); #Obtiene todos los resultados de la consulta en forma de un arreglo
  ?>

  <table>
    <tr>
      <th>pid</th>
      <th>Nombre</th>
    </tr>
  <?php

  foreach ($dataCollected as $p) {
    echo "<tr> <td>$p[0]</td> <td>$p[1]</td> </tr>";
  }
  ?>
  </table>

<?php include('../templates/footer.html'); ?>

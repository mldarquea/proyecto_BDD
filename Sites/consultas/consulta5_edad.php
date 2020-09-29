<!-- # 5. Muestre la edad promedio de los trabajadores de cada puerto. -->

<?php include('../templates/header.html');   ?>

<body>

  <?php
  require("../config/conexion.php"); #Llama a conexión, crea el objeto PDO y obtiene la variable $db

  #$var = $_POST["realizar_consulta"];
  $query = "SELECT ppi.nombre, AVG(personal.edad)
  FROM trabaja, personal,(SELECT instalaciones.iid, puertos.nombre
  FROM puertos, pertenece, instalaciones
  WHERE puertos.pid = pertenece.pid and 
  instalaciones.iid = pertenece.iid) AS ppi
  WHERE trabaja.rut = personal.rut and trabaja.iid = ppi.iid 
  GROUP BY ppi.nombre;"; 

  $result = $db -> prepare($query);
  $result -> execute();
  $dataCollected = $result -> fetchAll(); #Obtiene todos los resultados de la consulta en forma de un arreglo
  ?>

  <table>
    <tr>
      <th>Nombre</th>
      <th>Promedio</th>
    </tr>
  <?php

  foreach ($dataCollected as $p) {
    echo "<tr> <td>$p[0]</td> <td>$p[1]</td> </tr>";
  }
  ?>
  </table>

<?php include('../templates/footer.html'); ?>
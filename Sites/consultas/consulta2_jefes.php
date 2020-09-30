<!-- 
#2. Muestre todos los jefes de las instalaciones del puerto con nombre `Mejillones'. -->

<!-- SELECT *
FROM jefe, personal,(SELECT instalaciones.iid, puertos.nombre
FROM puertos, pertenece, instalaciones
WHERE puertos.pid = pertenece.pid and 
instalaciones.iid = pertenece.iid and puertos.nombre = 'Mejillones') AS ppi
WHERE jefe.rut = personal.rut and jefe.iid = ppi.iid; -->


<?php include('../templates/header.html');   ?>

<body>
  <body background="mar.jpg">

  <?php
  require("../config/conexion.php"); #Llama a conexión, crea el objeto PDO y obtiene la variable $db

  $var1 = $_POST["nombre_puerto"];
  $query = "SELECT personal.rut, personal.nombre, personal.edad, personal.sexo FROM jefe, personal,
  (SELECT instalaciones.iid, puertos.nombre
  FROM puertos, pertenece, instalaciones
  WHERE puertos.pid = pertenece.pid 
  and instalaciones.iid = pertenece.iid and puertos.nombre = '%$var1%') AS ppi
  WHERE jefe.rut = personal.rut and jefe.iid = ppi.iid;";

  $result = $db -> prepare($query);
  $result -> execute();
  $dataCollected = $result -> fetchAll(); #Obtiene todos los resultados de la consulta en forma de un arreglo
  ?>

  <table>
    <tr>
      <th>rut</th>
      <th>Nombre</th>
      <th>Edad</th>
      <th>Sexo</th>
    </tr>
  <?php

  foreach ($dataCollected as $p) {
    echo "<tr> <td>$p[0]</td> <td>$p[1]</td> <td>$p[2]</td> <td>$p[3]</td> </tr>";
  }
  ?>
  </table>

<?php include('../templates/footer.html'); ?>

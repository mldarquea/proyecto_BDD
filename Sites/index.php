<?php include('templates/header.html');   ?>

<body>
  <h1 align="center">Biblioteca Puertos </h1>
  <p style="text-align:center;">Aquí podrás encontrar información sobre los distintos Puertos, Astilleros y Gerencias.</p>
  <img src="barco.png" alt="barco" width="500" height="500">
  <body background="mar.jpg">
  <br>

<!-- 1. Muestre todos los puertos junto la ciudad a la que son asignados. -->

  <h3 align="center"> ¿Quieres buscar la ciudad de un puerto? </h3>

  <form align="center" action="consultas/consulta1_ciudades.php" method="post">
    Puerto:
    <input type="text" name="nombre_puerto">
    <br/><br/>
    <input type="submit" value="Buscar">
  </form>
  
  <br>
  <br>
  <br>

<!-- 
#2. Muestre todos los jefes de las instalaciones del puerto con nombre `Mejillones'. -->
  <h3 align="center"> ¿Quieres buscar los jefes de las instalaciones de algún puerto en particular?</h3>

  <form align="center" action="consultas/consulta2_jefes.php" method="post">
    Puerto:
    <input type="text" name="nombre_puerto">
    <br/><br/>
    <input type="submit" value="Buscar">
  </form>
  
  <br>
  <br>
  <br>

<!-- # 3. Muestre todos los puertos que tienen al menos un astillero. -->
  <h3 align="center"> ¿Quieres saber todos los puertos que tienen al menos un astillero? </h3>
  <form align="center" action="consultas/consulta3_puertos.php" method="post">
    <!-- Escribe sí:
    <input type="text" name="realizar_consulta"> -->
    <br/><br/>
    <input type="submit" value="Buscar">
  </form>

  <br>
  <br>
  <br>

<!-- #4. Muestre todas las veces en que el barco `Calypso' ha atracado en `Arica'. -->
  <!-- <h3 align="center">¿Quieres saber cuantas veces el barco "Calypso" ha atracado en "Arica"?</h3>

  <br>
  <br>
  <br>
  <br> -->

<!-- 
 # 5. Muestre la edad promedio de los trabajadores de cada puerto. -->
  <h3 align="center">¿Quieres saber la edad promedio de los trabajadores de algún puerto?</h3>
  <form align="center" action="consultas/consulta5_edad.php" method="post">
    <!-- Escribe sí:
    <input type="text" name="realizar_consulta"> -->
    <br/><br/>
    <input type="submit" value="Buscar">
  </form>
  <br>
  <br>
  <br>
  <br>

</body>
</html>

 <!-- # 6. Muestre el puerto que ha recibido más barcos en Agosto del 2020.
 <!-- <h3 align="center">¿Quieres saber el puerto que ha recibido más barcos en Agosto del 2020?</h3>

  <br>
  <br>
  <br>
  <br>

</body>
</html>-->

<img src="puerto.jpg" alt="barco" width="920" height="512">

<!-- 1. Muestre todos los puertos junto la ciudad a la que son asignados.
2. Muestre todos los jefes de las instalaciones del puerto con nombre `Mejillones'.
3. Muestre todos los puertos que tienen al menos un astillero.
4. Muestre todas las veces en que el barco `Calypso' ha atracado en `Arica'.
5. Muestre la edad promedio de los trabajadores de cada puerto.
6. Muestre el puerto que ha recibido mas barcos en Agosto del 2020. -->
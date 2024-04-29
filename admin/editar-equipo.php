<?php
session_start();
include "../archivos/conexion.php";
if (empty($_SESSION["admin"])) {
    header("location: ../index.php"); 
    exit;  
}

if(isset($_GET['id_equipo'])){
  $id_equipo = $_GET['id_equipo'];

  $sql = "SELECT * FROM equipos WHERE id_equipo = $id_equipo";
  $result = $conn->query($sql);
  $equipo = $result->fetch_assoc();

} else {header("Location: ../equipos.php");
}

?>
<!DOCTYPE html>
<html lang="es">
  <head>
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href= "css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/png" href="https://www.technovation.org/wp-content/themes/technovation_1.0.6_HC/favicon.png?v=1.0"/>
    <title>Administración | Equipos</title>
    <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
  
    <style>

    .texto-margen-izquierdo {
      margin-left: 40px;
    }

    .texto-label {
      margin-left: 10px;
      margin-top: 10px;
      margin-bottom: 5px;
    }

    .contenedor {
        width: 100%;
        height: 100%;
      }
  </style>
  
  </head>
  <body>
    <form id="formEditarEquipo" method="POST">
      <label for="id_equipo" style="margin-left: 10px;">ID Equipo</label>
      <input type="number" name="id_equipo" id="id_equipo" class="form-control" value="<?= $equipo['id_equipo']?>" readonly>
      <label for="nombre" class="texto-label">Nombre Equipo</label>
      <input type="text" name="nombre" id="nombre" class="form-control" value="<?= $equipo['nombre_equipo']?>">
      <label for="creador" class="texto-label">Creador Equipo</label>
      <input type="text" name="creador" id="creador" class="form-control" value="<?= $equipo['creador_equipo']?>">
      <label for="mentor" class="texto-label">Mentor Equipo</label>
      <input type="text" name="mentor" id="mentor" class="form-control" value="<?= $equipo['mentor_equipo']?>">
    </form>
</body>
</html>
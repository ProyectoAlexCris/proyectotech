<?php
session_start();
include "../archivos/conexion.php";
include "scripts/informacion-categorias-senior.php";

if (empty($_SESSION["nombre"]) || empty($_SESSION["id_usuario"])) {
    header("location: index.php");   
} else {
  $nombre = $_SESSION['nombre'];
  $id_usuario = $_SESSION['id_usuario'];
}

if (isset($_GET['id_equipo'])) {
    $id_equipo = $_GET['id_equipo'];
}

$sql_nombre = "SELECT nombre_equipo FROM equipos WHERE id_equipo = $id_equipo";
$resultado_nombre = $conn->query($sql_nombre);
if($resultado_nombre->num_rows > 0) {
    $equipo = $resultado_nombre->fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="es">
  <head>
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href= "../css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/png" href="https://www.technovation.org/wp-content/themes/technovation_1.0.6_HC/favicon.png?v=1.0"/>
    <title>Perfil juez | Evaluaciones</title>
    <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
  
    <style>

    .texto-margen-izquierdo {
      margin-left: 40px;
    }

    .contenedor {
        width: 100%;
        height: 100%;
      }

      .container {
        margin: 0 auto; /* Centra el contenedor horizontalmente */
        max-width: 1000px; /* Ancho máximo del contenedor */
    }

    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* color semitransparente */
    }

       html {
    position: relative;
    min-height: 100%;
    }

    body {
    margin-bottom: 140px; /* Ajusta este valor según la altura de tu footer */
    }

    footer {
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 120px; /* Ajusta la altura de tu footer según lo necesites */
    background-color: #343a40; /* Color de fondo del footer */
    color: white; /* Color del texto del footer */
    }

     .navbar-nav .nav-link {
    font-size: 18px; 
    }

    table {
        border-collapse: collapse;
        border-right: 2px solid  #87CEFA; /* Añade un borde a la derecha de la tabla */
        width: 100%;
    }

    th, td {
        border-right: 2px solid #87CEFA; /* Bordes a la derecha de todas las celdas */
        border-bottom: 2px solid #87CEFA;
        padding: 8px;
    }

    th.titulo {
        color: white; /* Texto blanco */
        font-weight: bold; /* Texto en negrita */
    }

    td.descripcion {
        width: 90%; /* Ancho de la columna de descripción */
    }

    td.puntuacion {
        width: 10%; /* Ancho de la columna de puntuación */
    }

    th.titulo:first-child, td.descripcion:first-child {
        border-left: none; /* Quitar el borde izquierdo de la primera celda en el encabezado y en el cuerpo de la tabla */
    }
    th, td:last-child {
        border-right: none; /* Quitar el borde derecho de la última celda en todas las filas */
    }

    input.centrado {
        border: none; /* Quitar el borde del input */
        background: none; /* Quitar el fondo del input */
        text-align: center; /* Centrar el texto dentro del input */
        width: 100%; /* Ajustar el ancho del input al 100% de la celda */
    }
  </style>
  
  </head>
  <body>
    <div class="contenedor" id="contenedorFormularioSenior">
     <div id="content" class="text-center mt-4">
        <p style="font-size: 18px;"><b>Evaluación División Senior</b> temporada 2023 - 2024</p>
        <p><b>Guía de puntuación para la asignación de puntos por ítem:</b></p>
        <p><b>1</b> - Insuficiente <span style="margin-left: 30px;"><b>2</b> - Mejorable </span> <span style="margin-left: 30px;"><b>3</b> - Bueno</span><span style="margin-left: 30px;"><b>4</b> - Media</span><span style="margin-left: 30px;"><b>5</b> - Asombroso</span></p>
        <p class="mt-2" style="font-size: 22px;">Equipo: <strong><?=$equipo['nombre_equipo']?></strong></p>
    </div>

  <div>
    <form id="formPuntuaciones">

    <div class="container mt-2">
        <table>
            <thead>
                <tr>
                    <th colspan="3" class="titulo" style="background-color: blue;"><?=$categorias_nombre[0]; ?></th>
                </tr>
            </thead>
            <tbody>
              <?php
                 while ($descripcion_item1 = $items_categoria1->fetch_assoc()):
                 ?>
                <tr>
                    <td class="descripcion" colspan="2" style="text-align: right;"><?= $descripcion_item1['descripcion']; ?></td>
                    <td class="puntuacion"><input type="text" class="centrado item-puntuacion" data-categoria="categoria1" id="<?= $descripcion_item1['id_item']; ?>"></td>
                </tr>
                <?php endwhile ?>
                <tr>
                    <td class="descripcion" colspan="2" style="text-align: right;"><b>Descripción del proyecto</b></td>
                    <td class="puntuacion"><input type="text" class="centrado puntuacion-automatica" data-categoria="categoria1" readonly></td>
                </tr>
            </tbody>
        </table>
    </div>

        <div class="container mt-5">
        <table>
            <thead>
                <tr>
                    <th colspan="3" class="titulo" style="background-color: deeppink;"><?=$categorias_nombre[1]; ?></th>
                </tr>
            </thead>
            <tbody>
                 <?php
                 while ($descripcion_item2 = $items_categoria2->fetch_assoc()):
                 ?>
                <tr>
                    <td class="descripcion" colspan="2"><?= $descripcion_item2['descripcion']; ?></td>
                    <td class="puntuacion"><input type="text" class="centrado item-puntuacion" data-categoria="categoria2"  id="<?= $descripcion_item2['id_item']; ?>"></td>
                </tr>
                <?php endwhile ?>
                <tr>
                    <td class="descripcion" colspan="2" style="text-align: right;"><b>Puntuación total del vídeo de lanzamiento</b></td>
                    <td class="puntuacion"><input type="text" class="centrado puntuacion-automatica" data-categoria="categoria2" readonly></td>
                </tr>
            </tbody>
        </table>
    </div>

<div class="container mt-5">
    <p style="margin-bottom: 0px;"><b>Puntuación para 1 de las siguientes categorías de vídeo técnico: Aplicación móvil o Prototipo de IA</b></p>
    <table>
        <thead>
            <tr>
                <th colspan="3" class="titulo" style="background-color: forestgreen;"><?=$categorias_nombre[2]; ?></th>
            </tr>
            <tr>
                <th colspan="3" class="titulo" style="background-color: lightgreen; color: black; font-weight: normal;"><b>Opción 1:</b> Entrega de aplicaciones móviles, solo calificación de vídeo técnico</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            while ($descripcion_item3 = $items_categoria3->fetch_assoc()):
                $i++;
                ?>
                <tr>
                    <td class="descripcion" colspan="2"><?= $descripcion_item3['descripcion']; ?></td>
                    <td class="puntuacion">
                        <input type="text" class="centrado especial item-puntuacion" data-categoria="categoria3" id="<?= $descripcion_item3['id_item']; ?>" data-especial="true">
                    </td>
                </tr>
                <?php if ($i == 4): ?>
                <tr>
                    <td colspan="3" class="descripcion" style="background-color: lightgreen; color: black;"><b>Opción 2:</b> Entrega del prototipo de IA, solo calificación del vídeo técnico</td>
                </tr>
                <?php endif; ?>
            <?php endwhile ?>
            <tr>
                <td class="descripcion" colspan="2" style="text-align: right;"><b>Puntuación total del vídeo técnico</b></td>
                <td class="puntuacion"><input type="text" class="centrado puntuacion-automatica" data-categoria="categoria3" readonly></td>
            </tr>
        </tbody>
    </table>
</div>

       <div class="container mt-5">
        <table>
            <thead>
                <tr>
                    <th colspan="3" class="titulo" style="background-color: deeppink;"><?=$categorias_nombre[3]; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                 while ($descripcion_item4 = $items_categoria4->fetch_assoc()):
                 ?>
                <tr>
                    <td class="descripcion" colspan="2"><?= $descripcion_item4['descripcion']; ?></td>
                    <td class="puntuacion"><input type="text" class="centrado item-puntuacion" data-categoria="categoria4" id="<?= $descripcion_item4['id_item']; ?>"></td>
                </tr>
                 <?php endwhile ?>
                <tr>
                    <td class="descripcion" colspan="2" style="text-align: right;"><b>Puntuación total del plan de negocios</b></td>
                    <td class="puntuacion"><input type="text" class="centrado puntuacion-automatica" data-categoria="categoria4" readonly></td>
                </tr>
            </tbody>
        </table>
    </div>

      <div class="container mt-5">
        <table>
            <thead>
                <tr>

                    <th colspan="3" class="titulo" style="background-color: darkorange;"><?=$categorias_nombre[4]; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                 while ($descripcion_item5 = $items_categoria5->fetch_assoc()):
                 ?>
                <tr>
                    <td class="descripcion" colspan="2"><?= $descripcion_item5['descripcion']; ?></td>
                    <td class="puntuacion"><input type="text" class="centrado item-puntuacion" data-categoria="categoria5" id="<?= $descripcion_item5['id_item']; ?>"></td>
                </tr>
                 <?php endwhile ?>
                <tr>
                    <td class="descripcion" colspan="2" style="text-align: right;"><b>Puntuación total de la ruta de aprendizaje</b></td>
                    <td class="puntuacion"><input type="text" class="centrado puntuacion-automatica" data-categoria="categoria5" readonly></td>
                </tr>
            </tbody>
        </table>
    </div>

      <div class="container mt-5" style="max-width: 700px;">
        <table>
            <thead>
                <tr>

                    <th colspan="2" class="titulo" style="background-color: darkblue;">Puntuación total</th>
                    <th colspan="1" class="titulo text-center" style="background-color: darkblue;">Puntuación</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="descripcion" colspan="2" style="width: 70%">Puntuación total de la Descripción del Proyecto</td>
                    <td class="puntuacion" style="width: 30%"><input type="text" class="centrado puntuacion-automatica" data-categoria="categoria1" id="totalCategoria1" readonly></td>
                </tr>
                <tr>
                    <td class="descripcion" colspan="2" style="width: 70%">Puntuación total del vídeo de lanzamiento</td>
                    <td class="puntuacion" style="width: 30%"><input type="text" class="centrado puntuacion-automatica" data-categoria="categoria2" id="totalCategoria2" readonly></td>
                </tr>
                <tr>
                    <td class="descripcion" colspan="2" style="width: 70%">Puntuación total del vídeo técnico</td>
                    <td class="puntuacion" style="width: 30%"><input type="text" class="centrado puntuacion-automatica" data-categoria="categoria3" id="totalCategoria3" readonly></td>
                </tr>
                <tr>
                    <td class="descripcion" colspan="2" style="width: 70%">Puntuación total del plan de negocios</td>
                    <td class="puntuacion" style="width: 30%"><input type="text" class="centrado puntuacion-automatica" data-categoria="categoria4" id="totalCategoria4" readonly></td>
                </tr>
                <tr>
                    <td class="descripcion" colspan="2" style="width: 70%">Puntuación total del camino de aprendizaje</td>
                    <td class="puntuacion" style="width: 30%"><input type="text" class="centrado puntuacion-automatica" data-categoria="categoria5" id="totalCategoria5" readonly></td>
                </tr>
                <tr>
                    <td class="descripcion" colspan="2" style="text-align: right;"><b>Puntuación total</b></td>
                    <td class="puntuacion"><input type="text" class="centrado puntuacion-automatica general" id="totalGeneral"  readonly></td>
                </tr>
            </tbody>
        </table>
          <div class="text-center mt-5">
            <button class="btn btn-secondary py-3 px-3" id="btnGuardar" data-equipo="<?=$id_equipo?>">Guardar</button>
            <button class="btn btn-primary py-3 px-3" id="btnEnviar" data-equipo="<?=$id_equipo?>" style="margin-left: 50px;">Enviar</button>
          </div>
    </div>
  </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<footer class="footer bg-dark text-white py-4">
  <div class="container">
    <div class="row">
      <div class="text-center">
        <ul class="list-inline">
          <li class="list-inline-item"><a href="#"><i class="bi bi-facebook text-white"></i></a></li>
          <li class="list-inline-item"><a href="#"><i class="bi bi-twitter text-white"></i></a></li>
          <li class="list-inline-item"><a href="#"><i class="bi bi-instagram text-white"></i></a></li>
          <li class="list-inline-item"><a href="#"><i class="bi bi-linkedin text-white"></i></a></li>
        </ul>
      </div>
      <div class="text-center">
        <p class="text-sm text-center">© 2024 Technovation. Todos los derechos reservados.</p>
      </div>
    </div>
  </div>
</footer>

<script>
$(document).ready(function(){
    window.onpopstate = function(event){
          $("#contenedorFormularioJunior").load("evaluaciones.php");
     };
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</div>
</body>
</html>
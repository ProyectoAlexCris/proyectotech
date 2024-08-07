<?php
require_once("conexion.php");

// Comprobar parámetros
if (isset($_POST['id_equipo']) && isset($_POST['id_participante'])) {

	$id_equipo = $_POST['id_equipo'];
	$id_participante = $_POST['id_participante'];
    
    // Comprobar si existe algún registro para equipo y participante, para no duplicar solicitudes
	$sql_comprobar = "SELECT COUNT(*) AS count FROM solicitudes_equipo WHERE id_equipo = $id_equipo AND id_participante = $id_participante";
	$resultado_comprobar = $conn->query($sql_comprobar);
	$row = $resultado_comprobar->fetch_assoc();

	if ($row['count'] > 0) {
		echo "haySolicitudes";
	} else {
		// Registrar solicitud del participante para unirse al equipo
		$sql_insertSolicitar = "INSERT solicitudes_equipo (id_participante, id_equipo) VALUES ($id_participante, $id_equipo)";
	    $resultado_insert = $conn->query($sql_insertSolicitar);

		if ($resultado_insert == true) {
			echo "solicitudEnviada";
		} else {
			echo "errorSolicitud";
		}
  }
} else {
	echo "errorVariables";
}
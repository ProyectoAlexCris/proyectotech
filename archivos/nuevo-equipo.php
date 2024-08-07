<?php
session_start();

// Comprobar que se reciben correctamente los parámetros necesarios
if (empty($_POST['nombreEquipo']) || empty($_POST['id_mentor'])) {
    echo "rellenaCampos";
} else {
    $nombre_equipo = $_POST['nombreEquipo'];
    $id_mentor = $_POST['id_mentor'];
    $division = $_POST['division'];
    
    // Obtener id de usuario a partir de variable de sesión
    if(isset($_SESSION['id_usuario'])) {
        $id_usuario = $_SESSION['id_usuario'];
        require_once "conexion.php";

        $nombre_equipo = mysqli_real_escape_string($conn, $nombre_equipo);
        $id_usuario = mysqli_real_escape_string($conn, $id_usuario);
        $id_mentor = mysqli_real_escape_string($conn, $id_mentor);
        
        // Recuperar id de participante asociado al usuario
        $sql_participante = "SELECT id_participante FROM participantes WHERE id_usuario = $id_usuario";
        $resultado_participante = $conn->query($sql_participante);

        if ($resultado_participante && $resultado_participante->num_rows > 0) {
            $id_participante = $resultado_participante->fetch_assoc()['id_participante'];
            
            // Registrar nuevo equipo
            $sql = "INSERT INTO equipos (nombre_equipo, id_creador, id_mentor, division) VALUES ('$nombre_equipo', '$id_usuario', '$id_mentor', '$division')";

            if ($conn->query($sql) === TRUE) {
                $id_equipo = $conn->insert_id;
                
                // Registrar al usuario como participante del equipo creado
                $sql_insertParticipante = "INSERT INTO solicitudes_equipo (id_participante, id_equipo) VALUES ($id_participante, $id_equipo)";
                
                if ($conn->query($sql_insertParticipante) === TRUE) {
                    echo "solicitudEnviada"; // El equipo se registra como 'pendiente' y esto genera una alerta al mentor seleccionado
                } else {
                    echo "Error al enviar la solicitud: " . $conn->error;
                }
            } else {
                echo "Error al crear el equipo: " . $conn->error;
            }
        } else {
            echo "No se pudo obtener el id_participante";
        }

        $conn->close();
    } else {
        echo "errorSesion";
    }   
}



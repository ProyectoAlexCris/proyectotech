<?php

if (empty($_POST['nombre']) || 
    empty($_POST['apellidos']) || 
    empty($_POST['fecha']) || 
    empty($_POST['email']) || 
    empty($_POST['contraseña']) || 
    empty($_POST['repiteContraseña']) || 
    empty($_POST['cargo'])) {
    echo "rellenaCampos";
    } else {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $fecha = $_POST['fecha'];
        $email = $_POST['email'];
        $contraseña = $_POST['contraseña'];
        $repiteContraseña = $_POST['repiteContraseña'];
        $cargo = $_POST['cargo'];  

        include "conexion.php";

        $sql = "SELECT * FROM registro WHERE email='".$email."'";
        $resultado= $conn->query($sql);

            if ($resultado->num_rows > 0){
                echo "emailYaRegistrado";
            } else if ($contraseña !== $repiteContraseña){
                echo "errorContraseña";

            } else {
                   $insertar = "INSERT INTO registro (nombre, apellidos, fecha, email, contraseña, cargo) VALUES ('$nombre', '$apellidos', '$fecha', '$email', '$contraseña', '$cargo')";

                    if ($conn -> query($insertar) == true) {
                        $id_usuario = $conn->insert_id;

                        if ($cargo == "Mentor") {
                            $insertarMentor = "INSERT INTO mentores (id_usuario) VALUES ('$id_usuario')";
                            $conn->query($insertarMentor);
                        } else if ($cargo == "Participante") {
                            $insertarParticipante = "INSERT INTO participantes (id_usuario) VALUES ('$id_usuario')";
                            $conn->query($insertarParticipante);
                        } else if ($cargo == "Juez") {
                            $insertarJuez = "INSERT INTO jueces (id_usuario) VALUES ('$id_usuario')";
                            $conn->query($insertarJuez);
                        }

                        echo "registroCorrecto";
                    } else {
                        echo "error";
                }  
            }
        
        $conn -> close();
    }
?>
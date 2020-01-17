<?php 

function conectarBD() {
	$servername = "localhost";
	$username = "root";
	$password = "rootroot";
	$dbname = "empleados08";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	return $conn;
}

function limpiar_campos($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Definicion funcion error_function
function errores ($error_level,$error_message,$error_file, $error_line, $error_context) {
  echo "<b> Codigo error: </b> $error_level  <br><b> Mensaje: </b> $error_message  <br><b> Fichero: </b> $error_file <br><b> Linea: </b>$error_line<br> ";
  //echo "<b>Array--> </b> <br>";
  //var_dump($error_context);
  echo "<br>";
  die();  

}

// Obtengo todos los departamentos para mostrarlos en la lista de valores
function obtenerDepartamentos($conn) {
	$departamentos = array();
	
	$sql = "SELECT cod_dpto,nombre FROM departamento";
	
	$resultado = mysqli_query($conn, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$departamentos[] = $row;
		}
	}
	
	return $departamentos;
}

//funcion que nos dira el codigo de departamento que coincide con el nombre del departamento seleccionado
function obtenerCodigoDepartamento($conn, $nombredpto) {
	$idDepartamento = null;
	
	$sql = "SELECT cod_dpto FROM departamento WHERE nombre = '$nombredpto'";
	$resultado = mysqli_query($conn, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$idDepartamento = $row['cod_dpto'];
		}
	}
	
	return $idDepartamento;
	
}
	
// Obtengo todos los empleados para mostrarlos en la lista de valores
function obtenerEmpleados($conn) {
	$empleados = array();
	
	$sql = "SELECT * FROM empleado";
	
	$resultado = mysqli_query($conn, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$empleados[] = $row;
		}
	}
	return $empleados;
}


?>
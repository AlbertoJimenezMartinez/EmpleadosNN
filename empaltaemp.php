<?php

	require "funciones.php";

	/*Conexion a la Base de Datos*/
	$conn=conectarBD();
	// Establecemos la funcion que va a tratar los errores
	set_error_handler("errores");

	/* Se muestra el formulario la primera vez */
	if (!isset($_POST) || empty($_POST)) {

		/*Función que obtiene los departamentos de la empresa*/
		$departamentos = obtenerDepartamentos($conn);

		/* Se inicializa la lista valores*/
		echo '<form action="" method="post">';
?>
	<div align="left">
 		<!--<form action="EJ1-Empleado.php" method="post">-->
 			<label for="dni">Introduzca el DNI del empleado:</label><input type='text' name='dni' size=9><br>
			<label for="nombre">Introduzca el nombre del empleado:</label><input type='text' name='nombre' size=40><br>
			<label for="apellidos">Introduzca el apellidos del empleado:</label><input type='text' name='apellidos' size=40><br>
			<label for="fechaNac">Introduzca la fecha de nacimiento del empleado:</label><input type='date' name='fechaNac'><br>
			<label for="salario">Introduzca el salario del empleado:</label><input type='number' name='salario'><br>
			<label for="fechaAlta">Introduzca la fecha de inicio en la que empieza a trabajar el empleado:</label><input type='date' name='fechaAlta'><br>
			<label for="departamento">Departamentos:</label>
			<select name="departamento">
				<?php foreach($departamentos as $departamento) : ?>
					<option> <?php echo $departamento['nombre'] ?> </option>
				<?php endforeach; ?>
			</select>
		<!--</form>-->
	</div>
<?php
	echo '<div><input type="submit" value="Crear" name="crear"></div>
	</form>';
} else {

	// Lo primero obtengo el dpto actual (para contrastar)
	$departamento = $_POST['departamento'];
	insertarEmpleados($conn, $departamento);

}
?>

<?php

//insertaremos los empleados
function insertarEmpleados($conn, $nombredpto) {

	// Aquí va el código al pulsar submit

	// Definicion funcion error_function
	if (empty($_POST["dni"])) {
		trigger_error("El DNI no puede estar vacio");
	}
	else {
	  $dni=$_POST['dni'];
	  limpiar_campos($dni);
	}
	if (empty($_POST["nombre"])) {
		trigger_error("El nombre no puede estar vacio");
	}
	else {
	  $nombre=$_POST['nombre'];
	  limpiar_campos($nombre);
	}
	if (empty($_POST["apellidos"])) {
		trigger_error("Los apellidos no puede estar vacio");
	}
	else {
	  $apellidos=$_POST['apellidos'];
	  limpiar_campos($apellidos);
	}
	if (empty($_POST["fechaNac"])) {
		trigger_error("La fecha de nacimiento no puede estar vacia");
	}
	else {
	  $fecha=strtotime($_REQUEST['fechaNac']);
	  $fechaNacimiento=date("Y-m-d",$fecha);
	  //limpiar_campos($fechaNacimiento); no haria falta limpiar el campo porque viene en formato fecha
	}
	if (empty($_POST["salario"])) {
		trigger_error("El salario no puede estar vacio");
	}
	else {
	  $salario=$_POST['salario'];
	  limpiar_campos($salario);
	}
	if (empty($_POST["fechaAlta"])) {
		trigger_error("La fecha de nacimiento no puede estar vacia");
	}
	else {
	  $fecha=strtotime($_REQUEST['fechaNac']);
	  $fechaInicio=date("Y-m-d",$fecha);
	  //limpiar_campos($fechaInicio); no haria falta limpiar el campo porque viene en formato fecha
	}

	$cod_dpto=obtenerCodigoDepartamento($conn, $nombredpto);

	$sqlEmpleado = "INSERT INTO empleado (dni, nombre, apellidos, fecha_nac, salario) values ('$dni','$nombre','$apellidos','$fechaNacimiento','$salario')";

	$sqlEmpleadoDepart = "INSERT INTO emple_depart (dni, cod_dpto, fecha_ini) values ('$dni','$cod_dpto','$fechaInicio')";

	//insertamos el empleado
	if (mysqli_query($conn, $sqlEmpleado)) {
		echo "El empleado se ha creado correctamente<br>";
		//si el empleado es correcto insertamos los datos de emple_depart
		if (mysqli_query($conn, $sqlEmpleadoDepart)) {
			echo "El empleado se ha insertado correctamente<br>";
		} else {
			echo "Error: " . $sqlEmpleadoDepart . "<br>" . mysqli_error($conn);
		}
	} else {
		echo "Error: " . $sqlEmpleado . "<br>" . mysqli_error($conn);
	}

}

?>

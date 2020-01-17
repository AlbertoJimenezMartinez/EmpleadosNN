<?php

	require "funciones.php"; 
	
	/*Conexion a la Base de Datos*/
	$conn=conectarBD();
	
	/* Se muestra el formulario la primera vez */
	if (!isset($_POST) || empty($_POST)) { 

		/*Función que obtiene los departamentos de la empresa*/
		$departamentos = obtenerDepartamentos($conn);
		$empleados = obtenerEmpleados($conn);
		
		/* Se inicializa la lista valores*/
		echo '<form action="" method="post">';
?>
	<div align="left">
 			<label for="empleados">Empleados:</label>
			<select name="empleados">
				<?php foreach($empleados as $dni) : ?>
					<option> <?php echo $dni['dni'] ?> </option>
				<?php endforeach; ?>
			</select>
			<br><br>
			<label for="departamento">Departamentos:</label>
			<select name="departamento">
				<?php foreach($departamentos as $departamento) : ?>
					<option> <?php echo $departamento['nombre'] ?> </option>
				<?php endforeach; ?>
			</select>
			<br><br>
	</div>
<?php
	echo '<div><input type="submit" value="Cambiar" name="cambiar"></div>
	</form>';
	//var_dump($empleados);var_dump($empleados);
} else { 
	// Lo primero obtengo el dpto actual (para contrastar)
	$departamento = $_POST['departamento'];
	$empleado = $_POST['empleados'];
	cambiarEmpleados($conn, $departamento, $empleado);
	
}
?>

<?php
	
//insertaremos los empleados
function cambiarEmpleados($conn, $nombredpto, $dni) {
	// Aquí va el código al pulsar submit
	
	$cod_dpto=obtenerCodigoDepartamento($conn, $nombredpto);

	$sqlActualizar = "update emple_depart set fecha_fin=sysdate() where dni='$dni' and fecha_fin is NULL";

	$sqlInsertar = "INSERT INTO emple_depart (dni, cod_dpto, fecha_ini) values ('$dni','$cod_dpto',sysdate())";

	// actualizamos el empleado
	if (mysqli_query($conn, $sqlActualizar)) {
		echo "El empleado se ha actualizado correctamente<br>";
		// si el empleado se actualizo correctamente, insertamos el empleado en su nuevo departamento
		if (mysqli_query($conn, $sqlInsertar)) {
			echo "El empleado ha cambiado de departamento correctamente<br>";	
		} else {
			echo "Error: " . $sqlInsertar . "<br>" . mysqli_error($conn);
		}
	} else {
		echo "Error: " . $sqlActualizar . "<br>" . mysqli_error($conn);
	}

}
	
?>
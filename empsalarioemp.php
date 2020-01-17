<?php

	require "funciones.php";

	/*Conexion a la Base de Datos*/
	$conn=conectarBD();
	// Establecemos la funcion que va a tratar los errores
	set_error_handler("errores");


	/* Se muestra el formulario la primera vez */
	if (!isset($_POST) || empty($_POST)) {

		/*Función que obtiene los departamentos de la empresa*/
		$empleados = obtenerEmpleados($conn);

		/* Se inicializa la lista valores*/
		echo '<form action="" method="post">';
?>
	<div align="left">
			<label for="empleados">Empleados:</label>
			<select name="empleados">
				<?php foreach($empleados as $empleado) : ?>
					<option> <?php echo $empleado['dni'] ?> </option>
				<?php endforeach; ?>
			</select>
			<br>
			<label for="salario">Porcentanje de Salario a Incrementar/Decrementar:</label>
			<input type="number" name="salario" placeholder="(-)Salario">%
			<br><br>
	</div>
<?php
	echo '<div><input type="submit" value="Cambiar" name="cambiar"></div>
	</form>';
	//var_dump($empleados);var_dump($empleados);
} else {
	// Lo primero obtengo el dpto actual (para contrastar)
	$empleado = $_POST['empleados'];
	$salario = $_POST['salario'];
	incrementarSalario($conn, $empleado, $salario);

}
?>

<?php

//insertaremos los empleados
function incrementarSalario($conn, $dni, $salario) {
	// Aquí va el código al pulsar submit

	if (empty($_POST["salario"])) {
		trigger_error("El Salario no puede estar vacio");
	}
	else {
	  $porcentaje=$_POST['salario'];
	  limpiar_campos($porcentaje);
	}

	$sqlSalarioAnt = "select salario from empleado where dni='$dni'";
	$sqlIncrementar = "update empleado set salario=salario+((salario*'$porcentaje')/100) where dni='$dni'";
	$sqlMostrar = "select dni, salario from empleado where dni='$dni'";

	// cojemos el salario antes de actualizarlo
	$salarioAnterior="";
	$resultadoSalarioAnt = mysqli_query($conn, $sqlSalarioAnt);
	if ($resultadoSalarioAnt) {
		while ($row = mysqli_fetch_assoc($resultadoSalarioAnt)) {
			$salarioAnterior = $row['salario'];
		}
	}


	if (mysqli_query($conn, $sqlIncrementar)) {
		echo "El salario se ha incrementado correctamente.";
		echo "<br>";
		$resultadoSalarioActual= mysqli_query($conn, $sqlMostrar);
		if ($resultadoSalarioActual) {
				$row = mysqli_fetch_assoc($resultadoSalarioActual);
				if ($porcentaje>0) {
					echo "El salario actual del empleado con dni ".$row['dni']." es de ".$row['salario']."€, despues de incrementar un ".$porcentaje."% su anterior salario ".$salarioAnterior."€";
				} else {
					echo "El salario actual del empleado con dni ".$row['dni']." es de ".$row['salario']."€, despues de decrementar un ".$porcentaje."% su anterior salario ".$salarioAnterior."€";
				}

		} else {
			echo "Error: " . $sqlMostrar . "<br>" . mysqli_error($conn);
		}

	} else {
		echo "Error: " . $sqlIncrementar . "<br>" . mysqli_error($conn);
	}


}

?>

<?php

	require "funciones.php"; 
	
	/*Conexion a la Base de Datos*/
	$conn=conectarBD();
	
	/* Se muestra el formulario la primera vez */
	if (!isset($_POST) || empty($_POST)) { 

		/*Función que obtiene los departamentos de la empresa*/
		$departamentos = obtenerDepartamentos($conn);
		
		/* Se inicializa la lista valores*/
		echo '<form action="" method="post">';
?>
	<div align="left">
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
	mostrarEmpleados($conn, $departamento);
	
}
?>

<?php
	
//insertaremos los empleados
function mostrarEmpleados($conn, $nombredpto) {
	// Aquí va el código al pulsar submit
	
	$cod_dpto=obtenerCodigoDepartamento($conn, $nombredpto);

	$sqlMostrar = "select emple_depart.dni, empleado.nombre, empleado.apellidos from emple_depart, empleado where emple_depart.dni=empleado.dni and cod_dpto='$cod_dpto' and fecha_fin is null";

	// mostramos el empleado
	$resultado= mysqli_query($conn, $sqlMostrar);
	if ($resultado) {
		if (mysqli_num_rows($resultado)>0) {
			echo "<table border='1'>";
			echo "Estos son todos los empleados que trabajan actualmente en el departamento ".$nombredpto."<br><br>";
			while ($row = mysqli_fetch_assoc($resultado)) {
				echo "<tr>";
				echo "<td>DNI: ".$row['dni']."</td>";
				echo "<td>Nombre: ".$row['nombre']."</td>";
				echo "<td>Apellidos: ".$row['apellidos']."</td>";
				echo "</tr>";
			}
			echo "</table>";
		} else {
			echo "El departamento no tiene empleados";
		}
	} else {
		echo "Error: " . $sqlMostrar . "<br>" . mysqli_error($conn);
	}
}
	
?>
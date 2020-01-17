<?php

	require "funciones.php";

	/*Conexion a la Base de Datos*/
	$conn=conectarBD();
	// Establecemos la funcion que va a tratar los errores
	set_error_handler("errores");


	/* Se muestra el formulario la primera vez */
	if (!isset($_POST) || empty($_POST)) {

		/* Se inicializa la lista valores*/
		echo '<form action="" method="post">';
?>
	<div align="left">
			<label for="fecha">Introduzca la fecha a comprobar:</label><input type='date' name='fecha'><br>
	</div>
<?php
	echo '<div><input type="submit" value="Buscar" name="buscar"></div>
	</form>';
} else {
	// Lo primero obtengo el dpto actual (para contrastar)
	$fecha = $_POST['fecha'];
	buscarEmpleados($conn, $fecha);

}
?>

<?php

//insertaremos los empleados
function buscarEmpleados($conn, $fecha) {
	// Aquí va el código al pulsar submit

	if (empty($_POST["fecha"])) {
		trigger_error("La fecha no puede estar vacia");
	}
	else {
	  $fecha=strtotime($_REQUEST['fecha']);
	  $fecha2=date("Y-m-d",$fecha);
	}
	
	$sqlMostrar = "select emple_depart.cod_dpto, departamento.nombre, emple_depart.dni, empleado.nombre, empleado.apellidos, emple_depart.fecha_ini, emple_depart.fecha_fin from emple_depart, empleado, departamento where emple_depart.dni=empleado.dni and emple_depart.cod_dpto=departamento.cod_dpto and fecha_ini<='$fecha2' and (fecha_fin>='$fecha2' or fecha_fin is null)";

	$resultado= mysqli_query($conn, $sqlMostrar);
	if ($resultado) {
		if (mysqli_num_rows($resultado)>0) {
			echo "<table border='1'>";
			while ($row = mysqli_fetch_assoc($resultado)) {
				echo "<tr>";
				echo "<td>Codigo Departamento: ".$row['cod_dpto']."</td>";
				echo "<td>Departamento: ".$row['nombre']."</td>";
				echo "<td>DNI: ".$row['dni']."</td>";
				echo "<td>Nombre: ".$row['nombre']."</td>";
				echo "<td>Apellidos: ".$row['apellidos']."</td>";
				echo "<td>Fecha inicio: ".$row['fecha_ini']."</td>";
				echo "<td>Fecha fin: ".$row['fecha_fin']."</td>";
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

<?php

$nombre=$_REQUEST['nombre'];

require "funciones.php"; 


if (empty($_POST["nombre"])) {
	trigger_error("El nombre no puede estar vacio");
} 
else {
	$nombre=$_POST['nombre']; 
	limpiar_campos($nombre);
}	


$conn=conectarBD();



$resultMAX= "select max(cod_dpto) from departamento";
$cod_depart = $conn->query($resultMAX);
$cod_departAUX="";
if ($cod_depart->num_rows > 0) {
    // output data of each row
    while($row = $cod_depart->fetch_assoc()) {		   
		$cod_departNUM=substr($row["max(cod_dpto)"], 1);
		settype($cod_departNUM,'integer');
		$cod_departNUM=$cod_departNUM+1;
		$cod_departNUM=str_pad($cod_departNUM,3,0,STR_PAD_LEFT);
		$cod_departAUX="D".$cod_departNUM;
	}
	 
} else {
    $cod_departAUX="D001";
}

	$sql = "INSERT INTO departamento (cod_dpto, nombre) VALUES ('$cod_departAUX', '$nombre')";

	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}


$conn->close();
	
	
echo "<form action='empaltadpto.html' method='post'>
			<input type='submit' value='Volver' name='volver'>
		  </form>";
	
?>
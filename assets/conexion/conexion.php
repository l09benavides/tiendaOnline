<?php
	$mysqli=new mysqli("mysqldb-tienda.mysql.database.azure.com","dbadmin@mysqldb-tienda","Truecontrol12!","tienda"); //servidor, usuario de base de datos, contraseña del usuario, nombre de base de datos
	
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
	$acentos = $mysqli->query("SET NAMES 'utf8'")
?>
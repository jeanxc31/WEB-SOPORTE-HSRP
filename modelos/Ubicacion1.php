<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Ubicacion1{


	//implementamos nuestro constructor
public function __construct1(){

}

//metodo insertar registro
public function insertar1($nombre1,$descripcion1){
	$sql="INSERT INTO ubicacion1 (nombre1,descripcion1,condicion1) VALUES ('$nombre1','$descripcion1','1')";
	return ejecutarConsulta($sql);
}
public function editar1($idubicacion1,$nombre1,$descripcion1){
	$sql="UPDATE ubicacion1 SET nombre1='$nombre1',descripcion1='$descripcion1' 
	WHERE idubicacion1='$idubicacion1'";
	return ejecutarConsulta($sql);
}


public function desactivar1($idubicacion1){
	$sql="UPDATE ubicacion1 SET condicion1='0' WHERE idubicacion1='$idubicacion1'";
	return ejecutarConsulta($sql);
}
public function activar1($idubicacion1){
	$sql="UPDATE ubicacion1 SET condicion1='1' WHERE idubicacion1='$idubicacion1'";
	return ejecutarConsulta($sql);
}


//metodo para mostrar registros
public function mostrar1($idubicacion1){
	$sql="SELECT * FROM ubicacion1 WHERE idubicacion1='$idubicacion1'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar1(){
	$sql="SELECT * FROM ubicacion1";
	return ejecutarConsulta($sql);
}
//listar y mostrar en select
public function select1(){
	$sql="SELECT * FROM ubicacion1 WHERE condicion1=1";
	return ejecutarConsulta($sql);
}
}

 ?>

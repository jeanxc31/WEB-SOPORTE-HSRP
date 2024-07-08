<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Ubicacion{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($nombre,$descripcion){
	$sql="INSERT INTO ubicacion (nombre,descripcion,condicion) VALUES ('$nombre','$descripcion','1')";
	return ejecutarConsulta($sql);
}

public function editar($idubicacion,$nombre,$descripcion){
	$sql="UPDATE ubicacion SET nombre='$nombre',descripcion='$descripcion' 
	WHERE idubicacion='$idubicacion'";
	return ejecutarConsulta($sql);
}
public function desactivar($idubicacion){
	$sql="UPDATE ubicacion SET condicion='0' WHERE idubicacion='$idubicacion'";
	return ejecutarConsulta($sql);
}
public function activar($idubicacion){
	$sql="UPDATE ubicacion SET condicion='1' WHERE idubicacion='$idubicacion'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idubicacion){
	$sql="SELECT * FROM ubicacion WHERE idubicacion='$idubicacion'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM ubicacion";
	return ejecutarConsulta($sql);
}
//listar y mostrar en selct
public function select(){
	$sql="SELECT * FROM ubicacion WHERE condicion=1";
	return ejecutarConsulta($sql);
}

//listar y mostrar en selct
public function select1(){
	$sql="SELECT * FROM ubicacion1 WHERE condicion=1";
	return ejecutarConsulta($sql);


}
}

 ?>

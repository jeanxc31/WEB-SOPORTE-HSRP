<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Marca{


	//implementamos nuestro constructor
	public function __construct(){

	}

	//metodo insertar regiustro
	public function insertar($nombre,$descripcion){
		$sql="INSERT INTO marca (nombre,descripcion,condicion) VALUES ('$nombre','$descripcion','1')";
		return ejecutarConsulta($sql);
	}

	public function editar($idmarca,$nombre,$descripcion){
		$sql="UPDATE marca SET nombre='$nombre',descripcion='$descripcion' 
		WHERE idmarca='$idmarca'";
		return ejecutarConsulta($sql);
	}
	public function desactivar($idmarca){
		$sql="UPDATE marca SET condicion='0' WHERE idmarca='$idmarca'";
		return ejecutarConsulta($sql);
	}
	public function activar($idmarca){
		$sql="UPDATE marca SET condicion='1' WHERE idmarca='$idmarca'";
		return ejecutarConsulta($sql);
	}

	//metodo para mostrar registros
	public function mostrar($idmarca){
		$sql="SELECT * FROM marca WHERE idmarca='$idmarca'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//listar registros
	public function listar(){
		$sql="SELECT * FROM marca";
		return ejecutarConsulta($sql);
	}
	//listar y mostrar en select
	public function select(){
		$sql="SELECT * FROM marca WHERE condicion=1";
		return ejecutarConsulta($sql);
	}
}

 ?>

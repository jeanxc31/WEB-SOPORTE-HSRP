<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Producto{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($idcategoria,$idmarca,$codigo,$nombre,$stock,$descripcion,$imagen){
	$sql="INSERT INTO producto (idcategoria,idmarca,codigo,nombre,stock,descripcion,imagen,condicion)
	 VALUES ('$idcategoria','$idmarca','$codigo','$nombre','$stock','$descripcion','$imagen','1')";
	return ejecutarConsulta($sql);
}

public function editar($idproducto,$idcategoria,$idmarca,$codigo,$nombre,$stock,$descripcion,$imagen){
	$sql="UPDATE producto SET idcategoria='$idcategoria', idmarca='$idmarca',codigo='$codigo', nombre='$nombre',stock='$stock',descripcion='$descripcion',imagen='$imagen' 
	WHERE idproducto='$idproducto'";
	return ejecutarConsulta($sql);
}
public function desactivar($idproducto){
	$sql="UPDATE producto SET condicion='0' WHERE idproducto='$idproducto'";
	return ejecutarConsulta($sql);
}
public function activar($idproducto){
	$sql="UPDATE producto SET condicion='1' WHERE idproducto='$idproducto'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idproducto){
	$sql="SELECT * FROM producto WHERE idproducto='$idproducto'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros 
public function listar(){
	$sql="SELECT a.idproducto,a.idcategoria,c.nombre as categoria,a.idmarca,m.nombre as marca,a.codigo, a.nombre,a.stock,a.descripcion,a.imagen,a.condicion FROM producto a 
	INNER JOIN Categoria c ON a.idcategoria=c.idcategoria
	INNER JOIN Marca m ON a.idmarca=m.idmarca";
	return ejecutarConsulta($sql);
}

//listar registros activos
public function listarActivos(){
	$sql="SELECT a.idproducto,a.idcategoria,c.nombre as categoria,a.idmarca,m.nombre as marca,a.codigo, a.nombre,a.stock,a.descripcion,a.imagen,a.condicion FROM producto a 
	INNER JOIN Categoria c ON a.idcategoria=c.idcategoria 
	INNER JOIN Marca m ON a.idmarca=m.idmarca WHERE a.condicion='1'";
	return ejecutarConsulta($sql);
}

//implementar un metodo para listar los activos, su ultimo precio y el stock(vamos a unir con el ultimo registro de la tabla detalle_ingreso)
public function listarActivosVenta(){
	$sql="SELECT a.idproducto,a.idcategoria,c.nombre as categoria,a.idmarca,m.nombre as marca,a.codigo, a.nombre,a.stock,(SELECT precio_venta FROM detalle_ingreso WHERE idproducto=a.idproducto ORDER BY iddetalle_ingreso DESC LIMIT 0,1) AS precio_venta,a.descripcion,a.imagen,a.condicion FROM producto a 
	INNER JOIN Categoria c ON a.idcategoria=c.idcategoria 
	INNER JOIN Marca m ON a.idmarca=m.idmarca WHERE a.condicion='1'";
	return ejecutarConsulta($sql);
}
}
 ?>

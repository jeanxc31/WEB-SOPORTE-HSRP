<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Articulo{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($idcategoria,$idmarca,$idubicacion, $idubicacion1,$codigo,$nombre,$stock,$descripcion,$imagen){
	$sql="INSERT INTO articulo (idcategoria,idmarca,idubicacion,idubicacion1,codigo,nombre,stock,descripcion,imagen,condicion)
	 VALUES ('$idcategoria','$idmarca','$idubicacion', '$idubicacion1','$codigo','$nombre','$stock','$descripcion','$imagen','1')";
	return ejecutarConsulta($sql);
}

public function editar($idarticulo,$idcategoria,$idmarca,$idubicacion, $idubicacion1,$codigo,$nombre,$stock,$descripcion,$imagen){
	$sql="UPDATE articulo SET idcategoria='$idcategoria', idmarca='$idmarca', idubicacion='$idubicacion', idubicacion1 ='$idubicacion1',codigo='$codigo', nombre='$nombre',stock='$stock',descripcion='$descripcion',imagen='$imagen' 
	WHERE idarticulo='$idarticulo'";
	return ejecutarConsulta($sql);
}
public function desactivar($idarticulo){
	$sql="UPDATE articulo SET condicion='0' WHERE idarticulo='$idarticulo'";
	return ejecutarConsulta($sql);
}
public function activar($idarticulo){
	$sql="UPDATE articulo SET condicion='1' WHERE idarticulo='$idarticulo'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idarticulo){
	$sql="SELECT * FROM articulo WHERE idarticulo='$idarticulo'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros 
public function listar(){
	$sql="SELECT  a.idarticulo,a.idcategoria,c.nombre as categoria,
	a.idmarca,m.nombre as marca,
	a.idubicacion,u.nombre as ubicacion,
	a.idubicacion1, o.nombre1 as ubicacion1,
	
	a.codigo, a.nombre,a.stock,a.descripcion,a.imagen,a.condicion FROM articulo a 

INNER JOIN Categoria c ON a.idcategoria=c.idcategoria
INNER JOIN Marca m ON a.idmarca=m.idmarca
INNER JOIN Ubicacion u ON a.idubicacion=u.idubicacion
INNER JOIN Ubicacion1 o ON a.idubicacion1=o.idubicacion1";

	return ejecutarConsulta($sql);


	
}

//listar registros activos
public function listarActivos(){
	$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,
	a.idmarca,m.nombre as marca,
	a.idubicacion,u.nombre as ubicacion,
	a.idubicacion1, o.nombre1 as ubicacion1,

	a.codigo, a.nombre,a.stock,a.descripcion,a.imagen,a.condicion FROM articulo a 

	INNER JOIN Categoria c ON a.idcategoria=c.idcategoria 
	INNER JOIN Marca m ON a.idmarca=m.idmarca 
	INNER JOIN Ubicacion u ON a.idubicacion=u.idubicacion 
	INNER JOIN Ubicacion1 o ON a.idubicacion1=o.idubicacion1

	WHERE a.condicion='1'";

	return ejecutarConsulta($sql);
}

//implementar un metodo para listar los activos, su ultimo precio y el stock(vamos a unir con el ultimo registro de la tabla detalle_ingreso)
public function listarActivosVenta(){
	$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,
	a.idmarca,m.nombre as marca,
	a.idubicacion,u.nombre as ubicacion,
	a.idubicacion1, o.nombre1 as ubicacion1,

	a.codigo, a.nombre,a.stock,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo ORDER BY iddetalle_ingreso DESC LIMIT 0,1) AS precio_venta,a.descripcion,a.imagen,a.condicion FROM articulo a 
	INNER JOIN Categoria c ON a.idcategoria=c.idcategoria 
	INNER JOIN Marca m ON a.idmarca=m.idmarca 
	INNER JOIN Ubicacion u ON a.idubicacion=u.idubicacion 
	INNER JOIN Ubicacion1 o ON a.idubicacion1=o.idubicacion1

	
	
	WHERE a.condicion='1'";
	return ejecutarConsulta($sql);
}
}
 ?>

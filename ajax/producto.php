<?php 
require_once "../modelos/Producto.php";

$producto=new Producto();

$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$idmarca=isset($_POST["idmarca"])? limpiarCadena($_POST["idmarca"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$stock=isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':

	if (!file_exists($_FILES['imagen']['tmp_name'])|| !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
		$imagen=$_POST["imagenactual"];
	}else{
		$ext=explode(".", $_FILES["imagen"]["name"]);
		if ($_FILES['imagen']['type']=="image/jpg" || $_FILES['imagen']['type']=="image/jpeg" || $_FILES['imagen']['type']=="image/png") {
			$imagen=round(microtime(true)).'.'. end($ext);
			move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/productos/".$imagen);
		}
	}
	if (empty($idproducto)) {
		$rspta=$producto->insertar($idcategoria,$idmarca,$codigo,$nombre,$stock,$descripcion,$imagen);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
         $rspta=$producto->editar($idproducto,$idcategoria,$idmarca,$codigo,$nombre,$stock,$descripcion,$imagen);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;
	

	case 'desactivar':
		$rspta=$producto->desactivar($idproducto);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$producto->activar($idproducto);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$producto->mostrar($idproducto);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$producto->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            
            "0"=>$reg->nombre,
            "1"=>$reg->categoria,
            "2"=>$reg->marca,
            "3"=>$reg->codigo,
            "4"=>$reg->stock,
            "5"=>"<img src='../files/productos/".$reg->imagen."' height='50px' width='50px'>",
            "6"=>$reg->descripcion,
            "7"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>',
			"8"=>($reg->condicion)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idproducto.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idproducto.')"><i class="fa fa-check"></i></button>');
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

		case 'selectCategoria':
			require_once "../modelos/Categoria.php";
			$categoria=new Categoria();

			$rspta=$categoria->select();

			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->idcategoria.'>'.$reg->nombre.'</option>';
			}
			break;
		case 'selectMarca':
			require_once "../modelos/Marca.php";
			$marca=new Marca();

			$rspta=$marca->select();

			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->idmarca.'>'.$reg->nombre.'</option>';
			}
			break;
}
 ?>
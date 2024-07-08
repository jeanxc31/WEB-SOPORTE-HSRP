<?php 
require_once "../modelos/Articulo.php";

$articulo=new Articulo();

$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$idmarca=isset($_POST["idmarca"])? limpiarCadena($_POST["idmarca"]):"";
$idubicacion=isset($_POST["idubicacion"])? limpiarCadena($_POST["idubicacion"]):"";
$idubicacion1=isset($_POST["idubicacion1"])? limpiarCadena($_POST["idubicacion1"]):"";
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
			move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/".$imagen);
		}
	}
	if (empty($idarticulo)) {
		$rspta=$articulo->insertar($idcategoria,$idmarca,$idubicacion, $idubicacion1,$codigo,$nombre,$stock,$descripcion,$imagen);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
         $rspta=$articulo->editar($idarticulo,$idcategoria,$idmarca,$idubicacion,$idubicacion1,$codigo,$nombre,$stock,$descripcion,$imagen);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;		
	

	case 'desactivar':
		$rspta=$articulo->desactivar($idarticulo);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$articulo->activar($idarticulo);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$articulo->mostrar($idarticulo);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$articulo->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            
            "0"=>$reg->nombre,
            "1"=>$reg->categoria,
            "2"=>$reg->marca,
            "3"=>$reg->ubicacion,
			"4"=>$reg->ubicacion1,
            "5"=>$reg->codigo,
            "6"=>$reg->stock,
            "7"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>",
            "8"=>$reg->descripcion,
            "9"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>',
			"10"=>($reg->condicion)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idarticulo.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-primary btn-xs" onclick="activar('.$reg->idarticulo.')"><i class="fa fa-check"></i></button>');
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
		    $categoria = new Categoria();
		    $rspta = $categoria->select();

		    $categorias = array();

		    while ($reg = $rspta->fetch_object()) {
		        $categorias[] = $reg;
		    }

		    // Ordenar las categorías alfabéticamente por el campo 'nombre'
		    usort($categorias, function ($a, $b) {
		        return strcmp($a->nombre, $b->nombre);
		    });

		    // Generar las opciones
		    foreach ($categorias as $categoria) {
		        echo "<option value='{$categoria->idcategoria}'>{$categoria->nombre}</option>";
		    }
		    break;

		case 'selectMarca':
		    require_once "../modelos/Marca.php";
		    $marca = new Marca();
		    $rspta = $marca->select();

		    $options = array();

		    while ($reg = $rspta->fetch_object()) {
		        $options[] = $reg;
		    }

		    // Ordenar las opciones alfabéticamente por el campo 'nombre'
		    usort($options, function ($a, $b) {
		        return strcmp($a->nombre, $b->nombre);
		    });

		    // Generar las opciones
		    foreach ($options as $option) {
		        echo "<option value='{$option->idmarca}'>{$option->nombre}</option>";
		    }
	    break;

	    case 'selectUbicacion':
		    require_once "../modelos/Ubicacion.php";
		    $ubicacion = new Ubicacion();
		    $rspta = $ubicacion->select();

		    $ubicacions = array();

		    while ($reg = $rspta->fetch_object()) {
		        $ubicacions[] = $reg;
		    }

		    // Ordenar las Ubicación alfabéticamente por el campo 'nombre'
		    usort($ubicacions, function ($a, $b) {
		        return strcmp($a->nombre, $b->nombre);
		    });

		    // Generar las opciones
		    foreach ($ubicacions as $ubicacion) {
		        echo "<option value='{$ubicacion->idubicacion}'>{$ubicacion->nombre}</option>";
		    }
		    break;


			case 'selectUbicacion1':
				require_once "../modelos/Ubicacion1.php";
				$ubicacion1 = new Ubicacion1();
				$rspta = $ubicacion1->select1();
	
				$ubicacions1 = array();
	
				while ($reg = $rspta->fetch_object()) {
					$ubicacions1[] = $reg;
				}
	
				// Ordenar las Ubicación alfabéticamente por el campo 'nombre'
				usort($ubicacions1, function ($a, $b) {
					return strcmp($a->nombre1, $b->nombre1);
				});
	
				// Generar las opciones	
				foreach ($ubicacions1 as $ubicacion1) {
					echo "<option value='{$ubicacion1->idubicacion1}'>{$ubicacion1->nombre1}</option>";
				}
				break;







}
 ?>
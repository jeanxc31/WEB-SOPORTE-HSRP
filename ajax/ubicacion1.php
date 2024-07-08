<?php 
require_once "../modelos/Ubicacion1.php";

$ubicacion1=new Ubicacion1();

$idubicacion1=isset($_POST["idubicacion1"])? limpiarCadena($_POST["idubicacion1"]):"";
$nombre1=isset($_POST["nombre1"])? limpiarCadena($_POST["nombre1"]):"";
$descripcion1=isset($_POST["descripcion1"])? limpiarCadena($_POST["descripcion1"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar1':
	if (empty($idubicacion1)) {
		$rspta=$ubicacion1->insertar1($nombre1,$descripcion1);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
         $rspta=$ubicacion1->editar1($idubicacion1,$nombre1,$descripcion1);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
		break;
	


	case 'desactivar1':
		$rspta=$ubicacion1->desactivar1($idubicacion1);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;

	case 'activar1':
		$rspta=$ubicacion1->activar1($idubicacion1);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	

	case 'mostrar1':
		$rspta=$ubicacion1->mostrar1($idubicacion1);
		echo json_encode($rspta);
		break;

    case 'listar1':
		$rspta=$ubicacion1->listar1();
		$data1=Array();

		while ($reg=$rspta->fetch_object()) {
			$data1[]=array(
            "2"=>($reg->condicion1)?'<button class="btn btn-warning btn-xs" onclick="mostrar1('.$reg->idubicacion1.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="desactivar1('.$reg->idubicacion1.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning btn-xs" onclick="mostrar1('.$reg->idubicacion1.')"><i class="fa fa-pencil"></i></button>'.' '.'<button class="btn btn-primary btn-xs" onclick="activar1('.$reg->idubicacion1.')"><i class="fa fa-check"></i></button>',
            "0"=>$reg->nombre1,
            "1"=>($reg->condicion1)?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
              );
		}
		$results1=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data1),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data1),//enviamos el total de registros a visualizar
             "aaData"=>$data1); 
		echo json_encode($results1);
		break;	
}
 ?>
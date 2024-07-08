var tabla1;

//funcion que se ejecuta al inicio
function init(){
   mostrarform1(false);
   listar1();

   $("#formulario1").on("submit",function(e){
   	guardaryeditar1(e);
   })
}

//funcion limpiar
function limpiar1(){
	$("#idubicacion1").val("");
	$("#nombre1").val("");
	$("#descripcion1").val("");
}

//funcion mostrar formulario
function mostrarform1(flag){
	limpiar1();
	if(flag){
		$("#listadoregistros1").hide();
		$("#formularioregistros1").show();
		$("#btnGuardar1").prop("disabled",false);
		$("#btnagregar1").hide();
	}else{
		$("#listadoregistros1").show();
		$("#formularioregistros1").hide();
		$("#btnagregar1").show();
	}
}

//cancelar form
function cancelarform1(){
	limpiar1();
	mostrarform1(false);
}

//funcion listar
function listar1(){
	tabla1=$('#tbllistado1').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		dom: 'Bfrtip',//definimos los elementos del control de la tabla
		buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdf'
		],
		"ajax":
		{
			url:'../ajax/ubicacion1.php?op=listar1',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":5,//paginacion
		"order":[[0,"desc"]]//ordenar (columna, orden)
	}).DataTable();
}
//funcion para guardaryeditar
function guardaryeditar1(e){
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar1").prop("disabled",true);
     var formData1=new FormData($("#formulario1")[0]);

     $.ajax({
     	url: "../ajax/ubicacion1.php?op=guardaryeditar1",
     	type: "POST",
     	data: formData1,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		bootbox.alert(datos);
     		mostrarform1(false);
     		tabla1.ajax.reload();
     	}
     });

     limpiar1();
}

function mostrar1(idubicacion1){
	$.post("../ajax/ubicacion1.php?op=mostrar1",{idubicacion1 : idubicacion1},
		function(data1,status)
		{
			data1=JSON.parse(data1);
			mostrarform1(true);

			$("#nombre1").val(data1.nombre1);
			$("#descripcion1").val(data1.descripcion1);
			$("#idubicacion1").val(data1.idubicacion1);
		})
}


//funcion para desactivar
function desactivar1(idubicacion1){
	bootbox.confirm("¿Esta seguro de desactivar este dato?", function(result){
		if (result) {
			$.post("../ajax/ubicacion1.php?op=desactivar1", {idubicacion1 : idubicacion1}, function(e){
				bootbox.alert(e);
				tabla1.ajax.reload();
			});
		}
	})
}

function activar1(idubicacion1){
	bootbox.confirm("¿Esta seguro de activar este dato?" , function(result){
		if (result) {
			$.post("../ajax/ubicacion1.php?op=activar1" , {idubicacion1 : idubicacion1}, function(e){
				bootbox.alert(e);
				tabla1.ajax.reload();
			});
		}
	})
}

init();
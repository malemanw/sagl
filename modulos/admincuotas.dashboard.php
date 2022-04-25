<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
?>
<div class="container center">
<h4><b>Administración de Cuotas a Pagar</b></h4>
</div>
<table id="tbldata" class="display">
    <thead>
		<tr>
            <th class="center">idmes</th>
            <th class="center">Mes</th>
			<th class="center">Descripción</th>	
			<th class="center">Editar</th>		
		</tr>
    </thead>
    <tbody>
<?php
					$strsql = 'SELECT idcuota, cuota, descripcion FROM cuotas ORDER BY fecha_creacion DESC';
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($idmes, $mes, $descripcion);
						while($stmt->fetch()){
						?>
							<tr id="rw-<?php echo $idmes?>" >
								<td><?php echo $idmes?></td>
								<td><?php echo $mes?></td>
								<td><?php echo $descripcion?></td>
		<td class="center">
			<a href="?mod=adminperfilusuario&idusuario=<?php echo $idmes?>" class="btn green">
			<i class="material-icons">edit</i>
			</a>
		</td>                               
							</tr>
						<?php
						}
						
						$stmt->close();
					}//cierre de consulta de valores retornados
				}
				else{
					echo "Error al ejecutar consulta: " . $stmt->error;
				}//Cierre de condicion de Ejecucion
			}
			else{
				echo "Error al preparar consulta: " . $mysqli->error;
			}
		?>
    </tbody>
</table>
<a class="btn green darken-3" href="javascript:nuevo()"><i class="material-icons left">add</i>Agregar</a>
<div id="frmbloques" class="modal">
	<div class="modal-content">
		<h4 class="center">Agregar año escolar</h4>
		<form class="row" action="javascript:guardarnuevo()">
			<div class="input-field col s12 l12">
				<i class="material-icons prefix">today</i>
				<input id="txtyear" type="text">
				<label for="txtyear">Nombre del Año</label>
			</div>
            <div class="input-field col s12 l12">
            	<i class="material-icons prefix">web</i>
				<input id="txtdescripcion" type="text">
				<label for="txtdescripcion">Descripción del año</label>
			</div>
			</form>
	</div>
	<div class="modal-footer">
		<a id="p" href="javascript:guardarnuevo()" class="waves-effect waves-green btn green">Guardar</a>      	
	</div>
</div>
<div id="frmbloques2" class="modal">
	<div class="modal-content">
		<h4>Administrador de Permisos</h4>
        <input id="id" style="display: none">
		<form id="rellenar" class="row">	
		</form>
	</div>
	<div class="modal-footer">
		<a id="p" href="javascript:guardarpermisos()" class="waves-effect waves-green btn green">Guardar</a> 	
	</div>
</div>
<script src="./recursos/js/datatables.min.js"></script>
<script src="<?php echo $urlweb?>recursos/js/sweetalert2.min.js"></script>
<script>	
$(document).ready( function () {
    $('#tbldata').DataTable({
    	responsive: true
    });
});	
function guardarnuevo(){
var year = $("#txtyear").val(),
	descripcion = $("#txtdescripcion").val();
swal({
	title:"¿Datos Correctos?",
	text: "¿Todos los datos ingresados estan bien?",
	type: "warning",
	showCancelButton: true,
	closeOnConfirm: false,
	showLoaderOnConfirm: true
}).then(function(){
	$.ajax({
		url:"<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=agregar",
		type: 'POST',
		data:{"year":year, "descripcion":descripcion},
		error:function(){
				swal.close();
				setTimeout(function(){
					swal({
							title:"Error!",
							text: "Tiempo Fuera, No se procesaron los datos",
							type:"error",
							showConfirmButton:true
						});
				}, 1000);
		},
		success: function(data){
			try{
				var retorno = data;
				$('#frmbloques').modal('close');
				$("#tbldata tbody").append(retorno.htmldata);
document.getElementById("rw-" + retorno.id).style.backgroundColor  = "#C8E6C9";	
				swal(retorno);
			}
			catch(err){
				swal({
					title:"Error!",
					text: err.message,
					type:"error",
					showConfirmButton:true
				});
			}
		},
		timeout: 5000
	});
	
});

}
function guardareditar(){
var idbloque = $("#txtidbloque").val(),
	bloque = $("#txtbloque").val(),
	esactivo = $("#esactivo").prop("checked") ? 1 : 0;
swal({
		title:"¿Datos Correctos?",
		text: "¿Todos los datos ingresados estan bien",
		type: "warning",
		showCancelButton: true,
		closeOnConfirm: false,
		showLoaderOnConfirm: true
	}).then(function(){
		$.ajax({
			url:"<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=editar",
			type: 'POST',
			data:{"idbloque":idbloque, "bloque":bloque, "tipo":tipo},
			error:function(){
					swal.close();
					setTimeout(function(){
						swal({
								title:"Error!",
								text: "Tiempo Fuera, No se procesaron los datos",
								type:"error",
								showConfirmButton:true
							});
					}, 1000);
			},
			success: function(data){
				try{
				var retorno = data;
				 $('#frmbloques').modal('close');
				$("#rw-" + idbloque).fadeOut("1000",function(){
                    $("#rw-" + idbloque).html(data.htmldata);
                    $("#rw-" + idbloque).fadeIn("1000");
                    location.reload();
                });
				}
				catch(err){
					swal({
						title:"Error!",
						text: err.message,
						type:"error",
						showConfirmButton:true
					});
				}
			},
			timeout: 5000
		});
		
	});
  
}
function nuevo(){
$('#frmbloques').modal('open');
$("#txtyear").focus();
$("#txtyear").val("");
$("#txtdescripcion").val("");
}


function editar(idbloque, bloque, tipo){
 $("#txtidbloque").val(idbloque);
 $("#txtbloque").val(bloque);
 $('#txtidbloque').attr('readonly', true);
 $('#frmbloques').modal('open');
 $("#txtbloque").focus();
		if(tipo==1){
   $("#chkarchivo").prop("checked", true);
    }else{
         $("#chkcontenido").prop("checked", true);
    }
$('#p').attr("href","javascript:guardareditar()");
}
</script>

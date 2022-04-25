<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
?>
<div class="container center">
<h4><b>Administrador de Notificaciones</b></h4>
</div>
<table id="tbldata" class="display centered" width="100%">
    <thead>
		<tr>
            <th class="center">No.</th>
            <th class="center">Titulo</th>
			<th class="center">Mensaje</th>	
			<th class="center">Fecha Publicación</th>
			<th class="center">Activo</th>	
			<th class="center">Editar</th>		
		</tr>
    </thead>
    <tbody>
<?php
					$strsql = 'SELECT idnotificacion, titulo, mensaje, fecha_creacion, activo FROM notificaciones ORDER BY fecha_creacion DESC';
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($idnotificacion, $titulo, $mensaje, $fecha_creacion, $activo);
						while($stmt->fetch()){
						?>
							<tr id="rw-<?php echo $idnotificacion?>" >
								<td><?php echo $idnotificacion?></td>
								<td><?php echo $titulo?></td>
								<td><?php echo $mensaje?></td>
								<td><?php echo $fecha_creacion?></td>
								<td class="center"><?php echo $activo == 1 ? "<i class=\"material-icons\">done</i>" : "<i class=\"material-icons\">clear</i>" ?></td>
		<td class="center">
			<a href="javascript:nuevo('<?php echo $idnotificacion?>', '<?php echo $titulo?>' , '<?php echo $mensaje?>', '<?php echo $activo?>')" class="btn green">
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
<a class="btn green darken-3" href="javascript:open()"><i class="material-icons left">add</i>Agregar</a>
<div id="frmbloques" class="modal">
	<div class="modal-content">
		<h4 class="center">Agregar Notificación</h4>
		<div class="row">
			<div class="input-field col s12 l6">
				<i class="material-icons prefix">today</i>
				<input id="txtcuota" type="text">
				<label for="txtcuota">Titulo</label>
			</div>
			</div>
			<div class="row">
        <div class="input-field col s12 l12">
          <i class="material-icons prefix">description</i>
          <input id="txtdescripcion" type="text" class="validate">
          <label for="txtdescripcion">Mensaje</label>
        </div>				
			</div>		
	</div>
	<div class="modal-footer">
		<a id="p" href="javascript:guardarnuevo()" class="waves-effect waves-green btn green">Guardar</a>      	
	</div>
</div>
<div id="frmbloques2" class="modal">
	<div class="modal-content">
		<h4 class="center">Agregar Notificación</h4>
		<div class="row">
			<div class="input-field col s12 l6">
				<i class="material-icons prefix">today</i>
				<input id="txtcuota2" type="text">
				<label for="txtcuota2">Titulo</label>
			</div>
            <div class="input-field col s12 l6">
			<div class="switch col s12 l12">
    <label>
      Desactivar
      <input id="esactivo" type="checkbox">
      <span class="lever"></span>
      Activar
    </label>
  </div>
			</div>
			</div>
			<div class="row">
        <div class="input-field col s12 l12">
          <i class="material-icons prefix">description</i>
          <input id="txtdescripcion2" type="text" class="validate">
          <label for="txtdescripcion2">Mensaje</label>
        </div>				
			</div>		
	</div>
	<div class="modal-footer">
		<a id="p2" href="javascript:guardareditar()" class="waves-effect waves-green btn green">Guardar</a>      	
	</div>
</div>
<script src="./recursos/js/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.4/js/dataTables.responsive.min.js"></script>
<script src="<?php echo $urlweb?>recursos/js/sweetalert2.min.js"></script>
<script>	
$(document).ready( function () {
    $('#tbldata').DataTable({
    	responsive: true
    });
});	
function guardarnuevo(){
var cuota = $("#txtcuota").val(),
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
		url:"<?php echo $urlweb?>servicios/ws_<?php echo $idpanel?>.php?accion=agregar",
		type: 'POST',
		data:{"cuota":cuota, "descripcion":descripcion},
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
				swal(retorno);
                if(retorno.type == "success"){
				$('#frmbloques').modal('close');
				$("#tbldata tbody").append(retorno.htmldata);
                } 				
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
function guardareditar(idcuota){
	var cuota = $("#txtcuota2").val(),
	descripcion = $("#txtdescripcion2").val(),
	precio = $("#esactivo").prop("checked") ? 1 : 0;
swal({
		title:"¿Datos Correctos?",
		text: "¿Todos los datos ingresados estan bien",
		type: "warning",
		showCancelButton: true,
		closeOnConfirm: false,
		showLoaderOnConfirm: true
	}).then(function(){
		$.ajax({
			url:"<?php echo $urlweb?>servicios/ws_<?php echo $idpanel?>.php?accion=editar",
			type: 'POST',
			data:{"cuota":cuota, "descripcion":descripcion, "precio":precio, "idcuota":idcuota},
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
				 $('#frmbloques2').modal('close');
				 $("#rw-" + idcuota).fadeOut("1000",function(){
                    $("#rw-" + idcuota).html(data.htmldata);
                    $("#rw-" + idcuota).fadeIn("1000");
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
function nuevo(idcuota, cuota, descripcion, precio){
	 $("#txtcuota2").val(cuota);
	 $("#txtdescripcion2").val(descripcion);
	$("#esactivo").prop("checked", precio==1 ? true : false);
 	$('#frmbloques2').modal('open');
 	$("#txtcuota").focus();	
$('#p2').attr("href","javascript:guardareditar('"+idcuota+"')");
}

function open(){
	 $("#txtcuota").val("");
	 $("#txtdescripcion").val("");
	 $("#txtprecio").val("");
 	$('#frmbloques').modal('open');
 	$("#txtcuota").focus();	
}

</script>

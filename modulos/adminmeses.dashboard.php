<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
?>
<div class="container center">
<h4><b>Administración de Cuotas a Pagar</b></h4>
</div>
<table id="tbldata" class="display nowrap centered" width="100%">
    <thead>
		<tr>
            <th class="center">idcuota</th>
            <th class="center">Cuota</th>
			<th class="center">Descripción</th>	
			<th class="center">Precio</th>	
			<th class="center">Editar</th>		
		</tr>
    </thead>
    <tbody>
<?php
					$strsql = 'SELECT idcuota, cuota, descripcion, precio FROM cuotas ORDER BY fecha_creacion DESC';
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($idmes, $mes, $descripcion, $precio);
						while($stmt->fetch()){
						?>
							<tr id="rw-<?php echo $idmes?>" >
								<td><?php echo $idmes?></td>
								<td><?php echo $mes?></td>
								<td><?php echo $descripcion?></td>
								<td><?php echo number_format($precio, 2, '.', ',')?></td>
		<td class="center">
			<a href="javascript:nuevo('<?php echo $idmes?>', '<?php echo $mes?>' , '<?php echo $descripcion?>', '<?php echo $precio?>')" class="btn green">
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
		<h4 class="center">Agregar Cuota</h4>
		<div class="row">
			<div class="input-field col s12 l6">
				<i class="material-icons prefix">today</i>
				<input id="txtcuota" type="text">
				<label for="txtcuota">Nombre de la cuota</label>
			</div>
            <div class="input-field col s12 l6">
            	<i class="material-icons prefix">attach_money</i>
				<input id="txtprecio" type="number">
				<label for="txtprecio">Precio de la cuota</label>
			</div>
			</div>
			<div class="row">
        <div class="input-field col s12 l12">
          <i class="material-icons prefix">description</i>
          <input id="txtdescripcion" type="text" class="validate">
          <label for="txtdescripcion">Descripción de la cuota</label>
        </div>				
			</div>		
	</div>
	<div class="modal-footer">
		<a id="p" href="javascript:guardarnuevo()" class="waves-effect waves-green btn green">Guardar</a>      	
	</div>
</div>
<div id="frmbloques2" class="modal">
	<div class="modal-content">
		<h4 class="center">Agregar Cuota</h4>
		<div class="row">
			<div class="input-field col s12 l6">
				<i class="material-icons prefix">today</i>
				<input id="txtcuota2" type="text">
				<label for="txtcuota2">Nombre de la cuota</label>
			</div>
            <div class="input-field col s12 l6">
            	<i class="material-icons prefix">attach_money</i>
				<input id="txtprecio2" type="number">
				<label for="txtprecio2">Precio de la cuota</label>
			</div>
			</div>
			<div class="row">
        <div class="input-field col s12 l12">
          <i class="material-icons prefix">description</i>
          <input id="txtdescripcion2" type="text" class="validate">
          <label for="txtdescripcion2">Descripción de la cuota</label>
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
	descripcion = $("#txtdescripcion").val(),
	precio = $("#txtprecio").val();
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
		data:{"cuota":cuota, "descripcion":descripcion, "precio":precio},
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
	precio = $("#txtprecio2").val();
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
	 $("#txtprecio2").val(precio);
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

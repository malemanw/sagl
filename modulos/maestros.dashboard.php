<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
?>
<div class="container center">
<h4><b>Administración de Maestros</b></h4>
</div>
<table id="tbldata" class="display">
	<thead>
		<tr>
            <th class="center">Cédula</th>
            <th class="center">Nombre Completo</th>
			<th class="center">Correo</th>
			<th class="center"># Teléfono</th>
			<th class="center">Fecha Nacimiento</th>	
			<th class="center">Residencia</th>	
		</tr>
	</thead>
	<tbody id="t-body">
		<?php
					$strsql = 'SELECT `idmaestro`, `nombre`, `fecha_nac`, `residencia`, `telefono`, `correo` FROM `maestros`';
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($idmaestro, $nombre, $fecha_nac, $residencia, $telefono, $correo);
						while($stmt->fetch()){
						?>
							<tr id="rw-<?php echo $idmaestro?>" >
							<td class="center"><?php echo $idmaestro?></td>
								<td class="center"><?php echo $nombre?></td>
								<td><?php echo $correo?></td>
								<td><?php echo $telefono?></td>
								<td><?php echo $fecha_nac?></td>
								<td><?php echo $residencia?></td>                            
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
		<h4 class="center">Agregar Maestro</h4>
		<form class="row" action="javascript:guardarnuevo()">
			<div class="input-field col s12 l6">
				<i class="material-icons prefix">perm_identity</i>
				<input id="txtcedula" type="text">
				<label for="txtcedula">Número de Cédula</label>
			</div>
			<div class="input-field col s12 l6">
				<i class="material-icons prefix">face</i>
				<input id="txtnombre" type="text">
				<label for="txtnombre">Nombre Completo</label>
			</div>
			<div class="input-field col s12 l6">
            	<i class="material-icons prefix">email</i>
				<input id="txtcorreo" type="text">
				<label for="txtcorreo">Correo</label>
			</div>
            <div class="input-field col s12 l6">
            	<i class="material-icons prefix">directions</i>
				<input id="txtresidencia" type="text">
				<label for="txtresidencia">Residencia</label>
			</div>
						<div class="row">
        <div class="input-field col s12 l6">
          <i class="material-icons prefix">local_phone</i>
          <input id="txttelefono" type="text">
          <label for="txttelefono"># Télefono</label>
        </div>		
        <div class="input-field col s12 l6">
          <i class="material-icons prefix">date_range</i>
          <input id="txtfecha_final" type="text" class="validate">
          <label for="txtfecha_final">Fecha Nacimiento</label>
        </div>	        		
			</div>	
		</form>
	</div>
	<div class="modal-footer">
		<a id="p" href="javascript:guardarnuevo()" class="waves-effect waves-green btn green">Guardar</a>      	
	</div>
</div>
<script src="./recursos/js/datatables.min.js"></script>
<script src="<?php echo $urlweb?>recursos/js/sweetalert2.min.js"></script>
<script>
$(function() {
        $( "#txtfecha_final" ).datepicker({
            changeMonth: true,
            changeYear: true, 
            dateFormat: "yy-mm-dd",
            yearRange: "1900:2100" 
        });
        $( "#txtfecha_final" ).datepicker($.datepicker.regional[ "es" ]);
    });	
$(document).ready( function () {
$('#tbldata').DataTable({
responsive: true
});
});		 
	function guardarnuevo(){
		var cedula = $("#txtcedula").val(),
			nombre = $("#txtnombre").val(),
			correo = $("#txtcorreo").val(),
			residencia = $("#txtresidencia").val(),
			telefono = $("#txttelefono").val(),
			fecha_final = $("#txtfecha_final").val();
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
				data:{"cedula":cedula, "nombre":nombre, "correo":correo, "residencia":residencia,"telefono":telefono,"fecha_final":fecha_final},
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
	function nuevo(){
		$("#txtcedula").focus();
        $("#txtcedula").val("");
        $("#txtnombre").val("");
		$("#txtcorreo").val("");
		$("#txtresidencia").val("");
		$("#txttelefono").val("");
		$("#txtfecha_final").val("");
		$('#frmbloques').modal('open');
	}

</script>

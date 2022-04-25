<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
?>
<div class="container center">
<h4><b>Administración de Clases</b></h4>
</div>
<table id="tbldata" class="display">
    <thead>
		<tr>
            <th class="center">idclase</th>
            <th class="center">Nombre</th>
			<th class="center">Descripción</th>	
			<th class="center">Modalidad</th>	
			<th class="center">Editar</th>		
		</tr>
    </thead>
    <tbody>
	<?php
        global $funciones;
if($funciones->login_admin()){      
					$strsql = 'SELECT `idclase`, `nombre`, `observacion`, `modalidad`, `semestre` FROM `clases`';
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($idmes, $mes, $descripcion, $precio, $semestre);
						while($stmt->fetch()){
						?>
							<tr id="rw-<?php echo $idmes?>" >
								<td><?php echo $idmes?></td>
								<td><?php echo $mes?></td>
								<td><?php echo $descripcion?></td>
								<td><?php echo $precio?></td>
		<td class="center">
			<a href="javascript:nuevo('<?php echo $idmes?>', '<?php echo $mes?>' , '<?php echo $descripcion?>', '<?php echo $precio?>', '<?php echo $semestre?>')" class="btn green">
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
		<h4 class="center">Agregar Clase</h4>
		<div class="row">
			<div class="input-field col s12 l4">
				<i class="material-icons prefix">assignment</i>
				<input id="txtcuota" type="text">
				<label for="txtcuota">Nombre de la Clase</label>
			</div>
            <div class="input-field col s12 l4">
			<span>Modalidad:</span>
         <select id="txtprecio" name="txtprecio">
            <option value="ESPAÑOL">ESPAÑOL</option>
            <option value="BILINGÜE">BILINGÜE</option>
            <option value="ESCUELA">ESCUELA</option>
         </select>
			</div>
			<div class="input-field col s12 l4">
			<span>Periodo:</span>
         <select id="txtperiodo" name="txtperiodo">
		 <option value="0">Anual</option>
            <option value="1">I Semestre</option>
            <option value="2">II Semestre</option>
         </select>
			</div>
			</div>
			<div class="row">
        <div class="input-field col s12 l12">
          <i class="material-icons prefix">description</i>
          <input id="txtdescripcion" type="text" class="validate">
          <label for="txtdescripcion">Descripción de la clase</label>
        </div>				
			</div>		
	</div>
	<div class="modal-footer">
		<a id="p" href="javascript:guardarnuevo()" class="waves-effect waves-green btn green">Guardar</a>      	
	</div>
</div>
<div id="frmbloques2" class="modal">
	<div class="modal-content">
		<h4 class="center">Editar Clase</h4>
		<div class="row">
			<div class="input-field col s12 l4">
				<i class="material-icons prefix">today</i>
				<input id="txtcuota2" type="text">
				<label for="txtcuota2">Nombre de la Clase</label>
			</div>
            <div class="input-field col s12 l4">
			<span>Modalidad:</span>
         <select id="txtprecio2" name="txtprecio2">
		 <option value="ESPAÑOL">ESPAÑOL</option>
            <option value="BILINGÜE">BILINGÜE</option>
            <option value="ESCUELA">ESCUELA</option>
         </select>
			</div>
			<div class="input-field col s12 l4">
			<span>Periodo:</span>
         <select id="txtperiodo2" name="txtperiodo2">
		 <option value="0">Anual</option>
            <option value="1">I Semestre</option>
            <option value="2">II Semestre</option>
         </select>
			</div>
			</div>
			<div class="row">
        <div class="input-field col s12 l12">
          <i class="material-icons prefix">description</i>
          <input id="txtdescripcion2" type="text" class="validate">
          <label for="txtdescripcion2">Descripción de la Clase</label>
        </div>				
			</div>		
	</div>
	<div class="modal-footer">
		<a id="p2" href="javascript:guardareditar()" class="waves-effect waves-green btn green">Guardar</a>      	
	</div>
</div>
<?php
        }else{
?>
      <h2>Ud no tiene permisos </h2>      
<?php
}
?>
<script src="./recursos/js/datatables.min.js"></script>
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
	periodo = $("#txtperiodo").val(),
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
		data:{"cuota":cuota, "descripcion":descripcion, "precio":precio, "periodo":periodo},
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
	periodo = $("#txtperiodo2").val(),
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
			data:{"cuota":cuota, "descripcion":descripcion, "precio":precio, "idcuota":idcuota, "periodo":periodo},
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
function nuevo(idcuota, cuota, descripcion, precio, periodo){
	if(periodo==0){
		$nombre="Anual";
	}else if(periodo==1){
		$nombre="I Semestre";
	}else if(periodo==2){
		$nombre="II Semestre";
	}
	 $("#txtcuota2").val(cuota);
	 $("#txtdescripcion2").val(descripcion);
	 $("#txtprecio2").prepend("<option value="+precio+">"+precio+"</option>");
	 $('#txtprecio2').prop('selectedIndex',0);
	 $("#txtperiodo2").prepend("<option value="+periodo+">"+$nombre+"</option>");
	 $('#txtperiodo2').prop('selectedIndex',0);
 	$('#frmbloques2').modal('open');
 	$("#txtcuota").focus();	
$('#p2').attr("href","javascript:guardareditar('"+idcuota+"')");
}

function open(){
	 $("#txtcuota").val("");
	 $("#txtdescripcion").val("");
 	$('#frmbloques').modal('open');
 	$("#txtcuota").focus();	
}

</script>

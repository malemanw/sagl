<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
?>
<div class="container center">
<h4><b>Administración de Cuotas por Año Escolar</b></h4>
</div>
<div class="row">
  <div class="col s12 l6">
<blockquote><h5  style="font-size: large;"><b>Seleccione el Año Escolar</b></h5></blockquote>  
<div class="input-field">
<select id="seleccionaño" name="seleccionaño" style="display: none;">
<option value="" disabled selected>Seleccione una Opción</option>
	<?php
			$strsql = "SELECT idaño, nombre FROM year_escolar ORDER BY fecha_creacion DESC";
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($idaño, $descripcion);
						while($stmt->fetch()){
						?>
						   <option value="<?php echo $idaño ?>"><?php echo $descripcion ?></option>
  				<?php
						}
						?>
</select>
</div>	
  <?php
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
  </div>
</div>
<div class="row">
<div class="col s12 l5">
	<blockquote><h5  style="font-size: large;"><b>Cuotas agregadas al año escolar</b></h5></blockquote> 	
<select id="seleccionados-si" multiple="multiple" style="width: 100%; height: 400px;">
<option value="" disabled>Aún no ha seleccionado un año escolar..</option>
</select>
</div>

	<div id="controles" class="col s12 l2 center">
  <a href="javascript:eliminar()" class="btn-floating btn-large waves-effect waves-light red margen-controles"><i class="material-icons">navigate_next</i></a>
  <a href="javascript:agregar()" class="btn-floating btn-large waves-effect waves-light red margen-controles"><i class="material-icons">navigate_before</i></a>
	</div>
  <div class="col s12 l5">
<blockquote><h5  style="font-size: large;"><b>Cuotas no agregadas al año escolar</b></h5></blockquote> 	
<select id="seleccionados-no" multiple="multiple" style="width: 100%; height: 400px;">
<option value="" disabled>Aún no ha seleccionado un año escolar..</option>	
</select>
</div>	
  </div>
  <ul>
  <li><b>Para Windows:</b> Mantenga presionado el botón de control (ctrl) para seleccionar múltiples opciones.</li>
  <li><b>Para Mac:</b> Mantenga presionado el botón de comando para seleccionar múltiples opciones.</li>
</ul>
<script src="./recursos/js/datatables.min.js"></script>
<script src="<?php echo $urlweb?>recursos/js/sweetalert2.min.js"></script>
<script>	

var valor =[];
var valor_eliminar = [];
$(function enviarcorreos(){
$('select#seleccionados-no').on('change',function(){
    valor = [$(this).val()];
});
$('select#seleccionados-si').on('change',function(){
    valor_eliminar = [$(this).val()];
});

});
function agregar(){
	var datos = new FormData();
	var anio = $( "#seleccionaño option:selected" ).val();
var arv = valor.toString();
		datos.append("action", "update");
        datos.append("arv", arv);
        datos.append("anio", anio);
swal({
			title:"¿Continuar?",
			text: "Al continuar se agregarán las cuotas seleccionadas al año escolar actual",
			type: "info",
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: true
}).then(function(){
			$.ajax({
				        type:'POST', 
                        data: 'formData',
                        async: false,
                        cache: false,
                        contentType: false,
                        processData: false,
                        url:"<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=agregar",
                        data:datos,
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
			$("#seleccionados-si").html(retorno.htmldata_si);
			$("#seleccionados-no").html(retorno.htmldata_no);
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
function eliminar(){
	var datos = new FormData();
	var anio = $( "#seleccionaño option:selected" ).val();
var arv = valor_eliminar.toString();
		datos.append("action", "update");
        datos.append("arv", arv);
        datos.append("anio", anio);
swal({
			title:"¿Continuar?",
			text: "Al continuar se agregarán las cuotas seleccionadas al año escolar actual",
			type: "info",
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: true
}).then(function(){
			$.ajax({
				        type:'POST', 
                        data: 'formData',
                        async: false,
                        cache: false,
                        contentType: false,
                        processData: false,
                        url:"<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=eliminar",
                        data:datos,
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
			$("#seleccionados-si").html(retorno.htmldata_si);
			$("#seleccionados-no").html(retorno.htmldata_no);
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
$("#seleccionaño").change(function () {

//$('#cbx_localidad').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');

$("#seleccionaño option:selected").each(function () {
	idaño = $(this).val();
	$.post("<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=selectanio", { idaño: idaño }, function(data){
			var retorno = data;
			$("#seleccionados-si").html(retorno.htmldata_si);
			$("#seleccionados-no").html(retorno.htmldata_no);
	});            
});
})
$('#seleccionaño').material_select();
$('#tbldata').DataTable({
responsive: true
});

</script>

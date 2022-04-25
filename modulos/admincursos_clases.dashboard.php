<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
?>
<div class="container center">
<h4><b>Administración de los cursos adémicos</b></h4>
</div>
<?php
        global $funciones;
if($funciones->login_admin()){ ?>
<div class="row">
  <div class="col s12 l6">
<blockquote><h5  style="font-size: large;"><b>Seleccione el Año Escolar</b></h5></blockquote>  
<div class="input-field">
<select id="seleccion_año" name="seleccion_año" style="display: none;">
<?php
			$strsql = "SELECT `idaño`, `nombre` FROM `year_escolar` WHERE activo=1";
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
  <div class="col s12 l6">
<blockquote><h5  style="font-size: large;"><b>Seleccione el Curso Académico</b></h5></blockquote>  
<div class="input-field">
<select id="seleccionaño" name="seleccionaño" style="display: none;">
<option value="" disabled selected>Seleccione una Opción</option>
	<?php
			$strsql = "SELECT idcurso, nombre_curso FROM cursos ORDER BY fecha_creacion DESC";
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
	<blockquote><h5  style="font-size: large;"><b>Listado de Clases</b></h5></blockquote> 	
<select id="seleccionados-si" multiple="multiple" style="width: 100%; height: 400px;">
<option value="" disabled>Aún no ha seleccionado un grado académico..</option>
</select>
</div>

	<div id="controles" class="col s12 l2 center">
  <a href="javascript:agregar()" class="btn-floating btn-large waves-effect waves-light red margen-controles"><i class="material-icons">navigate_next</i></a>
  <a href="javascript:eliminar()" class="btn-floating btn-large waves-effect waves-light red margen-controles"><i class="material-icons">navigate_before</i></a>
	</div>
  <div class="col s12 l5">
<blockquote><h5  style="font-size: large;"><b>Clases agregadas al grado escolar</b></h5></blockquote> 	
<select id="seleccionados-no" multiple="multiple" style="width: 100%; height: 400px;">
<option value="" disabled>Aún no ha seleccionado un grado académico..</option>	
</select>
</div>	
  </div>
  <ul>
  <li><b>Para Windows:</b> Mantenga presionado el botón de control (ctrl) para seleccionar múltiples opciones.</li>
  <li><b>Para Mac:</b> Mantenga presionado el botón de comando para seleccionar múltiples opciones.</li>
</ul>
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

var valor =[];
var valor_eliminar = [];
$(function enviarcorreos(){
$('select#seleccionados-no').on('change',function(){
    valor_eliminar = [$(this).val()];
});
$('select#seleccionados-si').on('change',function(){
    valor = [$(this).val()];
});

});
function agregar(){
	var datos = new FormData();
	var anio = $( "#seleccionaño option:selected" ).val();
	var anio_2 = $( "#seleccion_año option:selected" ).val();
var arv = valor.toString();
		datos.append("action", "update");
        datos.append("arv", arv);
        datos.append("anio", anio);
		datos.append("anio2", anio_2);
swal({
			title:"¿Continuar?",
			text: "Al continuar se agregarán las clases seleccionadas al grado escolar actual",
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
			$("#seleccionados-no").html(retorno.htmldata_si);
			$("#seleccionados-si").html(retorno.htmldata_no);
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
	var anio_2 = $( "#seleccion_año option:selected" ).val();
var arv = valor_eliminar.toString();
		datos.append("action", "update");
        datos.append("arv", arv);
        datos.append("anio", anio);
		datos.append("anio2", anio_2);
swal({
			title:"¿Continuar?",
			text: "Al continuar se agregarán las clases seleccionadas al grado escolar actual",
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
				$("#seleccionados-no").html(retorno.htmldata_si);
			$("#seleccionados-si").html(retorno.htmldata_no);
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
	var anio2 = $( "#seleccion_año option:selected" ).val();
	$.post("<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=selectanio", { idaño: idaño, anio2: anio2 }, function(data){
			var retorno = data;
			$("#seleccionados-si").html(retorno.htmldata_si);
			$("#seleccionados-no").html(retorno.htmldata_no);
	});            
});
})
$('#seleccionaño').material_select();
$('#seleccion_año').material_select();
$('#tbldata').DataTable({
responsive: true
});

</script>

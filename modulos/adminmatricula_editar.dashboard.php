<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
$idusuario=$_GET['idusuario'];
$accion=$_GET['accion'];
global $funciones;
if($funciones->login_estado()){   
?>
<h3 class="center grey-text">Boleta de Matrícula Re-Ingreso</h3>
<div class="row">
  <div class="col s12 l6">
<blockquote><h5  style="font-size: large;"><b>Seleccione el Año Escolar para visualizar los alumnos matriculados</b></h5></blockquote>  
<div class="input-field">
<select id="seleccionaño" name="seleccionaño" style="display: none;">
<option value="" disabled selected>Seleccione un año escolar</option>
	<?php
			$strsql = "SELECT `idaño`, `nombre`, `descripcion` FROM `year_escolar` where activo=1 ORDER BY fecha_creacion DESC";
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($idaño, $nombre, $descripcion);
						while($stmt->fetch()){
						?>
						   <option value="<?php echo $idaño ?>"><?php echo $nombre." - ".$descripcion ?></option>
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
<div id="contenedor_tabla">
	      <table id="tbldata" class="display nowrap centered" style="width:100%;">
        <thead>
          <tr>
              <th>Expediente</th>
              <th>Nombre Completo</th>
              <th>Curso Matriculado</th>
              <th>Sección</th>
              <th>Año Militar</th>
              <th>Matricular</th>
          </tr>
        </thead>
      </table>
</div>
  <div id="modal1" class="modal">
<div id="DatosAcademicos" class="bordes">
   <h3 id="DatosAcademicos" class="header2">Datos Académicos</h3>
   <h5 id="nombre" class="center">Nombre</h5>
   <br>
   <div class="row">
      <div class="col s12 l4">
         <span>Matricular en:</span>
         <select id="cmb_curso" name="cmb_curso">
            <?php
			$strsql = "SELECT `idcurso`, `nombre_curso` FROM `cursos`";
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($idcurso, $nombre_curso);
						while($stmt->fetch()){
						?>
				<option value="<?php echo $idcurso ?>"><?php echo $nombre_curso ?></option>
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
      <div class="col s12 l4">
         <span>Sección:</span>
         <select id="cmb_seccion" name="cmb_seccion">
<?php
			$strsql = "SELECT `idseccion`, `nombre_seccion` FROM `secciones`";
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($idseccion, $nombre_seccion);
						while($stmt->fetch()){
						?>
				<option value="<?php echo $idseccion ?>"><?php echo $nombre_seccion ?></option>
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
      <div class="col s12 l4">
         <span>Año Escolar:</span>
         <select id="cmb_year_escolar" name="cmb_year_escolar">
<?php
			$strsql = "SELECT `idaño`, `nombre`FROM `year_escolar` where activo=1 ORDER BY fecha_creacion DESC";
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($idaño, $nombre);
						while($stmt->fetch()){
						?>
				<option value="<?php echo $idaño ?>"><?php echo $nombre ?></option>
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
   <div class="row">
   		<div class="col l8 s12">
   			         <span>Año militar:</span>
         <select id="cmb_militar" name="cmb_militar">
<?php
			$strsql = "SELECT `idanio_militar`, `descripcion` FROM `anios_militares`";
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($idanio_militar, $descripcion);
						while($stmt->fetch()){
						?>
				<option value="<?php echo $idanio_militar ?>"><?php echo $descripcion ?></option>
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
      <div class="row">
   <h6 class="header2"></h6>
   <br>      	
         <div class="col s12 l6">
            <span>Tiene Beca</span>
            <select id="cmb_tienebeca" name="cmb_tienebeca">
               <option value="0">No</option>
               <option value="1">Si</option>
            </select>
         </div>
         <div class="col s12 l6">
            <span>Es interno</span>
            <select id="cmb_esinterno" name="cmb_esinterno">
               <option value="0">No</option>
               <option value="1">Si</option>
            </select>
         </div>         
      </div>  
	  <h6 class="header2"></h6>
	  <div class="row">
   <div class="col s12 l12 center">
   <div>
   <b><label for="">Fotografía</label></b>
   <div class="switch">
    <label>
      Pendiente
      <input type="checkbox" name="chk_fotografia" id="chk_fotografia">
      <span class="lever"></span>
      Entregado
    </label>
  </div>
  <div>
 <b><label for="">Partida de Nacimiento</label></b>
   <div class="switch">
    <label>
      Pendiente
      <input type="checkbox" name="chk_partida" id="chk_partida">
      <span class="lever"></span>
      Entregado
    </label>
  </div>
  </div>
  <div>
 <b><label for="">Certificación de Estudios</label></b>
   <div class="switch">
    <label>
      Pendiente
      <input type="checkbox" name="chk_certificacion" id="chk_certificacion">
      <span class="lever"></span>
      Entregado
    </label>
  </div>
  </div>
   </div>
   </div>
   </div>		
   		<input id="txtexpediente" type="hidden" name="txtexpediente">
<a id="send" href="javascript:guardar()" class="btn cyan waves-effect waves-light">Guardar<i class="material-icons right">send</i></a>  
  </div>
<?php
}else{
?>
<h2 class="center">Ud no tiene permisos o su cuenta ha sido desactivada, comuniquese con el administrador.</h2> 
<?php
}
?>
<script src="./recursos/js/datatables.min.js"></script>
<script src="<?php echo $urlweb?>recursos/js/sweetalert2.min.js"></script>
<script>
$(document).ready( function () {

});	
	var listar = function(){
		var idaño = $("#seleccionaño").val();
		var table = $('#tbldata').DataTable( {
	responsive: true,
	destroy:true,
    "ajax": {
    	"url": "<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=selectanio",
    	"method": "POST",
    	"data" : {
            "idaño" : idaño
        }
    },
   "columns":[
   	{"data":"idexpediente"},
   	{"data":"nombre_completo"},
   	{"data":"nombre_curso"},
   	{"data":"nombre_seccion"},
   	{"data":"descripcion"},
   	{"defaultContent": "<a href='#modal1' class='obtener btn green'><i class='material-icons'>assignment_turned_in</i></a>"}
   ],
   "language": idioma_español
});

		obtener_data("#tbldata tbody", table);
	}

	var obtener_data = function(tbody, table){
		$(tbody).on("click", "a.obtener", function(){
			var data = table.row( $(this).parents("tr")).data();
			if (typeof data !== 'undefined') {
  			console.log(data);
			var idexpediente = $("#txtexpediente").val(data.idexpediente);
			$("#nombre").text(data.nombre_completo);
}

				
		});
	}

var idioma_español = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
}		
var valor =[];




$("#seleccionaño").change(function () {
listar();
})

$(function() {
    $("ul.tabs").tabs({
        swipeable: true
    });
$('#seleccionaño').material_select();    
    $("#txtfechanac").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        yearRange: "1900:2100"
    });
    $("#txtfechanac").datepicker($.datepicker.regional["es"]);
});

function guardar() {
//Datos Academicos    
var idexpediente = $("#txtexpediente").val(),
	curso = $("#cmb_curso").val(),
    seccion = $("#cmb_seccion").val(),
    año_escolar = $("#cmb_year_escolar").val(),
    añomilitar = $("#cmb_militar").val(),
    beca = $("#cmb_tienebeca").val(),
    interno = $("#cmb_esinterno").val();

        var datos = new FormData();
        //enviar Datos Alumnos
        datos.append("action", "update");
        datos.append("idexpediente", idexpediente);
        datos.append("curso", curso);
        datos.append("seccion", seccion);
        datos.append("año_escolar", año_escolar);
        datos.append("añomilitar", añomilitar);
        datos.append("beca", beca);
        datos.append("interno", interno);
            swal({
                title: "¿Datos Correctos?",
                text: "¿Todos los datos ingresados estan bien?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }).then(function() {
                $.ajax({
                    type: 'POST',
                    data: 'formData',
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    url: "<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=re_matricular",
                    data: datos,
                    error: function() {
                        setTimeout(function() {
                            swal({
                                title: "Error!",
                                text: "Tiempo Fuera, No se procesaron los datos",
                                type: "error",
                                showConfirmButton: true
                            });
                        }, 1000);
                    },
                    success: function(data) {
                        try { 
                    var retorno = data;
                    swal(retorno);
                    $('#modal1').modal('close');
                        } catch (err) {
                            swal({
                                title: "Error!",
                                text: err.message,
                                type: "error",
                                showConfirmButton: true
                            });
                        }
                    },
                    timeout: 5000
                });

            });
}

</script>

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
<h3 class="center grey-text">Administrador de Pagos al Día</h3>
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
  <div class="col s12 l6">
  <h5>Reiniciar los pagos al día de los estudiantes</h5>
  <a href="javascript:reiniciar()" class="btn red">Reiniciar
										<i class="material-icons">autorenew</i>
									</a>
  </div>
</div>
<div style="font-size: 13px;" id="contenedor_tabla">
	      <table id="tbldata" class="display nowrap centered" style="width:100%;">
        <thead>
          <tr>
              <th>Expediente</th>
              <th>Nombre Completo</th>
              <th>Curso Matriculado</th>
              <th>Año Militar</th>
			  <th>Estado</th>
              <th>Poner en Día</th>
			  <th>Poner en Mora</th>
          </tr>
        </thead>
      </table>
</div>
<input id="txtexpediente" type="hidden" name="txtexpediente">
<?php
}else{
?>
<h2 class="center">Ud no tiene permisos o su cuenta ha sido desactivada, comuniquese con el administrador.</h2> 
<?php
}
?>
<script src="./recursos/js/print/datatables.min.js"></script>

 <!-- searchPanes   -->
 <script src="https://cdn.datatables.net/searchpanes/1.1.0/js/dataTables.searchPanes.min.js"></script>
    <!-- select -->
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script> 
<script>
$(document).ready( function () {

});	
	var listar = function(){
		var idaño = $("#seleccionaño").val();
		var table = $('#tbldata').DataTable( {
	responsive: true,
	destroy:true,
	dom: 'PBfrtip',
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
   	{"data":"descripcion"},
   	{"data":"al_dia"},
   	{"defaultContent": "<a href='javascript:al_dia()' class='obtener btn green'><i class='material-icons'>assignment_turned_in</i></a>"},
	   {"defaultContent": "<a href='javascript:mora()' class='obtener btn red'><i class='material-icons'>assignment_turned_in</i></a>"}
   ],
   "language": idioma_español,
   searchPanes:{
                    cascadePanes:true,
                    dtOpts:{
                        dom:'tp',
                        paging:'true',
                        pagingType:'simple',
                        searching:false
                    }
                }
});

		obtener_data("#tbldata tbody", table);
	}

	var obtener_data = function(tbody, table){
		$(tbody).on("click", "a.obtener", function(){
			var data = table.row( $(this).parents("tr")).data();
			if (typeof data !== 'undefined') {
  			console.log(data);
			var idexpediente = $("#txtexpediente").val(data.idexpediente);
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

function al_dia() {
	idexpediente = $("#txtexpediente").val();
	año_escolar = $("#seleccionaño").val();
	idusuario = '<?php echo $_SESSION["idusuario"] ?>';
	$.post("<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=al_dia", { idexpediente: idexpediente, año_escolar: año_escolar, idusuario:idusuario}, function(data){
			try{
			console.log(data);
			if(data.type=="success"){
				Materialize.toast(data.text, 4000);
				listar();
			}else{
				Materialize.toast(data.text, 4000);
			}
		}
		catch(err){
			alert(err.message);
		}
	}); 

}
function mora() {
	idexpediente = $("#txtexpediente").val();
	año_escolar = $("#seleccionaño").val();
	idusuario = '<?php echo $_SESSION["idusuario"] ?>';
	$.post("<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=mora", { idexpediente: idexpediente, año_escolar: año_escolar, idusuario:idusuario}, function(data){
			try{
			console.log(data);
			if(data.type=="success"){
				Materialize.toast(data.text, 4000);
				listar();
			}else{
				Materialize.toast(data.text, 4000);
			}
		}
		catch(err){
			alert(err.message);
		}
	}); 

}

function reiniciar(){
	año_escolar = $("#seleccionaño").val();
	$.post("<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=reiniciar", {año_escolar: año_escolar}, function(data){
			try{
			console.log(data);
			if(data.type=="success"){
				Materialize.toast(data.text, 4000);
				listar();
			}else{
				Materialize.toast(data.text, 4000);
			}
		}
		catch(err){
			alert(err.message);
		}
	}); 
}
</script>

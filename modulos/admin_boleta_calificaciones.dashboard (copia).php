<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
global $funciones;
$idaño=$_GET['idaño'];
if($funciones->login_estado()){   
?>
<div class="container center">
<h4><b>Imprimir Boleta de Calificaciones</b></h4>
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
  <div class="col s12 l6">
<blockquote><h5  style="font-size: large;"><b>Seleccione la modalidad</b></h5></blockquote>  
<div class="input-field">
<select id="modalidad" name="modalidad" style="display: none;">
<option value="" disabled selected>Seleccione una Opción</option>
<option value="0">ANUAL</option>
<option value="1">I SEMESTRE</option>
<option value="2">II SEMESTRE</option>
</select>
</div>  
  </div>
</div>
<div id="contenedor_tabla">
        <table id="tbldata" class="display centered" style="width:100%;">
        <thead>
          <tr>
              <th>Expediente</th>
              <th>Nombre</th>
              <th>Curso</th>
              <th>Año Militar</th>
              <th>Boleta Calificaciones</th>
          </tr>
        </thead>
      </table>
</div> 
<?php
}else{
?>
<h2 class="center">Ud no tiene permisos o su cuenta ha sido desactivada, comuniquese con el administrador.</h2> 
<?php
}
?>
<script src="./recursos/js/datatables.min.js"></script>
<script src="./recursos/js/sha512.js"></script>
<script src="<?php echo $urlweb?>recursos/js/sweetalert2.min.js"></script>
<script>
  var listar = function(){
    var idaño = $("#seleccionaño").val();
    var table = $('#tbldata').DataTable( {
  responsive: true,
  destroy:true,
    "ajax": {
      "url": "<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=alumnos",
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
    {"defaultContent": "<a class='obtener btn red darken-2 disabled'><i class='material-icons'>assignment</i></a>"}
],    
   "language": idioma_español});
    obtener_data("#tbldata tbody", table);
  }

var obtener_data = function(tbody, table){
    $(tbody).on("click", "a.obtener", function(){
        var data = table.row( $(this).parents("tr")).data();
        if (typeof data !== 'undefined') {
        console.log(data); 
var idaño = $("#seleccionaño").val(); 
window.open("<?php echo $urlweb?>reportes/rpt_boleta_calificaciones.php?idexpediente="+data.idexpediente+"&idaño="+idaño,
  '_blank');                       
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
      
$(document).ready( function () {
    
$(function enviardatos(){
$('select#seleccionaño').on('change',function(){
  listar();
});

});  
$('#tabla_alumnos').DataTable({
responsive: true
});

$('select#modalidad').on('change',function(){
  $( 'a' ).removeClass( "disabled" );
}); 
}); 
$(function() {
  $(document).ready(function() {
$('#seleccionaño').material_select();
$('#modalidad').material_select();
});

});

</script>
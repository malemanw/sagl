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
<h4><b>Imprimir Cuadro No. 2</b></h4>
</div>
<div class="row">
  <div class="col s12 l6">
<blockquote><h5 id="focus" style="font-size: large;"><b>Elija las siguientes opciones:</b></h5></blockquote>  
<div class="input-field">
<select id="seleccionaño" name="seleccionaño" style="display: none;">
<option value="" disabled selected>Seleccione el año escolar</option>
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
<div class="input-field col s12 l6">
    <select id="selectsemestre" name="selectsemestre" style="display: none;">
    <option value="" disabled selected>Seleccione el nivel académico</option>
      <optgroup label="Básica - 3er Ciclo">
        <option value="0">Anual</option>
      </optgroup>
      <optgroup label="Media">
        <option value="1">I Semestre</option>
        <option value="2">II Semestre</option>
      </optgroup>
    </select>
  </div>
</div>
<div id="contenedor_tabla">
        <table id="tbldata" class="display centered" style="width:100%;">
        <thead>
          <tr>
              <th>Expediente</th>
              <th>DNI</th>
              <th>Nombre</th>
              <th>Curso</th>
              <th>Año Militar</th>
              <th>Cuadro No. 2</th>
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
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
 <!-- searchPanes   -->
 <script src="https://cdn.datatables.net/searchpanes/1.0.1/js/dataTables.searchPanes.min.js"></script>
    <!-- select -->
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script> 
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
    {"data":"rtn"},
    {"data":"nombre_completo"},
    {"data":"nombre_curso"},
    {"data":"descripcion"},
    {"defaultContent": "<a class='obtener btn green lighten-1'><i class='material-icons'>filter_2</i></a>"}
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
                },
           dom: 'PBfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'pdfHtml5',
            'print'
        ]
  });
    obtener_data("#tbldata tbody", table);
  }

var obtener_data = function(tbody, table){
    $(tbody).on("click", "a.obtener", function(){
        var data = table.row( $(this).parents("tr")).data();
        if (typeof data !== 'undefined') {
        console.log(data); 
var idaño = $("#seleccionaño").val(); 
var semestre = $("#selectsemestre").val();
if(semestre==null){
alert("Debe seleccionar un nivel académico");
document.getElementById("focus").scrollIntoView();
}else{
  window.open("<?php echo $urlweb?>reportes/rpt_cuadro2.php?idexpediente="+data.idexpediente+"&idaño="+idaño+"&semestre="+semestre,
  '_blank');   
}                    
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
  $('select#selectsemestre').on('change',function(){

});
$(function enviardatos(){
$('select#seleccionaño').on('change',function(){
  listar();
});

});  
$('#tabla_alumnos').DataTable({
responsive: true
});
}); 
$(function() {
  $(document).ready(function() {
$('#seleccionaño').material_select();
$('#selectsemestre').material_select();
});

});

</script>
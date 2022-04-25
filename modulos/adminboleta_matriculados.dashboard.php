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
<h4><b>Listado de Alumnos Matrículados</b></h4>
  <div class="preloader-wrapper big active" id="circulo">
    <div class="spinner-layer spinner-blue-only">
      <div class="circle-clipper left">
        <div class="circle"></div>
      </div><div class="gap-patch">
        <div class="circle"></div>
      </div><div class="circle-clipper right">
        <div class="circle"></div>
      </div>
    </div>
  </div>
</div>
<div class="row hide" id="contenido">
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
<div id="contenedor_tabla">
        <table id="tbldata" class="display  responsive nowrap centered" cellspacing="0" width="100%">
        <thead>
          <tr>
              <th>Expediente</th>
              <th>Nombre</th>
              <th>RNP</th>
              <th>Curso</th>
              <th>Año Escolar</th>
              <th>Año Militar</th>
              <th>Fecha Nacimiento</th>
              <th>Residencia</th>
              <th>Género</th>
              <th>Interno</th>
              <th>Nombre Padre</th>
              <th>Nombre Madre</th>
              <th>Teléfono Padre</th>
              <th>Teléfono Madre</th>
              <th>Teléfono Ecancargado</th>
              <th>Correo Padre</th>
              <th>Nivel Académico</th>
              <th>Correo Madre</th>
              <th>Edad Alumno</th>
              <th>Fecha Matriculado</th>
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
<script src="./recursos/js/print/datatables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

 <!-- searchPanes   -->
 <script src="https://cdn.datatables.net/searchpanes/1.0.1/js/dataTables.searchPanes.min.js"></script>
    <!-- select -->
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>  
<script>
  window.addEventListener('load', () =>{

    carga();
    function carga(){
    document.getElementById('circulo').className = 'hide';
    document.getElementById('contenido').className = 'bb';
    }

  })
  var listar = function(){
    var idaño = $("#seleccionaño").val();
    var table = $('#tbldata').DataTable( {
  responsive: true,
  destroy:true,
    "ajax": {
      "url": "<?php echo $urlweb?>servicios/ws_<?php echo $idpanel?>.php?accion=alumnos",
      "method": "POST",
      "data" : {
            "idaño" : idaño
        }
    },
   "columns":[
    {"data":"idexpediente"},
    {"data":"nombre_completo"},
    {"data":"rtn"},
    {"data":"nombre_curso"},
    {"data":"nombre"},
    {"data":"descripcion"},
    {"data":"fecha_nacimiento_alumno"},
    {"data":"residencia_alumno"},
    {"data":"genero"},
    {"data":"esinterno"},
    {"data":"nombre_padre"},
    {"data":"nombre_madre"},
    {"data":"telefono_padre"},
    {"data":"telefono_madre"},
    {"data":"telefono_encargado"},
    {"data":"email_padre"},
    {"data":"nivel"},
    {"data":"email_madre"},
    {"data":"edad"},
    {"data":"fecha_matricula"},
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
        ],
        columnDefs:[
            {
                searchPanes:{
                    show: false,
                },
                targets: [4,14,15,17],
            }
                ]
});
    obtener_data("#tbldata tbody", table);
  }

var obtener_data = function(tbody, table){
  $(tbody).on("click", "a.obtener", function(){
    var data = table.row( $(this).parents("tr")).data();
    if (typeof data !== 'undefined') {
      console.log(data);
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
}); 
$(function() {
  $(document).ready(function() {
$('#seleccionaño').material_select();
});

});

</script>
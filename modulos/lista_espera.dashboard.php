<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
$idusuario=$_GET['idusuario'];
global $funciones;
if($funciones->login_estado()){   
?>
<h3 class="center grey-text">Alumnos que aún no han entregado papeles</h3>
<div>
   <div style="font-size: 13px;" id="contenedor_tabla">
          <table id="tbldata" class="display centered" style="width:100%;">
        <thead>
          <tr>
          <th>Matricular</th>
          <th>Expediente</th>
              <th>Nombre</th>
              <th>RNP</th>
              <th>Curso</th>
              <th>Año Escolar</th>
              <th>Año Militar</th>
              <th>Fecha Nacimiento</th>
              <th>Residencia</th>
              <th>¿Será interno?</th>
              <th>Registro</th>
              <th>¿Realizó Pagó?</th>
              <th>Nombre Padre</th>
              <th>Nombre Madre</th>
              <th>Teléfono Padre</th>
              <th>Teléfono Madre</th>
              <th>Teléfono Ecancargado</th>
              <th>Correo Padre</th>
              <th>Nivel Académico</th>
              <th>Correo Madre</th>
              <th>Télefono Alumno</th>
              <th>idaño</th>
              <th>Fecha Matriculado</th>
          </tr>
        </thead>
      </table>
</div> 
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
<script src="<?php echo $urlweb?>recursos/js/sweetalert2.min.js"></script>
 <!-- searchPanes   -->
 <script src="https://cdn.datatables.net/searchpanes/1.0.1/js/dataTables.searchPanes.min.js"></script>
    <!-- select -->
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>  
<script>
$(document).ready( function () {
listar();
});
$(function() {
    $("ul.tabs").tabs({
        swipeable: true
    });
    $("#txtfechanac").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        yearRange: "1900:2100"
    });
    $("#txtfechanac").datepicker($.datepicker.regional["es"]);
});
var listar = function(){
    var table = $('#tbldata').DataTable( {
destroy:true,
responsive:true,

"ajax": {
    "url": "<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=lista_espera",
    "method": "POST",
},
"columns":[
{"defaultContent": "<a href='#modal1' class='obtener btn green'><i class='material-icons'>assignment_turned_in</i></a>"},
{"data":"idexpediente"},
    {"data":"nombre_completo"},
    {"data":"rtn"},
    {"data":"nombre_curso"},
    {"data":"nombre"},
    {"data":"descripcion"},
    {"data":"fecha_nacimiento_alumno"},
    {"data":"residencia_alumno"},
    {"data":"esinterno"},
    {"data":"primer_ingreso"},
    {"data":"aldia"},
    {"data":"nombre_padre"},
    {"data":"nombre_madre"},
    {"data":"telefono_padre"},
    {"data":"telefono_madre"},
    {"data":"telefono_encargado"},
    {"data":"email_padre"},
    {"data":"nivel"},
    {"data":"email_madre"},
    {"data":"telefono_alumno"},
    {"data":"idaño"},
    {"data":"fecha_matricula"},
],
searchPanes:{
    cascadePanes:true,
                    dtOpts:{
                        dom:'tp',
                        paging:'true',
                        pagingType:'simple',
                        searching:false
                    }
                },
"language": idioma_español,
dom: 'PBfrtip',
responsive: true,
columnDefs:[
            {
                searchPanes:{
                    show: true,
                },
                targets: [4,11],
            },            {
                searchPanes:{
                    show: false,
                },
                targets: [8,12,13,14,15,16,17,19,20],
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
    location.href = "?mod=dashboard&panel=adminmatricula_lista&idexpediente="+data.idexpediente+"&idaño="+data.idaño;    
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
</script>
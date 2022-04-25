<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
global $funciones;
$idaño=$_GET['idaño'];
if($funciones->login_estado()){   
?>
<h3 class="center grey-text">Efectuar Pagos</h3>
<?php
//Consulta para obtener nombre del año
$stmt = $mysqli->prepare("SELECT `nombre` FROM `year_escolar` WHERE idaño=?");
$stmt->bind_param("i", $idaño);    
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($nombre);
$stmt->fetch();
$stmt->close();
?>
<h3 class="center grey-text"><?php echo $nombre?></h3>
  <div id="modal1" class="modal">
    <div class="modal-content">
<table id="tabla_alumnos" class="display nowrap centered" style="width:100%">
    <thead>
        <tr>
            <th>Expediente</th>
            <th>Nombre Alumno</th>
            <th>Curso</th>
            <th>Año Militar</th>
            <th class="center">Elegir</th>
        </tr>
    </thead>
    <tbody id="t-body">
        <div class="row center">
        <div class="col s12">
            <h5 class="flow-text">Seleccione el alumno al que desea efectuar pago</h5>
            <span>En caso que el alumno no aparezca en la lista de alumnos matriculados, ud. deberá acceder al modulo de alumnos en lista de espera</span>
        </div>
      </div>
        <?php
$strsql = 'SELECT alumnos_matriculados.idexpediente, alumnos.nombre_completo, cursos.nombre_curso, secciones.nombre_seccion, anios_militares.idanio_militar
FROM   alumnos INNER JOIN
             alumnos_matriculados ON alumnos.idexpediente = alumnos_matriculados.idexpediente INNER JOIN
             year_escolar ON alumnos_matriculados.idaño = year_escolar.idaño INNER JOIN cursos ON  alumnos_matriculados.idcurso = cursos.idcurso INNER JOIN secciones ON alumnos_matriculados.idseccion = secciones.idseccion INNER JOIN anios_militares ON alumnos_matriculados.idanio_militar = anios_militares.idanio_militar where alumnos_matriculados.idaño=?';
if($stmt = $mysqli->prepare($strsql)){
 $stmt->bind_param("i", $idaño);
    $stmt->execute();
    if($stmt->errno == 0){
        $stmt->store_result();
        if($stmt->num_rows > 0){
            $stmt->bind_result($idexpediente, $nombre_completo, $idcurso, $idseccion, $idanio_militar);
            while($stmt->fetch()){
            ?>
                <tr id="rw-<?php echo $idexpediente?>">
                    <td><?php echo $idexpediente?></td>
                    <td><?php echo $nombre_completo?></td>
                    <td><?php echo $idcurso?></td>
                    <td><?php echo $idanio_militar?></td>
                        <td class="center">
                        <a href="javascript:asignar('<?php echo $idexpediente?>','<?php echo $nombre_completo?>')" class="btn green">
                            <i class="material-icons">add_circle_outline</i>                       
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
    </div>
  </div>

<div class="row">
<div class="input-field col s12 l2">
  <i class="material-icons prefix">assignment</i>
  <input disabled value="Click en boton" id="txtexpediente" type="text" class="validate" required>
  <label for="icon_prefix">Expediente</label>
</div>
<div class="input-field col s12 l7">
  <i class="material-icons prefix">person</i>
  <input disabled value="Haz click en Buscar" id="txtnombre" type="tel" class="validate" required>
  <label for="icon_telephone">Nombre Alumno</label>
  <span>Si el alumno no se encuentra matriculado, acceda al modulo <a href="?mod=dashboard&panel=pre_inscripcion">matricula en lista de espera</a> para efectuar el pago</span>
</div>
<div class="input-field col s12 l3">
<a id="send" href="#modal1" class="btn light-green darken-4">Buscar<i class="material-icons right">search</i></a>
</div>
</div>
<div id="cuerpo-factura">
    <form class="bordes" action="javascript:ver_factura()">
        <h4>Detalle Factura</h4>
          <div class="input-field col s12" style="display: none;">
    <select multiple id="seleccioncuota" name="seleccioncuota" style="display: none;">
<option value="" disabled selected>Seleccione una Opción</option>

<?php
            $strsql = "SELECT cuotas.idcuota, cuotas.cuota, cuotas.precio
FROM   cuotas INNER JOIN
             cuota_year_detalle ON cuotas.idcuota = cuota_year_detalle.idcuota
WHERE (cuota_year_detalle.idaño = ?)";
            if($stmt = $mysqli->prepare($strsql)){
                $stmt->bind_param("i", $idaño); 
                $stmt->execute();
                if($stmt->errno == 0){
                    $stmt->store_result();
                    if($stmt->num_rows > 0){
                        $stmt->bind_result($idcuota, $descripcion, $precio);
                        while($stmt->fetch()){
                        ?>                        
                           <option value="<?php echo $idcuota?>"><?php echo $descripcion ." - ". number_format($precio, 2, '.', ',') ?></option>                    
                <?php
//2 Indica el número de decimales a mostrar ',' Indica el separador que se va a usar para el separador de los decimales '.' Indica el separador que se va a usar para el separador de los miles                
                        }
                        ?>
</select>
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
    <label>Seleccione las cuotas que desea cancelar</label>
  </div>
  <div class="input-field col s12">
  <select multiple id="seleccioncuota2" name="seleccioncuota" style="display: none;">
<option value="" disabled selected>Seleccione un alumno</option>
</select>
  <label>Seleccione las cuotas que desea cancelar</label>
</div>

            <div id="previsualizacion">
              <center>
  <button class="btn waves-effect waves-light" type="submit" name="action">Efectuar pago
    <i class="material-icons right">attach_money</i>
  </button>  
              </center>           
            </div>


    </form>
    <div >
    <h4 class="center grey-text">Cuotas canceladas:</h4>    
    </div>
  <!-- Modal Structure -->
  <div id="modal2" class="modal">
    <div class="modal-content">
      <h4>Factura Generada por el Sistema</h4>
<div id="invoice-table">
              <div class="invoice-header">
                <div class="row section">
                  <div class="col s12 m6 l6">
                    <img class="responsive-img circle" src="<?php echo $urlweb?>temas/LMN2018/img/logo-lmn.jpeg" alt="company logo">
                  </div>
                  <div class="col s12 m12 l6">
                    <div class="">
                      <span class="invoice-icon">
                        <i class="material-icons cyan-text">location_city</i>
                      </span>
                      <p>
                        <span class="strong">Liceo Militar del Norte</span>
                        <br>
                        <span>Colonia Colombia, Ave. Circunvalación Zona Militar 105 Brigada de Infanteria</span>
                        <br>
                        <span>San Pedro Sula, Honduras, C.A.</span>
                        <br>
                        <span>+504 2552-3013 / +504 2552-3014</span>
                      </p>
                    </div>
                    <div class="invoce-company-contact">
                      <span class="invoice-icon">
                        <i class="material-icons cyan-text">contact_mail</i>
                      </span>
                      <p>
                        <span class="strong">liceomilitardelnortesps@gmail.com</span>
                        <br>
                        <span>https://www.liceomilitardelnorte.com/</span>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="invoice-lable">
                <div class="row">
                <div id="fecha_actual" class="col s12 m9 l9 invoice-brief cyan white-text">
                      <div class="col s12 m3 l3 right">
                        <p class="strong">Fecha Actual</p>
                        <h4 class="header"><?php echo date("d/m/Y"); ?></h4>
                      </div>
                  </div>
              </div>
            </div>
              <div class="invoice-table">
                <div class="row">
                  <div class="col s12 m12 l12">
                    <table class="striped" id="tbldata-invoice">
                      <thead>
                        <tr class="encabezado">
                          <th data-field="no">No.</th>
                          <th data-field="item">Nombre Completo</th>
                          <th data-field="item">Cuota</th>
                          <th data-field="uprice">Precio</th>
                          <th data-field="price">Transacción</th>
                        </tr>
                      </thead>
                      <tbody id="t-body">
                        <tr>
                        </tr>
                        <tr class="total">
                          <td colspan="3"></td>
                          <td>Sub Total:</td>
                          <td><p id="subtotal"></p></td>
                        </tr>
                        <tr>
                          <td colspan="3"></td>
                          <td class="cyan white-text">Total</td>
                          <td class="cyan strong white-text">L. <span id="total"></span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div id="imprimir" class="invoice-footer center">
<a href="javascript:imprSelec('invoice-table')" class="waves-effect waves-light btn"><i class="material-icons left">print</i>Imprimir Factura</a>         
              </div>
             
            </div>  
          </div>

    </div>
  </div>
<div id="contenedor_tabla">
        <table id="tbldata" class="display nowrap centered" style="width:100%;">
        <thead>
          <tr>
              <th>Factura</th>
              <th>Cuota Cancelada</th>
              <th>Precio</th>
              <th>Ver factura</th>
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
<script type="text/javascript">
function imprSelec(muestra)
{var ficha=document.getElementById(muestra);var ventimp=window.open(' ','popimpr');ventimp.document.write(ficha.innerHTML);ventimp.document.close();ventimp.print();ventimp.close();}
</script>

<script src="./recursos/js/datatables.min.js"></script>
<script src="./recursos/js/sha512.js"></script>
<script src="<?php echo $urlweb?>recursos/js/sweetalert2.min.js"></script>
<script>

  var listar = function(){
    var expediente = $("#txtexpediente").val(); 
    var idaño = <?php echo $idaño ?>;
    var table = $('#tbldata').DataTable( {
  responsive: true,
  destroy:true,
    "ajax": {
      "url": "<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=ver_facturas",
      "method": "POST",
      "data" : {
            "expediente" : expediente,
            "idaño" : idaño
        }
    },
   "columns":[
    {"data":"idfactura"},
    {"data":"cuota"},
    {"data":"precio"},
    {"defaultContent": "<a href='#modal2' class='obtener btn green'><i class='material-icons'>credit_card</i></a>"}
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
      var nombre_completo = $("#txtnombre").val();
    $("#tbldata-invoice tbody").prepend("<tr><td>"+data.idfactura+"</td><td>"+nombre_completo+"</td><td>"+data.cuota+"</td><td class='suma'>"+data.precio+"</td><td>"+'Aceptada'+"</td></tr>");
    var totalDeuda=0;

$(".suma").each(function(){

  totalDeuda+=parseFloat($(this).html()) || 0;
  console.log(totalDeuda);
  $("#subtotal").html(totalDeuda);
  $("#total").html(totalDeuda);
});

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
$(document).ready( function () {
    
$(function enviardatos(){
$('select#seleccioncuota2').on('change',function(){
   valor = [$(this).val()];
});

});  
$('#tabla_alumnos').DataTable({
responsive: true
});
}); 
$(function() {
  $(document).ready(function() {
$('#seleccioncuota').material_select();
$('#seleccioncuota2').material_select();
});

});
function asignar(idexpediente, nombre_completo){

$("#txtexpediente").val(idexpediente);
$("#txtnombre").val(nombre_completo);
var idaño = <?php echo $idaño ?>; 
$('#modal1').modal('close');
listar();
       
           
            $.post("<?php echo $urlweb?>servicios/ws_<?php echo $idpanel?>.php?accion=llenar_select", { idaño: idaño, idexpediente:idexpediente }, function(data){
                var retorno = data;
                $("#seleccioncuota2").html(retorno.htmldata);
                $("#seleccioncuota2").material_select();
            });            
         
}
function ver_factura(){
var expediente = $("#txtexpediente").val();   
var arv = valor.toString();
  if ((arv !="") && (expediente!="Click en boton")) {
  var idaño = <?php echo $idaño ?>;  
  var idusuario= "<?php echo $_SESSION["idusuario"] ?>";     

  var datos = new FormData();
        //enviar Datos Alumnos
        datos.append("action", "update");
        datos.append("arv", arv);
        datos.append("idaño", idaño); 
        datos.append("expediente", expediente);
        datos.append("idusuario", idusuario);
            swal({
                title: "¿Datos Correctos?",
                text: "¿Todos los datos ingresados están bien?, a continuación se generará la factura.",
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
                    url: "<?php echo $urlweb?>servicios/ws_<?php echo $idpanel?>.php?accion=facturar",
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
                            if(retorno.type == "success"){
                            //$("#invoice").toggle("drop", 500);
                            //$('#previsualizacion').hide();
                            swal(retorno);
                            listar();
                            }
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
  }else{
    Materialize.toast('Debe seleccionar un alumno y al menos una cuota para efectuar el pago!', 4000)
  }

}
</script>
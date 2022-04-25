<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
global $funciones;

if($funciones->login_estado()){   
?>
<h3 class="center grey-text">Módulo Pre-inscripción</h3>
<p>En este módulo podrá agregar alumnos que aún no han entregado papeles en secretaría. Se creará su respectivo expediente y ya podrá realizar pagos.</p>
<div class="bordes">
   <div class="row">
      <div class="input-field  s12 col l8">
         <i class="material-icons prefix">account_box</i>
         <input required="true" id="txtnombre_alumno" type="text" class="validate">
         <label for="icon_prefix">Nombre Completo</label>
      </div>
      <div class="row">
      <div class="col s12 l6">
         Fecha de nacimiento:
         <div class="input-field inline">
            <input value="" id="txtfechanac" type="text"  class="validate">
            <label for="email_inline">Calendario</label>
         </div>
      </div>
         <div class="input-field s12 col l5">
            <i class="material-icons prefix">email</i>
            <input id="txtemail_alumno" type="email" class="validate">
            <label for="icon_prefix">Correo Electrónico</label>   
         </div>
      </div>
      <div class="row">
        <div class="col s12 l6">
            <span>Departamento:</span>
            <select id="cmb_depto" name="cmb_depto">
<?php
      $strsql = "SELECT `iddepto`, `departamento` FROM `departamentos`";
      if($stmt = $mysqli->prepare($strsql)){
        $stmt->execute();
        if($stmt->errno == 0){
          $stmt->store_result();
          if($stmt->num_rows > 0){
            $stmt->bind_result($iddepto, $departamento);
            while($stmt->fetch()){
            ?>
        <option value="<?php echo $iddepto ?>"><?php echo $departamento ?></option>
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
      <div class="col s12 l6">
         <span>Ciudad:</span>
         <select id="cmb_ciudad_alumno" name="cmb_ciudad_alumno">
<?php
      $strsql = "SELECT `idciudad`, `ciudad` FROM `ciudades`";
      if($stmt = $mysqli->prepare($strsql)){
        $stmt->execute();
        if($stmt->errno == 0){
          $stmt->store_result();
          if($stmt->num_rows > 0){
            $stmt->bind_result($idciudad, $ciudad);
            while($stmt->fetch()){
            ?>
        <option value="<?php echo $idciudad ?>"><?php echo $ciudad ?></option>
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
      <div class="col s6 l6">
         <span>Nacionalidad:</span>
         <select id="cmb_nacionalidad_alumno" name="cmb_nacionalidad_alumno">
<?php
      $strsql = "SELECT `idnacionalidad`, `nacionalidad` FROM `nacionalidades`";
      if($stmt = $mysqli->prepare($strsql)){
        $stmt->execute();
        if($stmt->errno == 0){
          $stmt->store_result();
          if($stmt->num_rows > 0){
            $stmt->bind_result($idnacionalidad, $nacionalidad);
            while($stmt->fetch()){
            ?>
        <option value="<?php echo $idnacionalidad ?>"><?php echo $nacionalidad ?></option>
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
         <div class="input-field col s12 l6">
            <span>Sexo</span>
            <select id="cmb_sexo" name="cmb_sexo">
               <option value="1">Masculino</option>
               <option value="0">Femenino</option>
            </select>
         </div> 
   </div>
</div>
<div class="bordes">
  <h4 id="DatosAcademicos" class="header2">Datos Académicos</h4>
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
</div>
<a id="send" href="javascript:guardarnuevo()" class="btn cyan waves-effect waves-light">Guardar<i class="material-icons right">send</i></a>
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
  $(function() {
    $("#txtfechanac").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        yearRange: "1900:2100"
    });
    $("#txtfechanac").datepicker($.datepicker.regional["es"]);
});
function guardarnuevo() {
//Datos Generales 
var nombre = $("#txtnombre_alumno").val(),
    email_alumno = $("#txtemail_alumno").val(),
    nacimiento = $("#txtfechanac").val(),
    sexo = $("#cmb_sexo").val(),
    nacionalidad_alumno = $("#cmb_nacionalidad_alumno").val(),
    ciudad_alumno = $("#cmb_ciudad_alumno").val(),
    depto = $("#cmb_depto").val(),
    nombre_alumno = nombre.toUpperCase(); 
//Datos Academicos    
var curso = $("#cmb_curso").val(),
    seccion = $("#cmb_seccion").val(),
    año_escolar = $("#cmb_year_escolar").val(),
    añomilitar = $("#cmb_militar").val();
        var datos = new FormData();
        //enviar Datos Alumnos
        datos.append("action", "update");
        datos.append("nombre_alumno", nombre_alumno);
        datos.append("email_alumno", email_alumno);
        datos.append("nacimiento", nacimiento);
        datos.append("sexo", sexo);
        datos.append("nacionalidad_alumno", nacionalidad_alumno);
        datos.append("ciudad_alumno", ciudad_alumno);
        datos.append("depto", depto);
        //enviar Datos Academicos
        datos.append("curso", curso);
        datos.append("seccion", seccion);
        datos.append("año_escolar", año_escolar);
        datos.append("añomilitar", añomilitar);

        if (nacimiento!="") {
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
                    url: "<?php echo $urlweb?>servicios/ws_<?php echo $idpanel?>.php?accion=nuevo",
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
                            if(retorno.type == "success"){
                            
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
        } else {
          txtfechanac.focus();
            swal({
                title: "Error!",
                text: "Ingrese una fecha de nacimiento válida",
                type: "error",
                showConfirmButton: true
            });
        }
}  
</script>
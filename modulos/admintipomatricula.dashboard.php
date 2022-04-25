<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
$idusuario=$_GET['idusuario'];
global $funciones;
if($funciones->login_estado()){   
?>
<h3 class="center grey-text">Matrícula</h3>
<?php
$idusuario=$_GET['idusuario'];
$dir = "uploads/avatar/";
 $direccion=$dir."default.jpg";
?>
 <script type="text/javascript">
var direccion = ('<?php echo $direccion  ?>');
</script>
<div class="">
   <div class="row">
      <div class="col s12 m12 l12">
                  <div class="row">
                    <div class="col s12 m6 l6">
                      <div class="card horizontal">
                        <div class="card-image" style="width: 304px; height: 327px;">
                          <img class="responsive-img" src="<?php echo $urlweb?>temas/LMN2018/img/matricula.png">
                        </div>
                        <div class="card-stacked">
                          <div class="card-content">
                          	<span class="card-title activator grey-text text-darken-4">Primer Ingreso
                          </span>
                            <p>Aquí podrá matricular a los alumnos de primer ingreso.</p>
                          </div>
                          <div class="card-action">
                            <a href="?mod=dashboard&panel=adminmatricula_nuevo" class="waves-effect waves-light btn gradient-45deg-red-pink">Matricular</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col s12 m6 l6">
                      <div class="card horizontal">
                        <div class="card-image" style="width: 304px; height: 327px;">
                          <img class="responsive-img" src="<?php echo $urlweb?>temas/LMN2018/img/matricula2.png">
                        </div>
                        <div class="card-stacked">
                          <div class="card-content">
                          	<span class="card-title activator grey-text text-darken-4">Re-Ingreso
                          </span>                          	
                            <p>Aquí podrá matricular a los alumnos que ya han sido matriculados en años anteriores.</p>
                          </div>
                          <div class="card-action">
                            <a href="?mod=dashboard&panel=adminmatricula_editar" class="waves-effect waves-light btn gradient-45deg-red-pink">Matricular</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
	</div>
</div>	
<?php
}else{
?>
<h2 class="center">Ud no tiene permisos o su cuenta ha sido desactivada, comuniquese con el administrador.</h2> 
<?php
}
?>
<script src="./recursos/js/sha512.js"></script>
<script src="<?php echo $urlweb?>recursos/js/sweetalert2.min.js"></script>
<script>
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

function guardarnuevo() {
//Datos Generales	
var nombre = $("#txtnombre_alumno").val(),
    rtn = $("#txtrtn").val(),
    email_alumno = $("#txtemail_alumno").val(),
    nacimiento = $("#txtfechanac").val(),
    tiposanbre = $( "#cmb_tiposangre option:selected" ).val(),
    domicilio_alumno = $("#txtdomicilio").val(),
    sexo = $("#cmb_sexo").val(),
    nacionalidad_alumno = $("#cmb_nacionalidad_alumno").val(),
    ciudad_alumno = $("#cmb_ciudad_alumno").val(),
    depto = $("#cmb_depto").val(),
    telefono_alumno = $("#txttelefono_alumno").val(),
    beca = $("#cmb_tienebeca").val(),
    interno = $("#cmb_esinterno").val(),
    nombre_alumno = nombre.toUpperCase(); 
//Datos Academicos    
var curso = $("#cmb_curso").val(),
    seccion = $("#cmb_seccion").val(),
    año_escolar = $("#cmb_year_escolar").val(),
    añomilitar = $("#cmb_militar").val(),
    institucion_previa = $("#cmb_institucion_previa").val(),
    ciudad_previa = $( "#cmb_ciudad_previa option:selected" ).val(),
    modalidad = $("#cmb_modalidad").val(),
    promedio_previo = $("#txtpromedio").val();
//Datos Familiares  Padres  
var nombre_padre = $("#txtnombre_padre").val(),
    direccion_padre = $("#txtdireccion_padre").val(),
    ciudad_padre = $("#cmb_ciudad_padre").val(),
    nacionalidad_padre = $("#cmb_nacionalidad_padre").val(),
    telefono_padre = $("#txttelefono_padre").val(),
    email_padre = $("#txtemail_padre").val();
    nombre_padre = nombre_padre.toUpperCase(); 
//Datos Familiares  Padres  
var nombre_madre = $("#txtnombre_madre").val(),
    direccion_madre = $("#txtdireccion_madre").val(),
    ciudad_madre = $("#cmb_ciudad_madre").val(),
    nacionalidad_madre = $("#cmb_nacionalidad_madre").val(),
    telefono_madre = $("#txttelefono_madre").val(),
    email_madre = $("#txtemail_madre").val();  
    nombre_madre = nombre_madre.toUpperCase();   
//Otros Datos
var religion = $("#cmb_religion").val();

        var datos = new FormData();
        var avatar = $("#adj")[0].files[0];
        //enviar Datos Alumnos
        datos.append("action", "update");
        datos.append("nombre_alumno", nombre_alumno);
        datos.append("rtn", rtn);
        datos.append("email_alumno", email_alumno);
        datos.append("nacimiento", nacimiento);
        datos.append("tiposanbre", tiposanbre);
        datos.append("domicilio_alumno", domicilio_alumno);
        datos.append("sexo", sexo);
        datos.append("nacionalidad_alumno", nacionalidad_alumno);
        datos.append("ciudad_alumno", ciudad_alumno);
        datos.append("depto", depto);
        datos.append("telefono_alumno", telefono_alumno);
        datos.append("beca", beca);
        datos.append("interno", interno);
        //enviar Datos Academicos
        datos.append("curso", curso);
        datos.append("seccion", seccion);
        datos.append("año_escolar", año_escolar);
        datos.append("añomilitar", añomilitar);
        datos.append("institucion_previa", institucion_previa);
        datos.append("ciudad_previa", ciudad_previa);
        datos.append("modalidad", modalidad);
        datos.append("promedio_previo", promedio_previo);
        //Datos Familiares
        datos.append("nombre_padre", nombre_padre);
        datos.append("direccion_padre", direccion_padre);
        datos.append("ciudad_padre", ciudad_padre);
        datos.append("nacionalidad_padre", nacionalidad_padre);
        datos.append("telefono_padre", telefono_padre);
        datos.append("email_padre", email_padre);

        datos.append("nombre_madre", nombre_madre);
        datos.append("direccion_madre", direccion_madre);
        datos.append("ciudad_madre", ciudad_madre);
        datos.append("nacionalidad_madre", nacionalidad_madre);
        datos.append("telefono_madre", telefono_madre);
        datos.append("email_madre", email_madre);
        //Otros Datos
        datos.append("religion", religion);
        //Foto
        datos.append("avatar", avatar);
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

function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

function guardareditar() {
    var idbloque = $("#txtidbloque").val(),
        bloque = $("#txtbloque").val(),
        esactivo = $("#esactivo").prop("checked") ? 1 : 0;
    swal({
        title: "Editar Registro",
        text: "¿De+sea editar el registro solicitado?",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    }).then(function() {
        $.ajax({
            url: "<?php echo $urlweb?>/servicios/ws_<?php echo $idmodulo?>.php?accion=editar",
            type: 'POST',
            data: {
                "idbloque": idbloque,
                "bloque": bloque,
                "tipo": tipo
            },
            error: function() {
                swal.close();
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

                    $('#frmbloques').modal('close');

                    $("#rw-" + idbloque).fadeOut("1000", function() {
                        $("#rw-" + idbloque).html(data.htmldata);
                        $("#rw-" + idbloque).fadeIn("1000");
                    });
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

function nuevo() {
    $("#esadmin").prop("checked", true);
    $("#esactivo").prop("cheked", true);
    $('#frmbloques').modal('open');
    $("#txtidusuario").focus();
    $("#txtfechanac").val("");
    $("#txtidusuario").val("");
    $("#txtusuario").val("");
    $("#txtemail").val("");
    $("#txtpassword").val("");
    $("#txtpassword2").val("");
}
</script>
<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
$idusuario=$_GET['idusuario'];
?>
<?php
global $funciones;
if(($funciones->login_admin() or $funciones->login_estado()) and 
($idusuario=$_GET['idusuario'] == $_SESSION["idusuario"] or $funciones->login_admin())){   
?>
<h3 class="center grey-text">Administración de Usuarios</h3>
<?php
$idusuario=$_GET['idusuario'];

    $dir = "uploads/avatar/";
    if(file_exists($dir.$idusuario.".jpg"))
    {
        $direccion=$dir.$idusuario.".jpg";
        ?>
<script type="text/javascript">
var direccion = ('<?php echo $direccion  ?>');
</script>
        <?php
    }else{
        
        $direccion=$dir."default.jpg";
?>
        <script type="text/javascript">
var direccion = ('<?php echo $direccion  ?>');
</script>
<?php
    }

	$strsql = "SELECT idusuario, usuario, llave, password, email, esadmin, estado, maestro, nacimiento FROM usuarios where idusuario = ?";
	if($stmt = $mysqli->prepare($strsql)){
        $stmt->bind_param("s", $idusuario);
		$stmt->execute();
		if($stmt->errno == 0){
			$stmt->store_result();
			if($stmt->num_rows > 0){
				$stmt->bind_result($idusuario, $usuario, $llave, $pass, $email, $esadmin, $esactivo, $esmaestro, $nacimiento);
				$stmt->fetch();
            
?>

<table id="tbldata" class="responsive-table">
<div id="frmbloques" >
<div class="modal-content">
<form class="row" action="javascript:guardarnuevo()">
  
    <div id="imagen" class="center">  
     <img  id="ima" class="z-depth-5 circle"  src="<?php echo $direccion ?>"  width="250" height="250"> 
      </div> 
    
<div id="adjuntar"> 
    
    
  
<div class="input-field col s12">       
<form action="#">
<div class="file-field input-field">
<div class="btn">
<span>Adjuntar Archivo</span>
<input id="adj" type="file" class="jj">
</div>
<div class="file-path-wrapper">
<input class="file-path validate" type="text" placeholder="Selecciona un Archivo">
</div>
</div>
</form>
</div>  
    </div>    
    

    
	<div class="input-field col s6">
		<input value="<?php echo $idusuario?>" id="txtidusuario" type="text" disabled >
		<label for="txtidusuario">Codigo de Usuario</label>
	</div>
    <div class="input-field col s6">
		<input value="<?php echo $usuario?>" id="txtusuario" type="text">
		<label for="txtusuario">Usuario</label>
	</div>
	<div class="input-field col s12">
		<input value="<?php echo $email?>" id="txtemail" type="text">
		<label for="txtemail">E-mail</label>
	</div>
    	<div class="input-field col s12">
		<input value="<?php echo $nacimiento?>" id="txtfechanac" type="text">
		<label for="txtfechanac">Fecha Nacimiento</label>
	</div>
    <div class="input-field col s6">
		<input id="txtpassword" type="password">
		<label for="txtpassword">Password</label>
	</div>
    
    
    
    
     <div style="display: none" class="input-field col s6">
		<input value="<?php echo $pass?>" id="txtpasswordesc" type="password">
		<label for="txtpasswordesc">Password</label>
	</div>
    
      <div style="display: none" class="input-field col s6">
		<input value="<?php echo $llave?>" id="txtllave" type="password">
		<label for="txtllave">Password</label>
	</div>
    
    
    
    
    
    <div class="input-field col s6">
		<input id="txtpassword2" type="password">
		<label for="txtpassword2">Confirmar</label>
	</div>
	
    <?php
if($funciones->login_admin()){      
?>
    	  <div class="switch center">
<label>
Inactivo
<input id="esactivo" type="checkbox" <?php echo $esactivo ? "checked='checked'" : "" ?>>
<span class="lever"></span>
Activo
</label>
</div>	
    
<div class="switch center">
<label>
No Admin
<input  id="esadmin" type="checkbox" <?php echo $esadmin ? "checked='checked'" : "" ?>>
<span class="lever"></span>
Es Admin
</label>
</div>
<div class="switch center">
<label>
No Maestro
<input  id="esmaestro" type="checkbox" <?php echo $esmaestro ? "checked='checked'" : "" ?>>
<span class="lever"></span>
Es Maestro
</label>
</div>
    <?php
}else{

?>
    
            	  <div class="switch center">
<label>
Inactivo
<input id="esactivo" type="checkbox" <?php echo $esactivo ? "checked='checked'" : "" ?>>
<span class="lever"></span>
Activo
</label>
</div>	
    <div id="noadmin" style="display:none">
<div class="switch center">
<label>
No Admin
<input  id="esadmin" type="checkbox" <?php echo $esadmin ? "checked='checked'" : "" ?>>
<span class="lever"></span>
Es Admin
</label>
</div>
        </div>
		<div id="noadmin" style="display:none">
<div class="switch center">
<label>
No Admin
<input  id="esmaestro" type="checkbox" <?php echo $esmaestro ? "checked='checked'" : "" ?>>
<span class="lever"></span>
Es Admin
</label>
</div>
        </div>
<?php
}
?>        

    

	<?php
    
				//$stmt->close();
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
</form>
</div>

</div>

</table>
<div class="modal-footer">

<a id="pedo" href="javascript:guardarnuevo()" class="waves-effect waves-green btn green ">Guardar</a>
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
        $( "#txtfechanac" ).datepicker({
            changeMonth: true,
            changeYear: true, 
            dateFormat: "yy-mm-dd",
            yearRange: "1900:2100" 
        });
        $( "#txtfechanac" ).datepicker($.datepicker.regional[ "es" ]);
    });

function guardarnuevo(){
var idusuario = $("#txtidusuario").val(),
	usuario = $("#txtusuario").val(),
    email = $("#txtemail").val(),
    nacimiento = $("#txtfechanac").val(),
    password1 = $("#txtpassword").val(),
    password2 = $("#txtpassword2").val(),
    password= $("#txtpasswordesc").val(),
    llave= $("#txtllave").val();
	var esactivo = $("#esactivo").prop("checked") ? 1 : 0;
    var esadmin = $("#esadmin").prop("checked") ? 1 : 0;
	var esmaestro = $("#esmaestro").prop("checked") ? 1 : 0;
if((password1=="")&&(password2=="")){
var datos = new FormData();
if($("#adj").val()!="")
    var avatar= $("#adj")[0].files[0];
            datos.append("action", "update");
            datos.append("idusuario",idusuario);
            datos.append("usuario",usuario);
            datos.append("email",email);
            datos.append("nacimiento",nacimiento);
            datos.append("estado",esactivo);
            datos.append("esadmin",esadmin);
			datos.append("esmaestro",esmaestro);
            datos.append("password",password);
       		datos.append("llave",llave);
			datos.append("avatar",avatar);
 if(isEmail(email)){
	swal({
	title:"¿Datos Correctos?",
	text: "¿Todos los datos ingresados estan bien?",
	type: "warning",
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
                url:"<?php echo $urlweb?>/servicios/ws_adminperfilusuario.php?accion=editar2",
                data:datos,
		error:function(){
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
				
				$(".jj").val("");
			d = new Date();
$("#ima").attr("src", direccion+"?"+d.getTime());
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
else{
    swal({
							title:"Error!",
							text: "Ingrese un correo valido",
							type:"error",
							showConfirmButton:true
						});
}


}else{
password1 = hex_sha512(password1);
var datos = new FormData();
if($("#adj").val()!="")
    var avatar= $("#adj")[0].files[0];
            datos.append("action", "update");
            datos.append("idusuario",idusuario);
            datos.append("usuario",usuario);
            datos.append("email",email);
            datos.append("nacimiento",nacimiento);
            datos.append("estado",esactivo);
            datos.append("esadmin",esadmin);
			datos.append("esmaestro",esmaestro);
            datos.append("password",password1);
			datos.append("avatar",avatar);
 if(isEmail(email)){
	swal({
	title:"¿Datos Correctos?",
	text: "¿Todos los datos ingresados estan bien?",
	type: "warning",
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
                url:"<?php echo $urlweb?>/servicios/ws_adminperfilusuario.php?accion=editar",
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
				
				$(".jj").val("");
			d = new Date();
$("#ima").attr("src", direccion+"?"+d.getTime());
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
	
});}
else{
    swal({
							title:"Error!",
							text: "Ingrese un correo valido",
							type:"error",
							showConfirmButton:true
						});
}

      }  
}
function isEmail(email) {
var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
return regex.test(email);
}
function guardareditar(){
var idbloque = $("#txtidbloque").val(),
	bloque = $("#txtbloque").val(),
	esactivo = $("#esactivo").prop("checked") ? 1 : 0;
	swal({
		title:"Editar Registro",
		text: "¿Desea editar el registro solicitado?",
		type: "warning",
		showCancelButton: true,
		closeOnConfirm: false,
		showLoaderOnConfirm: true
	}).then(function(){
		$.ajax({
			url:"<?php echo $urlweb?>/servicios/ws_<?php echo $idmodulo?>.php?accion=editar",
			type: 'POST',
			data:{"idbloque":idbloque, "bloque":bloque, "tipo":tipo},
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
				
				$("#rw-" + idbloque).fadeOut("1000",function(){
                    $("#rw-" + idbloque).html(data.htmldata);
                    $("#rw-" + idbloque).fadeIn("1000"); 
                });
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
function nuevo(){
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
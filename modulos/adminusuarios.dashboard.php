<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
global $funciones;
   if($funciones->login_admin()){      
?>
<div class="container center">
<h4><b>Administración de Usuarios</b></h4>
</div>
<table id="tbldata" class="display nowrap" style="width:100%">
	<thead>
		<tr>
			<th>Usuario</th>
			<th>Nombre</th>
			<th>E-mail</th>
            <th class="center">Administrador</th>
            <th class="center">Activo</th>
			<th class="center">Maestro</th>
			<th class="center">Perfiles</th>
            <th class="center">Perfil</th>
            <th class="center">Eliminar</th>
		</tr>
	</thead>
		<?php
$strsql = 'SELECT idusuario, usuario, email, esadmin, maestro, estado FROM usuarios ORDER BY esadmin DESC';
if($stmt = $mysqli->prepare($strsql)){
	$stmt->execute();
	if($stmt->errno == 0){
		$stmt->store_result();
		if($stmt->num_rows > 0){
			$stmt->bind_result($idusuario, $usuario, $email, $esadmin, $maestro, $estado);
			while($stmt->fetch()){
			?>
				<tr id="rw-<?php echo $idusuario?>">
					<td><?php echo $idusuario?></td>
					<td><?php echo $usuario?></td>
					<td><?php echo $email?></td>
					<td class="center"><?php echo $esadmin == 1 ? "<i class=\"material-icons\">done</i>" : "<i class=\"material-icons\">clear</i>" ?></td>
					<td class="center"><?php echo $estado == 1 ? "<i class=\"material-icons\">done</i>" : "<i class=\"material-icons\">clear</i>" ?></td>
					<td class="center"><?php echo $maestro == 1 ? "<i class=\"material-icons\">done</i>" : "<i class=\"material-icons\">clear</i>" ?></td>
						<td class="center">
						<a href="javascript:permisos('<?php echo $idusuario?>')" class="btn green">
							<i class="material-icons">vpn_key</i>
							
						</a>
						</td>
					<td class="center">
						<a href="?mod=dashboard&panel=adminperfilusuario&idusuario=<?php echo $idusuario?>" class="btn green">
							<i class="material-icons">assignment_ind</i>
							
						</a>
						</td>
						<td class="center">
						<a href="javascript:eliminar('<?php echo $idusuario?>')" class="btn red">
						<i class="material-icons">delete</i>
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
<a class="btn green darken-3" href="javascript:nuevo()"><i class="material-icons left">group_add</i>Agregar Usuario</a>
<div id="frmbloques" class="modal">
	<div class="modal-content">
		<h4 class="center">Agregar Usuario</h4>
		<form class="row" action="javascript:guardarnuevo()">
			<div class="input-field col s12 l6">
				<i class="material-icons prefix">person</i>
				<input id="txtidusuario" type="text" maxlength="14">
				<label for="txtidusuario">Codigo de Usuario</label>
			</div>
            <div class="input-field col s12 l6">
            	<i class="material-icons prefix">account_box</i>
				<input id="txtusuario" type="text">
				<label for="txtusuario">Usuario</label>
			</div>
			<div class="input-field col s12 l12">
				<i class="material-icons prefix">email</i>
				<input id="txtemail" class="validate" type="email">
				<label for="txtemail">E-mail</label>
			</div>
            	<div class="input-field col s12">
            		<i class="material-icons prefix">date_range</i>
				<input type="text" id="txtfechanac"/>
				<label for="txtfechanac">Fecha Nacimiento</label>
			</div>

            <div class="input-field col s6">
            	<i class="material-icons prefix">lock_outline</i>
				<input id="txtpassword" type="password">
				<label for="txtpassword">Password</label>
			</div>
            <div class="input-field col s6">
            	<i class="material-icons prefix">lock_open</i>
				<input id="txtpassword2" type="password">
				<label for="txtpassword2">Confirmar</label>
			</div>
			</form>
			<div class="row center">
	  <div class="switch col s12 l12">
    <label>
      Inactivo
      <input id="esactivo" type="checkbox" checked="checked">
      <span class="lever"></span>
     Activo
    </label>
  </div>	    
    <div class="switch col s12 l12">
    <label>
      No Admin
      <input id="esadmin" type="checkbox">
      <span class="lever"></span>
      Es Admin
    </label>
  </div>
  <div class="switch col s12 l12">
    <label>
      No Maestro
      <input id="esmaestro" type="checkbox">
      <span class="lever"></span>
      Es Maestro
    </label>
  </div>
		</div>	
	</div>
	<div class="modal-footer">
		<a id="p" href="javascript:guardarnuevo()" class="waves-effect waves-green btn green">Guardar</a>      	
	</div>
</div>
<div id="frmbloques2" class="modal">
	<div class="modal-content">
		<h4>Administrador de Permisos</h4>
        <input id="id" style="display: none">
		<form id="rellenar" class="row">	
		</form>
	</div>
	<div class="modal-footer">
		<a id="p" href="javascript:guardarpermisos()" class="waves-effect waves-green btn green">Guardar</a> 	
	</div>
</div>
<?php 
   }else{
   	echo "<center><h4>Ud no tiene permisos de administrador</h4></center>";
   }
?>
<script src="./recursos/js/datatables.min.js"></script>
<script src="./recursos/js/sha512.js"></script>
<script src="<?php echo $urlweb?>recursos/js/sweetalert2.min.js"></script>
<script>
$(document).ready( function () {
$('#tbldata').DataTable({
responsive: true,
            //con esta configuacion se puede hacer scroll sin la extensión SCROLLER (para tablas de pocos registros)
			//scrollY: "600px", 
          scrollCollapse: true,
          paging:true,
        "scrollX": true
});
});	
$(function() {
        $( "#txtfechanac" ).datepicker({
            changeMonth: true,
            changeYear: true, 
            dateFormat: "yy-mm-dd",
            yearRange: "1900:2100" 
        });
        $( "#txtfechanac" ).datepicker($.datepicker.regional[ "es" ]);
    });
function permisos(idusuario){
var idusuario=idusuario;
$("#id").val(idusuario);   
$.ajax({
		url:"<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=permisos",
		type: 'POST',
		data:{"idusuario":idusuario},
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
                $("#rellenar").html(data.htmldata);
		        $('#frmbloques2').modal('open');
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
}			
function guardarpermisos()
{ 
var idusuario = $("#id").val();     
$.ajax({
url:"<?php echo $urlweb?>/servicios/ws_<?php echo $idmodulo?>.php?accion=eliminarperfiles",
type: 'POST',
data:{"idusuario":idusuario},
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
$(".switch input:checked").each(function()
        {
            var idperfil = $(this).attr("id");
            $.ajax({
		    url:"<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=agregarperfiles",
		    type: 'POST',
		    data:{"idusuario":idusuario,"idperfil":idperfil},
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
swal({
        title:"Perfil Actualizado",
        text: "",
        type: "success",
        showCancelButton: false,
        showLoaderOnConfirm: true
    });
$('#frmbloques2').modal('close');
}
function guardarnuevo(){
var idusuario = $("#txtidusuario").val(),
	usuario = $("#txtusuario").val(),
    email = $("#txtemail").val(),
    nacimiento = $("#txtfechanac").val(),
    password2 = $("#txtpassword2").val(),
    password = $("#txtpassword").val();
	var esactivo = $("#esactivo").prop("checked") ? 1 : 0;
    var esadmin = $("#esadmin").prop("checked") ? 1 : 0;
	var esmaestro = $("#esmaestro").prop("checked") ? 1 : 0;
if(password == password2){
	password = hex_sha512(password);
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
		url:"<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=agregar",
		type: 'POST',
		data:{"idusuario":idusuario, "usuario":usuario, "email":email, "nacimiento":nacimiento, "password":password, "esactivo":esactivo, "esadmin":esadmin, "esmaestro":esmaestro},
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
				$("#tbldata tbody").append(retorno.htmldata);
				$("#rw-" + idusuario).fadeIn("1000");
				userss = $("#users").val();
			users = parseInt(userss);
			users = users+1;
			$("#users").val(users);
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
							text: "Ingrese un correo existente",
							type:"error",
							showConfirmButton:true
						});
}
}  else{

swal({
							title:"Error!",
							text: "Las Contraseñas Ingresadas son Diferentes",
							type:"error",
							showConfirmButton:true
						});

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
		title:"¿Datos Correctos?",
		text: "¿Todos los datos ingresados estan bien",
		type: "warning",
		showCancelButton: true,
		closeOnConfirm: false,
		showLoaderOnConfirm: true
	}).then(function(){
		$.ajax({
			url:"<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=editar",
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
                    location.reload();
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


function eliminar(idusuario){
swal({
		title:"Eliminar Registro",
		text: "¿Desea eliminar el registro solicitado?",
		type: "warning",
		showCancelButton: true,
		closeOnConfirm: false,
		showLoaderOnConfirm: true
	}).then(function(){
		$.ajax({
			url:"<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=eliminar",
			type: 'POST',
			data:{"idusuario":idusuario},
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
					swal(retorno);
							userss = $("#users").val();
			users = parseInt(userss);
			users = users-1;
			$("#users").val(users);
					if(retorno.type == "success"){
						$("#rw-" + idusuario).fadeOut('slow',function(){
							$(this).remove();
						});
					}
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
</script>

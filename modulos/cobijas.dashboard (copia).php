<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
?>
<div class="container center">
<h4><b>Administración de Cobijas Escolares</b></h4>
</div>
<table id="tbldata" class="display responsive centered" width="100%">
<thead>
		<tr>
            <th class="center">ESTUDIANTE</th>
			<?php
					$strsql_2 = 'SELECT clase_curso_detalles.idclase_curso, clases.nombre FROM `clase_curso_detalles` INNER JOIN cursos ON cursos.idcurso=clase_curso_detalles.idcurso INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase where clase_curso_detalles.idaño=2 and clase_curso_detalles.idcurso=12';
			if($st = $mysqli->prepare($strsql_2)){
				$st->execute();
				if($st->errno == 0){
					$st->store_result();
					if($st->num_rows > 0){
						$st->bind_result($alumno, $clase);
						while($st->fetch()){
						?>
					 <th class="center"><?php echo $clase?></th>
						<?php
						}
						
						$st->close();
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
		</tr>
    </thead>
			<?php
					$strsql_2 = 'SELECT clase_curso_detalles.idclase_curso, clases.nombre FROM `clase_curso_detalles` INNER JOIN cursos ON cursos.idcurso=clase_curso_detalles.idcurso INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase where clase_curso_detalles.idaño=2 and clase_curso_detalles.idcurso=12';
			if($st = $mysqli->prepare($strsql_2)){
				$st->execute();
				if($st->errno == 0){
					$st->store_result();
					if($st->num_rows > 0){
						$st->bind_result($idclase, $clase);
						while($st->fetch()){
						?>
						    <tbody>				
							<?php
												$strsql = 'SELECT alumnos.idexpediente, alumnos.nombre_completo, alumnos_matriculados.idcurso FROM `alumnos_matriculados`  INNER JOIN alumnos ON alumnos.idexpediente=alumnos_matriculados.idexpediente  WHERE alumnos_matriculados.idaño=2 and alumnos_matriculados.idcurso=12';
										if($stmt = $mysqli->prepare($strsql)){
											$stmt->bind_param("s",$expediente);
											$stmt->execute();
											if($stmt->errno == 0){
												$stmt->store_result();
												if($stmt->num_rows > 0){
													$stmt->bind_result($expediente, $alumno, $idcurso);
													while($stmt->fetch()){
													?>
														<tr id="rw-<?php echo $idclase?>" >
															<td><?php echo $alumno?></td>
															<?php
												$strsql_3 = 'SELECT AVG(sem1 + sem2 + sem3 + sem4 + sem5 + sem6 + sem7 + examen) AS total, recup FROM `notas` WHERE idclase_curso=? and idexpediente=?';
										if($st3 = $mysqli->prepare($strsql_3)){
											$st3->bind_param("is", $idclase, $expediente);
											$st3->execute();
											if($st3->errno == 0){
												$st3->store_result();
												if($st3->num_rows > 0){
													$st3->bind_result($total, $recup);
													while($st3->fetch()){
													?>
												<td><?php echo $total?></td>
													<?php
													}
													
													$st3->close();
												}//cierre de consulta de valores retornados
											}
											else{
												echo "Error al ejecutar consulta: " . $st3->error;
											}//Cierre de condicion de Ejecucion
										}
										else{
											echo "Error al preparar consulta: " . $mysqli->error;
										}
									?>				                         
														
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
									</tr>
								</tbody>
								<?php
						}
						
						$st->close();
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

</table>
<script src="./recursos/js/datatables.min.js"></script>
<script src="<?php echo $urlweb?>recursos/js/sweetalert2.min.js"></script>
<script>	
$(document).ready( function () {
    $('#tbldata').DataTable({
    	responsive: true
    });
});	
function guardarnuevo(){
var cuota = $("#txtcuota").val(),
	descripcion = $("#txtdescripcion").val(),
	precio = $("#txtprecio").val();
swal({
	title:"¿Datos Correctos?",
	text: "¿Todos los datos ingresados estan bien?",
	type: "warning",
	showCancelButton: true,
	closeOnConfirm: false,
	showLoaderOnConfirm: true
}).then(function(){
	$.ajax({
		url:"<?php echo $urlweb?>servicios/ws_<?php echo $idpanel?>.php?accion=agregar",
		type: 'POST',
		data:{"cuota":cuota, "descripcion":descripcion, "precio":precio},
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
                if(retorno.type == "success"){
				$('#frmbloques').modal('close');
				$("#tbldata tbody").append(retorno.htmldata);
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
function guardareditar(idcuota){
	var cuota = $("#txtcuota2").val(),
	descripcion = $("#txtdescripcion2").val(),
	precio = $("#txtprecio2").val();
swal({
		title:"¿Datos Correctos?",
		text: "¿Todos los datos ingresados estan bien",
		type: "warning",
		showCancelButton: true,
		closeOnConfirm: false,
		showLoaderOnConfirm: true
	}).then(function(){
		$.ajax({
			url:"<?php echo $urlweb?>servicios/ws_<?php echo $idpanel?>.php?accion=editar",
			type: 'POST',
			data:{"cuota":cuota, "descripcion":descripcion, "precio":precio, "idcuota":idcuota},
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
				 $('#frmbloques2').modal('close');
				$("#rw-" + idcuota).fadeOut("1000",function(){
                    $("#rw-" + idcuota).html(data.htmldata);
                    $("#rw-" + idcuota).fadeIn("1000");
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
function nuevo(idcuota, cuota, descripcion, precio){
	 $("#txtcuota2").val(cuota);
	 $("#txtdescripcion2").val(descripcion);
	 $("#txtprecio2").val(precio);
 	$('#frmbloques2').modal('open');
 	$("#txtcuota").focus();	
$('#p2').attr("href","javascript:guardareditar('"+idcuota+"')");
}

function open(){
	 $("#txtcuota").val("");
	 $("#txtdescripcion").val("");
	 $("#txtprecio").val("");
 	$('#frmbloques').modal('open');
 	$("#txtcuota").focus();	
}

</script>

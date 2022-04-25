<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
$idclase_curso = $_GET['idclase_curso'];
$idaño = $_GET['idaño'];
$parcial = $_GET['parcial'];
global $funciones;
if($funciones->clase_activa($idclase_curso)){      
$strsql = "SELECT cursos.nombre_curso, clases.nombre FROM `clase_curso_detalles` INNER JOIN cursos ON cursos.idcurso=clase_curso_detalles.idcurso INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase WHERE idclase_curso=?";
if($st = $mysqli->prepare($strsql)){
    $st->bind_param("i", $idclase_curso);
	$st->execute();
	if($st->errno == 0){
		$st->store_result();
		if($st->num_rows > 0){
			$st->bind_result($nombre_curso, $nombre_clase);
			$st->fetch();
				$st->close();
			}//cierre de consulta de valores retornados
		}
		else{
			echo "Error al ejecutar consulta: " . $st->error;
		}//Cierre de condicion de Ejecucion
	}
	else{
		echo "Error al preparar consulta: " . $mysqli->error;
	}	
?>
<div class="container center">
<h4><b>Administración de Notas</b></h4>
<?php
echo "<h5 class=\"flow-text\">Clase: $nombre_clase</h5>";
echo "<h6 class=\"flow-text\">Curso: $nombre_curso</h6>";
echo "<p style=\"display:none\" id=\"#parcial\" class=\"flow-text\">$parcial</p>";
?>
</div>
<table id="tbldata" class="display centered" width="100%" >
			  <thead>
          <tr>
		  	  <th>#</th>
		  	  <th>Expediente</th>				
              <th style="z-index: 1;">Nombre Completo</th>
			  <th>Sem. 1</th>
			  <th>Sem. 2</th>
			  <th>Sem. 3</th>
			  <th>Sem. 4</th>
			  <th>Sem. 5</th>
			  <th>Sem. 6</th>
			  <th>Sem. 7</th>
			  <th>Examen</th>
			  <th>Recup.</th>
			  <th>Total</th>
			  <th>Subir Nota</th>
          </tr>
        </thead>
              <tbody id="" class="">
             		<?php
			$strsql = "SELECT alumnos_matriculados.idexpediente, alumnos.nombre_completo  FROM `clase_curso_detalles` INNER JOIN alumnos_matriculados ON alumnos_matriculados.idcurso=clase_curso_detalles.idcurso INNER JOIN alumnos ON alumnos.idexpediente=alumnos_matriculados.idexpediente WHERE clase_curso_detalles.idclase_curso=? and alumnos_matriculados.idaño=? and alumnos_matriculados.lista_espera=0 ORDER BY alumnos.nombre_completo ASC";                
			if($s = $mysqli->prepare($strsql)){
                $s->bind_param("ii", $idclase_curso, $idaño);
				$s->execute();
				if($s->errno == 0){
					$s->store_result();
					if($s->num_rows > 0){
						$correlativo=0;
						$s->bind_result($idexpediente, $nombre_completo);
						while($s->fetch()){           
							$strsql_2 = "SELECT `sem1`, `sem2`,`sem3`,`sem4`,`sem5`,`sem6`,`sem7`, `examen`, `recup` FROM `notas` WHERE idclase_curso=? and idexpediente=? and idparcial=?";
	if ($stmt = $mysqli->prepare($strsql_2))
		{
		$stmt->bind_param("isi", $idclase_curso, $idexpediente, $parcial);
		$stmt->execute();
		if($stmt->errno == 0){
		$stmt->store_result();
		$stmt->bind_result($sem1, $sem2, $sem3, $sem4, $sem5, $sem6, $sem7, $examen, $recup);
		$stmt->fetch();
		}
	  else
		{
		echo "No se pudo ejecutar la consulta: " . $stmt->error;
		}
	}
	else{
		echo "Error al preparar consulta: " . $mysqli->error;
	}
						?>
							<tr id="rw-<?php echo $idexpediente ?>">
							<?php 
							?>
								<td><?php echo $correlativo+=1?></td>
								<td><?php echo $idexpediente?></td>
								<td style="background: #f6f6f6;"><?php echo $nombre_completo?></td>
								<?php
										if ($stmt->num_rows > 0)
										{
										?>
								<td><input min="0" max="100" class="validate" type="number" value="<?php echo $sem1?>"></td>
								<td><input min="0" max="100" class="validate" type="number" value="<?php echo $sem2?>"></td>
								<td><input min="0" max="100" class="validate" type="number" value="<?php echo $sem3?>"></td>
								<td><input min="0" max="100" class="validate" type="number" value="<?php echo $sem4?>"></td>
								<td><input min="0" max="100" class="validate" type="number" value="<?php echo $sem5?>"></td>
								<td><input min="0" max="100" class="validate" type="number" value="<?php echo $sem6?>"></td>
								<td><input min="0" max="100" class="validate" type="number" value="<?php echo $sem7?>"></td>
								<td><input min="0" max="100" class="validate" type="number" value="<?php echo $examen?>"></td>
								<td class="red lighten-4"><input min="0" max="70" class="validate" type="number" value="<?php echo $recup?>"></td>
								<td><input disabled type="text" value="<?php echo $sem1 + $sem2 + $sem3 + $sem4 + $sem5 + $sem6 + $sem7 + $examen?>"></td>
										<?php
										}else{
											?>
											<td><input min="0" max="100" class="validate" type="number"></td>
											<td><input min="0" max="100" class="validate" type="number"></td>
											<td><input min="0" max="100" class="validate" type="number"></td>
											<td><input min="0" max="100" class="validate" type="number"></td>
											<td><input min="0" max="100" class="validate" type="number"></td>
											<td><input min="0" max="100" class="validate" type="number"></td>
											<td><input min="0" max="100" class="validate" type="number"></td>
											<td><input min="0" max="100" class="validate" type="number"></td>	
											<td><input class="red lighten-4" min="0" max="70" class="validate" type="number"></td>										
											<td><input disabled type="text"></td>
													<?php
										}
								?>
								<td><a href="javascript:subir_nota('<?php echo $idexpediente ?>','<?php echo $idclase_curso ?>','<?php echo $_SESSION["idusuario"] ?>' )" class="btn green">
										<i class="material-icons">cloud_upload</i>
									</a></td>
							</tr>
				<?php
						}
                  
						$s->close();
					}else{
						echo "<p>No hay estudiantes matriculados en este año escolar.</p>";
                    }
                    
                    
                    //cierre de consulta de valores retornados
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
<?php
        }else{
?>
      <h2>El tiempo de subir notas ha vencido, consulte al departamento de secretaría</h2>      
<?php
}
?>
<script src="./recursos/js/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.4/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.0.0/js/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo $urlweb?>recursos/js/sweetalert2.min.js"></script>
<script>	
$('#seleccionaño').material_select();
$("#seleccionaño").change(function () {
	
})
var table = $('#tbldata').DataTable({
		select: true,
		            //con esta configuacion se puede hacer scroll sin la extensión SCROLLER (para tablas de pocos registros)
					//scrollY: "600px", 
          scrollCollapse: true,
          paging:true,
		  fixedColumns: {
			leftColumns: 3
		  },
        "scrollX": true,
		select: {
            toggleable: false
        },
		language: {
            select: {
                rows: {
                    _: "  | Has seleccionado %d filas",
                    0: "  | Haz click en la fila para seleccionarla",
                    1: "  | Solo 1 fila seleccionada"
                }
            }
        }
    });
function subir_nota(rowId, idclase_curso, idusuario){
  var sem1=document.getElementById('rw-' + rowId).cells[3].childNodes[0].value;
  var sem2=document.getElementById('rw-' + rowId).cells[4].childNodes[0].value;
  var sem3=document.getElementById('rw-' + rowId).cells[5].childNodes[0].value;
  var sem4=document.getElementById('rw-' + rowId).cells[6].childNodes[0].value;
  var sem5=document.getElementById('rw-' + rowId).cells[7].childNodes[0].value;
  var sem6=document.getElementById('rw-' + rowId).cells[8].childNodes[0].value;
  var sem7=document.getElementById('rw-' + rowId).cells[9].childNodes[0].value;
  var exa=document.getElementById('rw-' + rowId).cells[10].childNodes[0].value;
  var recup=document.getElementById('rw-' + rowId).cells[11].childNodes[0].value;
  var parcial = document.getElementById("#parcial").innerText;
$.post("<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=asignar_notas", { sem1: sem1,sem2: sem2,sem3: sem3,sem4: sem4,sem5: sem5,sem6: sem6,sem7: sem7, exa: exa, recup: recup, parcial: parcial, idclase_curso: idclase_curso, rowId:rowId, idusuario:idusuario}, function(data){
			try{
			console.log(data);
			if(data.type=="success"){
				document.getElementById('rw-' + rowId).cells[12].childNodes[0].value =Number(sem1)+Number(sem2)+Number(sem3)+Number(sem4)+Number(sem5)+Number(sem6)+Number(sem7)+Number(exa);
				Materialize.toast(data.text, 4000);
			}else{
				Materialize.toast(data.text, 4000);
			}
		}
		catch(err){
			alert(err.message);
		}
	}); 
};
</script>

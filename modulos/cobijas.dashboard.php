<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
$idaño=$_GET['idaño'];
$idcurso_fe=$_GET['idcurso'];
$modalidad=$_GET['modalidad'];
?>
<div class="container center">
<h4><b>Imprimir Actas Finales</b></h4>
<h4 id="curso" class="flow-text"></h4>
<h5 id="año"></h5>
</div>
<div id="char center">
<canvas id="ChartMatricula" ></canvas>
</div>
<div class="row">
<div class="col l4 s12 card-panel green lighten-4"><h5 class="flow-text">Aprobado</h5></div>
<div class="col l4 s12 card-panel yellow lighten-4"><h5 class="flow-text">Aprobado en Recuperación</h5></div>
<div class="col l4 s12 card-panel red lighten-4"><h5 class="flow-text">Reprobado</h5></div>
</div>
<table id="tbldata" class="display responsive centered" width="100%">
    <thead>
		<tr>
		<th style="z-index: 1;" class="center">ESTUDIANTE</th>
			<?php
					$strsql_2 = 'SELECT clases.nombre, clase_curso_detalles.idclase, cursos.nombre_curso, year_escolar.nombre FROM `clase_curso_detalles` INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase INNER JOIN cursos ON clase_curso_detalles.idcurso=cursos.idcurso INNER JOIN year_escolar ON clase_curso_detalles.idaño=year_escolar.idaño WHERE clase_curso_detalles.idcurso=? and clase_curso_detalles.idaño=? and clases.semestre=? ORDER BY clase_curso_detalles.idcurso';
			if($st = $mysqli->prepare($strsql_2)){
				$st->bind_param("iii",$idcurso_fe, $idaño, $modalidad);
				$st->execute();
				if($st->errno == 0){
					$st->store_result();
					if($st->num_rows > 0){
						$st->bind_result($alumno, $idcurso, $nombre_curso, $nombre_año);
						while($st->fetch()){
						?>
					 <th class="center"><?php echo $alumno?></th>
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
    <tbody>
<?php
					$strsql = 'SELECT alumnos.idexpediente, alumnos.nombre_completo, alumnos_matriculados.idcurso FROM `alumnos_matriculados`  INNER JOIN alumnos ON alumnos.idexpediente=alumnos_matriculados.idexpediente  WHERE alumnos_matriculados.idaño=? and alumnos_matriculados.idcurso=? and alumnos_matriculados.lista_espera=0';
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->bind_param("ii", $idaño, $idcurso_fe);
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($expediente, $alumno, $idcurso);
						while($stmt->fetch()){
						?>
							<tr id="rw-<?php echo $idcurso?>" >
								<td><?php echo $alumno?></td>
								<?php
					$strsql_2 = 'SELECT AVG(sem1 + sem2 + sem3 + sem4 + sem5 + sem6 + sem7 + examen) AS total, SUM(recup) as recup FROM `clase_curso_detalles` INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase RIGHT OUTER JOIN notas ON notas.idclase_curso=clase_curso_detalles.idclase_curso WHERE clase_curso_detalles.idcurso=? and clase_curso_detalles.idaño=? and notas.idexpediente=? and clases.semestre=? GROUP BY clases.idclase ORDER BY clase_curso_detalles.idcurso';
			if($st = $mysqli->prepare($strsql_2)){
				$st->bind_param("iisi", $idcurso, $idaño, $expediente, $modalidad);
				$st->execute();
				if($st->errno == 0){
					$st->store_result();
					if($st->num_rows > 0){
						$st->bind_result($total2, $recup);
						while($st->fetch()){
							$total = round($total2);
						if($recup>0){
							?>
							<td class="card-panel yellow lighten-3"><?php echo round($total) ?></td>
							<?php
						}elseif($total>=70){
							?>
							<td class="card-panel green lighten-4"><?php echo round($total) ?></td>
								<?php
						}else{
							?>
							<td class="card-panel red lighten-4"><?php echo round($total) ?></td>
								<?php
						}

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
<script src="./recursos/js/print/datatables.min.js"></script>
<script src="<?php echo $urlweb?>recursos/js/sweetalert2.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.0.0/js/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo $urlweb?>recursos/js/chart.js-3.1.1-1/package/dist/chart.min.js"></script>
<script>
var ctx2 = document.getElementById("ChartMatricula").getContext('2d');	
$(document).ready( function () {
	$("#curso").html("<?php echo $nombre_curso ?>");
	$("#año").html("<?php echo $nombre_año ?>");
    $('#tbldata').DataTable({
    	responsive: true,
		scrollCollapse: true,
		paging:true,
		"scrollX": true,
		scrollY: "600px",
		fixedColumns: true,
		destroy:true,
           dom: 'PBfrtip',
        buttons: [
            'copy', {
                extend: 'excel',
                text: 'Excel',
                title: 'SAGL | Liceo Militar de Honduras | Actas Finales',
                filename: 'ActasFinales',
            }, {
                extend: 'pdf',
                text: 'PDF',
                orientation: 'landscape',
                title: 'SAGL | Liceo Militar de Honduras | Actas Finales',
                filename: 'ActasFinales',
            }, {
                extend: 'csv',
                text: 'CSV',
                title: 'SAGL | Liceo Militar de Honduras | Actas Finales',
				filename: 'ActasFinales',
            }
        ]
    });
});	


var ChartMatricula = new Chart(ctx2, {
    type: 'line',
    data: {
  labels: [
	<?php 
	$strsql = "SELECT  alumnos.nombre_completo FROM `alumnos_matriculados`  INNER JOIN alumnos ON alumnos.idexpediente=alumnos_matriculados.idexpediente  WHERE alumnos_matriculados.idaño=$idaño and alumnos_matriculados.idcurso=$idcurso_fe and alumnos_matriculados.lista_espera=0";
		$resultado = $mysqli->query($strsql);
		//$stmt->bind_param("ii", $idaño, $idcurso_fe);
		$stmt->execute();
		$stmt->store_result();
		while ($registros = mysqli_fetch_array($resultado)) 
		{
		?>
		'<?php echo $registros["nombre_completo"]?>',
		<?php
		}
        $stmt->close();
        ?>
  ],
  datasets: [{
    label: 'Promedio Final',
    data: [
		<?php 
	$strsql = "SELECT AVG(sem1 + sem2 + sem3 + sem4 + sem5 + sem6 + sem7 + examen) AS total FROM `clase_curso_detalles` INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase RIGHT OUTER JOIN notas ON notas.idclase_curso=clase_curso_detalles.idclase_curso WHERE clase_curso_detalles.idcurso=$idcurso and clase_curso_detalles.idaño=$idaño and clases.semestre=$modalidad GROUP BY notas.idexpediente ORDER BY clase_curso_detalles.idcurso";
		$resultado = $mysqli->query($strsql);
		//$st->bind_param("iisi", $idcurso_fe, $idaño, $modalidad);
		$stmt->execute();
		$stmt->store_result();
		while ($registros = mysqli_fetch_array($resultado)) 
		{
		?>
		'<?php echo $registros["total"]?>',
		<?php
		}
        $stmt->close();
        ?>
	],
    fill: true,
    borderColor: 'rgb(75, 192, 192)',
    tension: 0.1
  }]
}
});

</script>

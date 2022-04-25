<?php
	global $mysqli;
	global $urlweb;
	global $idmodulo;
	global $idbloque;
?>
<h3 class="center grey-text">Administrador de Clases</h3>
 <p class="flow-text">A continuación se muestran las clases asignadas a su usuario por año escolar, si no aparecen correctamente sus clases contacte al soporte técnico.</span></p>
 <h5 class="center">Haga click en el año escolar.</h5>
  <ul  class="collapsible popout" data-collapsible="accordion">
<?php
        global $funciones;
if($funciones->login_check()){      
?>

		<?php
			$strsql = "SELECT `idaño`, `nombre`, `descripcion`, `fecha_inicio`, `fecha_final` FROM `year_escolar` WHERE activo=1";
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($idaño, $nombre, $descripcion, $fecha_inicio, $fecha_final);
						while($stmt->fetch()){
						?> 
    <li >
      <div id="<?php echo $idaño?>" class="collapsible-header"><i class="material-icons">event</i>
          <?php echo $nombre. " Liceo Militar de Honduras"?> 
        </div>
      <div class="collapsible-body" id="body-<?php echo $idaño?>">           
              <table class="highlight centered responsive-table">
			  <thead>
          <tr>
		  	  <th>No.</th>				
              <th>Curso</th>
			  <th>Clase</th>
			  <th>Semestre</th>
              <th>Asignar notas</th>
			  <th>Descargar notas</th>
          </tr>
        </thead>
              <tbody id="tabla-<?php echo $idmenu ?>" class="sortable">
             		<?php
			$strsql = "SELECT DISTINCT clase_curso_detalles.idclase_curso, clase_curso_detalles.idclase, clase_curso_detalles.idcurso, cursos.nombre_curso, clases.nombre, clases.semestre  FROM `maestro_grado_detalles` INNER JOIN clase_curso_detalles ON clase_curso_detalles.idclase_curso=maestro_grado_detalles.idclase_curso INNER JOIN cursos ON cursos.idcurso=clase_curso_detalles.idcurso INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase  INNER JOIN alumnos_matriculados ON alumnos_matriculados.idcurso=clase_curso_detalles.idcurso where maestro_grado_detalles.idusuario=? and clase_curso_detalles.idaño=? and clase_curso_detalles.activo=1";                
			if($s = $mysqli->prepare($strsql)){
                $s->bind_param("si", $_SESSION["idusuario"], $idaño);
				$s->execute();
				if($s->errno == 0){
					$s->store_result();
					if($s->num_rows > 0){
						$correlativo=0;
						$s->bind_result($idclase_curso, $idclase, $idcurso, $nombre_curso, $nombre_clase, $semestre);
						while($s->fetch()){           
						?>
							<tr id="rw-<?php echo $idcurso."-".$idclase ?>">
								<td><?php echo $correlativo+=1?></td>
								<td><?php echo $nombre_curso?></td>
								<td><?php echo $nombre_clase?></td>
								<td><?php echo ($semestre!=0) ? $semestre : "Clase Anual"?></td>
								<?php if(($semestre==1) || ($semestre==2)){?>
								<td class="center">
<div class="col s12 l12">
<div class="input-field">
<select id="seleccionaño" class="icons" name="seleccionaño" style="display: none;">
<option value="" disabled selected>Seleccione un parcial</option>
<option data-icon="<?php $urlweb ?>temas/LMN2018/img/logo_lmh.png" class="left circle" value="?mod=dashboard&panel=asignar_notas_clases&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=1">I PARCIAL</option>
<option data-icon="<?php $urlweb ?>temas/LMN2018/img/logo_lmh.png" class="left circle" value="?mod=dashboard&panel=asignar_notas_clases&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=2">II PARCIAL</option>
</select>
</div>
</div>
</div>									
								</td>
								<td class="center">
								<div class="col s12 l12">
<div class="input-field">
<select id="seleccionaño" name="seleccionaño" style="display: none;">
<option value="" disabled selected>Seleccione un parcial</option>
<option data-icon="<?php $urlweb ?>temas/LMN2018/img/descargar_notas.png" class="left circle" value="<?php echo $urlweb?>reportes/rpt_cuadro1.php?&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=1">I PARCIAL</option>
<option data-icon="<?php $urlweb ?>temas/LMN2018/img/descargar_notas.png" class="left circle" value="<?php echo $urlweb?>reportes/rpt_cuadro1.php?&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=2">II PARCIAL</option>
</select>
</div>
</div>
</div>
								</td>
								<?php }else{
								?>                
								<td class="center">
<div class="col s12 l12">
<div class="input-field">
<select id="seleccionaño" class="icons" name="seleccionaño" style="display: none;">
<option value="" disabled selected>Seleccione un parcial</option>
<option data-icon="<?php $urlweb ?>temas/LMN2018/img/logo_lmh.png" class="left circle" value="?mod=dashboard&panel=asignar_notas_clases&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=1">I PARCIAL</option>
<option data-icon="<?php $urlweb ?>temas/LMN2018/img/logo_lmh.png" class="left circle" value="?mod=dashboard&panel=asignar_notas_clases&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=2">II PARCIAL</option>
<option data-icon="<?php $urlweb ?>temas/LMN2018/img/logo_lmh.png" class="left circle" value="?mod=dashboard&panel=asignar_notas_clases&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=3">III PARCIAL</option>
<option data-icon="<?php $urlweb ?>temas/LMN2018/img/logo_lmh.png" class="left circle" value="?mod=dashboard&panel=asignar_notas_clases&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=4">IV PARCIAL</option>
</select>
</div>
</div>
</div>									
								</td>
								<td class="center">
								<div class="col s12 l12">
<div class="input-field">
<select id="seleccionaño" name="seleccionaño" style="display: none;">
<option value="" disabled selected>Seleccione un parcial</option>
<option data-icon="<?php $urlweb ?>temas/LMN2018/img/descargar_notas.png" class="left circle" value="<?php echo $urlweb?>reportes/rpt_cuadro1.php?&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=1">I PARCIAL</option>
<option data-icon="<?php $urlweb ?>temas/LMN2018/img/descargar_notas.png" class="left circle" value="<?php echo $urlweb?>reportes/rpt_cuadro1.php?&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=2">II PARCIAL</option>
<option data-icon="<?php $urlweb ?>temas/LMN2018/img/descargar_notas.png" class="left circle" value="<?php echo $urlweb?>reportes/rpt_cuadro1.php?&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=3">III PARCIAL</option>
<option data-icon="<?php $urlweb ?>temas/LMN2018/img/descargar_notas.png" class="left circle" value="<?php echo $urlweb?>reportes/rpt_cuadro1.php?&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=4">IV PARCIAL</option>
</select>
</div>
</div>
</div>
								</td><?php }?>
							</tr>
				<?php
						}
                  
						$s->close();
					}else{
						echo "<p>No tiene clases matriculadas para este año escolar</p>";
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
              
                 </div>
            </li>
        
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
 </ul>
<?php
        }else{
?>
      <h2>Ud no tiene permisos </h2>      
<?php
}
?>

 	
<script src="<?php echo $urlweb?>recursos/js/sweetalert2.min.js"></script>
<script>
$('#seleccionaño').material_select();
$(function(){
      // bind change event to select
      $('#seleccionaño').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
			window.open(url);
          }
          return false;
      });
    });
</script>

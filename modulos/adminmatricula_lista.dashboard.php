<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
$idexpediente=$_GET['idexpediente'];
$idaño=$_GET['idaño'];
global $funciones;
if($funciones->login_estado()){   
?>
<h3 class="center grey-text">Boleta de Matrícula</h3>
<?php
    $idexpediente = $_GET['idexpediente'];
    $dir = "uploads/avatar/";
    if(file_exists($dir.$idexpediente.".jpg")){
        $direccion=$dir.$idexpediente.".jpg";
    }else{
        $direccion=$dir."default.jpg";
    }
?>
 <script type="text/javascript">
var direccion = ('<?php echo $direccion  ?>');
</script>
<?php
$strsql = "SELECT alumnos.idexpediente, alumnos_matriculados.idcurso, cursos.nombre_curso, alumnos_matriculados.idseccion, secciones.nombre_seccion, alumnos_matriculados.idanio_militar, anios_militares.descripcion, year_escolar.nombre, alumnos.rtn, alumnos.nombre_completo, alumnos.fecha_nacimiento_alumno, alumnos.tiposangre, alumnos.sexo, alumnos.telefono_alumno, alumnos.email_alumno, alumnos.residencia_alumno, alumnos.idreligion, religiones.religion, alumnos.iddepto, departamentos.departamento, alumnos.idnacionalidad, nacionalidades.nacionalidad, alumnos.idinstitucion_previa, instituciones_previas.institucion_previa, alumnos.ciudad_previa, alumnos.modalidad, alumnos.promedio_anterior, alumnos.idciudad, ciudades.ciudad, alumnos.nombre_padre, alumnos.direccion_padre, alumnos.ciudad_padre, ciu_padre.ciudad, alumnos.nacionalidad_padre, nacio_padre.nacionalidad, alumnos.telefono_padre, alumnos.email_padre, alumnos.nombre_madre, alumnos.direccion_madre, alumnos.ciudad_madre, ciu_madre.ciudad, alumnos.nacionalidad_madre, nacio_madre.nacionalidad, alumnos.telefono_madre, alumnos.email_madre, alumnos_matriculados.tienebeca, alumnos_matriculados.esinterno, alumnos.id_padre, alumnos.id_madre, alumnos.nombre_encargado, alumnos.direccion_encargado, alumnos.telefono_encargado, alumnos.correo_encargado FROM `alumnos`INNER JOIN alumnos_matriculados ON alumnos.idexpediente = alumnos_matriculados.idexpediente  INNER JOIN cursos ON alumnos_matriculados.idcurso = cursos.idcurso INNER JOIN secciones ON alumnos_matriculados.idseccion = secciones.idseccion INNER JOIN anios_militares ON alumnos_matriculados.idanio_militar = anios_militares.idanio_militar INNER JOIN nacionalidades ON alumnos.idnacionalidad = nacionalidades.idnacionalidad INNER JOIN ciudades ON alumnos.idciudad = ciudades.idciudad INNER JOIN departamentos ON alumnos.iddepto = departamentos.iddepto INNER JOIN year_escolar ON alumnos_matriculados.idaño = year_escolar.idaño INNER JOIN instituciones_previas ON alumnos.idinstitucion_previa = instituciones_previas.idinstitucion INNER JOIN religiones ON alumnos.idreligion = religiones.idreligion INNER JOIN ciudades AS ciu_padre ON alumnos.ciudad_padre = ciu_padre.idciudad INNER JOIN nacionalidades as nacio_padre ON alumnos.nacionalidad_padre = nacio_padre.idnacionalidad INNER JOIN ciudades as ciu_madre ON alumnos.ciudad_madre = ciu_madre.idciudad INNER JOIN nacionalidades as nacio_madre ON alumnos.nacionalidad_madre = nacio_madre.idnacionalidad WHERE alumnos.idexpediente=? and alumnos_matriculados.idaño=?";
if($st = $mysqli->prepare($strsql)){
    $st->bind_param("si", $idexpediente, $idaño);
	$st->execute();
	if($st->errno == 0){
		$st->store_result();
		if($st->num_rows > 0){
			$st->bind_result($idexpediente, $idcurso, $nombre_curso, $idseccion, $nombre_seccion, $idanio_militar, $anio_militar, $nombre, $rtn, $nombre_completo, $fecha_nacimiento_alumno, $tiposangre, $sexo, $telefono_alumno, $email_alumno, $residencia_alumno, $idreligion, $religion, $iddepto, $departamento, $idnacionalidad,$nacionalidad_alumno, $idinstitucion,$institucion_previa, $ciudad_previa, $modalidad, $promedio_anterior, $idciudad, $ciudad_alumno, $nombre_padre, $direccion_padre, $ciudad_padre, $ciu_padre, $nacionalidad_padre, $nacio_padre, $telefono_padre, $email_padre, $nombre_madre, $direccion_madre, $ciudad_madre, $ciu_madre, $nacionalidad_madre, $nacio_madre, $telefono_madre, $email_madre, $tienebeca, $esinterno, $id_padre, $id_madre, $nombre_encargado, $direccion_encargado, $telefono_encargado, $correo_encargado);
			$st->fetch();
?>			
<div class="bordes">
   <div class="row">
      <div class="col s12 l2">
         <center><img class="z-depth-4 responsive-img" src="<?php echo $direccion ?>" style="width: 100px; height: 118px; top: 2px;"></center>
      </div>
      <div class="input-field  s12 col l2">
         <i class="material-icons prefix">accessibility</i>
         <input disabled id="txtidexpediente" value="<?php echo $idexpediente?>" type="text" class="validate">
         <label for="icon_prefix">Expediente</label>
      </div>      
      <div class="input-field  s12 col l8">
         <i class="material-icons prefix">account_box</i>
         <input required="true" id="txtnombre_alumno" value="<?php echo $nombre_completo?>" type="text" class="validate">
         <label for="icon_prefix">Nombre Completo</label>
      </div>
      <div class="row">
         <div class="input-field s12 col l5">
            <i class="material-icons prefix">assignment</i>
            <input id="txtrtn" type="text" value="<?php echo $rtn?>" class="validate">
            <label for="icon_prefix">DNI</label>		
         </div>
         <div class="input-field s12 col l5">
            <i class="material-icons prefix">email</i>
            <input disabled id="txtemail_alumno" value="<?php echo $idexpediente."@lmh.edu.hn"?>" type="email" class="validate">
            <label for="icon_prefix">Correo Electrónico</label>		
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col l5 s12">
         <form action="#">
            Seleccione una imagen: <input id="adj" type="file" name="adj"><br><br>
         </form>
      </div>
   </div>
</div>	
<div id="list" class="nav-wrapper white z-depth-4" >
   <ul id="tabs-swipe-demo" class="tabs" style="background-color: #007045;">
      <li class="tab col s3"><a class="active" href="#DatosGenerales">Datos Generales</a></li>
      <li class="tab col s3"><a href="#DatosAcademicos">Datos Académicos</a></li>
      <li class="tab col s3"><a href="#DatosPadres">Datos Familiares</a></li>
      <li class="tab col s3"><a href="#OtrosDatos">Otros Datos</a></li>
   </ul>
</div>
<div id="DatosGenerales" class="bordes">
   <h4 id="DatosGenerales" class="header2">Datos Generales</h4>
   <br>
   <div class="row">
      <div class="col s12 l6">
         Fecha de nacimiento:
         <div class="input-field inline">
            <input value="<?php echo $fecha_nacimiento_alumno?>" id="txtfechanac" type="text"  class="validate">
            <label for="email_inline">Calendario</label>
         </div>
      </div>
      <div class="col s12 l6">
         <span>Tipo Sangre</span>
         <select id="cmb_tiposangre" name="cmb_tiposangre">
         	<option value="<?php echo $tiposangre?>"><?php echo $tiposangre?></option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="NO DEFINIDO">NO DEFINIDO</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
            <option value="RH+">RH+</option>
         </select>
      </div>
   </div>
   <div class="row">
      <div class="row">
         <div class="input-field col s12 l6">
            <input placeholder="Ingrese el domicilio" value="<?php echo $residencia_alumno?>" id="txtdomicilio" type="text">
            <label class="active">Dirección</label>
         </div>
         <div class="input-field col s12 l4">
            <span>Sexo</span>
            <select id="cmb_sexo" name="cmb_sexo">
           	   <option value="<?php echo $sexo?>"><?php 
           	   if($sexo==1){
           	   	echo "Masculino";
           	   }else{
           	   	echo "Femenino";
           	   }
           	   	?></option>	
               <option value="0">Femenino</option>
               <option value="1">Masculino</option>
            </select>
         </div>         	
      </div>
      <div class="row">
        <div class="input-field col s12 l4">
            <span>Nacionalidad:</span>
            <select id="cmb_nacionalidad_alumno" name="cmb_nacionalidad_alumno">
            <option value="<?php echo $idnacionalidad?>"><?php echo $nacionalidad_alumno ?></option>
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
				<option value="<?php echo $idnacionalidad?>"><?php echo $nacionalidad ?></option>
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
        <div class="input-field col s12 l4">
            <span>Ciudad:</span>
            <select id="cmb_ciudad_alumno" name="cmb_ciudad_alumno">
            <option  value="<?php echo $idciudad?>"><?php echo $ciudad_alumno ?></option>
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
				<option value="<?php echo $idciudad?>"><?php echo $ciudad ?></option>
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
        <div class="input-field col s12 l4">
            <span>Departamento:</span>
            <select id="cmb_depto" name="cmb_depto">
            <option value="<?php echo $iddepto?>"><?php echo $departamento ?></option>
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
      </div>
      <div class="row">
         <div class="col s12 l6">
            Número de Telefono:
            <div class="input-field inline">
               <input value="<?php echo $telefono_alumno ?>" id="txttelefono_alumno" type="text"  class="validate">
               <label for="email_inline">P.E +504 0000-0000</label>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col s12 l6">
            <span>Tiene Beca</span>
            <select id="cmb_tienebeca" name="cmb_tienebeca">
               <option value="<?php echo $tienebeca ?>"><?php 
           	   if($tienebeca==1){
           	   	echo "Si";
           	   }else{
           	   	echo "No";
           	   }
           	   	?></option>               	
               <option value="0">No</option>
               <option value="1">Si</option>
            </select>
         </div>
         <div class="col s12 l6">
            <span>Es interno</span>
            <select id="cmb_esinterno" name="cmb_esinterno">
               <option value="<?php echo $esinterno ?>"><?php 
           	   if($esinterno==1){
           	   	echo "Si";
           	   }else{
           	   	echo "No";
           	   }
           	   	?></option>
               <option value="0">No</option>
               <option value="1">Si</option>
            </select>
         </div>         
      </div>
   </div>
</div>
<div id="DatosAcademicos" class="bordes">
   <h4 id="DatosAcademicos" class="header2">Datos Académicos</h4>
   <br>
   <div class="row">
      <div class="col s12 l4">
         <span>Matricular en:</span>
         <select id="cmb_curso" name="cmb_curso">
         <option value="<?php echo $idcurso ?>"><?php echo $nombre_curso ?></option>
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
         <option value="<?php echo $idaño ?>"><?php echo $nombre ?></option>
<?php
			$strsql = "SELECT `idaño`, `nombre`FROM `year_escolar` where activo=1";
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
         <option value="<?php echo $idanio_militar ?>"><?php echo $anio_militar ?></option>
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
   <p class="flow-text">Datos de Educación Prévia</p>
   <div class="row">
      <div class="col s12 l6">
         <span>Institución:</span>
         <select id="cmb_institucion_previa" name="cmb_institucion_previa">
         <option value="<?php echo $idinstitucion ?>"><?php echo $institucion_previa ?></option>
<?php
			$strsql = "SELECT `idinstitucion`, `institucion_previa` FROM `instituciones_previas`";
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($idinstitucion, $institucion_previa);
						while($stmt->fetch()){
						?>
				<option value="<?php echo $idinstitucion ?>"><?php echo $institucion_previa ?></option>
				<?php
					}
					?>
			</select>
         <a href="#modal1">Agregar nueva Institución</a>
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
         <select id="cmb_ciudad_previa" name="cmb_ciudad_previa">
         <option value="<?php ?>"><?php echo $ciudad_previa?></option>
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
     <div class="row">
      <div class="col s12 l6">
         <span>Tipo:</span>
         <select id="cmb_modalidad" name="cmb_modalidad">
         	<option value="<?php echo $modalidad ?>"><?php echo $modalidad ?></option>
            <option value="NO DEFINIDO">NO DEFINIDO</option>
            <option value="Público">Público</option>
            <option value="Privado">Privado</option>
         </select>
      </div>
      <div class="col s12 l6">
         <span>Promedio:</span>
         <input placeholder="Promedio obtenido" value="<?php echo $promedio_anterior ?>" type="number" name="txtpromedio" id="txtpromedio">
      </div>     	
     </div> 

</div>
<?php		
									//$stmt->close();
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
<div id="DatosPadres" class="bordes">
   <h4 id="DatosAcademicos" class="header2">Datos Familiares</h4>
   <br>
   <div class="row">
      <p class="flow-text">Datos del Padre</p>
      <div class="input-field col s12 l4">
         <input id="txtnombre_padre" value="<?php echo $nombre_padre?>" type="text" class="validate">
         <label for="last_name">Nombre Completo</label>
      </div>
      <div class="input-field col s12 l4">
         <input id="txtid_padre" value="<?php echo $id_padre?>" type="text" class="validate">
         <label for="identidad"># Identidad</label>
      </div>
      <div class="input-field col s12 l4">
         <input id="txtdireccion_padre" value="<?php echo $direccion_padre?>" type="text" class="validate">
         <label for="last_name">Dirección</label>
      </div>
   </div>
   <div class="row">
      <div class="col s6 l6">
         <span>Ciudad:</span>
         <select id="cmb_ciudad_padre" name="cmb_ciudad_padre">
         <option value="<?php echo $ciudad_padre ?>"><?php echo $ciu_padre ?></option>
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
      <div class="col s6 l6">
         <span>Nacionalidad:</span>
         <select id="cmb_nacionalidad_padre" name="cmb_nacionalidad_padre">
         <option value="<?php echo $nacionalidad_padre ?>"><?php echo $nacio_padre ?></option>
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
   </div>
   <div class="row">
      <div class="input-field col s12 l6">
         <input value="<?php echo $telefono_padre?>" placeholder="Ingrese el número telefónico" id="txttelefono_padre" type="text">
         <label class="active">Telefono</label>
      </div>
      <div class="input-field col s12 l6">
         <input value="<?php echo $email_padre ?>" placeholder="Ingrese el correo electrónico" id="txtemail_padre" type="email" class="validate">
         <label class="active">E-Mail</label>
      </div>
   </div>
   <div class="row">
      <p class="flow-text">Datos de la Madre</p>
      <div class="input-field col s12 l4">
         <input value="<?php echo $nombre_madre?>" id="txtnombre_madre" type="text" class="validate">
         <label for="last_name">Nombre Completo</label>
      </div>
      <div class="input-field col s12 l4">
         <input value="<?php echo $id_madre?>" id="txtid_madre" type="text" class="validate">
         <label for=""># Identidad</label>
      </div>
      <div class="input-field col s12 l4">
         <input value="<?php echo $direccion_madre?>" id="txtdireccion_madre" type="text" class="validate">
         <label for="last_name">Dirección</label>
      </div>
   </div>
   <div class="row">
      <div class="col s6 l6">
         <span>Ciudad:</span>
         <select id="cmb_ciudad_madre" name="cmb_ciudad_madre">
         <option value="<?php echo $ciudad_madre ?>"><?php echo $ciu_madre ?></option>
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
      <div class="col s6 l6">
         <span>Nacionalidad:</span>
         <select id="cmb_nacionalidad_madre" name="cmb_nacionalidad_madre">
         <option value="<?php echo $nacionalidad_madre ?>"><?php echo $nacio_madre ?></option>
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
   </div>
   <div class="row">
      <div class="input-field col s12 l6">
         <input value="<?php echo $telefono_madre?>" placeholder="Ingrese el número telefónico" id="txttelefono_madre" type="text">
         <label class="active">Telefono</label>
      </div>
      <div class="input-field col s12 l6">
         <input value="<?php echo $email_madre?>" placeholder="Ingrese el correo electrónico" id="txtemail_madre" type="email" class="validate">
         <label class="active">E-Mail</label>
      </div>
   </div>
   <p class="flow-text">Datos del Encargado</p>
      <div class="input-field col s12 l6">
         <input value="<?php echo $nombre_encargado?>" id="txtnombre_encargado" type="text" class="validate">
         <label for="last_name">Nombre Completo</label>
      </div>
      <div class="input-field col s12 l6">
         <input value="<?php echo $direccion_encargado?>" id="txtdireccion_encargado" type="text" class="validate">
         <label for="last_name">Dirección</label>
      </div>
      <div class="row">
      <div class="input-field col s12 l6">
         <input value="<?php echo $telefono_encargado?>" id="txtcelular_encargado" type="text" class="validate">
         <label for="last_name">Télefono</label>
      </div>
      <div class="input-field col s12 l6">
         <input value="<?php echo $correo_encargado?>" id="txtcorreo_encargado" type="text" class="validate">
         <label for="last_name">Correo Electrónico</label>
      </div>
   </div>
</div>

<div id="OtrosDatos" class="bordes">
   <h4 id="DatosAcademicos" class="header2">Otros Datos</h4>
   <br>	
   <div class="row">
      <p class="flow-text">Datos Religiosos</p>
      <div class="col s12 l12">
         <span>Religión:</span>
         <select id="cmb_religion" name="cmb_religion">
         <option value="<?php echo $idreligion ?>"><?php echo $religion ?></option>
<?php
			$strsql = "SELECT `idreligion`, `religion` FROM `religiones`";
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($idreligion, $religion);
						while($stmt->fetch()){
						?>
				<option value="<?php echo $idreligion ?>"><?php echo $religion ?></option>
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
<div id="modal1" class="modal">
<div id="DatosInstitucion" class="bordes">
   <h4 id="DatosInstitucion" class="header2">Agregar Nueva Institución</h4>
   <br>
   <div class="row">
   <div class="input-field  s12 col l6">
         <i class="material-icons prefix">domain</i>
         <input required="true" id="txtinstitucion_nombre" type="text" class="validate">
         <label for="icon_prefix">Ingrese el Nombre de la Institución</label>
   </div>
   <div class="input-field  s12 col l6">
         <i class="material-icons prefix">edit_location</i>
         <input required="true" id="txtinstitucion_ciudad" type="text" class="validate">
         <label for="icon_prefix">Ingrese la Localización</label>
   </div>
   </div>
   <a id="send" href="javascript:guardarinstitucion()" class="btn light-green darken-4">Guardar<i class="material-icons right">send</i></a>
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
function guardarinstitucion(){
   var nombre_institucion = $("#txtinstitucion_nombre").val(),
    ciudad_institucion = $("#txtinstitucion_ciudad").val(),
    nombre_institucion = nombre_institucion.toUpperCase();

    
    var datos = new FormData();
   //enviar Datos Institución
   datos.append("action", "update");
   datos.append("nombre_institucion", nombre_institucion);
   datos.append("ciudad_institucion", ciudad_institucion);
   if (nombre_institucion!="") {
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
                    url: "<?php echo $urlweb?>servicios/ws_<?php echo $idpanel?>.php?accion=nuevo_institucion",
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
                           $("#cmb_institucion_previa").append(retorno.htmldata);
                           $('#modal1').modal('close');
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
         txtinstitucion_nombre.focus();
            swal({
                title: "Error!",
                text: "Ingrese un nombre válido.",
                type: "error",
                showConfirmButton: true
            });
        }
} 
function guardarnuevo() {
//Datos Generales	
var nombre = $("#txtnombre_alumno").val(),
    rtn = $("#txtrtn").val(),
    idexpediente = $("#txtidexpediente").val(),
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
	idaño = <?php echo $_GET['idaño'];?>,
    seccion = $("#cmb_seccion").val(),
    año_escolar = $("#cmb_year_escolar").val(),
    añomilitar = $("#cmb_militar").val(),
    institucion_previa = $("#cmb_institucion_previa").val(),
    ciudad_previa = $( "#cmb_ciudad_previa option:selected").html(),
    modalidad = $("#cmb_modalidad").val(),
    promedio_previo = $("#txtpromedio").val();
//Datos Familiares  papa  
var nombre_padre = $("#txtnombre_padre").val(),
id_padre = $("#txtid_padre").val(),
    direccion_padre = $("#txtdireccion_padre").val(),
    ciudad_padre = $("#cmb_ciudad_padre").val(),
    nacionalidad_padre = $("#cmb_nacionalidad_padre").val(),
    telefono_padre = $("#txttelefono_padre").val(),
    email_padre = $("#txtemail_padre").val();
    nombre_padre = nombre_padre.toUpperCase(); 
//Datos Familiares  mama  
var nombre_madre = $("#txtnombre_madre").val(),
id_madre = $("#txtid_madre").val(),
    direccion_madre = $("#txtdireccion_madre").val(),
    ciudad_madre = $("#cmb_ciudad_madre").val(),
    nacionalidad_madre = $("#cmb_nacionalidad_madre").val(),
    telefono_madre = $("#txttelefono_madre").val(),
    email_madre = $("#txtemail_madre").val();  
    nombre_madre = nombre_madre.toUpperCase();   
     //Datos Familiares  Encargado  
var nombre_encargado = $("#txtnombre_encargado").val(),     
   direccion_encargado = $("#txtdireccion_encargado").val(),
   celular_encargado = $("#txtcelular_encargado").val(), 
   correo_encargado = $("#txtcorreo_encargado").val();
   nombre_encargado = nombre_encargado.toUpperCase();
//Otros Datos
var religion = $("#cmb_religion").val();
        var datos = new FormData();
        var avatar = $("#adj")[0].files[0];
        //enviar Datos Alumnos
        datos.append("action", "update");
        datos.append("idexpediente", idexpediente);
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
        datos.append("idaño", idaño);
        datos.append("curso", curso);
        datos.append("seccion", seccion);
        datos.append("año_escolar", año_escolar);
        datos.append("añomilitar", añomilitar);
        datos.append("institucion_previa", institucion_previa);
        datos.append("ciudad_previa", ciudad_previa);
        datos.append("modalidad", modalidad);
        datos.append("promedio_previo", promedio_previo);
        //Datos Familiares
        datos.append("id_padre", id_padre);
        datos.append("nombre_padre", nombre_padre);
        datos.append("direccion_padre", direccion_padre);
        datos.append("ciudad_padre", ciudad_padre);
        datos.append("nacionalidad_padre", nacionalidad_padre);
        datos.append("telefono_padre", telefono_padre);
        datos.append("email_padre", email_padre);

        datos.append("id_madre", id_madre);
        datos.append("nombre_madre", nombre_madre);
        datos.append("direccion_madre", direccion_madre);
        datos.append("ciudad_madre", ciudad_madre);
        datos.append("nacionalidad_madre", nacionalidad_madre);
        datos.append("telefono_madre", telefono_madre);
        datos.append("email_madre", email_madre);

        //encargado
        datos.append("nombre_encargado", nombre_encargado);
        datos.append("direccion_encargado", direccion_encargado);
        datos.append("celular_encargado", celular_encargado);
        datos.append("correo_encargado", correo_encargado);
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
                    url: "<?php echo $urlweb?>servicios/ws_<?php echo $idpanel?>.php?accion=editar",
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

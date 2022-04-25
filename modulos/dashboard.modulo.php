  <?php 
  global $idpanel;
  global $funciones;
  global $mysqli;
   if(!$funciones->login_check()){      
    echo "<script>location.href='?mod=inicio';</script>";
 }
 			  //query			  
         $stmt2 = $mysqli->prepare("SELECT COUNT(idnotificacion) FROM `notificaciones` WHERE activo=1");
         $stmt2->execute();
         $stmt2->store_result();
         $stmt2->bind_result($total_arreglo);
         $stmt2->fetch();
         $stmt2->close();
?>
<ul id="dropdown1" class="dropdown-content">
  <li><a href="#!">Pagos en Línea</a></li>
  <li class="divider"></li>
  <li><a href="#!">Acerca de</a></li>
</ul>

<ul id="dropdown2" class="dropdown-content">
<ul class="collection">
<?php
					$strsql = 'SELECT idnotificacion, titulo, mensaje, fecha_creacion FROM notificaciones where activo=1 ORDER BY fecha_creacion DESC';
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($idnotificacion, $titulo, $mensaje, $fecha_creacion);
						while($stmt->fetch()){
						?>
<li style="padding-left: 0px !important; text-align: center !important; padding: 0px 0px;" class="collection-item avatar dismissable">
<i class="material-icons circle">notifications_active</i>
<br>
<br>
<span class="title"><?php echo $titulo ?></span>
<p><?php echo $mensaje ?> </p>
<li class="divider"></li>
</li>
						<?php
						}
						
						$stmt->close();
					}else{
            echo "<span class=\"black-text\">No hay notificaciones disponibles.</span>";
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
</ul>
  <nav>
    <div class="nav-wrapper" id="menubar" style="background-color: #007045;">
      <!--<a href="#!" id="titulo" class="brand-logo">LMN</a>-->
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
      <ul class="right hide-on-med-and-down">
        <li><a href=""><i class="material-icons">search</i></a></li>
        <li><a href="?mod=dashboard"><i class="material-icons">view_module</i></a></li>
        <li><a class="dropdown-button" href="#!" data-activates="dropdown2"><i class="material-icons right">notifications</i><span class="new badge red" data-badge-caption="Nuevas"><?php echo $total_arreglo ?></span></a></li>
<li><a class="dropdown-button" href="#!" data-activates="dropdown1">Opciones<i class="material-icons right">arrow_drop_down</i></a></li>
      </ul>
      <ul class="side-nav" id="mobile-demo">
        <li><a href="?mod=dashboard&panel=admintipomatricula">Matricular</a></li>
        <li><a href="?mod=dashboard&panel=lista_espera">Lista de Espera</a></li>
        <li><a href="">Acerca de</a></li>
      </ul>
    </div>
  </nav>
    <!-- Navbar goes here -->

    <!-- Page Layout here -->
<?php
$idusuario= $_SESSION["idusuario"];
  $dir = "uploads/avatar/";
  if(file_exists($dir.$idusuario.".jpg"))
  {
      $direccion=$dir.$idusuario.".jpg";
  }else{
      
      $direccion=$dir."default.jpg";
  }             
?>    
    <div class="row">
      <section>
        <div id="dashboard-izq" class="col s12 m4 l3 dashboard-left cover">
        <!-- Grey navigation panel -->
        <div id="avatar">
        <img src="<?php echo $direccion ?>" alt="user_LMN" class="circle z-depth-5" width="150" height="150">
        <div id="name_user">
  <h4 class="center"><a href="?mod=dashboard&panel=adminperfilusuario&idusuario=<?php echo $_SESSION["idusuario"]?>"><?php echo $_SESSION["usuario"]?></a>
  </h4> 
        </div>
<a style="margin: 6px;" href="./logout.php" class="btn-floating red"><i class="material-icons">settings_power</i></a>
        </div>
  <a class="btn green darken-3" href="?mod=dashboard"><i class="material-icons left">dashboard</i>Dashboard</a>
  <?php if(!$funciones->es_maestro() || $funciones->login_admin()){?>
  <ul class="collapsible" data-collapsible="accordion">
    <li>
      <div class="collapsible-header"><i class="material-icons">account_box</i>Matrícula</div>
      <div class="collapsible-body">
<a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=admintipomatricula">Matricular</a><br>
<a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=lista_espera">Lista de Espera</a>
      </div>
    </li>
    <li>
      <div class="collapsible-header"><i class="material-icons">credit_card</i>Pagos</div>
      <div class="collapsible-body">
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=adminpagos_aldia">Estudiantes al Día</a><br>             
<a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=seleccionaño_factura">Efectuar Pagos</a><br>   
<a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=pre_inscripcion">Pre-inscripción</a><br>       
      </div>
    </li>
    <li>
      <div class="collapsible-header"><i class="material-icons">description</i>Reportes</div>
      <div class="collapsible-body">
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=adminboleta_matriculados">Alumnos Matrículados</a>
<a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=admin_forma03">Hoja de Matrícula</a>
      </div>
    </li>
    <li>
      <div class="collapsible-header"><i class="material-icons">assignment</i>Académico</div>
      <div class="collapsible-body">
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=maestro_clases_detalles">Administrador de Clases</a><br> 
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=adminnotas_clases_detalles">Cuadro No. 1</a><br> 
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=admin_cuadro2">Cuadro No. 2</a><br> 
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=admin_acta_final">Actas Finales</a><br> 
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=admin_boleta_calificaciones">Boleta de Calificaciones</a><br> 
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=boletas_entregadas">Boletas Entregadas</a><br> 
      </div>
    </li> 
    <li>
      <div class="collapsible-header"><i class="material-icons">show_chart</i>Estadísticas</div>
      <div class="collapsible-body"><span>En el dashboard se encuentran los elementos</span></div>
    </li>  
    <li>
      <div class="collapsible-header"><i class="material-icons">supervisor_account</i>Usuarios</div>
      <div class="collapsible-body">
<a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=adminusuarios">Admin. Usuarios</a><br>   
<a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=adminusuarios">Admin. Perfil Usuarios</a><br>       
      </div>
    </li>          
    <li>
      <div class="collapsible-header"><i class="material-icons">settings</i>Configuraciones</div>
      <div class="collapsible-body">
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=admin_alumnos">Admin. Alumnos</a><br> 
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=adminclases">Admin. Clases</a><br> 
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=admincursos_clases">Asignar Clases - Cursos</a><br>
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=adminmaestros_clases">Asignar Clases - Maestro</a><br> 
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=adminmeses">Admin. Cuotas</a><br>   
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=admindetallecuotas">Asignar Cuotas</a><br>           
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=escolar-year">Años Escolares</a><br>         
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=configuracion_periodos">Configuraciones Avanzadas</a><br>         
      </div>
    </li> 
    <li>
      <div class="collapsible-header"><i class="material-icons">notifications</i>Notificaciones</div>
      <div class="collapsible-body">
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=admin_notificaciones">Admin. Notificaciones</a><br> 
      </div>
    </li>   
  </ul>
      </div>
      </section>
      <div class="col s12 m8 l9 z-depth-5" style="background-color: white;">
        <!-- Teal page content  -->
        <section>
<?php $funciones->dashboard_panel($idpanel);?> 
        </section>
      </div>

    </div>
    <?php 
  }else{//fin de saber si es maestro
    ?> 
    <ul class="collapsible" data-collapsible="accordion">
    <li>
      <div class="collapsible-header"><i class="material-icons">description</i>Reportes</div>
      <div class="collapsible-body">
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=adminboleta_matriculados"">Alumnos Matrículados</a>
      </div>
    </li>
    <li>
      <div class="collapsible-header"><i class="material-icons">assignment</i>Académico</div>
      <div class="collapsible-body">
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=maestro_clases_detalles">Administrador de Clases</a><br> 
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=boletas_entregadas">Boletas Entregadas</a><br> 
      </div>
    </li> 
    <li>
      <div class="collapsible-header"><i class="material-icons">show_chart</i>Estadísticas</div>
      <div class="collapsible-body">
      <a class="waves-effect btn center light-green darken-2 margenes" href="?mod=dashboard&panel=admin_aldia">Alumnos Al Día</a><br> 
      </div>
    </li>             
  </ul>
      </div>
      </section>
      <div class="col s12 m8 l9 z-depth-5" style="background-color: white;">
        <!-- Teal page content  -->
        <section>
<?php $funciones->dashboard_panel($idpanel);?> 
        </section>
      </div>

    </div>
    <?php 
  }
  ?>   
<script type="text/javascript">
    $(function(){
    $(".button-collapse").sideNav();         
    });
$(document).ready(function() {
    $(".dropdown-button").dropdown();
});    
</script>
<?php
global $mysqli;
global $urlweb;
global $funciones;    
?>
<div id="cards">
    <div class="row">
        <div class="col s12 m6 l3 card-usuarios padding">
            <div class="card white-text">
                <div class="padding-4">
                    <div class="col s7 m7">
                        <i class="material-icons background-round medium">account_box</i>
                        <p>Usuarios</p>
                    </div>
                    <div class="col s5 m5 right-align">
<?php
//Consulta para saber cuantos registros existen en la base de datos
$stmt = $mysqli->prepare("SELECT count(*) from usuarios");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($total_arreglo);
$stmt->fetch();
$stmt->close();
?>                    	
                        <h5 class="mb-0"><?php echo $total_arreglo?></h5>
                        <p class="no-margin">Nuevos</p>
                    </div>
                </div>
            </div>
        </div>
        <?php
//Consulta para saber cuantos registros existen en la base de datos
$stmt = $mysqli->prepare("SELECT count(*) from alumnos_matriculados INNER JOIN cursos ON cursos.idcurso=alumnos_matriculados.idcurso INNER JOIN year_escolar ON year_escolar.idaño=alumnos_matriculados.idaño where year_escolar.predeterminado=1 and alumnos_matriculados.lista_espera=0 and cursos.nivel='MEDIA'");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($total_colegio);
$stmt->fetch();
$stmt->close();
//Consulta para saber cuantos registros existen en la base de datos
$stmt = $mysqli->prepare("SELECT count(*) from alumnos_matriculados INNER JOIN cursos ON cursos.idcurso=alumnos_matriculados.idcurso INNER JOIN year_escolar ON year_escolar.idaño=alumnos_matriculados.idaño where year_escolar.predeterminado=1 and alumnos_matriculados.lista_espera=0 and cursos.nivel='BASICA'");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($total_escuela);
$stmt->fetch();
$stmt->close();
?>      
<?php
//Consulta para saber cuantos registros existen en la base de datos
$stmt = $mysqli->prepare("SELECT count(*) from alumnos_matriculados INNER JOIN cursos ON cursos.idcurso=alumnos_matriculados.idcurso INNER JOIN year_escolar ON year_escolar.idaño=alumnos_matriculados.idaño where year_escolar.predeterminado=1 and alumnos_matriculados.lista_espera=0 and cursos.nivel='PRE-ESCOLAR'");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($total_prek);
$stmt->fetch();
$stmt->close();
?> 
        <div class="col s12 m6 l3 card-alumnos padding">
            <div class="card white-text">
                <div class="padding-4">
                    <div class="col s7 m7">
                        <i class="material-icons background-round medium">accessibility</i>
                        <p>Estudiantes:<?php echo $total_colegio + $total_escuela + $total_prek?></p>
                    </div>                   
                    <div class="col s5 m5 right-align">
                        <h6 class="mb-0"><?php echo $total_colegio?></h6>
                        <p style="margin: 0;">Colegio</p>
                        <h6 class="mb-0"><?php echo $total_escuela?></h6>
                        <p style="margin: 0;">Escuela</p>                                            
                    </div>
                </div>
            </div>
        </div>

        <div class="col s12 m6 l3 card-estadisticas padding">
            <div class="card white-text">
                <div class="padding-4">
                    <div class="col s7 m7">
                        <i class="material-icons background-round medium">insert_chart</i>
                        <p>Ingresos</p>
                    </div>
<?php
//Consulta para saber cuantos registros existen en la base de datos
$stmt = $mysqli->prepare("SELECT SUM(cuotas.precio) as total FROM `facturas_detalles` INNER JOIN cuotas ON facturas_detalles.idcuota = cuotas.idcuota  order by facturas_detalles.idcuota");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($total_arreglo);
$stmt->fetch();
$stmt->close();
?>                      
                    <div class="col s5 m5 right-align">
                        <span class="mb-0"><?php echo number_format($total_arreglo, 2, '.', ',')?></span>
                        <p class="no-margin">Nuevos</p>
                        <p>Total</p>
                    </div>
                </div>
            </div>
        </div>
        <a href="?mod=dashboard&panel=lista_espera">
        <div class="col s12 m6 l3 card-espera padding">
            
            <div class="card white-text">
                <div class="padding-4">
                    <div class="col s7 m7">
                        <i class="material-icons background-round medium">priority_high</i>
                        <p>Lista Espera</p>
                    </div>
<?php
//Consulta para saber cuantos registros existen en la base de datos
$stmt = $mysqli->prepare("SELECT count(*) from alumnos_matriculados where lista_espera=1");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($total_arreglo);
$stmt->fetch();
$stmt->close();
?>                      
                    <div class="col s5 m5 right-align">
                        <h5 class="mb-0"><?php echo $total_arreglo?></h5>
                        <p class="no-margin">Nuevos</p>
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>
</div>
<div class="row">
    <div class="col s12 l6 m6">
        <center>
            <div id="char" style="width: 100%;">
                <p><b>Gráfico de estudiantes Matrículados</b></p>
                <canvas id="ChartMatricula" width="500" height="350"></canvas>
                <p>Si desea imprimir este gráfico, haga click derecho sobre el gráfico y luego en guardar imagen.</p>
            </div>
        </center>
    </div>
<?php if($funciones->login_admin()){?>
    <div class="col s12 l6 m6">
        <center>
            <div id="char" style="width: 70%;">
                <p><b>Gráfico de Pagos al Día</b></p>
                <canvas id="morosos" width="500" height="350"></canvas>
                <p>Si desea imprimir este gráfico, haga click derecho sobre el gráfico y luego en guardar imagen.</p>
            </div>
        </center>
    </div>
</div>
<div class="row">
    <div class="col s12 l12 m12">
        <center>
            <div id="char" style="width: 40%;">
                <p><b>Gráfico de Ingresos mensuales</b></p>
                <canvas id="myChart" width="500" height="350"></canvas>
                <p>Si desea imprimir este gráfico, haga click derecho sobre el gráfico y luego en guardar imagen.</p>
            </div>
        </center>
    </div>
</div>
<?php 
  }//fin de saber si es maestro
    ?> 
<script src="<?php echo $urlweb?>recursos/js/chart.js-3.1.1-1/package/dist/chart.min.js"></script>
<script type="text/javascript">
//query
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
                Materialize.toast('<?php echo $mensaje ?>', 3000,'rounded');
						<?php
						}
						
						$stmt->close();
					}
				}
				else{
					echo "Error al ejecutar consulta: " . $stmt->error;
				}//Cierre de condicion de Ejecucion
			}
			else{
				echo "Error al preparar consulta: " . $mysqli->error;
			}
		?>

var ctx2 = document.getElementById("ChartMatricula").getContext('2d');
<?php if($funciones->login_admin()){?>
var ctx = document.getElementById("myChart").getContext('2d');
var ctx3 = document.getElementById("morosos").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [
        <?php 
	$strsql = "SELECT cuotas.cuota, SUM(cuotas.precio) as total FROM `facturas_detalles` INNER JOIN cuotas ON facturas_detalles.idcuota = cuotas.idcuota group by facturas_detalles.idcuota order by facturas_detalles.idcuota";
		$resultado = $mysqli->query($strsql);
		$stmt->execute();
		$stmt->store_result();
		while ($registros = mysqli_fetch_array($resultado)) 
		{
		?>
		'<?php echo $registros["cuota"]?>',
		<?php
		}
        $stmt->close();
        ?>
        ],
        datasets: [{
            label: '# de ingresos',
            data: [
        <?php 
	$strsql = "SELECT cuotas.cuota, SUM(cuotas.precio) as total FROM `facturas_detalles` INNER JOIN cuotas ON facturas_detalles.idcuota = cuotas.idcuota group by facturas_detalles.idcuota order by facturas_detalles.idcuota";
		$resultado = $mysqli->query($strsql);
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
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(130, 159, 64, 0.2)',
                'rgba(20, 159, 64, 0.2)',
                'rgba(79, 159, 64, 0.2)',
                'rgba(200, 159, 64, 0.2)',
                'rgba(45, 159, 64, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(30, 159, 64, 0.2)',
                'rgba(10, 159, 64, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    },
    responsive: true,
	title : {
		display: true,
		text: "Gráfico de Ingresos mensuales"
	}
});
//
var morosos = new Chart(ctx3, {
    type: 'doughnut',
    data: {
        labels: [
        <?php 
	$strsql = "SELECT COUNT(alumnos_matriculados.al_dia) as total, if(alumnos_matriculados.al_dia = 1,'AL DIA','MORA') AS PRUEBA FROM alumnos_matriculados INNER JOIN year_escolar ON year_escolar.idaño=alumnos_matriculados.idaño where year_escolar.predeterminado=1 and alumnos_matriculados.lista_espera=0 group by alumnos_matriculados.al_dia  order by alumnos_matriculados.al_dia";
		$resultado = $mysqli->query($strsql);
		$stmt->execute();
		$stmt->store_result();
		while ($registros = mysqli_fetch_array($resultado)) 
		{
		?>
		'<?php echo $registros["PRUEBA"]?>',
		<?php
		}
        $stmt->close();
        ?>
        ],
        datasets: [{
            label: '# de Matriculados',
            data: [
        <?php 
	$strsql = "SELECT COUNT(alumnos_matriculados.al_dia) as total, if(alumnos_matriculados.al_dia = 1,'AL DIA','MORA') AS PRUEBA FROM alumnos_matriculados INNER JOIN year_escolar ON year_escolar.idaño=alumnos_matriculados.idaño where year_escolar.predeterminado=1 and alumnos_matriculados.lista_espera=0 group by alumnos_matriculados.al_dia  order by alumnos_matriculados.al_dia";
		$resultado = $mysqli->query($strsql);
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
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(130, 159, 64, 0.2)',
                'rgba(20, 159, 64, 0.2)',
                'rgba(79, 159, 64, 0.2)',
                'rgba(200, 159, 64, 0.2)',
                'rgba(45, 159, 64, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(30, 159, 64, 0.2)',
                'rgba(10, 159, 64, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    },
    responsive: true,
	title : {
		display: true,
		text: "Gráfico De Estudiantes Matrículados"
	}
});
//
<?php 
  }//fin de saber si es maestro
    ?> 
var ChartMatricula = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: [
        <?php 
	$strsql = "SELECT cursos.nombre_curso as cursos, COUNT(alumnos_matriculados.idcurso) as total FROM `alumnos_matriculados` INNER JOIN cursos ON alumnos_matriculados.idcurso = cursos.idcurso INNER JOIN year_escolar ON year_escolar.idaño=alumnos_matriculados.idaño where year_escolar.predeterminado=1 and alumnos_matriculados.lista_espera=0 group by alumnos_matriculados.idcurso order by alumnos_matriculados.idcurso";
		$resultado = $mysqli->query($strsql);
		$stmt->execute();
		$stmt->store_result();
		while ($registros = mysqli_fetch_array($resultado)) 
		{
		?>
		'<?php echo $registros["cursos"]?>',
		<?php
		}
        $stmt->close();
        ?>
        ],
        datasets: [{
            label: '# de Matriculados',
            data: [
        <?php 
	$strsql = "SELECT cursos.nombre_curso, COUNT(alumnos_matriculados.idcurso) as total FROM `alumnos_matriculados` INNER JOIN cursos ON alumnos_matriculados.idcurso = cursos.idcurso INNER JOIN year_escolar ON year_escolar.idaño=alumnos_matriculados.idaño where year_escolar.predeterminado=1 and alumnos_matriculados.lista_espera=0 group by alumnos_matriculados.idcurso order by alumnos_matriculados.idcurso";
		$resultado = $mysqli->query($strsql);
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
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(130, 159, 64, 0.2)',
                'rgba(20, 159, 64, 0.2)',
                'rgba(79, 159, 64, 0.2)',
                'rgba(200, 159, 64, 0.2)',
                'rgba(45, 159, 64, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(30, 159, 64, 0.2)',
                'rgba(10, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        indexAxis: 'y',
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    },
    responsive: true,
    plugins: {
      legend: {
        position: 'right',
      },
	title : {
		display: true,
		text: "Gráfico De Estudiantes Matrículados"
	}
}
});

</script>
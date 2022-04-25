<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
global $funciones;
$idaño=$_GET['idaño'];
if($funciones->login_estado()){   
?>
<div class="container center">
<h4><b>Generar Actas Finales</b></h4>
</div>
<div class="row">
  <div class="col s12 l6">
<blockquote><h5 id="focus" style="font-size: large;"><b>Elija las siguientes opciones:</b></h5></blockquote>  
<div class="input-field">
<select id="seleccionaño" name="seleccionaño" style="display: none;">
<option value="" disabled selected>Seleccione el año escolar</option>
  <?php
      $strsql = "SELECT idaño, nombre FROM year_escolar ORDER BY fecha_creacion DESC";
      if($stmt = $mysqli->prepare($strsql)){
        $stmt->execute();
        if($stmt->errno == 0){
          $stmt->store_result();
          if($stmt->num_rows > 0){
            $stmt->bind_result($idaño, $descripcion);
            while($stmt->fetch()){
            ?>
               <option value="<?php echo $idaño ?>"><?php echo $descripcion ?></option>
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
<div class="row">
  <div class="col s12 l6">
<div class="input-field">
<select id="idcurso" name="idcurso" style="display: none;">
<option value="" disabled selected>Seleccione el curso académico</option>
  <?php
      $strsql = "SELECT idcurso, nombre_curso FROM cursos ORDER BY idcurso ASC";
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
  </div>
</div>
<div class="row">
<div class="input-field col s12 l6">
    <select id="selectsemestre" name="selectsemestre" style="display: none;">
    <option value="" disabled selected>Seleccione el nivel académico</option>
      <optgroup label="Básica - 3er Ciclo">
        <option value="0">Anual</option>
      </optgroup>
      <optgroup label="Media">
        <option value="1">I Semestre</option>
        <option value="2">II Semestre</option>
      </optgroup>
    </select>
  </div>
</div>
<div class="center">
<a href="javascript:actas()" class="waves-effect red waves-light btn"><i class="material-icons left">developer_board</i>Generar Acta</a>
</div>
<?php
}else{
?>
<h2 class="center">Ud no tiene permisos o su cuenta ha sido desactivada, comuniquese con el administrador.</h2> 
<?php
}
?>
<script src="./recursos/js/datatables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
 <!-- searchPanes   -->
 <script src="https://cdn.datatables.net/searchpanes/1.0.1/js/dataTables.searchPanes.min.js"></script>
    <!-- select -->
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script> 
<script src="./recursos/js/sha512.js"></script>
<script src="<?php echo $urlweb?>recursos/js/sweetalert2.min.js"></script>
<script>   
function actas(){
  var idaño = $("#seleccionaño").val(); 
  var idcurso = $("#idcurso").val(); 
  var idmodalidad = $("#selectsemestre").val(); 
  window.open("<?php echo $urlweb?>?mod=dashboard&panel=cobijas&idaño="+idaño+"&idcurso="+idcurso+"&modalidad="+idmodalidad,
  '_blank');
}
$(document).ready( function () {
  $('select#selectsemestre').on('change',function(){

});

}); 
$(function() {
  $(document).ready(function() {
$('#seleccionaño').material_select();
$('#idcurso').material_select();
$('#selectsemestre').material_select();
});

});

</script>
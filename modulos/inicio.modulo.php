<?php
  global $funciones;
  global $mysqli;
  global $urlweb;
  global $urltema;
  global $idmodulo;
?>
  <div class="row">
    <div id="main-text">
       <div class="col s12 m12">
        <span class="text_login">BIENVENIDO</span>
    </div>
    <div class="col s12 m12">
        <span class="text_login flow-text">Sistema para la Automatización de Gestiones en Línea</span>
    </div>
    </div>
  </div>  
  <div>
    <form class="logInForm" action="?mod=inicio" method="post">
      <?php
    global $funciones;
if(isset($_POST["login_idusuario"], $_POST["login_password"])){
$idusuario = $_POST["login_idusuario"];
$password = $_POST["login_password"];
if(!$funciones->login($idusuario, $password)){
?>
<script type="text/javascript">
Materialize.toast("Error!, credenciales incorrectas.", 5000, 'rounded');
</script> 
   <?php 
}
}
   if($funciones->login_check()){  
    echo "<script>location.href='?mod=dashboard';</script>";
   }
?>
<div class="col s12 l12 m12">
<img style="max-height: 125px;" src="<?php echo $urltema?>img/LMH-min.png" title="Liceo Militar de Honduras" alt="Liceo Militar de Honduras">
<h4>Inicio de Sesión</h4>
<div class="input-field">
<i class="material-icons prefix">account_circle</i>
<input id="login_idusuario" name="login_idusuario" type="text" class="validate">
<label for="icon_prefix">Usuario</label>
</div>
<div class="input-field">
<i class="material-icons prefix">lock</i>
<input id="login_password" name="login_password" type="password" class="validate">
<label for="password">Contraseña</label>
</div>
</div>
<div class="col s12 m12">
<button class="btn waves-effect red darken-3" onclick="javascript:encriptarpassw()" type="submit" name="action">Ingresar
</button> 
</div>  
<span style="font-size: 15px;" class="text_login flow-text">Tecnología Educativa LMH <span id="año"></span>, SAGL V2.1 | Todos los derechos reservados.</span>
</form>
</div>
<script src="./recursos/js/sha512.js"></script> 
<script>
var year = new Date().getFullYear();
document.getElementById('año').innerHTML=year;
  function encriptarpassw(){
    var passw = $("#login_password").val();
    passw = hex_sha512(passw);
    $("#login_password").val(passw);
    }
</script> 


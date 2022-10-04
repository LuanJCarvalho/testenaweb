<?php include 'api/funcoes.php'; ?>
<?php include 'api/head_login.php'; ?>
<form class="form-signin" method="POST" action="">
    <h1 class="h3 mb-3 font-weight-normal text-center">Efetue o login</h1>
    <label for="inputLogin" class="sr-only">Login</label>
    <input type="text" id="inputLogin" name="inputLogin" class="form-control" placeholder="Login" required="" autofocus="">
    <label for="inputSenha" class="sr-only">Senha</label>
    <input type="password" id="inputSenha" name="inputSenha" class="form-control" placeholder="Senha" required="">
    <button class="btn btn-lg btn-primary btn-block" id="logar" name="logar" type="submit">Logar</button>
</form>
<?php include 'api/foot.php'; ?>
<?php 
logout();
if(isset($_POST['logar'])){
   login($_POST['inputLogin'], md5($_POST['inputSenha']));
}

?>
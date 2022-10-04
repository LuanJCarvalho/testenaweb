<?php include 'api/funcoes.php'; ?>
<?php include 'api/head.php'; ?>
<?php
    $aplicacao = $_GET['aplicacao'];
    if(!($aplicacao>0)){
        $link = "aplicacao.php";
        redireciona($link);
    }
?>
    
    <main role="main" class="container"> 
        <div class="row">
            <div class="col-sm">    </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <h1 class="text-center">Aplicação de Prova</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center">|dados da instituição|</h3>
                <h3 class="text-center">|dados da turma|</h3>
                <h3 class="text-center">|dados do aluno|</h3>
                <form method="POST" action="">
                    <?php echo responderAplicacao($aplicacao); ?>
                    <?php //echo botaoVoltar(); ?>
                    <button type="submit" class="btn btn-primary float-right" id="responder" name="responder" >Concluir prova</button>
                </form>
            </div>
        </div>
    </main><!-- /.container -->

<?php 

if(isset($_POST['responder'])){
    //var_dump($_POST);
    incluirRespostas($_POST, $aplicacao);
    $usuario = $_SESSION['id']; // usuário logado que acabou de responder a prova
    $link = "resultadoaplicacao.php?aplicacao=".$aplicacao."&usuario=".$usuario;
    redireciona($link);
}

?>

<?php include 'api/foot.php'; ?>
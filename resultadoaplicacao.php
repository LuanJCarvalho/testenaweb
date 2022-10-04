<?php include 'api/funcoes.php'; ?>
<?php include 'api/head.php'; ?>
<?php
    $aplicacao = $_GET['aplicacao'];
    if(!($aplicacao>0)){
        $link = "aplicacao.php";
        redireciona($link);
    }
    $usuario = $_GET['usuario'];
    if(!($usuario>0)){
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
                <h1 class="text-center">Resultado Aplicação de Prova</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center">|dados da instituição|</h3>
                <h3 class="text-center">|dados da turma|</h3>
                <h3 class="text-center">|dados do aluno|</h3>
                <h2 class="text-center">Nota: <?php echo calcularNotaAplicacao($aplicacao, $usuario); ?></h2>
                <?php echo resultadoAplicacao($aplicacao, $usuario); ?>
            </div>
        </div>
    </main><!-- /.container -->

<?php 



?>

<?php include 'api/foot.php'; ?>
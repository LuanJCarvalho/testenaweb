<?php include 'api/funcoes.php'; ?>
<?php include 'api/head.php'; ?>
<?php include 'api/menu.php'; ?>  
<?php
    $questao = $_GET['questao'];
    if(!($questao>0)){
        $link = "questao.php";
        redireciona($link);
    }
?>
    
    <main role="main" class="container"> 
        <div class="row">
            <div class="col-sm"><br><br><br></div>
        </div>
        <div class="row">
            <div class="col-sm">
                <h1 class="text-center">Itens</h1>
                <br><br>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center">Inclusão</h3>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="itens">Verifique abaixo como ficou a questão #<?php echo $questao; ?></label>
                        <br>
                        <div class="alert alert-primary" role="alert">
                            <?php echo enunciadoQuestao($questao); ?>
                        </div>
                        <div class="alert alert-light" role="alert">
                            <?php echo listaItensCadastrados($questao); ?>
                        </div>
                    </div>
                    <?php echo botaoVoltar(); ?>
                    <button type="submit" class="btn btn-primary float-right" id="concluir" name="concluir" >Concluir</button>
                </form>
            </div>
        </div>
    </main><!-- /.container -->

<?php 

if(isset($_POST['concluir'])){
    $link = "questao.php";
    redireciona($link);
}

?>

<?php include 'api/foot.php'; ?>
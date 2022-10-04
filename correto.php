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
                        <label for="itens">Indique qual o item correto da questão #<?php echo $questao; ?></label>
                        <br>
                        <div class="alert alert-primary" role="alert">
                            <?php echo enunciadoQuestao($questao); ?>
                        </div>
                        <div class="alert alert-secondary" role="alert">
                            <?php echo listaItens($questao); ?>
                        </div>
                    </div>
                    <?php echo botaoVoltar(); ?>
                    <button type="submit" class="btn btn-primary float-right" id="incluir_item_correto" name="incluir_item_correto" >Próxima etapa</button>
                </form>
            </div>
        </div>
    </main><!-- /.container -->

<?php 

if(isset($_POST['incluir_item_correto'])){
     $id_item = $_POST['item_optradio'];
     if(atribuiItemCorreto($id_item, $questao)){
        $link = "verquestao.php?questao=".$questao;
        redireciona($link);
     }else{
        echo "Erro ao atribuir o item correto!";
     }
}

?>

<?php include 'api/foot.php'; ?>
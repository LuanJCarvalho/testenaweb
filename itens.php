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
                        <label for="itens">Preencha os itens da questão #<?php echo $questao; ?></label>
                        <br>
                        <div class="alert alert-primary" role="alert">
                            <?php echo enunciadoQuestao($questao); ?>
                        </div>
                        <br>
                        <input type="text" id="item_1" name="item_1" class="form-control" placeholder="Digite aqui o item que deseja incluir" autofocus="">
                        <br>
                        <input type="text" id="item_2" name="item_2" class="form-control" placeholder="Digite aqui o item que deseja incluir">
                        <br>
                        <input type="text" id="item_3" name="item_3" class="form-control" placeholder="Digite aqui o item que deseja incluir">
                        <br>
                        <input type="text" id="item_4" name="item_4" class="form-control" placeholder="Digite aqui o item que deseja incluir">
                        <br>
                        <input type="text" id="item_5" name="item_5" class="form-control" placeholder="Digite aqui o item que deseja incluir">
                    </div>
                    <?php echo botaoVoltar(); ?>
                    <button type="submit" class="btn btn-primary float-right" id="incluir_itens" name="incluir_itens" >Próxima etapa</button>
                </form>
            </div>
        </div>
    </main><!-- /.container -->

<?php 

if(isset($_POST['incluir_itens'])){
    $qtdeItens = 0;
    if(desativarItens($questao)){
        for($i=1;$i<6;$i++){
            if($_POST['item_'.$i]!=""){
                incluirItem($questao, $_POST['item_'.$i]);
                $qtdeItens++;
            }
        }
    }else{
        echo 'Erro ao desativar itens anteriores!';
    }
    if($qtdeItens>0){
        $link = "correto.php?questao=".$questao;
        redireciona($link);
    }
}

?>
<?php include 'api/foot.php'; ?>
<?php include 'api/funcoes.php'; ?>
<?php include 'api/head.php'; ?>
<?php include 'api/menu.php'; ?>
<?php
    $prova = $_GET['prova'];
    if(!($prova>0)){
        $link = "prova.php";
        redireciona($link);
    }
?>
<?php 
    if(isset($_POST['inclusao'])){
       //var_dump($_POST);
       if(isset($_POST['questoes'])){
            foreach ($_POST['questoes'] as $questao) {
                //echo $questao.'<br>';
                incluirQuestaoProva($prova, $questao);
            }
        }else{
            echo '<div class="alert alert-warning text-center" role="alert">
                     Nenhuma questão foi selecionada!
                  </div>';
        }
        //$link = "montarprova.php?prova=".$prova;
        //redireciona($link);

    }
?>
    
    
    <main role="main" class="container"> 
        <div class="row">
            <div class="col-sm"><br><br><br></div>
        </div>
        <div class="row">
            <div class="col-sm">
                <h1 class="text-center">Provas</h1>
                <br><br>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center">Seleção de questões para a prova</h3>
                <form method="POST" action="">
                    <div class="form-group">
                        <div class="alert alert-info text-center" role="alert">
                            Questões incluídas à prova #<?php echo $prova; ?>
                        </div>
                        <?php echo listaQuestoesTableInputIncluidas($_SESSION['id'], $prova); // passar o id do usuário logado na sessão!!!!! ?>
                    </div>
                    <div class="form-group">
                        <div class="alert alert-info text-center" role="alert">
                            Seleciona na listagem abaixo as questões que deverão estar na prova #<?php echo $prova; ?>
                        </div>
                        <?php echo listaQuestoesTableInput($_SESSION['id'], $prova); // passar o id do usuário logado na sessão!!!!! ?>
                    </div>
                    <?php echo botaoVoltar(); ?>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-primary" id="inclusao" name="inclusao" >Incluir questões à prova</button>
                        <button type="submit" class="btn btn-primary" id="montar_prova" name="montar_prova" >Próxima etapa</button>
                    </div>                    
                </form>
            </div>
        </div>
        <?php         
            if(isset($_POST['montar_prova'])){           
                $link = "verprova.php?prova=".$prova;
                redireciona($link);           
            }
        ?>
        
    </main><!-- /.container -->



<?php include 'api/foot.php'; ?>
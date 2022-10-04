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
                            Prova #<?php echo $prova; ?>
                        </div>
                        <?php echo verProva($_SESSION['id'], $prova); // passar o id do usuário logado na sessão!!!!! ?>
                    </div>                    
                    <?php echo botaoVoltar(); ?>
                    <div class="form-group float-right">
                        <button type="submit" class="btn btn-primary" id="concluir" name="concluir" >Concluir</button>
                    </div>                    
                </form>
            </div>
        </div>
        <?php         
            if(isset($_POST['concluir'])){           
                $link = "prova.php";
                redireciona($link);           
            }
        ?>
        
    </main><!-- /.container -->



<?php include 'api/foot.php'; ?>
<?php include 'api/funcoes.php'; ?>
<?php include 'api/head.php'; ?>
<?php include 'api/menu.php'; ?>    
    
    <main role="main" class="container"> 
        <div class="row">
            <div class="col-sm"><br><br><br></div>
        </div>
        <div class="row">
            <div class="col-sm">
                <h1 class="text-center">Aplicações</h1>
                <br><br>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center">Inclusão</h3>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="prova">Prova</label>
                        <select class="form-control" id="prova" name="prova">
                            <?php echo listaProvasOptions($_SESSION['id']); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="usuario">Usuário</label>
                        <select class="form-control" id="usuario" name="usuario">
                            <?php echo listaUsuariosOptions($_SESSION['id']); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="turma">Turma</label>
                        <select class="form-control" id="turma" name="turma">
                            <?php echo listaTurmasOptions($_SESSION['id']); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dataInicial" >Data inicial</label>
                        <input class="form-control" type="date" value="" id="dataInicial" name="dataInicial" required >                        
                    </div>
                    <div class="form-group">
                        <label for="dataFinal" >Data final</label>
                        <input class="form-control" type="date" value="" id="dataFinal" name="dataFinal" required >
                    </div>
                    <div class="form-group">
                        <label for="observacao">Observação</label>
                        <textarea class="form-control" id="observacao" name="observacao" placeholder="Escreva aqui uma observação em relação a essa aplicação de prova" rows="4" cols="50" required></textarea>           
                    </div>
                    <button type="submit" class="btn btn-primary float-right" id="incluir_aplicacao" name="incluir_aplicacao" >Incluir</button>
                </form>
            </div>
        </div>
        <?php 

        if(isset($_POST['incluir_aplicacao'])){
           $aplicacao = incluirAplicacao($_POST['prova'], $_POST['usuario'], $_POST['turma'], $_POST['dataInicial'], $_POST['dataFinal'], $_POST['observacao']);
           if($aplicacao>0){
                //$link = "veraplicacao.php?aplicacao=".$aplicacao;
                //redireciona($link);
           }
        }

        ?>
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center">Listagem</h3>      
                <?php echo listaAplicacoesTable($_SESSION['id']); // passar o id do usuário logado na sessão!!!!! ?>
            </div>
        </div>
    </main><!-- /.container -->



<?php include 'api/foot.php'; ?>
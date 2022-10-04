<?php include 'api/funcoes.php'; ?>
<?php include 'api/head.php'; ?>
<?php include 'api/menu.php'; ?>    
    
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
                <h3 class="text-center">Inclusão</h3>
                <form method="POST" action="">
                    <div class="form-group">
                       <label for="enunciado">Título</label>
                       <textarea class="form-control" id="titulo" name="titulo" placeholder="Escreva aqui o título da prova" rows="1" cols="50" required></textarea>           
                    </div>
                    <div class="form-group">
                       <label for="enunciado">Descrição</label>
                       <textarea class="form-control" id="descricao" name="descricao" placeholder="Escreva aqui uma descrição para a prova" rows="4" cols="50"></textarea>           
                    </div>
                  <button type="submit" class="btn btn-primary float-right" id="incluir_prova" name="incluir_prova" >Próxima etapa</button>
                </form>
            </div>
        </div>
        <?php 

        if(isset($_POST['incluir_prova'])){
           $prova = incluirProva($_POST['titulo'], $_POST['descricao']);
           if($prova>0){
                $link = "montarprova.php?prova=".$prova;
                redireciona($link);
           }
        }

        ?>
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center">Listagem</h3>      
                <?php echo listaProvasTable($_SESSION['id']); // passar o id do usuário logado na sessão!!!!! ?>
            </div>
        </div>
    </main><!-- /.container -->



<?php include 'api/foot.php'; ?>
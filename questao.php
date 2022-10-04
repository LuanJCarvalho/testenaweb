<?php include 'api/funcoes.php'; ?>
<?php include 'api/head.php'; ?>
<?php include 'api/menu.php'; ?>    
    
    <main role="main" class="container"> 
        <div class="row">
            <div class="col-sm"><br><br><br></div>
        </div>
        <div class="row">
            <div class="col-sm">
                <h1 class="text-center">Questões</h1>
                <br><br>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center">Inclusão</h3>
                <form method="POST" action="">
                  <div class="form-group">
                     <label for="enunciado">Enunciado</label>
                     <textarea class="form-control" id="enunciado" name="enunciado" placeholder="Escreva aqui o enunciado da questão" rows="4" cols="50" required></textarea>           
                  </div>
                  <button type="submit" class="btn btn-primary float-right" id="incluir_questao" name="incluir_questao" >Próxima etapa</button>
                </form>
            </div>
        </div>
        <?php 

        if(isset($_POST['incluir_questao'])){
           $questao = incluirQuestao(1, $_POST['enunciado']);
           if($questao>0){
                $link = "itens.php?questao=".$questao;
                redireciona($link);
           }
        }

        ?>
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center">Listagem</h3>      
                <?php echo listaQuestoesTable($_SESSION['id']); // passar o id do usuário logado na sessão!!!!! ?>
            </div>
        </div>
    </main><!-- /.container -->



<?php include 'api/foot.php'; ?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <span class="navbar-brand"><?php echo TITLE; ?></span>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="questao.php">Questões <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="prova.php">Provas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="aplicacao.php">Aplicações</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="aguarde.php">Turmas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="aguarde.php">Resultados</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Procurar" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
        <a class="btn btn-outline-danger my-2 my-sm-0" style="margin-left: 30px;" href="index.php">Sair</a>
      </div>
    </nav>
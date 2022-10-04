<?php

include 'config.php';

session_start();
//var_dump($_SESSION);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function conectaMySQL(){
    $connect = mysqli_connect(SERVER, USER, PASS);
    $db = mysqli_select_db($connect, DB);
    return $connect;
}

function redireciona($link){
    echo '<script>location.href="'.$link.'";</script>'; 
}

function botaoVoltar(){
    //echo '<button onclick="window.history.back()">Voltar</button>'; 
    echo '<a class="btn btn-primary float-left" href="javascript:window.history.go(-1)">Voltar</a>';
    //echo '<button onclick="javascript:window.history.go(-1)" class="btn btn-primary float-left" id="voltar" name="voltar" >Voltar</button>';
}

function login($login, $senha){
    $link = conectaMySQL();
    $verifica = mysqli_query($link, "SELECT * FROM usuario WHERE ativo IS TRUE AND login = '$login' AND senha = '$senha'") or die("erro ao selecionar");
    if (mysqli_num_rows($verifica)<=0){
        echo "<script language='javascript' type='text/javascript'>alert('Login e/ou senha incorretos');window.location.href='index.php';</script>";
        die();
    }else{ 
        $query = "SELECT * FROM usuario WHERE ativo IS TRUE AND login = '$login' AND senha = '$senha'";
        $listagem = mysqli_query($link, $query) or die("Erro ao carregar dados do usuário!");
        $row = mysqli_fetch_assoc($listagem);
        $_SESSION['id'] = $row['id'];
        //$_SESSION['cpf'] = $row['cpf'];
        $_SESSION['nome'] = $row['nome'];
        //$_SESSION['email'] = $row['email'];
        $_SESSION['login'] = $row['login'];
        //$_SESSION['senha'] = $row['senha'];
        //$_SESSION['sexo'] = $row['sexo'];
        //$_SESSION['data_nascimento'] = $row['data_nascimento'];
        $link = "questao.php";
        redireciona($link);
    }
}

function logout(){
    unset($_SESSION['id']);
    unset($_SESSION['nome']);
    unset($_SESSION['login']);
}

function incluirQuestao($tipo, $enunciado){
    $data_inclusao = date("Y-m-d H:i:s"); 
    $usuario_inclusao = $_SESSION['id'];
    $ativo = TRUE;
    $link = conectaMySQL();
    //$enunciado = utf8_decode($enunciado);
    $query = "INSERT INTO questao (tipo, enunciado, data_inclusao, usuario_inclusao, ativo) 
             VALUES (".$tipo.", '".$enunciado."', '".$data_inclusao."', ".$usuario_inclusao.", ".$ativo.")";
    //echo $query;
    $inclui = mysqli_query($link, $query) or die("erro ao incluir questão");
    return mysqli_insert_id($link);
}

function listaQuestoes($usuario){
    $itensDaLista = '<ul class="list-group">';
    $link = conectaMySQL();
    $query = "SELECT * FROM questao WHERE ativo IS TRUE AND usuario_inclusao = ".$usuario." ORDER BY id DESC";
    $listagem = mysqli_query($link, $query) or die("erro ao listar questões");
    while($row = mysqli_fetch_assoc($listagem)){
        $itensDaLista .= '<a href="verquestao.php?questao='.$row['id'].'" class="list-group-item">'.$row['enunciado'].'</a>';
    }
    $itensDaLista .= '</ul>';
    
    return $itensDaLista;
}

function listaQuestoesTable($usuario){
    $itensDaLista = '<table class="table table-striped" id="listagem">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Enunciado da questão</th>
                          </tr>
                        </thead>
                        <tbody>';
    $link = conectaMySQL();
    $query = "SELECT * FROM questao WHERE ativo IS TRUE AND usuario_inclusao = ".$usuario." ORDER BY id DESC";
    $listagem = mysqli_query($link, $query) or die("erro ao listar questões");
    while($row = mysqli_fetch_assoc($listagem)){
        //$itensDaLista .= '<a href="verquestao.php?questao='.$row['id'].'" class="list-group-item">'.$row['enunciado'].'</a>';
        $itensDaLista .= '<tr>
                            <th scope="row">'.$row['id'].'</th>
                            <td><a href="verquestao.php?questao='.$row['id'].'" >'.$row['enunciado'].'</a></td>
                          </tr>';
    }
    $itensDaLista .= '  </tbody>
                    </table>';
    
    return $itensDaLista;
}

function listaQuestoesTableInput($usuario, $prova){
    $itensDaLista = '<table class="table table-striped" id="listagem">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Enunciado da questão</th>
                            <th scope="col">Seleção</th>
                          </tr>
                        </thead>
                        <tbody>';
    $link = conectaMySQL();
    
    $itensIncluidos = '(0';
    $query0 = "SELECT * FROM prova_questao WHERE ativo IS TRUE AND id_prova = ".$prova;
    $listagem0 = mysqli_query($link, $query0) or die("erro ao listar questões incluidas");
    while($row = mysqli_fetch_assoc($listagem0)){
        $itensIncluidos .= ','.$row['id_questao'].'';
    }
    $itensIncluidos .= ')';
    $query = "SELECT * FROM questao WHERE ativo IS TRUE AND usuario_inclusao = ".$usuario." AND id NOT IN ".$itensIncluidos." ORDER BY id DESC";
    //echo $query;
    //die();
    $listagem = mysqli_query($link, $query) or die("erro ao listar questões");
    while($row = mysqli_fetch_assoc($listagem)){
        //$itensDaLista .= '<a href="verquestao.php?questao='.$row['id'].'" class="list-group-item">'.$row['enunciado'].'</a>';
        $itensDaLista .= '<tr>
                            <th scope="row">'.$row['id'].'</th>
                            <td><a href="verquestao.php?questao='.$row['id'].'" target="_BLANK" >'.$row['enunciado'].'</a></td>
                            <td><input type="checkbox" name="questoes[]" id="questao_'.$row['id'].'" value="'.$row['id'].'"></td>
                          </tr>';
    }
    $itensDaLista .= '  </tbody>
                    </table>';
    
    return $itensDaLista;
}

function listaQuestoesTableInputIncluidas($usuario, $prova){
    $itensDaLista = '<table class="table table-striped" >
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Enunciado da questão</th>
                            <th scope="col">Exluir</th>
                          </tr>
                        </thead>
                        <tbody>';
    $link = conectaMySQL();
    $query = "  SELECT * 
                FROM questao q, prova_questao pq
                WHERE q.ativo IS TRUE AND pq.ativo IS TRUE AND q.usuario_inclusao = ".$usuario." 
                AND pq.usuario_inclusao = ".$usuario." AND q.id = pq.id_questao AND pq.id_prova = ".$prova."
                ORDER BY pq.data_inclusao";
    //echo $query;
    //die();
    $listagem = mysqli_query($link, $query) or die("erro ao listar questões");
    while($row = mysqli_fetch_assoc($listagem)){
        //$itensDaLista .= '<a href="verquestao.php?questao='.$row['id'].'" class="list-group-item">'.$row['enunciado'].'</a>';
        $itensDaLista .= '<tr>
                            <th scope="row">'.$row['id_questao'].'</th>
                            <td><a href="verquestao.php?questao='.$row['id_questao'].'" target="_BLANK">'.$row['enunciado'].'</a></td>
                            <td><button type="button" class="btn btn-danger">Excluir</button></td>
                          </tr>';
    }
    $itensDaLista .= '  </tbody>
                    </table>';
    
    return $itensDaLista;
}


function enunciadoQuestao($questao){
    $enunciado = '';
    $link = conectaMySQL();
    $query = "SELECT enunciado FROM questao WHERE ativo IS TRUE AND id = ".$questao;
    $listagem = mysqli_query($link, $query) or die("erro ao buscar questão");
    $row = mysqli_fetch_assoc($listagem);
    $enunciado .= $row['enunciado'];  
    
    return $enunciado;
}

function desativarItens($id_questao){
    $link = conectaMySQL();
    $desativa = FALSE;
    $query1 = "UPDATE item SET ativo = FALSE WHERE ativo IS TRUE AND id_questao = ".$id_questao;
    $desativa = mysqli_query($link, $query1);
    return $desativa;
}

function incluirItem($questao, $texto){
    $data_inclusao = date("Y-m-d H:i:s"); 
    $usuario_inclusao = $_SESSION['id'];
    $ativo = TRUE;
    $link = conectaMySQL();
    //$texto = utf8_decode($texto);
    $query = "INSERT INTO item (id_questao, texto, correto, data_inclusao, usuario_inclusao, ativo) 
             VALUES (".$questao.", '".$texto."', FALSE, '".$data_inclusao."', ".$usuario_inclusao.", ".$ativo.")";
    //echo $query;
    $inclui = mysqli_query($link, $query) or die("erro ao incluir item");
    return mysqli_insert_id($link);
}

function listaItens($questao){
    $itensDaLista = '';
    $link = conectaMySQL();
    $query = "SELECT * FROM item WHERE ativo IS TRUE AND id_questao = ".$questao;
    $listagem = mysqli_query($link, $query) or die("erro ao listar itens");
    $count = 1;
    while($row = mysqli_fetch_assoc($listagem)){
        $itensDaLista .= '<div class="alert alert-dark" role="alert">
                            <div class="radio">
                                <label><input required type="radio" name="item_optradio" id="item_'.$count.'" value="'.$row['id'].'"> '.$row['texto'].'</label>
                            </div>
                          </div>';
        $count++;
    }
    $itensDaLista .= '';
    
    return $itensDaLista;
}

function atribuiItemCorreto($id_item, $id_questao){
    $link = conectaMySQL();
    $atribui = FALSE;
    $query1 = "UPDATE item SET correto = FALSE WHERE ativo IS TRUE AND id_questao = ".$id_questao;
    if(mysqli_query($link, $query1)){
        $query2 = "UPDATE item SET correto = TRUE WHERE ativo IS TRUE AND id = ".$id_item;
        $atribui = mysqli_query($link, $query2) or die("erro ao atribuir item correto");
    }    
    return $atribui;
}

function listaItensCadastrados($questao){
    $itensDaLista = '';
    $link = conectaMySQL();
    $query = "SELECT * FROM item WHERE ativo IS TRUE AND id_questao = ".$questao;
    $listagem = mysqli_query($link, $query) or die("erro ao listar itens");
    $count = 1;
    while($row = mysqli_fetch_assoc($listagem)){
        if($row['correto']){
            $alertTipo = 'success';
        }else{
            $alertTipo = 'danger';
        }
        $itensDaLista .= '<div class="alert alert-'.$alertTipo.'" role="alert">                            
                                <label>'.$row['texto'].'</label>
                          </div>';
        $count++;
    }
    $itensDaLista .= '';
    
    return $itensDaLista;
}

function incluirProva($titulo, $descricao){
    $data_inclusao = date("Y-m-d H:i:s"); 
    $usuario_inclusao = $_SESSION['id'];
    $ativo = TRUE;
    $link = conectaMySQL();
    //$enunciado = utf8_decode($enunciado);
    $query = "INSERT INTO prova (titulo, descricao, data_inclusao, usuario_inclusao, ativo) 
             VALUES ('".$titulo."', '".$descricao."', '".$data_inclusao."', ".$usuario_inclusao.", ".$ativo.")";
    //echo $query;
    $inclui = mysqli_query($link, $query) or die("erro ao incluir prova");
    return mysqli_insert_id($link);
}

function incluirQuestaoProva($prova, $questao){
    $data_inclusao = date("Y-m-d H:i:s"); 
    $usuario_inclusao = $_SESSION['id'];
    $ativo = TRUE;
    $link = conectaMySQL();
    //$enunciado = utf8_decode($enunciado);
    $query0 = "UPDATE prova_questao SET ativo = FALSE WHERE ativo IS TRUE AND id_prova = ".$prova." AND id_questao = ".$questao;
    mysqli_query($link, $query0); 
    $query = "INSERT INTO prova_questao (id_prova, id_questao, data_inclusao, usuario_inclusao, ativo) 
             VALUES (".$prova.", ".$questao.", '".$data_inclusao."', ".$usuario_inclusao.", ".$ativo.")";
    //echo $query;
    $inclui = mysqli_query($link, $query) or die("erro ao incluir prova_questao");
    return mysqli_insert_id($link);
}

function listaProvasTable($usuario){
    $itensDaLista = '<table class="table table-striped" id="listagem">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Título</th>
                            <th scope="col">Descrição</th>
                          </tr>
                        </thead>
                        <tbody>';
    $link = conectaMySQL();
    $query = "SELECT * FROM prova WHERE ativo IS TRUE AND usuario_inclusao = ".$usuario." ORDER BY id DESC";
    $listagem = mysqli_query($link, $query) or die("erro ao listar provas");
    while($row = mysqli_fetch_assoc($listagem)){
        //$itensDaLista .= '<a href="verquestao.php?questao='.$row['id'].'" class="list-group-item">'.$row['enunciado'].'</a>';
        $itensDaLista .= '<tr>
                            <th scope="row">'.$row['id'].'</th>
                            <td><a href="verprova.php?prova='.$row['id'].'" >'.$row['titulo'].'</a></td>
                            <td><a href="verprova.php?prova='.$row['id'].'" >'.$row['descricao'].'</a></td>
                          </tr>';
    }
    $itensDaLista .= '  </tbody>
                    </table>';
    
    return $itensDaLista;
}

function verProva($usuario, $prova){
    $itensDaLista = '';
    $link = conectaMySQL();
    $query0 = " SELECT * 
                FROM prova
                WHERE ativo IS TRUE AND usuario_inclusao = ".$usuario." 
                AND id = ".$prova;
    //echo $query;
    //die();
    $listagem0 = mysqli_query($link, $query0) or die("erro ao listar dados da prova");
    $row0 = mysqli_fetch_assoc($listagem0);
    $itensDaLista .= '  <div class="alert alert-primary text-center" role="alert">
                            <b>'.$row0['titulo'].'</b>
                        </div>';
    $itensDaLista .= '  <div class="alert alert-secondary text-center" role="alert">
                            <i>'.$row0['descricao'].'</i>
                        </div>';
    $query = "  SELECT * 
                FROM questao q, prova_questao pq
                WHERE q.ativo IS TRUE AND pq.ativo IS TRUE AND q.usuario_inclusao = ".$usuario." 
                AND pq.usuario_inclusao = ".$usuario." AND q.id = pq.id_questao AND pq.id_prova = ".$prova."
                ORDER BY pq.data_inclusao";
    //echo $query;
    //die();
    $listagem = mysqli_query($link, $query) or die("erro ao listar questões");
    while($row = mysqli_fetch_assoc($listagem)){
        //$itensDaLista .= '<a href="verquestao.php?questao='.$row['id'].'" class="list-group-item">'.$row['enunciado'].'</a>';
        $itensDaLista .= '  <div class="alert alert-dark" role="alert">
                                <div class="alert alert-primary" role="alert">
                                    '.enunciadoQuestao($row['id_questao']).'
                                </div>
                                <div class="alert alert-light" role="alert">
                                    '.listaItensCadastrados($row['id_questao']).'
                                </div>
                            </div>';
    }
    $itensDaLista .= '';
    
    return $itensDaLista;
}

function listaProvasOptions($usuario){
    $itensDaLista = '';
    $link = conectaMySQL();
    $query = "SELECT * FROM prova WHERE ativo IS TRUE AND usuario_inclusao = ".$usuario." ORDER BY id DESC";
    $listagem = mysqli_query($link, $query) or die("erro ao listar provas");
    while($row = mysqli_fetch_assoc($listagem)){
        //$itensDaLista .= '<a href="verquestao.php?questao='.$row['id'].'" class="list-group-item">'.$row['enunciado'].'</a>';
        $itensDaLista .= '<option value='.$row['id'].'>'.$row['titulo'].'</option>';
    }
    $itensDaLista .= '';
    
    return $itensDaLista;
}

function listaUsuariosOptions($usuario){
    $itensDaLista = '';
    $link = conectaMySQL();
    $query = "SELECT * FROM usuario WHERE ativo IS TRUE AND usuario_inclusao = ".$usuario." ORDER BY id DESC";
    $listagem = mysqli_query($link, $query) or die("erro ao listar provas");
    while($row = mysqli_fetch_assoc($listagem)){
        //$itensDaLista .= '<a href="verquestao.php?questao='.$row['id'].'" class="list-group-item">'.$row['enunciado'].'</a>';
        $itensDaLista .= '<option value='.$row['id'].'>'.$row['nome'].'</option>';
    }
    $itensDaLista .= '';
    
    return $itensDaLista;
}

function listaTurmasOptions($usuario){
    $itensDaLista = '';
    $link = conectaMySQL();
    $query = "SELECT * FROM turma WHERE ativo IS TRUE AND usuario_inclusao = ".$usuario." ORDER BY id DESC";
    $listagem = mysqli_query($link, $query) or die("erro ao listar provas");
    while($row = mysqli_fetch_assoc($listagem)){
        //$itensDaLista .= '<a href="verquestao.php?questao='.$row['id'].'" class="list-group-item">'.$row['enunciado'].'</a>';
        $itensDaLista .= '<option value='.$row['id'].'>'.$row['nome'].'</option>';
    }
    $itensDaLista .= '';
    
    return $itensDaLista;
}

function incluirAplicacao($prova, $usuario, $turma, $data_inicial, $data_final, $observacao){
    $data_inclusao = date("Y-m-d H:i:s"); 
    $usuario_inclusao = $_SESSION['id'];
    $ativo = TRUE;
    $link = conectaMySQL();
    //$enunciado = utf8_decode($enunciado);
    $query = "INSERT INTO aplicacao (id_prova, id_usuario, id_turma, data_inicial, data_final, observacao, data_inclusao, usuario_inclusao, ativo) 
             VALUES (".$prova.", ".$usuario.", ".$turma.", '".$data_inicial."', '".$data_final."', '".$observacao."', '".$data_inclusao."', ".$usuario_inclusao.", ".$ativo.")";
    //echo $query;
    //die();
    $inclui = mysqli_query($link, $query) or die("erro ao incluir aplicação");
    return mysqli_insert_id($link);
}

function listaAplicacoesTable($usuario){
    $itensDaLista = '<table class="table table-striped" id="listagem">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">ID da Prova</th>
                            <th scope="col">Data Inicial</th>
                            <th scope="col">Data Final</th>
                            <th scope="col">Observação</th>
                            <th scope="col">Link</th>
                          </tr>
                        </thead>
                        <tbody>';
    $link = conectaMySQL();
    $query = "SELECT * FROM aplicacao WHERE ativo IS TRUE AND usuario_inclusao = ".$usuario." ORDER BY id DESC";
    $listagem = mysqli_query($link, $query) or die("erro ao listar aplicacoes");
    while($row = mysqli_fetch_assoc($listagem)){
        //$itensDaLista .= '<a href="verquestao.php?questao='.$row['id'].'" class="list-group-item">'.$row['enunciado'].'</a>';
        $itensDaLista .= '<tr>
                            <th scope="row">'.$row['id'].'</th>
                            <td><a href="verprova.php?prova='.$row['id_prova'].'" target="_BLANK">'.$row['id_prova'].'</a></td>
                            <td>'.$row['data_inicial'].'</a></td>
                            <td>'.$row['data_final'].'</a></td>
                            <td>'.$row['observacao'].'</a></td>
                            <td><a href="responderaplicacao.php?aplicacao='.$row['id'].'" target="_BLANK">Clique aqui</a></td>
                          </tr>';
    }
    $itensDaLista .= '  </tbody>
                    </table>';
    
    return $itensDaLista;
}

function responderAplicacao($aplicacao){
    $numeroQuestao = 0;
    $itensDaLista = '';
    $link = conectaMySQL();
    $query0 = " SELECT * 
                FROM prova p, aplicacao a
                WHERE p.ativo IS TRUE AND a.ativo IS TRUE AND p.id = a.id_prova AND a.id = ".$aplicacao;
    //echo $query0;
    //die();
    $listagem0 = mysqli_query($link, $query0) or die("erro ao listar dados da prova");
    $row0 = mysqli_fetch_assoc($listagem0);
    $itensDaLista .= '  <div class="alert alert-primary text-center" role="alert">
                            <b>'.$row0['titulo'].'</b>
                        </div>';
    $itensDaLista .= '  <div class="alert alert-secondary text-center" role="alert">
                            <i>'.$row0['descricao'].'</i>
                        </div>';
    $query = "  SELECT * 
                FROM questao q, prova_questao pq
                WHERE q.ativo IS TRUE AND pq.ativo IS TRUE AND q.id = pq.id_questao 
                AND pq.id_prova = ".$row0['id_prova']."
                ORDER BY pq.data_inclusao";
    //echo $query;
    //die();
    $listagem = mysqli_query($link, $query) or die("erro ao listar questões");
    while($row = mysqli_fetch_assoc($listagem)){
        $numeroQuestao++;
        //$itensDaLista .= '<a href="verquestao.php?questao='.$row['id'].'" class="list-group-item">'.$row['enunciado'].'</a>';
        $itensDaLista .= '  <div class="alert alert-dark" role="alert">
                                <div class="alert alert-light" role="alert">
                                    <b>'.$numeroQuestao.') </b>
                                    '.enunciadoQuestao($row['id_questao']).'
                                </div>
                                <div class="alert alert-light" role="alert">
                                    '.listaItensAplicacao($row['id_questao']).'
                                </div>
                            </div>';
    }
    $itensDaLista .= '';
    
    return $itensDaLista;
}

function listaItensAplicacao($questao){
    $itensDaLista = '';
    $link = conectaMySQL();
    $query = "SELECT * FROM item WHERE ativo IS TRUE AND id_questao = ".$questao;
    $listagem = mysqli_query($link, $query) or die("erro ao listar itens");
    $count = 1;
    while($row = mysqli_fetch_assoc($listagem)){
        $itensDaLista .= '<div class="alert alert-dark" role="alert">
                            <div class="radio">
                                <label><input required type="radio" name="item_optradio_'.$questao.'" id="item_'.$count.'" value="'.$row['id'].'"> '.$row['texto'].'</label>
                            </div>
                          </div>';
        $count++;
    }
    $itensDaLista .= '';
    
    return $itensDaLista;
}

function incluirRespostas($respostas, $aplicacao){
    $data_inclusao = date("Y-m-d H:i:s"); 
    $usuario_inclusao = $_SESSION['id'];
    $ativo = TRUE;
    $link = conectaMySQL();
    $query0 = " SELECT * 
                FROM prova p, aplicacao a
                WHERE p.ativo IS TRUE AND a.ativo IS TRUE AND p.id = a.id_prova AND a.id = ".$aplicacao;
    //echo $query0;
    //die();
    $listagem0 = mysqli_query($link, $query0) or die("erro ao listar dados da prova");
    $row0 = mysqli_fetch_assoc($listagem0);
    $query1 = " SELECT * 
                FROM questao q, prova_questao pq
                WHERE q.ativo IS TRUE AND pq.ativo IS TRUE AND q.id = pq.id_questao 
                AND pq.id_prova = ".$row0['id_prova']."
                ORDER BY pq.data_inclusao";
    //echo $query;
    //die();
    $listagem1 = mysqli_query($link, $query1) or die("erro ao listar questões");
    while($row = mysqli_fetch_assoc($listagem1)){
        $id_usuario = $usuario_inclusao;
        $id_aplicacao = $aplicacao;
        $id_questao = $row['id_questao'];
        $id_item = $respostas['item_optradio_'.$id_questao];
        
        $query2 = " SELECT COUNT(*) as qtde 
                FROM resposta
                WHERE ativo IS TRUE 
                AND id_usuario = ".$id_usuario." 
                AND id_aplicacao = ".$id_aplicacao." 
                AND id_questao = ".$id_questao." ";
        //echo $query2;
        //die();
        $listagem2 = mysqli_query($link, $query2) or die("erro ao listar respostas");
        $row2 = mysqli_fetch_assoc($listagem2);
        
        if($row2['qtde']==0){
            $query = "INSERT INTO resposta (id_usuario, id_aplicacao, id_questao, id_item, data_inclusao, usuario_inclusao, ativo) 
                 VALUES (".$id_usuario.", ".$id_aplicacao.", ".$id_questao.", ".$id_item.", '".$data_inclusao."', ".$usuario_inclusao.", ".$ativo.")";
            //echo $query;
            //die();
            $inclui = mysqli_query($link, $query) or die("erro ao incluir resposta");
        }else{
            echo "Questão ID ".$id_questao." já respondida!<br>";
        }
    }
    //$enunciado = utf8_decode($enunciado);
    
    return TRUE;
}

function resultadoAplicacao($aplicacao, $usuario){
    $numeroQuestao = 0;
    $itensDaLista = '';
    $link = conectaMySQL();
    $query0 = " SELECT * 
                FROM prova p, aplicacao a
                WHERE p.ativo IS TRUE AND a.ativo IS TRUE AND p.id = a.id_prova AND a.id = ".$aplicacao;
    //echo $query0;
    //die();
    $listagem0 = mysqli_query($link, $query0) or die("erro ao listar dados da prova");
    $row0 = mysqli_fetch_assoc($listagem0);
    $itensDaLista .= '  <div class="alert alert-primary text-center" role="alert">
                            <b>'.$row0['titulo'].'</b>
                        </div>';
    $itensDaLista .= '  <div class="alert alert-secondary text-center" role="alert">
                            <i>'.$row0['descricao'].'</i>
                        </div>';
    $query = "  SELECT * 
                FROM questao q, prova_questao pq
                WHERE q.ativo IS TRUE AND pq.ativo IS TRUE AND q.id = pq.id_questao 
                AND pq.id_prova = ".$row0['id_prova']."
                ORDER BY pq.data_inclusao";
    //echo $query;
    //die();
    $listagem = mysqli_query($link, $query) or die("erro ao listar questões");
    while($row = mysqli_fetch_assoc($listagem)){
        $numeroQuestao++;
        //$itensDaLista .= '<a href="verquestao.php?questao='.$row['id'].'" class="list-group-item">'.$row['enunciado'].'</a>';
        $itensDaLista .= '  <div class="alert alert-dark" role="alert">
                                <div class="alert alert-light" role="alert">
                                    <b>'.$numeroQuestao.') </b>
                                    '.enunciadoQuestao($row['id_questao']).'
                                </div>
                                <div class="alert alert-light" role="alert">
                                    '.listaItensAplicacaoCorrecao($row['id_questao'], $aplicacao, $usuario).'
                                </div>
                            </div>';
    }
    $itensDaLista .= '';
    
    return $itensDaLista;
}

function listaItensAplicacaoCorrecao($questao, $aplicacao, $usuario){
    $itensDaLista = '';
    $link = conectaMySQL();
    $query = "SELECT * FROM item WHERE ativo IS TRUE AND id_questao = ".$questao;
    $listagem = mysqli_query($link, $query) or die("erro ao listar itens");
    $count = 1;
    while($row = mysqli_fetch_assoc($listagem)){
        $id_usuario = $usuario;
        $id_aplicacao = $aplicacao;
        $id_questao = $questao;
        $id_item = $row['id'];
        $query2 = " SELECT COUNT(*) as qtde 
                FROM resposta
                WHERE ativo IS TRUE 
                AND id_usuario = ".$id_usuario." 
                AND id_aplicacao = ".$id_aplicacao." 
                AND id_questao = ".$id_questao." 
                AND id_item = ".$id_item." ";
        //echo $query2;
        //die();
        $listagem2 = mysqli_query($link, $query2) or die("erro ao listar respostas");
        $row2 = mysqli_fetch_assoc($listagem2);
        if($row2['qtde']>0){
            $check = 'checked';
        }else{
            $check = '';
        }
        if($row['correto']){
            $alertTipo = 'success';
        }else{
            $alertTipo = 'danger';
        }
        $itensDaLista .= '<div class="alert alert-'.$alertTipo.'" role="alert">
                            <div class="radio">
                                <label><input disabled '.$check.' required type="radio" name="item_optradio_'.$questao.'" id="item_'.$count.'" value="'.$row['id'].'" > '.$row['texto'].'</label>
                            </div>
                          </div>';
        $count++;
    }
    $itensDaLista .= '';
    
    return $itensDaLista;
}

function calcularNotaAplicacao($aplicacao, $usuario){
    $link = conectaMySQL();
    $query1 = " SELECT COUNT(*) as qtde
                FROM resposta r, item i
                WHERE r.ativo IS TRUE
                    AND i.ativo IS TRUE
                    AND i.id_questao = r.id_questao
                    AND r.id_aplicacao = ".$aplicacao."
                    AND r.id_usuario = ".$usuario."
                    AND i.correto IS TRUE
                    AND i.id = r.id_item";
    $listagem1 = mysqli_query($link, $query1) or die("erro ao contar acertos");
    $row1 = mysqli_fetch_assoc($listagem1);
    $acertos = $row1['qtde'];
    
    $query2 = " SELECT COUNT(*) as qtde
                FROM aplicacao a, prova_questao pq, questao q
                WHERE a.ativo IS TRUE
                AND pq.ativo IS TRUE
                AND q.ativo IS TRUE
                AND a.id_prova = pq.id_prova
                AND pq.id_questao = q.id
                AND a.id = ".$aplicacao." ";
    $listagem2 = mysqli_query($link, $query2) or die("erro ao contar questoes");
    $row2 = mysqli_fetch_assoc($listagem2);
    $questoes = $row2['qtde'];
    
    //echo 'A nota é: '.$acertos;
    
    $nota = (10/$questoes)*$acertos;
    
    $nota = round($nota, 2);
    
    return $nota;
}

<?php 
require_once "validador_acesso.php";
  
?>

<?php
//Referencias de uso das funções > http://php.net/manual/pt_BR/function.fopen.php

  //array de chamados
  $chamados = [];

  //abrir arquivo.hd
  $arquivo = fopen('arquivo.hd','r');

  //enquato houverem registros (linhas) a serem recuperados
  
  while(!feof($arquivo)){ //testa pelo fim do arquivo (isso passa de linha em linha pra saber se ta no final do arquivo)
    //linhas
    $registro = fgets($arquivo);//recupera a linha (a cada vez que ele passa pela linha pra saber se é o final, esse metodo pega o valor da linha em q ele está)

    //explode dos detalhes do registro para verificar o id do usuário responsável pelo cadastro
    $registro_detalhes = explode('#', $registro);

    //(perfil id = 2) só vamos exibir o chamado, se ele foi criado pelo usuário
    if($_SESSION['perfil_id'] == 2) {

      //se usuário autenticado não for o usuário de abertura do chamado então não faz nada
      if($_SESSION['id'] != $registro_detalhes[0]) {
        continue; //não faz nada

      } else {
        $chamados[] = $registro; //adiciona o registro do arquivo ao array $chamados
      }
    } else {
      $chamados[] = $registro; //Inseri o valor da linha no array
    }
  }

  //fechando o arquivo.hd
  fclose($arquivo);
  
?>
<html>
  <head>
    <meta charset="utf-8" />
    <title>App Help Desk</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
      .card-consultar-chamado {
        padding: 30px 0 0 0;
        width: 100%;
        margin: 0 auto;
      }
    </style>
  </head>

  <body>

    <nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="#">
        <img src="logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
        App Help Desk
      </a>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="logoff.php" class="nav-link">
          SAIR
          </a>
        </li>
      </ul>
    </nav>

    <div class="container">    
      <div class="row">

        <div class="card-consultar-chamado">
          <div class="card">
            <div class="card-header">
              Consulta de chamado
            </div>
            
            <div class="card-body">
              
              <?php  foreach($chamados as $chamado){ 
                  $chamado_dados = explode('#', $chamado);

					        //não existe detalhes do chamado se ele não estiver completo
                  if(count($chamado_dados) < 3) { continue; }
              ?>
              <div class="card mb-3 bg-light">
                <div class="card-body">
                  <h5 class="card-title"><?= $chamado_dados[1]?></h5>
                  <h6 class="card-subtitle mb-2 text-muted"><?= $chamado_dados[2]?></h6>
                  <p class="card-text"><?= $chamado_dados[3]?></p>
                </div>
              </div>

              <?php } ?>

              <div class="row mt-5">
                <div class="col-6">
                  <a href="home.php" class="btn btn-lg btn-warning btn-block">Voltar</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
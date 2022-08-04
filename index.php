<?php

//require significa => pegar um arquivo externo e conectar com este;
//require for get an external file and connect with this;

require('db/conexao.php');


?>

  
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD COM PHP</title>

    <link href="css/style.css" rel="stylesheet" type="text/css" />

    

</head>
<body>

     <h2>Trabalhar com os dados através do formulario (CRUD)</h2>

     <!-- Formulario para inserir -->
     <!-- Form TO insert -->


     <form id="form_salva" method="POST">

        <input type="text" name="nome" placeholder="Digite seu nome">
        <input type="email" name="email" placeholder="Digite seu email">
        
        <button type="submit" name="salvar">Salvar</button>

     </form>
     <br>

  
     <!-- Formulario para atualizar -->
     <!-- Form to update -->

     <form class="oculto" id="form_atualiza" method="post">
        <input type="hidden" id="id_editado" name="id_editado" placeholder="ID">
        <input type="text" id="nome_editado" name="nome_editado" placeholder="Editar nome">
        <input type="email" id="email_editado" name="email_editado" placeholder="Editar email">
        <button type="submit" name="atualizar">Atualizar</button>
        <button type="button" id="cancelar" name="cancelar">Cancelar</button>
      </form> 


      <br>

      <!-- Formulario para deletar -->
       <!-- Form to delete -->

      <form class="oculto" id="form_deleta" method="post">
        <input type="hidden" id="id_deleta" name="id_deleta" placeholder="ID">
        <input type="hidden" id="nome_deleta" name="nome_deleta" placeholder="Editar nome" required>
        <input type="hidden" id="email_deleta" name="email_deleta" placeholder="Editar email" required> 
        <b>Tem certeza que quer deletar? <span id="cliente"></span>?</b>
        <button type="submit" name="deletar">Confirmar</button>
        <button type="button" id="cancelar_delete" name="cancelar_delete">Cancelar</button>
      </form>   
      

     <?php

        /*inserir um dado no banco - modo simples - simple away for prepare query
          preparar query

          $sql = $pdo->prepare("INSERT INTO clientes VALUES (null, 'Patricia','teste@teste.com','29-07-2022')");
          $sql->execute();

           =>Agora modo correto de preparar iserçao de dados evitando SQL INJECTION;
           =>Better away to prepare query, you can avoid SQL INJECTION;

          $nome="Maria";
          $email="provedor";
          $data=date(d-m-Y);

          $sql = $pdo->prepare("INSERT INTO clientes VALUES (null, ?,?,?)");
          $sql->execute(array($nome, $email, $data));*/ 




    //INSERIR DADOS 
    //Insert data

 if (isset($_POST['salvar']) && isset($_POST['nome']) && isset($_POST['email'])){



   $nome= limparPost($_POST['nome']);
   $email= limparPost($_POST['email']);
   $data=date('d-m-Y');

   //validação de campo vazio
   //validation empty space
   if ($nome=="" || $nome==NULL){

    echo "<b>Nome não pode ser vazio</b>";

    exit();

   }
   if ($email=="" || $email==NULL){

    echo "<b>Email não pode ser vazio</b>";

    exit();

   }

   //validação de nome
   //validation name

    if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)) {

      echo "<b style='color:red'>Somente permitido letras e espaços em branco</b>";

        exit();
    }

    //validação de email
     //validation email

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "<b style='color:red'>Formato de email invalido</b>";

      exit();
    }

  //Comando para inserir
  //command to insert

    $sql = $pdo->prepare("INSERT INTO clientes VALUES (null, ?,?,?)");
    $sql->execute(array($nome, $email, $data));

   echo "<b>Cliente inserido com sucesso</b>";


 }

?>


<?php

//Atualizar dados
//Update data

if(isset($_POST['atualizar']) && isset($_POST['id_editado']) && isset($_POST['nome_editado']) && isset($_POST['email_editado'])){
        
  $id=limparPost($_POST['id_editado']);
  $nome=limparPost($_POST['nome_editado']);
  $email=limparPost($_POST['email_editado']);

  //Validação campo vazio
if ($nome=="" || $nome==null){
  echo "<b style='color:red'>Nome não pode ser vazio</b>";
  exit();
}

if ($email=="" || $email==null){
  echo "<b style='color:red'>Email não pode ser vazio</b>";
  exit();
}



//Validaço de nome
//validation name
  if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)) {
    echo "<b style='color:red'>Somente permitido letras e espaços em branco para o nome</b>";
    exit();
  }

  //validação email
  //validation email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<b style='color:red'>Formato de email inválido!</b>";
    exit();
  }

  //Comando para atualizar
  //Command for update
  $sql = $pdo->prepare("UPDATE clientes SET nome=?, email=? WHERE id=?");
  $sql->execute(array($nome,$email,$id));

  echo "Atualizado ".$sql->rowCount()." registros!";

}

?>

<?php
    //Deletar dados
    //Delete data
    if(isset($_POST['deletar']) && isset($_POST['id_deleta']) && isset($_POST['nome_deleta']) && isset($_POST['email_deleta'])){
        
        $id=limparPost($_POST['id_deleta']);
        $nome=limparPost($_POST['nome_deleta']);
        $email=limparPost($_POST['email_deleta']); 

    //Comando para deletar
    //Command for delete

        $sql = $pdo->prepare("DELETE FROM clientes WHERE id=? AND nome=? AND email=?");
        $sql->execute(array($id, $nome, $email));

        echo "Deletado com sucesso!";

    }

    ?>




<?php

      //selecionar dados
      //select date

      $sql = $pdo->prepare("SELECT * FROM clientes");
        $sql->execute();

        //Com a função fetchAll coloca os dados em uma matriz;
        //The function fetchALL put the data in a matrix;

        $dados = $sql->fetchAll();


        //echo "<pre>";
        //print_r($dados);
        //echo "</pre>";


        //selecionar dados especificos (filtrar) do banco de dados:
        //select specific data (filter) to database;

        // $sql = $pdo->prepare("SELECT * FROM clientes WHERE email=?");
        //$email = 'teste2@gmail.com';
        // $sql->execute(array($email));

        //cria uma variavel para receber os dados do bd e com a função fetchAll coloca-os em uma matriz;
        //$dados = $sql->fetchAll();   


?>

  <?php

   //Verificar se tem dados (ARRAY DADOS MAIOR QUE ZERO)
   //check for date

  if (count($dados) > 0){

    echo "<br><br><table>

    <tr>
      <th>ID</th>
      <th>Nome</th>
      <th>Email</th>
      <th>Ações</th>
    </tr>";


    //Laço de repetição para criar nova linha
    //Loop for create new line
    foreach($dados as $chave => $valor){

      echo 
            "<tr>
              <td>".$valor['id']."</td>
              <td>".$valor['nome']."</td>
              <td>".$valor['email']."</td>
              <td><a href='#' class='btn-atualizar' data-id= '".$valor['id']."' data-nome= '".$valor['nome']."' data-email= '".$valor['email']."'>Atualizar</a> | 
              <a href='#' class='btn-deletar' data-id= '".$valor['id']."' data-nome= '".$valor['nome']."' data-email= '".$valor['email']."'>Deletar</a></td>
            </tr>";

    }
  
    echo "</table>";


  }else{

    echo "<b>Nenhum Cliente Cadastrado</b>";
  }


  ?>
  

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 

    
    <script>
          
          //A função abaixo foi criada para alimentar o link com os os dados do bd, quando quiser editar ou excluir, ou atualizar;
          //the function was create to feed the link with the data of the database, when someone wants: update, delete or edit;



        $(".btn-atualizar").click(function(){
          //this = do botao que foi clicado/attr=atributo que quero pegar é o data-id
              var id = $(this).attr('data-id');
              var nome =  $(this).attr('data-nome');
              var email = $(this).attr('data-email');

              $('#form_salva').addClass('oculto');
              $('#form_deleta').addClass('oculto');
              $('#form_atualiza').removeClass('oculto');

              //quando clicar em editar recebe o valor do id;
              //when click in edit, received the value to id;
              $("#id_editado").val(id);
              $("#nome_editado").val(nome);
              $("#email_editado").val(email);

            //alert('O ID é: '+id+" | nome é: "+nome+" | email é: "+email);
        });


        $(".btn-deletar").click(function(){
          //this = do botao que foi clicado/attr=atributo que quero pegar é o data-id
              var id = $(this).attr('data-id');
              var nome =  $(this).attr('data-nome');
              var email = $(this).attr('data-email');


              $("#id_deleta").val(id);
              $("#nome_deleta").val(nome);
              $("#email_deleta").val(email);
              $("#cliente").html(nome);
          
              $('#form_salva').addClass('oculto');
              $('#form_atualiza').addClass('oculto');
              $('#form_deleta').removeClass('oculto');

            });


            $('#cancelar').click(function(){
               $('#form_salva').removeClass('oculto');
               $('#form_atualiza').addClass('oculto'); 
               $('#form_deleta').addClass('oculto');
                 
            });
      

            $('#cancelar_delete').click(function(){
               $('#form_salva').removeClass('oculto');
               $('#form_atualiza').addClass('oculto');
               $('#form_deleta').addClass('oculto');

            });       

            

    </script>  
    

        

   

      
</body>



</html>









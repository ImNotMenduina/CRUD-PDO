<?php 
@require_once('classPessoa.php') ; 
$p = new Pessoa("oop_crud","localhost","root","") ; 

if(count($_POST)>0)
{
    $nome = $_POST['nome'] ; 
    $email = $_POST['email'] ; 
    $senhav1 = $_POST['senhav1'] ; 
    $senhav2 = $_POST['senhav2'] ; 
    $nivelAcesso = $_POST['array'] ; 
    $dataCadastro = date("Y/m/d H:i:s",time()) ; 
    $return = $p->addCliente($nome,$email,$senhav1,$senhav2,$nivelAcesso,$dataCadastro) ; 
   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/cadastro.css">
    <title>Cadastro OOP</title>
</head>
<body>
    <section id="crud">
    <?php 
    if($return){
    ?>
    <div id="error"><?php echo $return ?></div>
    <?php
    }
    else { 
    ?>
    <div id="sucess"><?php echo "<p>Usurário cadastrado com sucesso.</p>" ?></div>
    <?php 
    unset($_POST) ;
    }
    ?>
        <form method="POST">
            
            <h3>Cadastro de Usuário</h3>
            <input type="text" name="nome" placeholder="Nome" value=<?php 
            if(isset($_POST['nome'])) 
            echo $_POST['nome'] ; 
            ?>> <!-- NOME DA PESSOA -->
            <input type="text" name="email" placeholder="E-mail" value=<?php
            if(isset($_POST['email']))
            echo $_POST['email'] ; 
            ?>> <!-- EMAIL  -->
            <input type="password" name="senhav1" placeholder="Senha"> <!-- SENHA -->
            <input type="password" name="senhav2" placeholder="Repita a senha"> <!-- CONFIRMA SENHA -->
            <div>
                <input type="radio" name="array" value="padrao" id="padrao" checked><!-- NIVEL DE ACESSO PADRAO -->
                 <label for="padrao">Usuário Padrão</label>
                <input type="radio" name="array" value="adm" id="adm"><!-- NIVEL DE ACESSO ADM -->
                <label for="adm">Gestor</label>
            </div>
            
            <button type="submit">Enviar</button>
        </form>
    </section>
</body>
</html>
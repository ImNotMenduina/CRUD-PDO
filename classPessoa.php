<?php 

class Pessoa {
    private $pdo  ;
    
    public function __construct($db,$host,$user,$senha)
    {
        try
        {
            $this->pdo = new PDO("mysql:dbname=".$db.";host=".$host,$user,$senha) ; /* mysqli:dbname=$db;host=$host,$user,$password */
        }
        catch (PDOException $error)
        {
            echo "* Falha ao conectar com o banco de dados : " . $error->getMessage() ; 
        }
        catch (Exception $error)
        {
            echo "* Falha generica ao conectar : ".$error->getMessage() ; 
        }
        
    }
    public function addCliente($nome,$email,$senhav1,$senhav2,$nivelAcesso,$dataCadastro)
    {
        $e = false ; 
        if(empty($nome) || strlen($nome) < 3)
        {
            $e = "<p>* Insira um nome válido . </p>" ; 
        }

        /* =================================CONTROLE DE DE ENTRADA DO EMAIL ============================*/

        if(!empty($email))
        {
            if(filter_var($email,FILTER_VALIDATE_EMAIL))
            {   
                $query_email = $this->pdo->query("SELECT email FROM crud WHERE email='$email'") ; 
                if($query_email->rowCount()>0)
                {
                    $e.= "<p>* E-mail já cadastrado.</p>" ; 
                }
            }
            else
            {
                $e.="<p>* Insira um email válido.</p>";
            }   
        }
        else
        {
            $e.="<p>* O campo email deve ser preenchido para concluir o cadastro.</p>" ; 
        }

        /* =================================CRIPTOGRAFIA DA SENHA ============================*/
        
        if(empty($senhav2))
        {
            $e.="<p>* Confirme sua senha para concluir o cadastro.</p>" ; 
        }
        else
        {
            if($senhav2 === $senhav1)
            {
                $senha_cript = password_hash($senhav2,PASSWORD_DEFAULT) ; 
            }
            else
            {
                $e.="<p>* As senhas não coincidem.</p>";
            }
        }
        /* INSERIR DADOS NO BANCO */
        if(!$e)
        {
            $cmd = $this->pdo->prepare("INSERT INTO crud (nome,email,senha,nivelAcesso,dataCadastro) VALUES (:nome,:email,:senha,:nivelAcesso,:dataCadastro)") ; 
            $cmd->bindValue(":nome","$nome") ; 
            $cmd->bindValue(":email","$email") ; 
            $cmd->bindValue(":senha","$senha_cript") ;
            $cmd->bindValue(":nivelAcesso","$nivelAcesso") ; 
            $cmd->bindValue(":dataCadastro","$dataCadastro") ; 
            $cmd->execute() ; 
            
            return 0 ; 
        }
        else
        {
            return $e ; 
        }
        
    }
}


?>
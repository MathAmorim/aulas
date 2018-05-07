<?php
    require_once ("conexao.class.php");
    require_once ("escola.class.php");
    class DaoEscola{
        public function getAll(){
            $retorno = NULL;
            $conexao = new Conexao(); 
            $sql = "SELECT `e`.`id_escola`, `e`.`nome`, `e`.`telefone`, 
            `e`.`endereco`, `e`.`email`, `d`.`nome` AS diretor, 
            `c`.`nome` AS categoria FROM `escola` AS `e` 
            INNER JOIN `diretor` as `d` ON `d`.`id_diretor` = 
            `e`.`diretor_id_diretor` 
            INNER JOIN `categoria` as `c`ON 
            `e`.`categoria_id_categoria` = `c`.`id_categoria` 
            ORDER BY `c`.`nome`ASC";

            $con = $conexao->connection();
            $result = $con->query($sql);
            if($result->num_rows > 0){
                $retorno = array();
                while($row = $result->fetch_assoc()){
                    $escola = new Escola();
                    $escola->setCodigo($row['id_escola']);
                    $escola->setNome($row['nome']);
                    $escola->setTelefone($row['telefone']);
                    $escola->setEmail($row['email']);
                    $escola->setEndereco($row['endereco']);
                    $escola->setDiretor($row['diretor']);
                    $escola->setCategoria($row['categoria']);

                    array_push($retorno,$escola);
                }
            }
            $con->close();
            return $retorno;
        }
        public function save($escola){
        
            $conexao = new Conexao();
            $sql = "INSERT INTO `escola`(`nome`, `telefone`, 
                                `email`, `endereco`,`codigo_diretor_fk`)
                                 VALUES (?,?,?,?,?)";
            $con = $conexao->connection();
            $stmt = $con->prepare($sql); //anitaaa[]
            $stmt->bind_param('ssssi',$a,$b,$c,$d,$e);
            $a = $escola->getNome();
            $b = $escola->getTelefone();
            $c = $escola->getEmail();
            $d = $escola->getEndereco();
            $e  = intval($escola->getDiretor());
            $stmt->execute();

            

            $stmt->close();
            $con->close();

            return true;
        }


        public function pesquisarEscola($id){
            $conexao = new Conexao(); 
            $escola  = NULL;
            $con = $conexao->connection();
            $sql = " select `id_escola`,`nome`, `telefone`, `endereco`, `email`, `diretor_id_diretor`,`categoria_id_categoria` from `escola` where `id_escola` = {$id}";
            $result = $con->query($sql);
        
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $escola = new Escola();
                    $id = $row['id_escola'];
                    $nome = $row['nome'];
                    $telefone = $row['telefone'];
                    $endereco = $row['endereco'];
                    $email = $row['email'];
                    $diretor_id = $row['diretor_id_diretor'];
                    $categoria_id = $row['categoria_id_categoria'];
    
                    $escola->setNome($nome);
                    $escola->setTelefone($telefone);
                    $escola->setEndereco($endereco);
                    $escola->setEmail($email);
                    $escola->setDiretor($diretor_id);
                    $escola->setCategoria($categoria_id);
                    $escola->setCodigo($id);
    
                }
            }
    
            $con->close();
    
            var_dump($escola);
            return $escola;
        
        
    
        }

        
    }


   

    /*$dao = new DaoEscola();

    var_dump($dao->getAll());*/
/*
    $escola = new Escola();
    $escola->setNome("IFGOIANO");
    $escola->setTelefone("36202500");
    $escola->setEmail("ifgoiano@ifgoiano.edu.br");
    $escola->setEndereco("Rodovia Sul Goiana, Km 01, Zona Rural | Rio Verde - Go ");
    $escola->setDiretor(1);
    $dao = new DaoEscola();
    $dao->save($escola);*/




?>
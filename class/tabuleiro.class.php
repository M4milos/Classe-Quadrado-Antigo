<?php
    include_once "../conf/default.inc.php";
    require_once "../conf/Conexao.php";
    include_once "../constante/const.php";
    class Tabuleiro{
        private $id;
        private $lado;

        public function __construct($id, $lado){
            $this->setId($id);
            $this->setLado($lado);     
        }

        public function setId($id){
            if ($id > 0){
                $this->id = $id;
            }
        }
        public function getId(){return $this->id;}

        public function setLado($lado){
            if($lado > 0) {
            $this->lado = $lado;
            }
        }
        public function getLado(){return $this->lado;}

        public function Area(){
            return $this->getLado() * $this->getLado();
        }

        public function Perimetro (){
            return $this->getLado() * Perimetro;
        }

        public function Desenhar(){
            $desenho = "<div style='width: ".$this->getLado()."px; height: ".$this->getLado()."px; background: #9400D3'></div>";
            return $desenho;
        }

        public function Listar($tipo = 0, $info = "" ){

            $pdo = Conexao::getInstance();

            $sql = 'SELECT * FROM tabuleiro';
            //adicionar parametros
            if ($tipo > 0) {
                switch ($tipo) {
                    case '1': $sql .= " WHERE idTabuleiro = :info"; break; 
                    case '2': $sql .= " WHERE lado LIKE :info"; $info .= "%"; break;
                }
            }

            $lista = $pdo->prepare($sql);

            if ($tipo > 0) 
                $lista->bindValue(':info',$info, PDO::PARAM_STR);
            
            $lista->execute();

            return $lista->fetchAll();

        }

        public function Salvar(){
            $pdo = Conexao::getInstance();
            $sql = "INSERT INTO tabuleiro (idTabuleiro,Lado) VALUES (null,:lado)";
            $inserir = $pdo->prepare($sql);
            $inserir->bindValue(':lado', $this->getLado());

            if ($inserir->execute()){
                return $pdo->lastInsertId()." Deu boa <br>";
            } else{
                return $inserir->debugDumpParams();
            }
        }

        public function Excluir(){
            $pdo = Conexao::getInstance();
            $excluir = $pdo->prepare('DELETE FROM tabuleiro WHERE idTabuleiro = :id');
            $excluir->bindValue(':id', $this->getId(), PDO::PARAM_STR);
            if ($excluir->execute()){
                return $pdo->lastInsertId()." Item excluido";
            } else{
                return $excluir->debugDumpParams();
            }
        }

        public function Editar(){
            $pdo = Conexao::getInstance();
            $sql = "UPDATE tabuleiro SET lado = :lado WHERE idTabuleiro = :id";
            $editar = $pdo->prepare($sql);
            $editar->bindValue(':lado', $this->getLado(), PDO::PARAM_STR);
            $editar->bindValue(':id', $this->getId(), PDO::PARAM_STR);
            return $editar->execute();
        }

        public function __toString(){
            return  "<h5>[TABULEIRO] <br>".
                    "ID: ". $this->getId(). "<br>".
                    "Lado: ". $this->getLado() ."<br>".
                    "??rea: ". $this->Area()."<br>".
                    "Perimetro: ". $this->Perimetro(). "</h5><br>";
        }
    }

?>
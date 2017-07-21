<?php
namespace FlexPeak\App;
use Exception;
use FlexPeak\Model\Curso;
use FlexPeak\Utils\Log;
use PDO;

/**
 * Created by Rudda Beltrao
 * Date: 21/07/2017
 * Time: 16:54
 * Lab312 developer android  & php backend
 * www.lab312-icetufam.com.br
 * beltrao.rudah@gmail.com
 */
class PortalProfessor
{
    private $pdo;
    private $log;
    private $PDOExceptionMessage;

    public $host='localhost';
    public $pass= '';
    public $user='root';
    public $dbname= 'flexpeak-desafio';


    function __construct()
    {
        $this->log = new Log();
    }

    private function  connect(){

           try{
                //nao usar porta 80 em teste local
                $this->pdo = new PDO('mysql:host=localhost;dbname=flexpeak-desafio', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true); //habilitar par multiplas queries


            }catch (\PDOException $err){
               $this->PDOExceptionMessage = $err->getMessage();
                $this->pdo = false;

            }

        return false;
    }


    public function addCurso(Curso $curso){


        $this->connect();

        if($this->pdo != null && $this->pdo != false){


            try{

                $query = 'INSERT INTO `curso` ( `nome`, `resumo`, `professor_id_professor`, `capa`) VALUES ( :nome, :resumo, :professor_id_professor, :capa) ';


                $stmt = $this->pdo->prepare($query);
                $stmt->bindValue(':nome', $curso->getNome());
                $stmt->bindValue(':resumo', $curso->getResumo());
                $stmt->bindValue(':professor_id_professor', $curso->getProfessorIdProfessor());
                $stmt->bindValue(':capa', $curso->getCapa());


                if($stmt->execute()){

                    $curso->setIdCurso($this->pdo->lastInsertId());
                    return $this->log->sucess('sucesso ao cadastrar curso', $curso);

                }else{

                    return $this->log->error('curso nao cadastrado');

                }

            }catch (\PDOException $erro){

                return $this->log->error($erro->getMessage());

            }


        }
            return $this->log->error('conexao not  ok '.$this->PDOExceptionMessage);

    }

    public function getCursos($professor_id){

        $this->connect();
        if($this->pdo != null and $this->pdo != false){


           $query = 'select * from curso where professor_id_professor = :key';


            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':key', $professor_id);

            if($stmt->execute()){
                $data = array();

                while($result = $stmt->fetch(PDO::FETCH_ASSOC)){

                    $data[] = $result;

                }
                if(count($data)>0){

                    return $this->log->sucess('sucesso', $data);
                }else{


                    return $this->log->noDada();

                }


            }

            return $this->log->sucess('sucess', null);


        }

        return $this->log->error('erro');


    }

    
    
    
}
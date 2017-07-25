<?php
namespace FlexPeak\App;

use Exception;
use FlexPeak\Model\Aluno;
use FlexPeak\Model\Curso;
use FlexPeak\Model\Nota;
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

    public $host = 'localhost';
    public $pass = '';
    public $user = 'root';
    public $dbname = 'flexpeak-desafio';


    function __construct()
    {
        $this->log = new Log();
    }

    private function connect()
    {

        try {
            //nao usar porta 80 em teste local
            $this->pdo = new PDO('mysql:host=localhost;dbname=flexpeak-desafio', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true); //habilitar par multiplas queries


        } catch (\PDOException $err) {
            $this->PDOExceptionMessage = $err->getMessage();
            $this->pdo = false;

        }

        return false;
    }


    public function addCurso(Curso $curso)
    {


        $this->connect();

        if ($this->pdo != null && $this->pdo != false) {


            try {

                $query = 'INSERT INTO `curso` ( `nome`, `resumo`, `professor_id_professor`, `capa`) VALUES ( :nome, :resumo, :professor_id_professor, :capa) ';


                $stmt = $this->pdo->prepare($query);
                $stmt->bindValue(':nome', $curso->getNome());
                $stmt->bindValue(':resumo', $curso->getResumo());
                $stmt->bindValue(':professor_id_professor', $curso->getProfessorIdProfessor());
                $stmt->bindValue(':capa', $curso->getCapa());


                if ($stmt->execute()) {

                    $curso->setIdCurso($this->pdo->lastInsertId());
                    return $this->log->sucess('sucesso ao cadastrar curso', $curso);

                } else {

                    return $this->log->error('curso nao cadastrado');

                }

            } catch (\PDOException $erro) {

                return $this->log->error($erro->getMessage());

            }


        }
        return $this->log->error('conexao not  ok ' . $this->PDOExceptionMessage);

    }

    public function getCursos($professor_id, $idcurso = "")
    {


        $this->connect();
        if ($this->pdo != null and $this->pdo != false) {

            $query = 'select * from curso where professor_id_professor = :key';

            if (strcmp($idcurso, '') != 0) {

                $query = $query . ' and id_curso = :curso';
                $stmt = $this->pdo->prepare($query);
                $stmt->bindValue(':key', $professor_id);
                $stmt->bindValue(':curso', $idcurso);
            } else {

                $stmt = $this->pdo->prepare($query);
                $stmt->bindValue(':key', $professor_id);

            }


            if ($stmt->execute()) {
                $data = array();

                while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $data[] = $result;

                }
                if (count($data) > 0) {

                    return $this->log->sucess('sucesso', $data);
                } else {


                    return $this->log->noDada();

                }


            }

            return $this->log->sucess('sucess', null);


        }

        return $this->log->error('erro');


    }


    public function getnotas($aluno_id, $curso_id)
    {

        $query = 'select nota_1, nota_2, nota_3, nota_4, ( (nota_1 + nota_2 + nota_3 + nota_4)/4 ) as media from notas where aluno_id_aluno = :aluno and curso_id_curso = :curso';
        $this->connect();
        // $this->pdo = new PDO();


        if ($this->pdo != false && $this->pdo != null) {

            try {

                $stmt = $this->pdo->prepare($query);
                $stmt->bindValue(":aluno", $aluno_id);
                $stmt->bindValue(":curso", $curso_id);

                if ($stmt->execute()) {

                    if ($stmt->rowCount() > 0) {

                        $data = array();
                        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

                            if($result['media']>=6){

                                $result['situacao'] = 'aprovado';

                            }else{

                                $result['situacao'] = 'reprovado';
                            }

                            $data[] = $result;

                        }

                        return $this->log->sucess('sucess', $data);

                    } else {

                        return $this->log->error($stmt->queryString);
                    }

                }

            } catch (Exception $err) {


                $this->log->error($err->getMessage());

            }

        } else
            return $this->log->error('Erro de conexao com o banco de dados');

        return $this->log->error('Erro desconhecido');

    }


    public function updateNota(Nota $notas)
    {

        $queryUpdate = 'update notas set nota_1 = :n1, nota_2 = :n2, nota_3 = :n3, nota_4 = :n4 where curso_id_curso = :curso and aluno_id_aluno = :aluno';

        $this->connect();

        if ($this->pdo != false && $this->pdo != null) {

            try {

                //tratar notas vazias --- o construct seria a melhor opcao
                $notas->setNota1($notas->getNota1() != null && $notas->getNota1() != '' ? $notas->getNota1() : 0);
                $notas->setNota2($notas->getNota2() != null && $notas->getNota2() != '' ? $notas->getNota2() : 0);
                $notas->setNota3($notas->getNota3() != null && $notas->getNota3() != '' ? $notas->getNota3() : 0);
                $notas->setNota4($notas->getNota4() != null && $notas->getNota4() != '' ? $notas->getNota4() : 0);


                $stmt = $this->pdo->prepare($queryUpdate);
                $stmt->bindValue(':n1', $notas->getNota1());
                $stmt->bindValue(':n2', $notas->getNota2());
                $stmt->bindValue(':n3', $notas->getNota3());
                $stmt->bindValue(':n4', $notas->getNota4());
                $stmt->bindValue(':curso', $notas->getCursoIdCurso());
                $stmt->bindValue(':aluno', $notas->getAlunoIdAluno());

                if ($stmt->execute()) {
                    //fazer uma notificao para o aluno tambem
                    return $this->log->sucess('sucess', null);

                } else {

                    //falha sql
                    return $this->log->error('erro ao cadastrar');
                }


            } catch (Exception $err) {

                return $this->log->error($err->getMessage());

            }


        } else {

            return $this->log->error('erro de conexao');

        }

    }

    public function addNota(Nota $notas)
    {
        error_reporting(0);
        ini_set('display_errors', 0 );

        $data = $this->getnotas($notas->aluno_id_aluno, $notas->curso_id_curso);


        $query = 'insert into notas(nota_1, nota_2, nota_3, nota_4, aluno_id_aluno, curso_id_curso) values(:n1, :n2, :n3, :n4, :aluno, :curso)';


        if ($data['code'] == 200) {

            /*return $this->log->sucess('passou 200', null);
            die;
            */
            return $this->updateNota($notas);


        } else {


            $this->connect();
            if ($this->pdo != false && $this->pdo != null) {

                try {

                    //tratar notas vazias --- o construct seria a melhor opcao
                    $notas->setNota1($notas->getNota1() != null && $notas->getNota1() != '' ? $notas->getNota1() : 0);
                    $notas->setNota2($notas->getNota2() != null && $notas->getNota2() != '' ? $notas->getNota2() : 0);
                    $notas->setNota3($notas->getNota3() != null && $notas->getNota3() != '' ? $notas->getNota3() : 0);
                    $notas->setNota4($notas->getNota4() != null && $notas->getNota4() != '' ? $notas->getNota4() : 0);


                    $stmt = $this->pdo->prepare($query);
                    $stmt->bindValue(':n1', $notas->getNota1());
                    $stmt->bindValue(':n2', $notas->getNota2());
                    $stmt->bindValue(':n3', $notas->getNota3());
                    $stmt->bindValue(':n4', $notas->getNota4());
                    $stmt->bindValue(':curso', $notas->getCursoIdCurso());
                    $stmt->bindValue(':aluno', $notas->getAlunoIdAluno());

                    if ($stmt->execute()) {
                        //fazer uma notificao para o aluno tambem
                        return $this->log->sucess('sucess', null);

                    } else {

                        //falha sql
                        return $this->log->error('erro ao cadastrar');
                    }


                } catch (Exception $err) {

                    return $this->log->error($err->getMessage());

                }

            } else {

                //falha de conexao
                return $this->log->error($this->PDOExceptionMessage);

            }

        }


    }


    public function addAluno(Aluno $aluno)
    {


        $query = 'insert into aluno(nome, mae, cep, logradouro, bairro, cidade, numero, curso_id_curso) values( :nome, :mae, :cep, :logradouro, :bairro, :cidade, :numero, :curso)';


        $this->connect();
        if ($this->pdo != null && $this->pdo != false) {

            try {

                $stmt = $this->pdo->prepare($query);

                $stmt->bindValue(':nome', $aluno->getNome());
                $stmt->bindValue(':curso', $aluno->getCursoIdCurso());
                $stmt->bindValue(':bairro', $aluno->getBairro());
                $stmt->bindValue(':cep', $aluno->getCep());
                $stmt->bindValue(':cidade', $aluno->getCidade());
                $stmt->bindValue(':logradouro', $aluno->getLogradouro());
                $stmt->bindValue(':mae', $aluno->getMae());
                $stmt->bindValue(':numero', $aluno->getNumero());

                if ($stmt->execute()) {

                    return $this->log->sucess('sucess', null);

                }

            } catch (Exception $erro) {

                return $this->log->error($erro);

            }

        }

        return $this->log->error('erro na conexao com banco de dados');

    }

    public
    function getAlunos($curso_id)
    {

        $query = 'select * from aluno where curso_id_curso = :curso';

        $this->connect();


        if ($this->pdo != false && $this->pdo != null) {


            try {

                $stmt = $this->pdo->prepare($query);
                $stmt->bindValue(':curso', $curso_id);

                if ($stmt->execute()) {

                    if ($stmt->rowCount() > 0) {

                        $data = array();

                        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {

                            $data[] = $result;

                        }

                        return $this->log->sucess('sucess', $data);


                    } else {

                        return $this->log->noDada();
                    }

                }

            } catch (Exception $erro) {

                return $this->log->error($erro->getMessage());

            }


        }

        return $this->log->error("Erro de conexao com banco de dados");

    }


    public
    function professorLogin($email, $pass)
    {

        $query = 'select id_professor, nome from professor where email =:email and senha = :pass';

        $this->connect();

        if ($this->pdo != false and $this->pdo != null) {


            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':pass', $pass);

            if ($stmt->execute()) {

                if ($stmt->rowCount() === 1) {

                    $response = $stmt->fetch(PDO::FETCH_ASSOC);

                    return $this->log->sucess('sucess', $response);
                } else {

                    return $this->log->error('erro ao efetuar login');
                }

            } else {

                return $this->log->error("erro ao executar sql");
            }


        }

        return $this->log->error("erro ao conectar ao banco de dados");

    }


}
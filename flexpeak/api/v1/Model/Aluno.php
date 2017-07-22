<?php
/**
 * Created by Rudda Beltrao
 * Date: 21/07/2017
 * Time: 20:44
 * Lab312 developer android  & php backend
 * www.lab312-icetufam.com.br
 * beltrao.rudah@gmail.com
 */

namespace FlexPeak\Model;


class Aluno
{

    public $id_aluno, $nome, $mae, $cep, $logradouro, $bairro, $cidade, $numero, $curso_id_curso;

    
    /**
     * @return mixed
     */
    public function getIdAluno()
    {
        return $this->id_aluno;
    }

    /**
     * @param mixed $id_aluno
     */
    public function setIdAluno($id_aluno)
    {
        $this->id_aluno = $id_aluno;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getMae()
    {
        return $this->mae;
    }

    /**
     * @param mixed $mae
     */
    public function setMae($mae)
    {
        $this->mae = $mae;
    }

    /**
     * @return mixed
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @param mixed $cep
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    /**
     * @return mixed
     */
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    /**
     * @param mixed $logradouro
     */
    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;
    }

    /**
     * @return mixed
     */
    public function getBairro()
    {
        return $this->bairro;
    }

    /**
     * @param mixed $bairro
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    /**
     * @return mixed
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @param mixed $cidade
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getCursoIdCurso()
    {
        return $this->curso_id_curso;
    }

    /**
     * @param mixed $curso_id_curso
     */
    public function setCursoIdCurso($curso_id_curso)
    {
        $this->curso_id_curso = $curso_id_curso;
    }

    
    
}
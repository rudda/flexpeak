<?php
/**
 * Created by Rudda Beltrao
 * Date: 21/07/2017
 * Time: 17:08
 * Lab312 developer android  & php backend
 * www.lab312-icetufam.com.br
 * beltrao.rudah@gmail.com
 */

namespace FlexPeak\Model;


class Curso
{

    public $id_curso, $nome, $resumo, $professor_id_professor, $capa;

    /**
     * @return mixed
     */
    public function getCapa()
    {
        return $this->capa;
    }

    /**
     * @param mixed $capa
     */
    public function setCapa($capa)
    {
        $this->capa = $capa;
    }

    
    
    /**
     * @return mixed
     */
    public function getIdCurso()
    {
        return $this->id_curso;
    }

    /**
     * @param mixed $id_curso
     */
    public function setIdCurso($id_curso)
    {
        $this->id_curso = $id_curso;
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
    public function getResumo()
    {
        return $this->resumo;
    }

    /**
     * @param mixed $resumo
     */
    public function setResumo($resumo)
    {
        $this->resumo = $resumo;
    }

    /**
     * @return mixed
     */
    public function getProfessorIdProfessor()
    {
        return $this->professor_id_professor;
    }

    /**
     * @param mixed $professor_id_professor
     */
    public function setProfessorIdProfessor($professor_id_professor)
    {
        $this->professor_id_professor = $professor_id_professor;
    }
    
    


}
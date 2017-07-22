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


class Nota
{

    public $id_notas, $nota_1, $nota_2, $nota_3, $nota_4, $aluno_id_aluno, $curso_id_curso;

    /**
     * @return mixed
     */
    public function getIdNotas()
    {
        return $this->id_notas;
    }

    /**
     * @param mixed $id_notas
     */
    public function setIdNotas($id_notas)
    {
        $this->id_notas = $id_notas;
    }

    /**
     * @return mixed
     */
    public function getNota1()
    {
        return $this->nota_1;
    }

    /**
     * @param mixed $nota_1
     */
    public function setNota1($nota_1)
    {
        $this->nota_1 = $nota_1;
    }

    /**
     * @return mixed
     */
    public function getNota2()
    {
        return $this->nota_2;
    }

    /**
     * @param mixed $nota_2
     */
    public function setNota2($nota_2)
    {
        $this->nota_2 = $nota_2;
    }

    /**
     * @return mixed
     */
    public function getNota3()
    {
        return $this->nota_3;
    }

    /**
     * @param mixed $nota_3
     */
    public function setNota3($nota_3)
    {
        $this->nota_3 = $nota_3;
    }

    /**
     * @return mixed
     */
    public function getNota4()
    {
        return $this->nota_4;
    }

    /**
     * @param mixed $nota_4
     */
    public function setNota4($nota_4)
    {
        $this->nota_4 = $nota_4;
    }

    /**
     * @return mixed
     */
    public function getAlunoIdAluno()
    {
        return $this->aluno_id_aluno;
    }

    /**
     * @param mixed $aluno_id_aluno
     */
    public function setAlunoIdAluno($aluno_id_aluno)
    {
        $this->aluno_id_aluno = $aluno_id_aluno;
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
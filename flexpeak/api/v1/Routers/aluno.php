<?php
/**
 * Created by Rudda Beltrao
 * Date: 22/07/2017
 * Time: 03:18
 * Lab312 developer android  & php backend
 * www.lab312-icetufam.com.br
 * beltrao.rudah@gmail.com
 */

/*
 * CURSO_ID
 * */

use FlexPeak\App\PortalProfessor;
use FlexPeak\Model\Aluno;
use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/aluno', function(Request $request, Response $response, $agrs){

    $curso_id = $request->getParam('curso_id');
    $api = new \FlexPeak\App\PortalProfessor();
    $response->write($api->getAlunos($curso_id));

});

/*
 * curso_id
 * 
 * */
$app->post('/aluno', function(Request $request, Response $response, $agrs){

    
    $aluno = new Aluno();
    $aluno->setCursoIdCurso($request->getParam('curso_id'));
    $aluno->setNome($request->getParam('nome'));
    $aluno->setMae($request->getParam('mae'));
    $aluno->setCep($request->getParam('cep'));
    $aluno->setLogradouro($request->getParam('logradouro'));
    $aluno->setBairro($request->getParam('bairro'));
    $aluno->setNumero("0000");
    $aluno->setCidade($request->getParam('cidade'));

     
    $api = new PortalProfessor();
    $response->write($api->addAluno($aluno));



});
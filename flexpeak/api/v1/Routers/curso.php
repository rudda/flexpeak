<?php
/**
 * Created by Rudda Beltrao
 * Date: 21/07/2017
 * Time: 15:41
 * Lab312 developer android  & php backend
 * www.lab312-icetufam.com.br
 * beltrao.rudah@gmail.com
 */


use FlexPeak\App\PortalProfessor;
use FlexPeak\Model\Curso;
use FlexPeak\Utils\Log;
use Slim\Http\Request;
use Slim\Http\Response;


/**
 *  nome
 *  professor_id
 *  resumo
 *
 *  resposta de sucesso
 *  resposta de erro
 */

$app->post('/curso', function (Request $request, Response $response, $args){

    $log = new Log();
    try{

        if( isset($_FILES['foto']) ){

            $nameProfile = 'getProfile'.time().'.'.(explode('/',$_FILES['foto']['type'])[1]);

            $path= 'http://localhost/flexpeak/flexpeak/api/v1/src/img/';

            $workspace =__DIR__.'/../src/img/';

            if( move_uploaded_file($_FILES['foto']['tmp_name'],$workspace.$nameProfile)) {

                $curso = new Curso();
                $curso->setNome($request->getParam('nome'));
                $curso->setProfessorIdProfessor($request->getParam('professor_id'));
                $curso->setResumo($request->getParam('resumo'));
                $curso->setCapa($path.$nameProfile);
                $api  = new PortalProfessor();

                $response->write( $api->addCurso($curso) );

            }

        }

    }catch (Exception $erro){

        $log->error($erro->getMessage());
    }


});


/**
    professor_id
 * curso_id
 *
 */
$app->get('/curso', function(Request $request, Response $response, $args){

    try{

        $id = $request->getParam('professor_id');

        $api = new PortalProfessor();
        $response->write($api->getCursos($id, ''));

    }catch (Exception $err){
        $log = new Log();
        $response->write($log->error($err->getMessage()));
    }


});

$app->get('/curso/{id}', function(Request $request, Response $response, $args){

    try{

        $id = $request->getParam('professor_id');
        $curso = $args['id'];

        $api = new PortalProfessor();
        $response->write($api->getCursos($id, $curso));

    }catch (Exception $err){
        $log = new Log();
        $response->write($log->error($err->getMessage()));
    }


});


/**
curso_id
 *
 */
$app->get('/curso/notas/{id}', function(Request $request, Response $response, $args){


    $id = $request->getParam('curso_id');
    $aluno = $args['id'];
    
    $api = new PortalProfessor();
    $response->write($api->getnotas($aluno, $id));
    
    
});



/**

 * curso_id
 * nota_1
 * nota_2
 * nota_3
 * nota_4
 *
 */
$app->post('/curso/notas/{aluno}', function(Request $request, Response $response, $args){


    $notas = new \FlexPeak\Model\Nota();
    $notas->setCursoIdCurso($request->getParam('curso_id'));
    $notas->setAlunoIdAluno($args['aluno']);
    
    $notas->setNota1($request->getParam(':nota_1'));
    $notas->setNota2($request->getParam(':nota_2'));
    $notas->setNota3($request->getParam(':nota_3'));
    $notas->setNota4($request->getParam(':nota_4'));

    $api = new PortalProfessor();
    $response->write($api->addNota($notas) );


});



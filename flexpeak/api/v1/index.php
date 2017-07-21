<?php
/**
 * Created by PhpStorm.
 * User: BELTRAO
 * Date: 20/07/2017
 * Time: 10:28
 */

use FlexPeak\App\PortalProfessor;
use FlexPeak\Model\Curso;
use FlexPeak\Utils\Log;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require (__DIR__.'/../../vendor/autoload.php');


$app = new App();

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

            $workspace =__DIR__.'/src/img/';

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
 * 
 */
$app->get('/curso', function(Request $request, Response $response, $agrs){

    
    $id = $request->getParam('professor_id');
    
    $api = new PortalProfessor();
    $response->write($api->getCursos(1));
    
    
});


$app->run();
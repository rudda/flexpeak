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

include (__DIR__.'/Routers/curso.php');
include (__DIR__.'/Routers/professor.php');
include (__DIR__.'/Routers/aluno.php');
include (__DIR__.'/Routers/notas.php');


$app->run();
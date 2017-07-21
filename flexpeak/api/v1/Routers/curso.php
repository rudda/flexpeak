<?php
/**
 * Created by Rudda Beltrao
 * Date: 21/07/2017
 * Time: 15:41
 * Lab312 developer android  & php backend
 * www.lab312-icetufam.com.br
 * beltrao.rudah@gmail.com
 */


use FlexPeak\Utils\Log;
use Slim\Http\Request;
use Slim\Http\Response;

$app->post('/curso', function (Request $request, Response $response, $args){


    $log = new Log();
    $response->write($log->sucess("sucesso", null));


});
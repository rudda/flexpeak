<?php
/**
 * Created by Rudda Beltrao
 * Date: 22/07/2017
 * Time: 03:17
 * Lab312 developer android  & php backend
 * www.lab312-icetufam.com.br
 * beltrao.rudah@gmail.com
 */
use Slim\Http\Response;
use Slim\Http\Request;
use FlexPeak\Utils\Log;

/**

 * email
 * senha  
 */

$app->get('/professor', function(Request $request, Response $response, $agrs){
    
    $email = $request->getParam('email');
    $senha = $request->getParam('senha');
    $api = new \FlexPeak\App\PortalProfessor();

    $response->write($api->professorLogin($email, $senha));
    

});
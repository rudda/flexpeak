<?php
/**
 * Created by Rudda Beltrao
 * Date: 25/07/2017
 * Time: 19:50
 * Lab312 developer android  & php backend
 * www.lab312-icetufam.com.br
 * beltrao.rudah@gmail.com
 */


use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/reports', function(Request $request, Response $response, $agrs){

    $curso = $request->getParam('curso_id');
    $api = new \FlexPeak\App\PortalProfessor();
    
    try{

        $html = json_decode( $api->getReport($curso) );

        if($html->code == 200){

            $mpdf = new \mPDF();
            $mpdf->WriteHTML($html->data);
            $mpdf->Output('flexpeak-report-notas-'.time().'.pdf','D');


        }else{

            $log = new \FlexPeak\Utils\Log();
            $response->write($log->error("Sem dados para reportar"));

        }



    }catch (Exception $err){


        $log = new \FlexPeak\Utils\Log();
        $response->write($log->error($err->getMessage()));


    }





});
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
    
    
    $html = json_decode( $api->getReport($curso) );

    $mpdf = new \mPDF();
    $mpdf->WriteHTML($html->data);
    $mpdf->Output('flexpeak-report-notas-'.time().'.pdf','D');



});
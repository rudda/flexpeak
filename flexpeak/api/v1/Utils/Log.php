<?php
/**
 * Created by Rudda Beltrao
 * Date: 16/07/2017
 * Time: 03:50
 * Lab312 developer android  & php backend
 * www.lab312-icetufam.com.br
 * beltrao.rudah@gmail.com
 */

namespace FlexPeak\Utils;


class Log
{

    public function sucess($message, $data){

        $response = array("code"=>200, "message"=>$message, "data"=> $data );
        return json_encode($response);
        
    }

    public function error($message){

        $response = array("code"=>400, "message"=>$message);
        return json_encode($response);


    }

    public function noDada(){

        $response = array("code"=>401, "message"=>"nenhum registro");
        return json_encode($response);


    }

    public function internalError($message){

        $response = array("code"=>407, "message"=>$message);
        return json_encode($response);

    }

}
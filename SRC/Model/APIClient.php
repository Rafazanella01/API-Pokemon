<?php

class ApiClient
{

    public function get($endpoint)
    {

        $Urlbase = 'https://pokeapi.co/api/v2';
        $Url = "$Urlbase/$endpoint";


        $ch = curl_init($Url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            http_response_code(400);
            echo json_encode(['message' => 'Curl error: ' . curl_error($ch)]);
            exit;
        }

        curl_close($ch);


        $decodificado = json_decode($response, true);

        if(!$decodificado){
            http_response_code(404);
            echo json_encode(['message' => 'Data not found']);
            exit;
        }

        return $decodificado;
    }

    

}



?>


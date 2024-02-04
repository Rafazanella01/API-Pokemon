<?php

require_once __DIR__ . '/../Request/Request.php';
require_once __DIR__ . '/../Model/APIClient.php';



class Controlador
{
    private $ApiClient;

    public function __construct(ApiClient $ApiClient)
    {
        $this->ApiClient = $ApiClient;
    }

    public function Desafio2(Request $request)
    {
        $message = 'Read from file.';

       
        if (!file_exists('all.txt')) {
           
            $limit = 150;

           
            $message = 'Fetched from API.';

            
            $response = $this->ApiClient->get("pokemon?limit=$limit");

           
            $data = array_map(function ($data) {
                return $data["name"];
            }, $response['results']);

           
            file_put_contents('all.txt', json_encode($data));
        }

        
        $PegarArquivo = file_get_contents('all.txt');

        
        $todos = json_decode($PegarArquivo, true, JSON_PRETTY_PRINT);

        $page = (int)$_GET['page'] ?? 1;

       
        $resultsPerPage = 15;

      
        if ($page < 1) {
            $page = 1;
        }

        
        if ($page * $resultsPerPage > count($todos)) {
           
            $page = ceil(count($todos) / $resultsPerPage);
        }

       
        $retorno = array_slice($todos, ($page - 1) * $resultsPerPage, $resultsPerPage);

        
        
        
        echo "<pre>";
        echo json_encode([
            'message' => $message,
            'page' => $page,
            'data' => $retorno,
        ], JSON_PRETTY_PRINT);
        echo "</pre>";
        
        exit;
    }

    public function Desafio3(Request $request)
    {
        $message = 'Read from file.';

      
        $searched = $request->getUri(1);

       
        if (!file_exists("$searched.txt")) {
           
            $message = 'Fetched from API.';

          
            $response = $this->ApiClient->get("pokemon/$searched");

           
            $formatted = [
                'name' => $response['name'],
                'stats' => []
            ];

           
            foreach ($response['stats'] as $stat) {
                $formatted['stats'][$stat['stat']['name']] = $stat['base_stat'];
            }

          
            file_put_contents("$searched.txt", json_encode($formatted, JSON_PRETTY_PRINT));
        }

       
        $fileContent = file_get_contents("$searched.txt");

        
        
        echo "<pre>";
        echo json_encode([
            'message' => $message,
            'pokemon' => json_decode($fileContent),
        ], JSON_PRETTY_PRINT);
        echo "</pre>";

        exit;
    }
}

?>

<?php 
$ChatGPT_API_Key = '${{ secrets.OPENAI_API_KEY }}'; // Remplacez par votre clé API OpenAI

function call_API_POST_ChatGPT($json_body, $ChatGPT_API_Key){
    $curl = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
      'Authorization: bearer '. $ChatGPT_API_Key,
      'Content-Type: application/json',
      'Content-Length: ' . strlen($json_body)
    ]);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json_body);
    $api_response = curl_exec($curl);
    curl_close($curl);
    return $api_response;
}


$prompt = "Propose-moi une liste de 5 films";

$body = [
    'model' => 'gpt-4',
    'messages' => [
        ['role' => 'system', 'content' => "Tu es un assistant strictement factuel qui donne toujours les mêmes réponses."],
        ['role' => 'user', 'content' => $prompt]
    ]
];
$json_body = json_encode($body);
$api_response = call_API_POST_ChatGPT($json_body, $ChatGPT_API_Key);
echo "API response : ".$api_response;

$json_response = json_decode($api_response);

$response =  $json_response->choices[0]->message->content;

echo $response;

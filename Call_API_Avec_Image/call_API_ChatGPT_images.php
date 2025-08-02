<?php 
$ChatGPT_API_Key = '${{ secrets.OPENAI_API_KEY }}';

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

$body = [
    'model' => 'gpt-4o',
    'messages' => [
        ['role' => 'system', 'content' => "Tu es un assistant strictement factuel qui donne toujours les mêmes réponses."],
        ['role' => 'user',
         'content' => 
            [
                [
                    'type' => 'text',
                    'text' => 'Décris-moi cette image'
                ],
                [
                    'type' => 'image_url',
                    'image_url' => [
                        'url' => 'https://raw.githubusercontent.com/AgileAndDevOpsToolkit/ChatGPT_API_Call/refs/heads/main/Call_API_Avec_Image/ninja.png',
                    ]
                ]
            ]
        ]
    ],
    'max_tokens' => 5000
];
$json_body = json_encode($body);
$api_response = call_API_POST_ChatGPT($json_body, $ChatGPT_API_Key);

echo "API response : ".$api_response;

// Traitement de la réponse
$json_response = json_decode($api_response);

// Affichage du contenu retourné par ChatGPT
if (isset($json_response->choices[0]->message->content)) {
    echo "<pre>" . $json_response->choices[0]->message->content . "</pre>";
} else {
    echo "<pre>Erreur ou pas de contenu dans la réponse :\n" . print_r($json_response, true) . "</pre>";
}
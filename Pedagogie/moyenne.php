<?php
// URL de l'API calculatrice
$apiBaseUrl = 'http://localhost/calculator/index.php';

// Tableau d'entiers à traiter
$numbers = [15, 12, 8, 20, 16];

// Fonction pour appeler l'API avec des paramètres en GET
function callCalculatorApi($operation, $a, $b, $apiBaseUrl) {
    // Construire l'URL avec les paramètres a et b
    $url = $apiBaseUrl . '/' . $operation . '?a=' . urlencode($a) . '&b=' . urlencode($b);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Ignorer les erreurs SSL pour test/démo
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    if($response === false){
        die('Erreur CURL : ' . curl_error($ch));
    }
    curl_close($ch);

    $data = json_decode($response, true);

    if(isset($data['result'])){
        return $data['result'];
    } else {
        die('Erreur API : ' . json_encode($data));
    }
}

// Calcul de la somme via l'API (enchainement des additions)
$sum = 0;
foreach ($numbers as $number) {
    $sum = callCalculatorApi('addition', $sum, $number, $apiBaseUrl);
}

// Calcul de la moyenne via l'API (division)
$count = count($numbers);
$moyenne = callCalculatorApi('division', $sum, $count, $apiBaseUrl);

// Affichage
echo "Tableau : " . implode(", ", $numbers) . "<br>";
echo "Somme via API : $sum<br>";
echo "Moyenne via API : $moyenne<br>";

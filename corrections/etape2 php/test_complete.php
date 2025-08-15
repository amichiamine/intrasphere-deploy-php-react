<?php
// test_complete.php - Tests complets pour cPanel
echo "<h2>🧪 TEST COMPLET INTRASPHERE</h2>";
echo "<hr>";

function test_url($url, $name) {
    $context = stream_context_create([
        "http" => [
            "timeout" => 10,
            "user_agent" => "IntraSphere Test Script"
        ]
    ]);

    $headers = @get_headers($url, 1, $context);
    $status = $headers ? $headers[0] : false;

    if ($status && (strpos($status, '200') !== false || strpos($status, '301') !== false || strpos($status, '302') !== false)) {
        echo "✅ $name : OK ($status)<br>";
        return true;
    } else {
        echo "❌ $name : PROBLÈME ($status)<br>";
        return false;
    }
}

echo "<h3>Tests d'accès:</h3>";
$tests = [
    'https://stacgate.com/intrasphere/' => 'Frontend',
    'https://stacgate.com/intrasphere/api/health' => 'Backend API',
    'https://stacgate.com/intrasphere/assets/index-CAmCCyH9.css' => 'CSS Assets',
    'https://stacgate.com/intrasphere/assets/index-DP1xPCxU.js' => 'JS Assets'
];

$all_ok = true;
foreach ($tests as $url => $name) {
    $result = test_url($url, $name);
    if (!$result) $all_ok = false;
}

echo "<h3>🎯 RÉSUMÉ:</h3>";
if ($all_ok) {
    echo "<strong style='color:green;'>🟢 Tous les tests PASSENT - Application doit fonctionner</strong><br>";
    echo "Si interface reste basique, problème de build React<br>";
} else {
    echo "<strong style='color:red;'>🔴 Certains tests ÉCHOUENT - Vérifier configuration</strong><br>";
}

echo "<hr>";
echo "<strong>🔍 Pour diagnostic: </strong><a href='diagnostic_frontend.php'>diagnostic_frontend.php</a><br>";
echo "<strong>🛠️ Pour correction: </strong><a href='fix_react_frontend.php'>fix_react_frontend.php</a><br>";
?>
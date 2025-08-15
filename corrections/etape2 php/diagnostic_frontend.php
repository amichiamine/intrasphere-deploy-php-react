<?php
// diagnostic_frontend.php - Version PHP pour cPanel
echo "<h2>🔍 DIAGNOSTIC FRONTEND REACT INTRASPHERE</h2>";
echo "<hr>";

$base_path = "/home/zzdwczcx/public_html/intrasphere/";
// Remplacez "username" par votre nom d'utilisateur cPanel

echo "<h3>📄 ANALYSE INDEX.HTML RACINE</h3>";
$index_file = $base_path . "index.html";

if (file_exists($index_file)) {
    echo "✅ index.html existe<br>";
    $content = file_get_contents($index_file);
    echo "<strong>Contenu index.html:</strong><br>";
    echo "<pre style='background:#f5f5f5;padding:10px;'>" . htmlspecialchars($content) . "</pre>";

    // Vérifier éléments React
    if (strpos($content, 'id="root"') !== false || strpos($content, "id='root'") !== false) {
        echo "✅ Div#root trouvée<br>";
    } else {
        echo "❌ Div#root MANQUANTE - PROBLÈME CRITIQUE<br>";
    }

    if (strpos($content, '.js') !== false) {
        echo "✅ Scripts JS référencés<br>";
    } else {
        echo "❌ Scripts JS MANQUANTS<br>";
    }

    if (strpos($content, '.css') !== false) {
        echo "✅ CSS référencé<br>";
    } else {
        echo "❌ CSS MANQUANT<br>";
    }
} else {
    echo "❌ index.html MANQUANT - Copier depuis intrasphere-frontend/<br>";
}

echo "<h3>📁 ANALYSE ASSETS</h3>";
$assets_path = $base_path . "intrasphere-frontend/assets/";
if (is_dir($assets_path)) {
    echo "✅ Dossier assets existe<br>";
    $files = scandir($assets_path);
    echo "<strong>Fichiers dans assets:</strong><br>";
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            echo "- " . $file . "<br>";
        }
    }
} else {
    echo "❌ Dossier assets manquant<br>";
}

echo "<h3>🔧 RECOMMANDATIONS</h3>";
if (!file_exists($index_file) || strpos(file_get_contents($index_file), 'id="root"') === false) {
    echo "<strong style='color:red;'>🔴 CRITIQUE: Corriger index.html</strong><br>";
}
if (!is_dir($assets_path)) {
    echo "<strong style='color:red;'>🔴 CRITIQUE: Assets manquants</strong><br>";
}
echo "<strong style='color:blue;'>🔵 INFO: Utiliser fix_react_frontend.php pour correction automatique</strong><br>";
?>
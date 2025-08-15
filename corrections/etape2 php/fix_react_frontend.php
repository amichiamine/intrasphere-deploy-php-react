<?php
// fix_react_frontend.php - Correction automatique pour cPanel
echo "<h2>🔧 CORRECTION FRONTEND REACT INTRASPHERE</h2>";
echo "<hr>";

$base_path = "/home/zzdwczcx/public_html/intrasphere/";
// ⚠️ IMPORTANT: Remplacez "username" par votre nom d'utilisateur cPanel

// Backup de l'ancien index.html
$index_file = $base_path . "index.html";
if (file_exists($index_file)) {
    $backup_name = "index-backup-" . date('Ymd-His') . ".html";
    if (copy($index_file, $base_path . $backup_name)) {
        echo "💾 Sauvegarde créée: " . $backup_name . "<br>";
    }
}

// Créer le nouvel index.html avec React
$new_index_content = '<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>IntraSphere - Portail d Entreprise " </title>
    <meta name="description" content="IntraSphere - Votre portail dentreprise moderne">
    <link rel="stylesheet" href="./assets/index-CAmCCyH9.css">
    <style>
        .loading-container {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 50%, #e0e7ff 100%);
            display: flex; align-items: center; justify-content: center; flex-direction: column;
        }
        .loading-card {
            background: hsla(0, 0%, 100%, .8); backdrop-filter: blur(12px);
            border: 1px solid hsla(0, 0%, 100%, .2); border-radius: 1rem;
            padding: 3rem; text-align: center;
            box-shadow: 0 8px 32px rgba(139, 92, 246, 0.1);
        }
        .loading-title {
            font-size: 2rem; font-weight: 700; margin-bottom: 1rem;
            background: linear-gradient(135deg, #8B5CF6, #A78BFA);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .loading-spinner {
            width: 40px; height: 40px; margin: 20px auto;
            border: 3px solid rgba(139, 92, 246, 0.1);
            border-top: 3px solid #8B5CF6; border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div id="root"></div>
    <div class="loading-container">
        <div class="loading-card">
            <h1 class="loading-title">IntraSphere</h1>
            <p style="color: #6B7280; margin-bottom: 1rem;">Chargement de votre portail...</p>
            <div class="loading-spinner"></div>
        </div>
    </div>
    <script src="./assets/index-DP1xPCxU.js"></script>
</body>
</html>';

// Écrire le fichier
if (file_put_contents($index_file, $new_index_content)) {
    echo "✅ index.html React créé avec succès<br>";
} else {
    echo "❌ Erreur lors de la création de index.html<br>";
}

// Vérifier les assets
$css_file = $base_path . "intrasphere-frontend/assets/index-CAmCCyH9.css";
$js_file = $base_path . "intrasphere-frontend/assets/index-DP1xPCxU.js";

echo "<h3>🔍 Vérification des assets</h3>";
echo file_exists($css_file) ? "✅ CSS trouvé<br>" : "❌ CSS manquant<br>";
echo file_exists($js_file) ? "✅ JS trouvé<br>" : "❌ JS manquant<br>";

// Définir les permissions
chmod($index_file, 0644);

echo "<h3>🧪 TESTS À EFFECTUER</h3>";
echo "<a href='https://stacgate.com/intrasphere/' target='_blank'>1. Tester Frontend</a><br>";
echo "<a href='https://stacgate.com/intrasphere/assets/index-CAmCCyH9.css' target='_blank'>2. Tester CSS</a><br>";
echo "<a href='https://stacgate.com/intrasphere/assets/index-DP1xPCxU.js' target='_blank'>3. Tester JS</a><br>";

echo "<hr><strong>✅ Correction terminée!</strong><br>";
?>
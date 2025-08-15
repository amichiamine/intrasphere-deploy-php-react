#!/bin/bash
# Script de correction frontend React - fix_react_frontend.sh

echo "🔧 CORRECTION FRONTEND REACT INTRASPHERE"
echo "======================================="

cd /public_html/intrasphere/

# Backup de l'ancien index.html s'il existe
if [ -f "index.html" ]; then
    echo "💾 Sauvegarde de l'ancien index.html..."
    cp index.html index-backup-$(date +%Y%m%d-%H%M%S).html
fi

# Créer un index.html React fonctionnel
echo "🛠️  Création d'un index.html React correct..."
cat > index.html << 'EOF'
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>IntraSphere - Portail d'Entreprise</title>
    <meta name="description" content="IntraSphere - Votre portail d'entreprise moderne pour une communication fluide et une collaboration efficace">
    <link rel="stylesheet" href="./assets/index-CAmCCyH9.css">
</head>
<body>
    <div id="root">
        <div style="display: flex; align-items: center; justify-content: center; min-height: 100vh; flex-direction: column;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h1 style="font-size: 2rem; margin-bottom: 1rem; color: #8B5CF6;">IntraSphere</h1>
                <p style="color: #6B7280;">Chargement de votre portail d'entreprise...</p>
            </div>
            <div style="width: 40px; height: 40px; border: 4px solid #E5E7EB; border-top: 4px solid #8B5CF6; border-radius: 50%; animation: spin 1s linear infinite;"></div>
        </div>
    </div>
    <script src="./assets/index-DP1xPCxU.js"></script>
    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</body>
</html>
EOF

echo "✅ index.html React créé avec succès"

# Vérifier les assets
echo ""
echo "🔍 Vérification des assets..."
if [ -f "intrasphere-frontend/assets/index-CAmCCyH9.css" ]; then
    echo "✅ CSS trouvé"
else
    echo "❌ CSS manquant dans intrasphere-frontend/assets/"
fi

if [ -f "intrasphere-frontend/assets/index-DP1xPCxU.js" ]; then
    echo "✅ JS trouvé"
else
    echo "❌ JS manquant dans intrasphere-frontend/assets/"
fi

# Vérifier les permissions
echo ""
echo "🔧 Correction des permissions..."
chmod 644 index.html
find intrasphere-frontend/assets/ -type f -exec chmod 644 {} \; 2>/dev/null || echo "⚠️ Impossible de modifier les permissions des assets"

echo ""
echo "🧪 TESTS À EFFECTUER:"
echo "===================="
echo "1. Frontend: https://stacgate.com/intrasphere/"
echo "2. CSS: https://stacgate.com/intrasphere/assets/index-CAmCCyH9.css"
echo "3. JS: https://stacgate.com/intrasphere/assets/index-DP1xPCxU.js"

echo ""
echo "✅ Correction terminée!"
echo "Si le problème persiste, vérifiez que l'application React est buildée correctement."

#!/bin/bash
# Script de diagnostic automatisé - diagnose.sh

echo "🔍 DIAGNOSTIC AUTOMATISÉ INTRASPHERE"
echo "===================================="

cd /public_html/intrasphere/

echo ""
echo "📂 STRUCTURE DES FICHIERS:"
echo "=========================="
echo "Fichier index.html racine:"
if [ -f "index.html" ]; then
    echo "✅ index.html présent"
else
    echo "❌ index.html MANQUANT - Cause de l'erreur 403"
fi

echo ""
echo "Dossier intrasphere-frontend:"
if [ -d "intrasphere-frontend" ]; then
    echo "✅ intrasphere-frontend présent"
    ls -la intrasphere-frontend/
else
    echo "❌ intrasphere-frontend MANQUANT"
fi

echo ""
echo "Dossier intrasphere-backend:"
if [ -d "intrasphere-backend" ]; then
    echo "✅ intrasphere-backend présent"
    ls -la intrasphere-backend/api/Config/
else
    echo "❌ intrasphere-backend MANQUANT"
fi

echo ""
echo "🔧 ROUTERS DISPONIBLES:"
echo "======================"
if [ -f "intrasphere-backend/api/Config/Router.php" ]; then
    echo "📄 Router.php présent"
    # Vérifier s'il contient du debug
    if grep -q "echo.*DEBUG" "intrasphere-backend/api/Config/Router.php"; then
        echo "⚠️  Router.php contient du DEBUG - PROBLÉMATIQUE"
    else
        echo "✅ Router.php sans debug"
    fi
fi

if [ -f "intrasphere-backend/api/Config/2Router.php" ]; then
    echo "📄 2Router.php présent"
    if grep -q "echo.*DEBUG" "intrasphere-backend/api/Config/2Router.php"; then
        echo "⚠️  2Router.php contient du DEBUG"
    else
        echo "✅ 2Router.php sans debug - RECOMMANDÉ"
    fi
fi

echo ""
echo "🌐 TEST AUTOMATIQUE DES URLS:"
echo "============================="

# Test API (si curl disponible)
if command -v curl &> /dev/null; then
    echo "🧪 Test API health..."
    response=$(curl -s "https://stacgate.com/intrasphere/api/health")
    if echo "$response" | grep -q '"success":true'; then
        echo "✅ API fonctionne"
    else
        echo "❌ API ne fonctionne pas"
        echo "Réponse: $response"
    fi
else
    echo "ℹ️  curl non disponible - test manuel requis"
fi

echo ""
echo "📋 RECOMMANDATIONS:"
echo "=================="
if [ ! -f "index.html" ]; then
    echo "🔴 CRITIQUE: Exécuter fix_frontend.sh"
fi

if [ -f "intrasphere-backend/api/Config/Router.php" ] && grep -q "echo.*DEBUG" "intrasphere-backend/api/Config/Router.php"; then
    echo "🔴 CRITIQUE: Exécuter fix_router.sh"
fi

if [ -f "index.html" ] && [ -f "intrasphere-backend/api/Config/2Router.php" ]; then
    echo "✅ Structure semble correcte - tester les URLs"
fi

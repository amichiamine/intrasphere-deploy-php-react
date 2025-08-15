#!/bin/bash
# Script de diagnostic frontend React - diagnose_frontend.sh

echo "🔍 DIAGNOSTIC FRONTEND REACT INTRASPHERE"
echo "========================================"

cd /public_html/intrasphere/

echo ""
echo "📄 ANALYSE INDEX.HTML RACINE:"
echo "=============================="
if [ -f "index.html" ]; then
    echo "✅ index.html existe"
    echo ""
    echo "Contenu index.html:"
    echo "-------------------"
    cat index.html
    echo ""
    echo "🔍 Recherche éléments React:"
    if grep -q "id.*root" index.html; then
        echo "✅ Div#root trouvée"
    else
        echo "❌ Div#root MANQUANTE - PROBLÈME CRITIQUE"
    fi

    if grep -q "\.js" index.html; then
        echo "✅ Scripts JS référencés"
    else
        echo "❌ Scripts JS MANQUANTS"
    fi

    if grep -q "\.css" index.html; then
        echo "✅ CSS référencé"
    else
        echo "❌ CSS MANQUANT"
    fi
else
    echo "❌ index.html MANQUANT - Copier depuis intrasphere-frontend/"
fi

echo ""
echo "📁 ANALYSE ASSETS:"
echo "=================="
echo "Assets dans intrasphere-frontend/assets/:"
ls -la intrasphere-frontend/assets/ 2>/dev/null || echo "❌ Dossier assets manquant"

echo ""
echo "🌐 TEST ACCÈS ASSETS:"
echo "===================="
if command -v curl &> /dev/null; then
    echo "Test CSS:"
    css_status=$(curl -s -o /dev/null -w "%{http_code}" "https://stacgate.com/intrasphere/assets/index-CAmCCyH9.css")
    if [ "$css_status" = "200" ]; then
        echo "✅ CSS accessible (HTTP $css_status)"
    else
        echo "❌ CSS inaccessible (HTTP $css_status)"
    fi

    echo "Test JS:"
    js_status=$(curl -s -o /dev/null -w "%{http_code}" "https://stacgate.com/intrasphere/assets/index-DP1xPCxU.js")
    if [ "$js_status" = "200" ]; then
        echo "✅ JS accessible (HTTP $js_status)"
    else
        echo "❌ JS inaccessible (HTTP $js_status)"
    fi
else
    echo "ℹ️  curl non disponible - test manuel requis"
fi

echo ""
echo "🔧 RECOMMANDATIONS:"
echo "=================="
if [ ! -f "index.html" ] || ! grep -q "id.*root" index.html; then
    echo "🔴 CRITIQUE: Corriger index.html"
fi
if [ ! -d "intrasphere-frontend/assets" ]; then
    echo "🔴 CRITIQUE: Assets manquants"
fi
echo "🔵 INFO: Utiliser fix_react_frontend.sh pour correction automatique"

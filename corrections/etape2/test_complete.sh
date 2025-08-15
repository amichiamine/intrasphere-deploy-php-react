#!/bin/bash
# Script de test complet - test_complete.sh

echo "🧪 TEST COMPLET INTRASPHERE"
echo "=========================="

# Tests de base
echo "1️⃣ Test Backend API..."
if command -v curl &> /dev/null; then
    api_response=$(curl -s "https://stacgate.com/intrasphere/api/health")
    if echo "$api_response" | grep -q '"success":true'; then
        echo "✅ Backend API fonctionne"
    else
        echo "❌ Backend API problème: $api_response"
    fi
else
    echo "ℹ️ curl non disponible"
fi

echo ""
echo "2️⃣ Test Frontend..."
frontend_response=$(curl -s -o /dev/null -w "%{http_code}" "https://stacgate.com/intrasphere/")
if [ "$frontend_response" = "200" ]; then
    echo "✅ Frontend accessible (HTTP 200)"
else
    echo "❌ Frontend problème (HTTP $frontend_response)"
fi

echo ""
echo "3️⃣ Test Assets CSS..."
css_response=$(curl -s -o /dev/null -w "%{http_code}" "https://stacgate.com/intrasphere/assets/index-CAmCCyH9.css")
if [ "$css_response" = "200" ]; then
    echo "✅ CSS accessible (HTTP 200)"
else
    echo "❌ CSS problème (HTTP $css_response)"
fi

echo ""
echo "4️⃣ Test Assets JS..."
js_response=$(curl -s -o /dev/null -w "%{http_code}" "https://stacgate.com/intrasphere/assets/index-DP1xPCxU.js")
if [ "$js_response" = "200" ]; then
    echo "✅ JS accessible (HTTP 200)"
else
    echo "❌ JS problème (HTTP $js_response)"
fi

echo ""
echo "🎯 RÉSUMÉ:"
echo "========="
if [ "$api_response" ] && echo "$api_response" | grep -q '"success":true' && 
   [ "$frontend_response" = "200" ] && 
   [ "$css_response" = "200" ] && 
   [ "$js_response" = "200" ]; then
    echo "🟢 Tous les tests PASSENT - Application doit fonctionner"
    echo "Si interface reste basique, problème de build React"
else
    echo "🔴 Certains tests ÉCHOUENT - Vérifier configuration"
fi

echo ""
echo "🔍 Pour diagnostic détaillé: bash diagnose_frontend.sh"
echo "🛠️ Pour correction: bash fix_react_frontend.sh"

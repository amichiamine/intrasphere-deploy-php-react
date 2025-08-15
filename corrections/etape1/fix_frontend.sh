#!/bin/bash
# Script de correction du problème frontend - fix_frontend.sh

echo "🔧 CORRECTION DU PROBLÈME FRONTEND"
echo "=================================="

cd /public_html/intrasphere/

# Copier index.html manquant
if [ -f "intrasphere-frontend/index.html" ]; then
    echo "📁 Copie de index.html vers la racine..."
    cp intrasphere-frontend/index.html .
    echo "✅ index.html copié vers /intrasphere/"
else
    echo "❌ ERREUR: intrasphere-frontend/index.html non trouvé!"
    exit 1
fi

# Vérifier la structure
echo ""
echo "📋 VÉRIFICATION DE LA STRUCTURE:"
ls -la index.html
ls -la intrasphere-frontend/assets/

echo ""
echo "🧪 TESTS À EFFECTUER:"
echo "1. Frontend: https://stacgate.com/intrasphere/"
echo "2. API: https://stacgate.com/intrasphere/api/health"
echo "3. Assets: https://stacgate.com/intrasphere/assets/index-CAmCCyH9.css"
echo ""
echo "✅ Correction du frontend terminée!"

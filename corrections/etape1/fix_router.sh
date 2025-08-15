#!/bin/bash
# Script de correction du problème router - fix_router.sh

echo "🔧 CORRECTION DU PROBLÈME ROUTER"
echo "================================="

cd /public_html/intrasphere/intrasphere-backend/api/Config/

# Sauvegarder le router cassé
if [ -f "Router.php" ]; then
    echo "📁 Sauvegarde de Router.php cassé..."
    mv Router.php Router-broken-backup.php
    echo "✅ Router.php renommé en Router-broken-backup.php"
fi

# Activer le bon router
if [ -f "2Router.php" ]; then
    echo "🔄 Activation de 2Router.php..."
    cp 2Router.php Router.php
    echo "✅ 2Router.php copié vers Router.php"
else
    echo "❌ ERREUR: 2Router.php non trouvé!"
    exit 1
fi

echo ""
echo "🧪 TEST DE L'API:"
echo "Testez: https://stacgate.com/intrasphere/api/health"
echo "Résultat attendu: JSON sans messages DEBUG"
echo ""
echo "✅ Correction du router terminée!"

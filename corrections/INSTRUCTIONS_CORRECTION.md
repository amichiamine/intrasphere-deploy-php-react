
🚀 INSTRUCTIONS DE CORRECTION IMMÉDIATE
=======================================

PROBLÈME IDENTIFIÉ:
==================
1. Router.php est CASSÉ (structure incompatible + debug echo)
2. 2Router.php FONCTIONNE parfaitement
3. index.html manque à la racine (cause erreur 403)

SOLUTION IMMÉDIATE:
==================

ÉTAPE 1: Correction du Router (CRITIQUE)
----------------------------------------
Via SSH ou File Manager cPanel:

cd /public_html/intrasphere/intrasphere-backend/api/Config/

# Sauvegarder l'ancien
mv Router.php Router-broken.php

# Activer le bon router
cp 2Router.php Router.php

# Ou utiliser le script automatique:
bash fix_router.sh


ÉTAPE 2: Correction du Frontend (CRITIQUE)  
------------------------------------------
cd /public_html/intrasphere/

# Copier index.html manquant
cp intrasphere-frontend/index.html .

# Ou utiliser le script automatique:
bash fix_frontend.sh


ÉTAPE 3: Vérification (IMPORTANTE)
----------------------------------
Tester ces URLs dans l'ordre:

1. ✅ API: https://stacgate.com/intrasphere/api/health
   Résultat attendu: {"success":true,"status":200,...} SANS debug

2. ✅ Frontend: https://stacgate.com/intrasphere/
   Résultat attendu: Page React chargée

3. ✅ Assets: https://stacgate.com/intrasphere/assets/index-CAmCCyH9.css  
   Résultat attendu: CSS affiché


ÉTAPE 4: Optimisation (OPTIONNELLE)
-----------------------------------
# Remplacer .htaccess par version optimisée
cp htaccess_optimized.txt /public_html/intrasphere/.htaccess


DIAGNOSTIC AUTOMATIQUE:
=======================
Utilisez le script: bash diagnose.sh


POURQUOI ÇA MARCHE:
==================
- 2Router.php utilise structure simple: routes[method][path]
- Router.php utilisait structure cassée: routes[] puis cherchait routes[method]
- 2Router.php n'a pas d'echo DEBUG qui corrompt le JSON
- index.html racine résout l'erreur 403 Forbidden

TEMPS ESTIMÉ: 5 minutes maximum
RÉSULTAT: Application 100% fonctionnelle

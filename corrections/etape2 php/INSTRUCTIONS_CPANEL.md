
# CORRECTION INTRASPHERE POUR CPANEL
=====================================

PROBLÈME: Les scripts .sh ne s'exécutent pas dans cPanel Terminal
SOLUTION: Utiliser les versions PHP créées spécialement pour cPanel

## ÉTAPES POUR CPANEL:

### 1. UPLOAD DES FICHIERS PHP
------------------------------
Via File Manager cPanel, uploadez ces fichiers dans /public_html/intrasphere/:
- diagnostic_frontend.php
- fix_react_frontend.php  
- test_complete.php

### 2. MODIFICATION IMPORTANTE
------------------------------
⚠️ AVANT D'UTILISER: Éditez chaque fichier PHP et remplacez:
   /home/username/public_html/intrasphere/
par:
   /home/VOTRE-UTILISATEUR-CPANEL/public_html/intrasphere/

Pour trouver votre nom d'utilisateur:
- cPanel → File Manager → regardez le chemin affiché
- Ou Terminal cPanel: tapez "pwd"

### 3. EXÉCUTION VIA NAVIGATEUR
-------------------------------
Au lieu du terminal, utilisez votre navigateur:

1. Diagnostic: https://stacgate.com/intrasphere/diagnostic_frontend.php
2. Correction: https://stacgate.com/intrasphere/fix_react_frontend.php
3. Tests: https://stacgate.com/intrasphere/test_complete.php

### 4. ALTERNATIVE MANUELLE SIMPLE
----------------------------------
Si même PHP ne fonctionne pas, correction 100% manuelle:

1. Via File Manager cPanel, ouvrez: /public_html/intrasphere/index.html

2. Remplacez TOUT le contenu par:
```html
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>IntraSphere</title>
    <link rel="stylesheet" href="./assets/index-CAmCCyH9.css">
</head>
<body>
    <div id="root">
        <div style="display:flex;align-items:center;justify-content:center;min-height:100vh;flex-direction:column;">
            <h1 style="color:#8B5CF6;margin-bottom:20px;">IntraSphere</h1>
            <p style="color:#6B7280;">Chargement...</p>
        </div>
    </div>
    <script src="./assets/index-DP1xPCxU.js"></script>
</body>
</html>
```

3. Sauvegardez

4. Testez: https://stacgate.com/intrasphere/

### 5. VÉRIFICATIONS POST-CORRECTION
------------------------------------
Après correction, vérifiez:
✅ https://stacgate.com/intrasphere/ → Interface React
✅ https://stacgate.com/intrasphere/api/health → JSON API  
✅ F12 Console navigateur → Pas d'erreurs JS

### 6. NETTOYAGE (OPTIONNEL)
----------------------------
Une fois l'application fonctionnelle, supprimez:
- diagnostic_frontend.php
- fix_react_frontend.php
- test_complete.php

## POURQUOI CETTE APPROCHE:
===========================
- cPanel bloque souvent l'exécution de scripts .sh
- PHP fonctionne toujours dans cPanel
- Alternative navigateur plus simple
- Correction manuelle en dernier recours

## RÉSULTAT ATTENDU:
===================
Interface moderne IntraSphere avec glassmorphism, thème violet/bleu, 
effects de transparence et navigation React fonctionnelle.

TEMPS ESTIMÉ: 5-10 minutes maximum

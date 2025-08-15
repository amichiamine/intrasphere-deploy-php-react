# Configuration IntraSphere

## 1. Base de données
Éditez intrasphere-backend/.env :
DB_HOST=localhost
DB_DATABASE=votre_base_intrasphere
DB_USERNAME=votre_username
DB_PASSWORD=votre_password
APP_URL=https://votre-domaine.com/intrasphere

## 2. Importation de la base
mysql -u username -p database_name < intrasphere-backend/database/schema.sql

## 3. Permissions
chmod 755 intrasphere-backend/public/uploads/ -R
chmod 700 intrasphere-backend/logs/ -R

## 4. Tests
- Frontend: https://votre-domaine.com/intrasphere/
- API: https://votre-domaine.com/intrasphere/api/health
- Uploads: https://votre-domaine.com/intrasphere/uploads/
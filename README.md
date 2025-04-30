MindMate
# Étapes d'installation et configuration

# 1. Accéder au dossier du repository
ls
cd <nom_du_dossier_du_repository>

# 2. Installer les dépendances PHP
composer install

# 3. Configurer le fichier .env
# Ouvrez le fichier .env et modifiez les paramètres de la base de données :
DATABASE_URL="mysql://utilisateur:mdp@127.0.0.1:3306/nomdelabdd?serverVersion=8.0.32&charset=utf8mb4"

# 4. Créer la base de données
symfony console doctrine:database:create

# 5. Effectuer les migrations
symfony console doctrine:migrations:migrate

# 6. Mettre à jour les changements de la base de données
symfony console d:s:u -f

# 7. Configurer la clé API
# Ouvrez le fichier .env et ajoutez la clé API obtenue auprès du TechLead Backend.
# Ajoutez ensuite le fichier .env à votre .gitignore pour éviter de partager des données sensibles.

# 8. Finaliser et Push
# Sauvegardez vos modifications, Fetch & Push vers le repository distant !
 

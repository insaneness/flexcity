# Flexcity

Backend technical test 

---

## 🛠 Pré-requis

Assurez-vous que votre environnement de développement dispose des éléments suivants :

* **PHP 8.3** ou supérieur
* **Composer**
* **Symfony CLI** (utile pour serveur http local -> https://symfony.com/download)
* **Docker & Docker Compose**

---

## ⚙️ Installation et Configuration

Suivez ces étapes pour cloner et lancer le projet localement :

### 1. Cloner le dépôt
```bash
cd votre-dossier-de-travail
git clone https://github.com/insaneness/flexcity.git
```
### 2. Installer les dépendances
```bash
composer install
```
### 3. Configurer l'environnement
Le fichier `.env` est pré configuré et contient les variables d'environnement nécessaires pour la connexion à la base de données (Docker).

### 4. Lancer le conteneur Docker
```bash
docker-compose up -d
```
### 5. Exécuter les migrations
```bash
php bin/console doctrine:migrations:migrate
```
### 6. Loader les fixtures
```bash
php bin/console doctrine:fixtures:load
```
### 7. Lancer le serveur de développement
```bash
symfony server:start
``` 

## 🚀 Utilisation
### Ajouter une activation (recevoir une requête TSO)
```bash
curl -X POST http://127.0.0.1:8000/activation \
-H "Content-Type: application/json" \
-d '{
      "volume": 150, 
      "date": "17-03-2026"
    }'
```

## 🚥 Tests
Pour éxécuter les tests lancer la commande suivante : 
```bash
php bin/phpunit
```

## Design decisions
- J'ai voulu mettre en place le Domain Driven Design (DDD) pour structurer le projet de manière claire et maintenable. Cela permet de séparer les différentes couches de l'application (Domain, Application, Infrastructure) et de favoriser la réutilisabilité du code.
- J'ai mis en place le début d'une petite API REST pour permettre l'ajout d'objets du modèle via des requêtes HTTP. Cela rend l'application plus flexible et facilement intégrable avec d'autres systèmes.
- J'ai utilisé Docker pour faciliter le déploiement et la gestion de la base de données. Cela permet à n'importe qui de cloner le projet et de le faire fonctionner rapidement.
- Concernant la partie optimisation de la recherche d'assets, j'ai implémenté la version demandée (Cost Effective) et j'ai aussi travaillé sur une version qui prend en compte la notion d'overpower.

# Nom du Projet
Une brève description du projet : qu'est-ce que c'est, à quoi ça sert, et pourquoi c'est utile.

## Table des Matières
- [Installation](#installation)
- [Utilisation](#utilisation)
- [Fonctionnalités](#fonctionnalités)
- [Contribuer](#contribuer)

## Installation

### Prérequis
Avant de commencer, assurez-vous d'avoir les outils suivants installés :
- **PHP** (>= 8.1)
- **Composer** (dernière version)
- **MySQL**
- **Git**

1. Clonez le dépôt du projet :
   ```bash
   git clone https://github.com/jeanmichel07/taram_test.git
   cd taram_test

2. Installez les dépendances PHP via Composer
    *composer install*

3. Configurez l'environnement
    Modifiez **.env** pour configurer la connexion à la base de données:
        **DATABASE_URL="mysql://utilisateur:motdepasse@127.0.0.1:3306/db_taram?serverVersion=8.0"**

4. Importez le fichier SQL
    Un fichier *db_taram.sql* est fourni dans le dossier *sql/* pour créer les tables et insérer les données initiales.

5. Lancez le serveur de développement
    *symfony server:start*
    **Accédez au projet sur http://localhost:8000**


## Utilisation
## Créer un nouvel achat

Pour ajouter un nouvel achat dans l’application, suivez ces étapes :

1. **Exporter la liste des produits** :
   - Accédez au menu **Produits** dans l’interface.
   - Cliquez sur l’option **Exporter en CSV** pour télécharger la liste des produits sous forme de fichier CSV.

   ![Exportation de la liste des produits](images/export-products-screenshot.png)

2. **Modifier le fichier CSV** :
   - Ouvrez le fichier CSV exporté dans un éditeur (ex. : Excel, LibreOffice Calc, ou un éditeur de texte).
   - Remplissez la colonne **Quantité** pour chaque produit souhaité.
   - Dans la colonne **UnitPrice**, remplacez les points (`.`) par des virgules (`,`), si nécessaire, pour respecter le format attendu.
   - Calculez et remplissez la colonne **TotalPrice** (par exemple, `TotalPrice = Quantité * UnitPrice`).
   - Enregistrez les modifications dans le fichier CSV.

3. **Importer le fichier pour un nouvel achat** :
   - Accédez au menu **Achats** dans l’interface.
   - Cliquez sur **Nouveau** pour ouvrir le formulaire de création d’un achat.
   - Sélectionnez le fichier CSV modifié en cliquant sur le champ d’importation.
   - Validez pour enregistrer le nouvel achat.

   ![Formulaire de nouvel achat](images/new-purchase-form-screenshot.png)

### Remarques
- Assurez-vous que le format du fichier CSV reste inchangé (ne modifiez pas les en-têtes ou la structure).
- Vérifiez que les valeurs dans **UnitPrice** et **TotalPrice** sont correctes pour éviter des erreurs lors de l’importation.
- Si des problèmes surviennent, consultez la section [Dépannage](#dépannage) ou contactez le support.
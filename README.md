# Projet de base pour Symfony 5 #

Symfony 5 propose deux versions à installer : soit une version très légère, convenant à la création d'API de type REST,
soit une version plus complète pour la création de sites Web. C'est cette deuxième version que nous allons utiliser.

On peut installer Symfony soit avec l'utilitaire `symfony` (installé sur les Linux de l'IUT) soit avec l'utilitaire de
gestion de paquets PHP `composer` (également installé à l'IUT).

Avec `symfony` : 

    symfony new --full BaseSymfony5

Avec `composer` :

    composer create-project symfony/website-skeleton BaseSymfony5

La différence est que `symfony` configure le projet pour `git` (avec un `git init`) et ajoute le serveur web de
développement (qu'on peut lancer avec `symfony server:start` et arrêter avec `symfony server:stop`).
On préférera donc en général utiliser l'application `symfony` pour créer de nouveaux projets.

La configuration de cette application Web classique contient :

- **Vues :** `twig-pack` (gestionnaire de templates), `asset` (fichiers css, js, img), `form` (formulaires) ;
- **Contrôleurs :** les annotations (notamment pour les routes), `security-bundle` (pour les utilisateurs et les
  droits d'accès), `form` ;
- **Modèles :** `orm-pack` (ORM : *Object Repository Manager*, pour l'accès à la base de données), `form`, `maker-bundle`
  (outils d'aide à la création de code) ;
- **Outils bien pratiques :** `profiler-pack` (outils de débogage), un serveur web intégré, pour le
  développement), `flex` (gestion simplifiée des paquets composer).

# Quelques ressources pour les vues #

Pour démarrer la création du design de votre application, vous trouverez dans `public` :

- `js` : répertoire contenant le code JavaScript pour jQuery-3.4.1 et Bootstrap-4.4.1 (la version `bundle` contient
  `popper`) ;
- `fonts` : les fontes Font Awesome ;
- `css` : feuilles de style de Bootstrap, Font Awesome ainsi que `main.css` copié de `gigondas` ;
- `img` : le bandeau de `gigondas` et l'icône de l'UGA.

Ces ressources sont importées dans le fichier `templates/base.html.twig`.

# Pour utiliser ce projet : #

Faire un *fork* sur votre Gitlab pour démarrer votre application. Pour rendre le projet indépendant : éditer le projet
puis `Remove Fork RelationShip` et enfin renommer le projet (`BaseSymfony5` n'est pas très parlant).

Ceci fait vous pouvez cloner ce projet dans votre compte pour commencer à travailler. Il n'est pas indispensable de le
rendre accessible sur `gigondas` puisqu'on peut utiliser le serveur Web intégré à Symfony, mais c'est prérérable. Donc :

    cd public_html
    git clone git@gitlab.iut-valence.fr:monLogin/MonBeauProjet.git

ou encore :

    cd public_html
    git clone https://gitlab.iut-valence.fr/monLogin/MonBeauProjet.git

Ceci fait vous devez installer les modules Symfony (qui ne sont pas intégrés au projet Git) avec :

    composer install

Ensuite vous pouvez lancer le serveur de développement avec `symfony server:start`.

Vous pouvez maintenant voir la page d'accueil par défaut de Symfony 5 : [http://localhost:8000](http://localhost:8000),
mais aussi les deux petites pages définies pour l'exemple :
[http://localhost:8000/bonjour](http://localhost:8000/bonjour) et
[http://localhost:8000/icons](http://localhost:8000/icons).

# Vous êtes prêts à travailler avec Symfony 5 ! #


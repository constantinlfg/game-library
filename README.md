# SAE2-01 : Développement d’une application
## Auteurs : 
- Lyfoung Constantin (```lyfo0002```)
- Betry Eliott (```betr0003```)
## Mise en place du projet
- Initialisation de ```composer```
    > ```composer init```
- Ajout de ```php-cs-fixer```
    > ```composer require friendsofphp/php-cs-fixer --dev```
- Récupération de la base de données
    > ![bd](img/bd.jpg)
- création de ```.mypdo.ini```
    > ![ini](img/ini.jpg)
## Création des classes
### Création de la classe ```Category```
- Création de la branche categories
    > ```git branch categories```
> ![category](img/category1.jpg)
- Création de la merge request sur Gitlab
> ![merge](img/merge-request.jpg)

### Création de la classe ```Genre```
- Même procédé pour la classe genre mais utilisation de ```git rebase``
    > branche genre active :
    >```git checkout genre```
    >
    > rebase la branche sur main:
    >```git rebase main```
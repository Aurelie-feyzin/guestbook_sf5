# Guestbook Symfony

Mise en pratique du livre [Symfony 5: The Fast Track](https://symfony.com/book)  
Le github du code présent dans le livre est [là](https://github.com/the-fast-track/book-5.0-4)   
License identique au livre c'est à dire [Creative Commons BY-NC-SA 4.0 license](https://creativecommons.org/licenses/by-nc-sa/4.0/deed.fr). 

## Prérequis
 - PHP 7.4 extension intl, pdo_pgsql, xsl, amqp, gd, openssl, sodium + redis et curl
 - [Composer](https://getcomposer.org/)
 - Docker et Docker Compose : [documentation](https://docs.docker.com/get-docker/)
 - [Symfony CLI](https://symfony.com/download)
 - Compte [Akismet](akismet.com) et [Blackfire](https://blackfire.io/)
 - App Slack https://api.slack.com

## Différence par rapport au livre
- Symfony 5.1 au lieu de 5.0
- Utilisation de EasyAdmin 3 au lieu de 2
- Pas de déploiement
- Slack utilisation Webhooks à la place des tokens qui sont legacy

## Installation et lancer le serveur 

### Installation 
```bash
git clone https://github.com/Aurelie-feyzin/guestbook_sf5.git
cd guestbook_sf5
make install
```

### Configuration
 
#### Clé secretes : Akismey et Slack
Ces clés sont stockées dans un _coffre-fort_ stocké dans `config\secrets`
[Doc officielle](https://symfony.com/doc/current/configuration/secrets.html) et du [livre](https://symfony.com/doc/current/the-fast-track/fr/16-spam.html#storing-secrets)    
AKISMET : AKISMET API KEY disponible dans `My Account`  
SLACK : slack://default/ID avec ID à récupérer dans `https://api.slack.com` `Features\Incomings Webhooks\Webhook URL` l'url est du type `https://hooks.slack.com/services/ID`

```bash
symfony console secrets:set AKISMET_KEY
Please type the secret value:
 >

 [OK] Secret "AKISMET_KEY" encrypted in "config/secrets/dev/"; you can commit it.

symfony console secrets:set SLACK_DSN
```
J'ai fait le choix de ne pas envoyer sur github les clés privées car le dépôt est public et présence de ma clé AKISMET donnée confidentielle.
Il a donc fallu que je nettoie mon historique git [info ici](https://www.davidlangin.fr/articles/git-supprimer-un-fichier-de-lhistorique) et j'ai également régénérer les clés `secrets:generate-keys --rotate`.

#### Env.local : Blackfire
Créer le fichier env.local et mettre les variables suivantes dedans
```bash
BLACKFIRE_SERVER_ID=
BLACKFIRE_SERVER_TOKEN=
```

### Lancer docker et le serveur
```bash
make start
make start_spa
```

## Commande utile

### Symfony Make
```bash
symfony console make:controller NameController
symfony console make:entity Entity
symfony console make:user Admin => Entité User
symfony console make:subscriber TwigEventSubscriber
symfony console make:form EntityFormType Entity
symfony console make:auth
symfony console make:command app:step:info
```

### Symfony debug
```bash
symfony server:log
symfony console debug:router
symfony var:export
```

### Symfony Messenger
```bash
symfony console messenger:consume async -vv
symfony server:status # lister tous les workers en arrière-plan
symfony console messenger:failed:show
symfony console messenger:failed:retry
```

### Symfony Encore
```bash
symfony run yarn encore dev
symfony run -d yarn encore dev --watch
```

### Symfony Traduction
```bash
symfony console translation:update fr --force --domain=messages
```

### Symfony autre
```
symfony console secrets:set NAME_KEY
symfony console security:encode-password => générer un mdp encoder
symfony console workflow:dump comment | dot -Tpng -o workflow.png
symfony console app:comment:cleanup
```

### Commande Docker
```bash
docker-compose up -d  => Lance Docker en arrière plan
docker-compose ps => Liste les containeurs
docker-compose logs => Logs de Composer
```

### BDD
 ```bash
symfony run psql
docker exec -it guestbook_database_1 psql -U main -W main => si pas de bianire pqsl sur l'hôte local
 symfony console make:migration
 symfony console doctrine:migrations:migrate
 ```

### Fixture et Test

#### Créer Test et Fixture
```bash
symfony console make:unit-test NameTest
symfony console make:functional-test Controller\\NameController

```

#### Lancer les tests
```bash
symfony console doctrine:fixtures:load
symfony php bin/phpunit
symfony php bin/phpunit tests/Controller/ConferenceControllerTest.php
make tests
```

### Git
 ```bash
git checkout -b new-branche
# ligne de commande
git status
git add .
git commit -m 'message'
# interface graphique
git gui &
# supprimer la branche apès merge
git branch -d new-branche
 ```

### Blackfire

```bash
curl https://installer.blackfire.io/ | bash
blackfire config --client-id=xxx --client-token=xxx
curl -OLsS https://get.blackfire.io/blackfire-player.phar
chmod +x blackfire-player.phar
make blackfire
```
**Remarque**: pour que le scénario marche il faut :
- pas de message en attente d'être consommé
- mailcatcher vide
- que le message crée dans le scénaro soit consommé
- et qu'il ne soit pas déjà présent dans le site.
   
Exemple :  il y aura une erreur si le scénario est lancé 2 fois de suite car le message est trouvé avant d'être validé.

### Autre
```bash
curl -s -I -X GET https://127.0.0.1:8000/
```
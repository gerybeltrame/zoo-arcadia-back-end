# MonprojetECF
Ce repository a été créé dans le cadre d’un projet de formation. Il s'agit de la partie back-end de mon projet ECF-Zoo_Arcadia qui se trouve ici: https://github.com/gerybeltrame/ECF-Zoo_Arcadia/tree/main

# Instruction d'installation
Pour faire fonctionner ce projet en local, il vous faut:
- PHP >= 8.2.2
- Symfony >= 5.8.16
- Composer >= 2.5.5
- Git
- Les extensions PHP: Iconv, JSON, PCRE, Session, Tokenizer et les éléments pour Symfony.

Pour vérifier les éléments requit par par Symfony taper la commande suivante:
- `symfony check:requirements`

## Installation

D'abord, il vous faut créer une clef SSH ou GPG sur votre compte Github ou Gitlab.

Il faut ensuite cloner le repository:
- `$ git clone 'git@github.com:gerybeltrame/zoo-arcadia-back-end.git'`

Puis créez des fichiers `.env.{environnement}.local` selon votre configuration.
- `$ cp .env .env.local   # Crée des fichiers .env.$APP_ENV.local. Il suffit de les compléter avec votre configuration`

Pour finir, paramètrez votre DATABASE_URL dans les fichiers `.env.{environnement}.local` et tapez les commandes suivantes:
- `$ composer install # cela tous les éléments PHP`
- `$ php bin/console d:d:c # Cela crée la base de données en fonction de votre configuration .env.local`
- `$ php bin/console d:d:m # Cela lance une migration pour paramètrer votre base de données selon vos entitées`

Il ne vous restera plus qu'à lancer votre serveur symfony:
- `symfony server:start`

Et voilà, vous devriez avoir la partie Back-end du projet zoo arcadia installée et fonctionnelle.
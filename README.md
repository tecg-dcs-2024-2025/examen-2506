# Examen de juin 2025

Votre application a évolué. Désormais sur le formulaire, un déclarant a la possibilité de choisir de se créer un compte pour suivre l'évolution de sa déclaration. S'il le fait, sa déclaration lui appartient. Il est donc désormais possible d'attacher dans la base de données une déclaration à un utilisateur. Voyez les migrations et le seeder si vous avez un doute.

N'oubliez pas de créer les dossiers /storage/cache et /storage/logs. Sans eux, BladeOne ne peut pas fonctionner. 



## Mission - 1

La première mission est de corriger un bug qui s'est introduit lors du fonctionnement du seeder. Quand on exécute le seeder, des *losses* sont créées, certaines avec une référence à un utilisateur (toujours le même, dominique.vilain@hepl.be) et d'autres sans. Pourtant, dans la DB aucune déclaration n’est associée à un utilisateur. Le code du seeder est correct, ce n'est pas lui qui est en tort.

Corrigez ce bug.

[Solution](https://github.com/tecg-dcs-2024-2025/examen-2506/pull/2)

## Mission - 2

Quand dominique.vilain@hepl.be se connecte, il est redirigé vers une page qui devrait lui affiche des déclarations. Pour le moment, cette page a un problème, une variable n’est pas définie. Corrigez ce problème mais faites attention à l'aspect suivant : le seeder a créé des déclarations dans la DB, dont certaines appartiennent à dominique.vilain@hepl.be et d’autres à personne. 

dominique.vilain@hepl.be ne peut voir ici que les déclarations qui lui appartiennent. 

Corrigez ce bug en **définissant** et en **utilisant** la relation qui unit les pertes et les utilisateurs de l'application.

[Solution](https://github.com/tecg-dcs-2024-2025/examen-2506/pull/4)

## Mission - 3

Quand on a accès au résumé d'une déclaration, le template essaie d'accéder à une variable `loss` qui n’est pas présente et affiche des avertissements. 

Corrigez ce bug sans modifier le template. 

Attention, quand le template affiche le nom de l'animal, les informations concernant l'animal doivent déjà exister dans `$loss`. Vous devez *eager loader* l'animal dans `loss` au niveau du controlleur plutôt que tenter d'accéder à l'animal au dernier moment, quand vous êtes dans le template.

[Solution](https://github.com/tecg-dcs-2024-2025/examen-2506/pull/6)

## Mission - 4

Réalisez un middleware `OwnsLoss` qui vérifie si l'utilisateur connecté est propriétaire de la déclaration qu'il veut consulter. Appliquez ce middleware à la route qui permet de *voir* une déclaration de perte. 

Pour l'instant, il est possible à dominique.vilain@hepl.be d'accéder à n'importe quelle déclaration de perte en mettant un id dans l'url. Il ne devrait pouvoir accéder qu'aux siennes. Si dominique.vilain@hepl.be tente d'accéder à la déclaration dont l'id est 2, la réponse doit lui dire qu'il n'en a pas l'autorisation.

[Solution](https://github.com/tecg-dcs-2024-2025/examen-2506/pull/8)

## Mission - 5

Modifiez l’application pour qu'il soit possible de stocker dans la base de données une information à propos d’une déclaration concernant son statut *archivé*. Pour cela, un colonne `solved_at` serait utile. Quand elle est `NULL`, la déclaration n’est pas archivée et quand un timestamp s'y trouve, elle est *archivée*. 

Pour simplifier les interactions avec les déclarations archivées ou non archivées, écrivez un _scope_ eloquent qui embarque la logique de filtrage (le `where`) et en masque la complexité au _controller_.

Voyez la documentation sur les _local scopes_ dans la section _Getting started_ de la documentation d'Eloquent. Inspirez-vous du scope `popular()` qui y est montré en exemple. Faites deux scopes, un nommé `active()`et un autre nommé `archived()`

Pour tester votre scope `active()`, modifiez le seeder où il y a déjà des déclarations qui sont seedées. Faites en sorte que certaines soient archivées et d'autres pas, au hasard. Bien sûr, pour vos tests, c'est surtout utile si vous faites en sorte que celles de l'utilisateur dominique.vilain@hepl.be soit parfois archivées, parfois pas. 

Vérifiez donc votre scope lorsque dominique.vilain@hepl.be essaie de voir ses déclarations. Il ne devrait pas voir les archivées dans le template qui fait la liste des déclarations. 

[Solution](https://github.com/tecg-dcs-2024-2025/examen-2506/pull/10)

## Mission - 6

Pour le moment, le composant `layouts.navigation` contient deux parties, une avec le code destiné aux utilisateurs connectés et une avec le code destiné aux utilisateurs non connectés. 

Quand un utilisateur est connecté, il devrait voir trois liens (déclarations, animaux, propriétaires), en plus du formulaire déjà présent lui permettant de se déconnecter. Vous allez refactoriser ce composant de la manière suivante et y mettre trois liens fonctionnels.

`layouts.navigation` va contenir un composant `navigation.links` qui servira de conteneur pour les liens de la navigation. Dans `navigation.links`, vous itérerez sur un array `$links` qui sera transmis depuis `layouts.navigation` à `navigation.links`. Lors de cette itération, vous introduirez `link`, simple emballage sous la forme d’un composant de la balise html `<a>`. Vous transmettrez à ce composant l'url destinée à l'attribut `href`. Par contre, vous arrangerez votre code pour que le texte du lien soit utilisé en tant que _slot_. 

Vous vous assurerez que les trois liens fonctionnent en prévoyant les trois routes correspondantes et pour chacune un contrôleur qui retourne une vue annonçant simplement le titre de la vue (ce titre est défini dans le contrôleur qui affiche la vue).

Le formulaire de déconnexion deviendra lui aussi un composant à part entière (`auth.logout`), et le lien profil récemment apparu dans l’application devra profiter également de votre création de composant pour les liens et être inséré en utilisant ce composant.

[Solution](https://github.com/tecg-dcs-2024-2025/examen-2506/pull/12)
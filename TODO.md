# TODO - Nouvel Parent depuis inscription (admin)

## Étape 1 — Comprendre le flow existant (fait)
- Vérifier le formulaire `resources/views/admin/inscriptions/create.blade.php`
- Confirmer que `parent_id` est déjà utilisé pour associer à l’inscription.

## Étape 2 — Ajouter le lien “Nouvel Parent” dans la sidebar (à faire)
- Placer un bouton/lien à droite (dans la carte sidebar du formulaire d’inscription)
- Cible: route de création parent

## Étape 3 — Passer le contexte pour revenir à la page d’inscription (à faire)
- Définir comment le système garde l’intention de sélection du parent après création
- Exemple: retourner vers `admin/inscriptions/create` avec `parent_created_id` ou équivalent

## Étape 4 — Pré-sélectionner le parent nouvellement créé (à faire)
- Modifier `create.blade.php` pour lire le paramètre de contexte (ex: `parent_created_id`)
- Pré-remplir le `<select name="parent_id">` sur retour

## Étape 5 — Ajouter/ajuster route(s) et redirection (à faire)
- Dans `routes/web.php`, ajouter une route dédiée ou adapter la logique existante
- Côté `ParentAdminController`, s’assurer que la création parent redirige vers l’inscription avec le bon contexte

## Étape 6 — Associer au moment de la soumission (à vérifier)
- Vérifier que le backend utilise bien `parent_id` transmis par le formulaire
- Aucun changement si déjà correct

## Étape 7 — Tests manuels (à faire)
- Cas A: parent existant sélectionné dans le select => association OK
- Cas B: cliquer “Nouvel Parent” => créer parent => retour => select pré-sélectionné => association OK
- Vérifier que le retour ne casse pas la saisie ou la validation


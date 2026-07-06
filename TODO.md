# TODO - ParcoursScolaires

- [x] Générer automatiquement `code` lors de la création d’une matière (règle: slug du nom en majuscules, lettres/chiffres uniquement, + suffix si collision).
- [x] Modifier la vue `resources/views/admin/matieres/create.blade.php` pour supprimer/simplifier la saisie manuelle de `code`.
- [x] Adapter `MatiereController@store()` pour ne plus valider `code` comme requis, et utiliser le code généré.
- [ ] Vérifier manuellement : création matière sans saisir `code` + test collision (deux matières au même nom/slug).



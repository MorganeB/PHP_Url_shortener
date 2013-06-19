Réalisation d'un site local de raccourcissement d'url

Contraintes :
	- gérer un espace membre et ses fonctionnalités
	- générer des statistiques pour l'utilisateur 
	- le 1er utilisateur créer doit être un administrateur
	- cet administrateur doit pouvoir effectuer des opérations
		de maintenance sur les utilisateurs de son site 


Utilisation d'éléments de sécurité de base vus en cours : 
- La fonction addslashes() dans les champs de formulaires.
- Les mots de passe sont cryptés grâce à sha1(). 
- Exclusion de toute personne essayant d'accéder à une page sans login 
 avec une redirection


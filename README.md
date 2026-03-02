# Système d'Annuaire Universitaire (Defitech)

## 1. Présentation du Projet

L'université souhaite mettre en place un système d'annuaire centralisé. Ce projet vise à simplifier la gestion des identités numériques au sein de l'établissement et à servir de socle de données pour tous les services numériques futurs (bibliothèque, portail de notes, accès réseau, etc.).

### 1.1 Objectifs principaux

- **Centralisation :** Regrouper en un seul lieu les données de toutes les personnes travaillant ou étudiant à l'université.
    
- **Identité Numérique :** Automatiser la création d'adresses email institutionnelles.
    
- **Interopérabilité :** Permettre aux autres logiciels de l'université de consulter les données de manière sécurisée via une interface programmable (API).
    

## 2. Périmètre du Système

Le système doit gérer l'ensemble des profils rattachés à l'institution.
### 2.1 Populations concernées
L'annuaire doit être capable de stocker et de distinguer les catégories suivantes 
- **Corps Étudiant :** Inscrits dans les différentes filières.
- **Corps Enseignant :** Professeurs permanents et vacataires.
- **Personnel Administratif :** Comptables, secrétariats, direction.
- **Personnel de Soutien :** Surveillants, concierges, agents de maintenance.
### 2.2 Informations à collecter (Données de base)

Pour chaque individu, le système doit enregistrer au minimum :

- **Identité :** Nom, prénoms, sexe, date de naissance.
- **Contact :** Téléphone, adresse email personnelle (pour la récupération).
- **Professionnel :** Matricule unique, fonction/rôle, département de rattachement.
## 3. Besoins Fonctionnels

### F1 : Gestion des Inscriptions et Profils

Le système doit permettre l'importation ou la saisie des nouvelles recrues et des nouveaux étudiants. Chaque fiche doit pouvoir être mise à jour (changement de statut : actif, suspendu, diplômé).

### F2 : Attribution automatique d'Emails

Dès qu'une personne est enregistrée avec un statut "Actif", le système doit :

1. Générer une adresse email basée sur une règle de nommage précise (ex: `p.nom@defitech.tg`).
2. Vérifier que l'adresse n'est pas déjà attribuée (gestion des homonymes).

### F3 : Exposition des données (API)

Le système ne doit pas rester "fermé". Il doit mettre à disposition des outils pour que d'autres applications puissent :
- Vérifier si un matricule est valide.
- Récupérer la liste des étudiants d'une filière spécifique.
- Authentifier un utilisateur pour un service tiers.

## 4. Règles de Gestion et Contraintes
- **Unicité du matricule :** Chaque individu possède un et un seul matricule à vie au sein de l'institution.
- **Confidentialité :** Les données personnelles (adresse, téléphone) ne doivent être accessibles qu'aux administrateurs et via des accès API sécurisés.
- **Disponibilité :** L'annuaire étant le cœur du système, il doit être accessible en permanence par les applications tierces.

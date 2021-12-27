# Projet web L2 2021-2021
## **_Maxime FIQUET_**

<br> 

---

<br>

## **_Backlog produit_**

|  Numéro  | User Story  |  Importance  | Note | Cirtère | Etat |
| :------: | ----------- | :----------: | ---- | ------- | ---- |
| US-01 |En tant qu'utilisateur, je veux pouvoir visualiser les données du site|1|Les documents doivent être lisibles et ordonnés|Etant donné que je suis utilisateur, lorsque la page se charge, alors je dois pouvoir visualiser les données du site| FINI |
| US-02 |En tant qu'utilisateur, je veux pouvoir voir les détails d'un concert  |1|Le documents doit être mis en valeur et compréhensible à tous|Etant donné que je suis l'utilisateur, lorsque je clique sur "Voir les détails", alors je dois pouvoir connaître toutes les informations concernants la donnée| FINI |
| US-03 |En tant qu'administrateur du site, je veux pourvoir gérer les données du site|1|La gestion du pouvoir être faite par un formulaire pour ajouter des données dans la/les table(s)e| Etant l'administrateur, lorsque je clique sur le bouton "Admin", alors j'accède à la page de gestion| FINI |
| US-04 |En tant qu'utilisateur, je souhaite pouvoir me connecter sur le site|3|Le moyen de connection dois être intuitif et simple|Etant donné que je suis l'utilisateur, lorsque je suis connecté, alors je dois pouvoir voir mon status de connection| FINI
| US-05 |En tant qu'utilisateur, je souhaite pouvoir réserver une place pour un concert|3| | | FINI |
| US-07 |En tant qu'utilisateur, je souhaite pourvoir visualiser mes réservations|3| | | FINI |
| US-07 |En tant qu'utilisateur, je dois pouvoir annuler une réservation|3| | | FINI |
| US-08 |En tant qu'administrateur, je dois pouvoir retirer une réservation d'un client|2| | | FINI |
| US-09 |En tant qu'administrateur, je dois pouvoir visualiser les réservations d'un client|2| | | EN COURS |

<br> 

---

<br>

```
id Administrateur : 
       login : admin
       pass  : admin
```

<br> 

---

<br>

## **Détails des tables de données**

|     Nom      |    Champs    | Clé primaire | Clé étrangère |
| :----------: | :----------: | -----------: | ------------: |
|   concerts   |**id_concert**|    **Oui**   |      Non      |
|              | **_groupe_** |      Non     |   **_Oui_**   |
|              |     lieu     |      Non     |      Non      |
|              |     date     |      Non     |      Non      |
|              |  prix_place  |      Non     |      Non      |
|              |              |              |               |
| genremusical | **id_genre** |    **Oui**   |      Non      |
|              |   nomGenre   |      Non     |      Non      |
|              |              |              |               |
|   groupes    | **id_groupe**|    **Oui**   |      Non      |
|              |      nom     |      Non     |      Non      |
|              |  **_genre_** |      Non     |   **_Oui_**   |
|              |     image    |      Non     |      Non      |
|              |              |              |               |
|    users     | **id_user**  |    **Oui**   |      Non      |
|              |    login     |      Non     |      Non      |
|              |    pass      |      Non     |      Non      |
|              |    email     |      Non     |      Non      |
|              |              |              |               |
| reservation  | **id_reser** |    **Oui**   |      Non      |
|              | **_idUser_** |      Non     |   **_Oui_**   |
|              | **_idConc_** |      Non     |   **_Oui_**   |

<br>

---

<br>

## **Concerts dans la base de données**

| Nom | Genre | Date | Lieu | Prix |
| --- | ----- | ---- | ---- | ---- |
| AC-DC | Rock | 24-02-2022 | Southampton - Royaume Uni | 16.96 |
| Red Hot Chili Peppers | Rock | 09-07-2022 | St-Denis - Stade de France |56.5 |
| Scorpion | Rock | 15-05-2022 | Lille - Zenith Arena | 68 | 
|  |  |  |  |  |
| Tryo | Chanson Française | 12-02-2022 | Paris - Bercy | 55 |

<br>

---

<br>

[Lien vers le projet sur GitLab](https://gitlab.univ-lr.fr/mfiquet/projet_web)


# Projet web L2 2021-2021
## **_Maxime FIQUET_**

<br> 

---

<br>

## **_Backlog produit_**

|  Numéro  | User Story  |  Importance  | Note |
| :------: | ----------- | :----------: | :--: |
| US-01 |En tant qu'utilisateur, je veux pouvoir visualiser les données du site|1|Les documents doivent être lisibles et ordonnés|
| US-02 |En tant qu'utilisateur, je veux pouvoir voir les détails d'un concert  |1|Le documents doit être mis en valeur et compréhensible à tous|
| US-03 |En tant qu'administrateur du site, je veux pourvoir gérer les données du site|1|La gestion du pouvoir être faite par un formulaire pour ajouter des données dans la/les table(s)|
| US-04 |En tant qu'utilisateur, je souhaite pouvoir me connecter sur le site|2|Le moyen de connection dois être intuitif et simple|
| US-05 |En tant qu'utilisateur, je souhaite pouvoir réserver une place pour un concert|3| La réservation doit être explicite et facile à réaliser |
| US-06 |En tant qu'utilisateur, je souhaite pourvoir visualiser mes réservations|3| Les réservations doivent être visibes et compréhensibles |
| US-07 |En tant qu'utilisateur, je dois pouvoir annuler une réservation|3| L'annulation d'une réservation doit être facile et explicite |
| US-08 |En tant qu'administrateur, je dois pouvoir retirer une réservation d'un client|3| Je doit pouvoir annuler la réservation de n'importe quel utilisateur en prévision de problème avec un concert |
| US-09 |En tant qu'administrateur, je dois pouvoir visualiser les réservations d'un client|3| Les réservations doivent être lisibles et compréhensibles |

<br> 

---

<br>

```
id Administrateur : 
    login : admin
    pass  : admin
    aucune adresse email
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
| :-: | :---: | :--: | :--: | ---: |
| AC-DC | Rock | 24-02-2022 | Southampton - Royaume Uni | 16.96 |
| Red Hot Chili Peppers | Rock | 09-07-2022 | St-Denis - Stade de France | 56.5 |
| Scorpion | Rock | 15-05-2022 | Lille - Zenith Arena | 68 | 
|  |  |  |  |  |
| Tryo | Chanson Française | 12-02-2022 | Paris - Bercy | 55 |
|  |  |  |  |  |
| Imagine Dragons | Pop | 16-06-2022 | Esch sur Alzette - Luxembourg | 99 |
| Coldplay | Pop | 16-07-2022 | St-Denis - Stade de France | 78.5 |
| Marron 5 | Pop | 28-03-2022 | San Juan - Poto Rico | 90 |

<br>

---

<br>

[Lien vers le projet sur GitHub](https://github.com/MaximeFqt/projet_web)


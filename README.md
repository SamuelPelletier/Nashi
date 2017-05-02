Nashi API
====

# Call to Wit.ai

Permet d'appeller wit.ai avec une phrase

### URL : 
url/nashi/web/wit/?message=''&langue=''
### Paramétre d'entrée: 
- message : Chaîne de texte interpréter par wit.ai
- language : La langue dans laquelle la chaîne sera interpréter. Par défault : EN (English)

### Paramétre de sortie: 
- array(json) : structuré | vide si aucun résultat

### Structure : 
- ingredient (array):
  
  [
  '-> suggested (bool)
  
  '-> confidence (number)
  
  '-> value (string)
  
  '-> type (string)
  
  ],
  
  [
  
  '-> confidence (number)
  
  '-> value (string)
  
  '-> type (string)
  
  ]
  
- suggested (optionnel): certifie si la valeur correspond
- confidence : détermine la sureté du résultat de 0 à 1
- value : l'ingrédient trouver
- type : type de donnée

### Exemple :
url/nashi/web/wit/?message=i%20have%20some%20milk%20and%20beacon

# Post ingrédient

Permet d'envoyer les ingrédients que possédents un client

### URL : 
url/nashi/web/ingredient/post/{id}/
### Paramétre d'entrée dans le body: 
- ingredient (array json) : 

  [
  
  "ingredientValue" (string): 
  
    amount (interger) : value
    
    unit (integer) : value
    
    ],
    
    [ ... ]
    
    , language (string) : value
    
- ingredient : tableau d'ingredient
- ingredientValue à remplacer par la chaine de texte correspondant à un ingrédient
- amount : quantité de l'ingrédient choisis
- unit : correspond à l'unité de mesure (1: litre, 2: gramme, 3: piece)
- language : langue des ingrédients
- {id} : id de l'utilisateur

### Paramétre de sortie: 
- message (string)
- code retour : 200 (OK) | 400 (NOK)

### Exemple :
#### URL :
url/nashi/web/ingredient/post/1/
### Content :
{"ingredient":{"cheese":{"amount":500,"unit":2}},"language":"EN"}

# Get ingrédient

Permet de récupérer les ingrédients que posséde un client

### URL : 
url/nashi/web/ingredient/get/{id}/
### Paramétre d'entrée dans l'url: 
- {id} : id de l'utilisateur

### Paramétre de sortie: 
- ingredient (array json) : 

  [
  
  "ingredientValue" (string): 
  
    amount (interger) : value
    
    unit (integer) : value
    
    ],
    
    [ ... ]
    
- ingredient : tableau d'ingredient
- ingredientValue à remplacer par la chaine de texte correspondant à un ingrédient
- amount : quantité de l'ingrédient choisis
- unit : correspond à l'unité de mesure (1: litre, 2: gramme, 3: piece)

code retour : 200 (OK) | 400 (NOK)
Erreur : retourne un tableau vide

### Exemple :
#### URL :
url/nashi/web/ingredient/get/1/
### Content :
{"apple":{"amount":10,"unit":3},"cheese":{"amount":500,"unit":2},"bread":{"amount":1000,"unit":2},"milk":{"amount":2,"unit":1}}


function ajouterIngredient(event) {
    event.preventDefault();

    let nomIngredient = document.getElementById("nom_ingredient").value;
    let quantiteIngredient = document.getElementById("quantite_ingredient").value;
    let uniteIngredient = document.getElementById("unite_ingredient").value;
    if (nomIngredient !== "" && quantiteIngredient !== "" && uniteIngredient !== "") {
        let nouvelIngredient = document.createElement("li");
        nouvelIngredient.textContent = quantiteIngredient + " " + uniteIngredient + " de " + nomIngredient;

        let croixIcon = document.createElement("span");
        croixIcon.textContent = "❎";
        croixIcon.style.cursor = "pointer" 

        croixIcon.addEventListener("click", function() {
            nouvelIngredient.remove();
        });

        nouvelIngredient.appendChild(croixIcon);

        createHiddenInput('ingredients[]', JSON.stringify({name: nomIngredient, quantity: quantiteIngredient, unit: uniteIngredient}));

        document.getElementById("ingredientList").appendChild(nouvelIngredient);
        document.getElementById("nom_ingredient").value = "";
        document.getElementById("quantite_ingredient").value = "";
        document.getElementById("unite_ingredient").value = "";
    } else {
        alert("Veuillez remplir tous les champs avant d'ajouter un ingrédient.");
    }
}


// function prepareFormData() {
//     // Update the hidden input fields with the content of display-info
//     let ingredients = document.querySelectorAll('.ingredient');
//     ingredients.forEach(function(ingredient, index) {
//         let nom = ingredient.querySelector('input[name="nom_ingredient[]"]').value;
//         let quantite = ingredient.querySelector('input[name="quantite_ingredient[]"]').value;
//         let unite = ingredient.querySelector('input[name="unite_ingredient[]"]').value;
//         // Create hidden inputs for each field
//         createHiddenInput('nom[' + index + ']' ,nom);
//         createHiddenInput('quantite[' + index + ']', quantite);
//         createHiddenInput('unite[' + index + ']', unite);

//     });
// }

function createHiddenInput(name, value) {
    // Create a hidden input element
    let hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = name;
    hiddenInput.value = value;
    console.log(hiddenInput);
    
    // Append it to the form
    document.getElementById('form1').appendChild(hiddenInput);
    console.log(document.getElementById('form1'));
}


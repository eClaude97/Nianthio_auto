<?php

use App\Models\Car;
use Class\Form;
/* @var Car $car */ $car = $car ?? null;

?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Véhicule</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Véhicule</a></div>
                <div class="breadcrumb-item"><?= ( isset($car) ) ? 'Modification' : 'Creation'  ?></div>
            </div>
        </div>
        <div class="card">
            <form action="<?= ( isset($car) ) ? '?p=admin.car.update' : '?p=admin.car.store'?>"
                  method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="card-header">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <h4>Formulaire <?= ( isset($car) ) ? 'Modification' : 'Creation' ?> de Véhicule </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?=/* @var Form $form */
                        $form->selectField('mark_id', $marks ?? [], (!is_null($car)) ? $car->getMarkId() : '', 'Choisir la Marque', 'required', 'col-md-6') ?>
                        <div class="form-group col-md-6">
                            <label for="model_id">Modèles</label>
                            <select name="model_id" class="form-control" id="model_id" disabled="" required="">
                                <option value="">Sélectionnez d'abord une marque</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <?= $form->inputField('matricule', values:(!is_null($car))? $car->getMatricule() : '', class: 'col-md-6') ?>
                        <?= $form->inputField('title', values:(!is_null($car))? $car->getTitle() : '', label: 'Titre', required: 'required', class: 'col-md-6') ?>
                    </div>
                    <div class="row">
                        <?= $form->inputField('price', 'number', (!is_null($car)) ? $car->getPrice() : '','Prix','required',class: 'col') ?>
                        <?= $form->inputField('mileage', 'number', (!is_null($car)) ? $car->getMileage() : '','Kilométrage','required',class: 'col') ?>
                        <?= $form->inputField('doors', 'number', (!is_null($car)) ? $car->getDoors() : '','Nombre de portes','required',class: 'col') ?>
                        <?= $form->inputField('seats', 'number', (!is_null($car)) ? $car->getSeats() : '','Nombre de places','required',class: 'col') ?>
                    </div>
                    <div class="row">
                        <?= $form->selectField('type', $types ?? [], (!is_null($car)) ? $car->getType() : '' , required: 'required', class: 'col') ?>
                        <?= $form->selectField('color', $colors ?? [], (!is_null($car)) ? $car->getColor() : '' , required: 'required', class: 'col') ?>
                        <?= $form->selectField('energy', $energies ?? [], (!is_null($car)) ? $car->getEnergy() : '' , 'Carburant', required: 'required', class: 'col') ?>
                        <?= $form->selectField('transmission', $transmissions ?? [], (!is_null($car)) ? $car->getTransmission() : '' , 'Type de transmission', required: 'required', class: 'col') ?>
                    </div>
                    <div class="row col-md-12 m-auto" >
                        <?= $form->checkboxField('sold', '', 'Vendu', 'required', 'col') ?>
                        <?= $form->checkboxField('rented', '', 'Louer', 'required', 'col') ?>
                    </div>
                    <div class="form-group row mt-5 mb-4">
                        <label for="description" class="col-form-label text-left col-12 mb-2">Description</label>
                        <div class="col-sm-12">
                            <textarea id="description" name="description" class="summernote"></textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary mb-2" id="ajouterImage">Ajouter une autre image</button>
                    <div id="champsDynamiques" class="row col-md-12">
                        <?= $form->fileField('img', 'Image1', 'required', 'form-group col-md-4') ?>
                    </div>

                </div>
                <div class="card-footer">
                    <button name="add" type="submit" class="btn btn-primary">Créer</button>
                </div>

            </form>
        </div>
    </section>
</div>

<script>
    const markSelect = document.getElementById('mark_id');
    const modelSelect = document.getElementById('model_id');

    markSelect.addEventListener('change', function() {
        let selectedMark = markSelect.value;
        modelSelect.innerHTML = '';
        if (selectedMark === '') {
            modelSelect.disabled = true;
        } else {
            modelSelect.disabled = false;

            // Utilisez AJAX pour obtenir les modèles en fonction de la marque sélectionnée
            $.ajax({
                url: "index.php", // Assurez-vous que le chemin est correct
                method: 'GET',
                data: { markId: selectedMark },
                success: function(data) {
                    const models = JSON.parse(data);

                    const option = document.createElement('option');
                    option.value = '';
                    option.text = "Veuillez choisir le model";
                    option.selected = true;
                    modelSelect.appendChild(option);


                    for (let i = 0; i < models.length; i++) {
                        const option = document.createElement('option');
                        option.value = models[i].id;
                        option.text = models[i].title;
                        modelSelect.appendChild(option);
                    }
                }
            });
        }
    });

    const maxChamps = 6; // Limite maximale de champs d'image
    let numChamps = 1; // Compteur de champs

    // Fonction pour ajouter un champ d'image
    function ajouterChampImage() {
        if (numChamps < maxChamps) {
            const nouveauChamp = document.createElement("div");
            nouveauChamp.innerHTML = `
                    <input type='file' required class='custom-file-input' id="img${numChamps}" name="img${numChamps}" >
                    <label class='custom-file-label' for="img${numChamps}">Image${numChamps+1}</label>
                    <div class='invalid-feedback'>Champ requis !</div>
                `;
            nouveauChamp.classList.add("custom-file");
            nouveauChamp.classList.add("form-group");
            nouveauChamp.classList.add("col-md-4");
            document.getElementById("champsDynamiques").appendChild(nouveauChamp);
            numChamps++;
            // Vérifier si le nombre de champs atteint la limite
            if (numChamps >= maxChamps) {
                document.getElementById("ajouterImage").style.display = "none"; // Masquer le bouton
            }
        }
    }

    // Écouter le clic sur le bouton "Ajouter une autre image"
    document.getElementById("ajouterImage").addEventListener("click", ajouterChampImage);
</script>


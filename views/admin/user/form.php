<?php /* @var Class\Form $form */ ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Utilisateur</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="?p=admin.dashboard.index">Dashboard</a></div>
                <div class="breadcrumb-item">Profile</div>
            </div>
        </div>
        <div class="card">
            <form action="?p=admin.user.store" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="card-header">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <h4 class="section-title mt-0">Formulaire de création d'un utilisateur</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?= $form->inputField('firstname', label: 'Prénom', required: 'required', class: 'col-md-6') ?>
                        <?= $form->inputField('lastname', label: 'Nom', required: 'required', class: 'col-md-6') ?>
                    </div>
                    <div class="row">
                        <?= $form->inputField('login', required: 'required', class: 'col-md-6') ?>
                        <?= $form->inputField('email', 'email', required: 'required', class: 'col-md-6') ?>
                    </div>
                    <div class="row">
                        <?= $form->inputField('password', 'password', label: 'Mot de pass', required: 'required', class: 'col-md-6') ?>
                        <?= $form->inputField('re_password', 'password', label: 'Confirmer le mot de pass', required: 'required', class: 'col-md-6') ?>
                    </div>
                    <div class="row">
                        <?= $form->inputField('tel', 'number', '','Téléphone', required: 'required', class: 'col') ?>
                        <?= $form->inputField('address', 'text','' ,'Adresse', required: 'required', class: 'col') ?>
                        <?= $form->inputField('job', 'text','' ,'Profession', required: 'required', class: 'col') ?>
                        <?= $form->selectField('type', $type ?? [],'' ,'Type d\'utilisateur','required','col') ?>
                    </div>
                    <div class="row col-md-12 m-auto" >
                        <?= $form->fileField('picture', 'Photo de Profil', class: 'col mr-5') ?>
                        <?= $form->fileField('doc', 'Document', class: 'col') ?>
                    </div>
                    <div class="form-group row mt-5 mb-4">
                        <label for="about" class="col-form-label text-left col-12 mb-2">Description</label>
                        <div class="col-sm-12">
                            <textarea id="about" name="about" class="summernote"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button name="add" type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </section>
</div>
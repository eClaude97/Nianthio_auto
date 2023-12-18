<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Profile</div>
            </div>
        </div>
        <div class="card">
            <form action="<?= (isset($mark)) ? '?p=admin.mark.update' : '?p=admin.mark.store' ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>

                <div class="card-header">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <h4>Formulaire de <?= isset($mark) ? 'Modification' : 'Création'?> d'une Marque</h4>
                </div>
                <div class="card-body">
                    <?= /* @var \Class\Form $form */$form->inputField('name', values: $mark->name ?? '', label: 'Nom', required: 'required') ?>
                    <?= $form->fileField('logo', required: 'required') ?>
                </div>
                <div class="card-footer">
                    <?php if (isset($mark)) : ?>
                        <button name="edit" value="<?=$mark->id?>" type="submit" class="btn btn-primary">Modifier</button>
                    <?php else : ?>
                        <button name="add" type="submit" class="btn btn-primary">Créer</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </section>
</div>
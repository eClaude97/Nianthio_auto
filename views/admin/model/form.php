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
            <form action="<?= isset($model) ? '?p=admin.model.update' : '?p=admin.model.store'?>"
                  method="post"
                  enctype="multipart/form-data"
                  class="needs-validation"
                  novalidate
            >
                <div class="card-header">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <h4>Formulaire de <?= isset($model) ? 'Modification' : 'Création'?> d'une Marque</h4>
                </div>
                <div class="card-body">
                    <?= /* @var \Class\Form $form */
                    $form->inputField('title', values: $model->title ?? '', label: 'Titre', required: 'required') ?>
                    <?= $form->inputField('year', values: $model->year ?? '', label: 'Année', required: 'required') ?>
                    <?= $form->selectField('mark_id', $options ?? [], $model->mark_id ?? '', 'Marque', 'required') ?>
                </div>
                <div class="card-footer">
                    <?php if (isset($model)) : ?>
                        <button name="edit" value="<?=$model->id?>" type="submit" class="btn btn-primary">Modifier</button>
                    <?php else : ?>
                        <button name="add" type="submit" class="btn btn-primary">Créer</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </section>
</div>

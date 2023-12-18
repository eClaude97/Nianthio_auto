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
        <div class="row">
            <div class="col-12">
                <?php if (isset($success)) :?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php elseif (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Liste des Modèles</h4>
                        <h4>
                            <a href="?p=admin.model.add" class="nav-link link">Ajouter un modèle</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Titre</th>
                                    <th>Année</th>
                                    <th>Marque</th>
                                    <th class="text-right pr-5">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0;foreach ($models ?? [] as /* @var App\Models\Model $model */$model): ?>
                                    <tr>
                                        <td><?=  ++$i ?></td>
                                        <td><?= $model->getTitle() ?></td>
                                        <td><?= $model->getYear() ?></td>
                                        <td><?= $model->mark->getName() ?></td>
                                        <td>
                                            <div class="d-flex float-right">
                                                <a href="?p=admin.model.edit&id=<?=$model->getToken()?>" class="btn btn-secondary mx-2">Edit</a>
                                                <form action="?p=admin.model.delete" method="post">
                                                    <button type="submit" class="btn btn-danger" name="delete" value="<?=$model->getId()?>">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
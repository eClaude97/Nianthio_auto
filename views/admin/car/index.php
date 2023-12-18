<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Véhicule</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Véhicule</a></div>
                <div class="breadcrumb-item">Liste</div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Liste des Véhicules</h4>
                        <h4>
                            <a href="?p=admin.car.add" class="nav-link link">Ajouter un véhicule</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Matricule</th>
                                    <th>Titre</th>
                                    <th>Modèle</th>
                                    <th>Type</th>
                                    <th>Ajouter Par</th>
                                    <th>Vendue | louée</th>
                                    <th class="text-right pr-5">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0;foreach ($cars ?? [] as $car): ?>
                                    <tr>
                                        <td><?= ++$i ?></td>
                                        <td><?= $car->matricule ?? 'Sans Matricule' ?></td>
                                        <td><?= $car->title ?></td>
                                        <td><?= $car->modelMark ?></td>
                                        <td><?= $car->type ?></td>
                                        <td><?= $car->user ?></td>
                                        <td><?= ($car->sold) ? 'Oui' : 'Non' ?> | <?= ($car->rented) ? 'Oui' : 'Non' ?></td>
                                        <td>
                                            <div class="d-flex float-right">
                                                <a href="?p=admin.car.edit&id=<?=$car->token?>" class="btn btn-secondary mx-2">Edit</a>
                                                <form action="?p=admin.car.delete" method="post">
                                                    <button type="submit" class="btn btn-danger" name="delete" value="<?=$car->id?>">Delete</button>
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

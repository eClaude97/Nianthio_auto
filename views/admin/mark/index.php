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
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Liste des marques</h4>
                        <h4>
                            <a href="?p=admin.mark.add" class="nav-link link">Ajouter une marque</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th class="text-right pr-5">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0;foreach ($marks ?? [] as /* @var App\Models\Mark $mark*/ $mark): ?>
                                <tr>
                                    <td><?=  ++$i ?></td>
                                    <td class="align-middle">
                                        <img src="<?= $mark->logoPath() ?>" alt="logo" width="" height="60" class="rounded"/>
                                    </td>
                                    <td class="align-middle font-weight-bold"><?= $mark->getName() ?></td>
                                    <td class="align-middle">
                                        <div class="d-flex float-right">
                                            <a href="?p=admin.mark.edit&id=<?=$mark->getToken()?>" class="btn btn-secondary mx-2">Edit</a>
                                            <form action="?p=admin.mark.delete" method="post">
                                                <button type="submit" name="delete" value="<?=$mark->getId()?>" href="#" class="btn btn-danger">Delete</button>
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
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
                        <h4>Liste des Utilisateurs</h4>
                        <h4>
                            <a href="?p=admin.user.add" class="nav-link link">Ajouter un utilisateur</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Profil</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Adresse</th>
                                    <th>Téléphone</th>
                                    <th>Profession</th>
                                    <th>Statut</th>
                                    <th class="text-right pr-5">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0;foreach ($users ?? [] as $user): ?>
                                    <tr>
                                        <td><?= ++$i ?></td>
                                        <td><img src="<?= file_exists($user->picture()) ? $user->picture() : 'assets/img/avatar/avatar-1.png' ?>"
                                                 class="rounded" width="50" height="50"  alt=""></td>
                                        <td><?= "$user->firstname $user->lastname" ?></td>
                                        <td><?= $user->email ?></td>
                                        <td><?= $user->address ?></td>
                                        <td><?= $user->tel ?></td>
                                        <td><?= $user->job ?></td>
                                        <td><?= $user->active ? 'actif':'inactif' ?></td>
                                        <td>
                                            <div class="d-flex float-right">
                                                <a href="?p=admin.user.profil&id=<?=$user->token?>" class="btn btn-secondary mx-2">Detail</a>
                                                <form action="?p=admin.user.delete" method="post">
                                                    <button type="submit" class="btn btn-danger" name="delete" value="<?=$user->id?>">Delete</button>
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
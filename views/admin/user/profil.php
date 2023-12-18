<?php
 /* @var \App\Models\User $user */ $user = $user ?? ''
?>
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
        <div class="section-body">
            <h2 class="section-title">Hi, <?= $user->firstname ?>!</h2>
            <p class="section-lead">
                Change information about yourself on this page.
            </p>
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image"
                                 src="<?= (file_exists($user->picture())) ? $user->picture() : 'assets/img/avatar/avatar-1.png' ?>"
                                 class="rounded-circle profile-widget-picture"
                            >
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Posts</div>
                                    <div class="profile-widget-item-value">187</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Followers</div>
                                    <div class="profile-widget-item-value">6,8K</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Following</div>
                                    <div class="profile-widget-item-value">2,1K</div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name"><?= $user->name ?> <div class="text-muted d-inline font-weight-normal"><div class="slash"></div> <?= $user->job ?></div></div>
                            <?= $user->about ?><br/>
                        </div>
                        <div class="card-footer text-center">
                            <?php if(file_exists($user->doc())) :?>
                                <a href="<?= $user->doc() ?>" class="link nav-link">Voir de document</a>
                            <?php endif; ?>
                            <div class="font-weight-bold mb-2">Follow <?= $user->name ?> On</div>
                            <a href="#" class="btn btn-social-icon btn-facebook mr-1">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-social-icon btn-success mr-1">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="#" class="btn btn-social-icon btn-github mr-1">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="#" class="btn btn-social-icon btn-instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <form action="?p=admin.user.update" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <div class="card-header">
                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger"><?= $error ?></div>
                                <?php endif; ?>
                                <h4>Formulaire de Modification d'un Utilisateur</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?= /* @var \Class\Form $form */
                                    $form->inputField('firstname', values: $user->firstname ?? '', label: 'Prénom', required: 'required', class: 'col-md-6') ?>
                                    <?= $form->inputField('lastname', values: $user->lastname ?? '', label: 'Nom', required: 'required', class: 'col-md-6') ?>
                                </div>
                                <div class="row">
                                    <?= $form->inputField('tel', 'number', $user->tel ?? '', 'Téléphone', required: 'required', class: 'col') ?>
                                    <?= $form->inputField('address', 'text',$user->address ?? '' ,'Adresse', required: 'required', class: 'col') ?>
                                    <?= $form->inputField('job', 'text',$user->job ?? '' ,'Profession', required: 'required', class: 'col') ?>
                                </div>
                                <div class="form-group row mt-3 mb-2">
                                    <label for="about" class="col-form-label text-left col-12 mb-2">Description</label>
                                    <div class="col-sm-12">
                                        <textarea id="about" name="about" class="summernote"><?= $user->about ?? '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button name="edit" value="<?= $user->id ?? ''?>" type="submit" class="btn btn-primary">Modifier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

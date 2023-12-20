<?php
 /* @var App\Models\User $user */
 /* @var Class\Form $form */

use App\Controllers\Admin\UserController as UC;

?>
<!-- Main Content -->
 <div class="main-content">
    <section class="section">
        <!-- Profil header start -->
        <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="?p=admin.dashboard">Dashboard</a></div>
                <div class="breadcrumb-item">Profile</div>
            </div>
        </div>
        <!-- Profil header end -->

        <!-- Profil body start -->
        <div class="section-body">

            <!-- Profil body title start -->
            <h2 class="section-title">Hi, <?= $user->getFirstname() ?>!</h2>
            <p class="section-lead">
                Change information about yourself on this page.
            </p>
            <?php if (isset($success, $message) && $success) : ?>
            <div class="alert alert-success"> <?= $message ?></div>
            <?php endif; ?>
            <!-- Profil body title end -->

            <!-- Profil row start -->
            <div class="row mt-sm-4">
                <!-- Profil left row start -->
                <div class="col-12 col-md-12 col-lg-5">
                    <!-- profil widget card start -->
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
                            <div class="profile-widget-name">
                                <?= $user->name() ?>
                                <div class="text-muted d-inline font-weight-normal">
                                    <div class="slash"></div><?= $user->getJob() ?>
                                </div>
                            </div>
                            <?= $user->getAbout() ?>
                            <br/>
                        </div>
                        <div class="card-footer text-center">
                            <?php if(file_exists($user->doc())) :?>
                                <a target="_blank" href="<?= $user->doc() ?>" class="link nav-link">Voir de document</a>
                            <?php endif; ?>
                            <div class="font-weight-bold mb-2">Follow <?= $user->name() ?> On</div>
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
                    <!-- profil widget card end -->
                    <!-- Reset Password card start -->
                    <div class="card card-primary" id="reset_pass">
                        <div class="card-body">
                            <h2 class="section-title">Changer son mot de passe</h2>
                            <?php if (isset($error, $message) and $error == UC::ERROR_RESET_PASS) : ?>
                            <p class="section-lead text-danger"> <?= $message ?></p>
                            <?php endif; ?>
                            <form action="?p=admin.user.reset_pass" method="post" class="needs-validation mt-3" novalidate>
                                <?= $form->inputField('old_pass', 'password', label: 'Ancien mot de passe', required: 'required'); ?>
                                <?= $form->inputField('new_pass', 'password', label: 'Nouveau mot de passe', required: 'required') ?>
                                <?= $form->inputField('re_new_pass', 'password', label: 'Confirmer mot de passe', required: 'required') ?>
                                <div class="form-group gap-lg-3">
                                    <button class="btn btn-danger" type="reset" >
                                        Annuler
                                    </button>
                                    <button class="btn btn-primary" type="submit" value="<?=$user->getId()?>" name="reset_pass">
                                        Modifier mot de passe
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Reset password card end -->
                </div>
                <!-- Profil left row end -->

                <!-- Profil right row start -->
                <div class="col-12 col-md-12 col-lg-7">
                    <!-- Profil picture change files card start -->
                    <div class="card card-primary" id="change_profil_picture">
                        <div class="card-body">
                            <h2 class="section-title mt-0">Changer son image de profil</h2>
                            <?php if (isset($error, $message) && $error == UC::ERROR_CHANGE_PICTURE ) : ?>
                                <p class="section-lead text-danger"> <?= $message ?></p>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <img alt="image de profil"
                                         src="<?= (file_exists($user->picture())) ? $user->picture() : 'assets/img/avatar/avatar-1.png' ?>"
                                         class="rounded profile-widget-picture" width="120" height="120" >
                                </div>
                                <div class="col-md-8">
                                    <form action="?p=admin.user.changeFile" method="post" enctype="multipart/form-data" class="needs-validation mt-3" novalidate>
                                        <?= $form->fileField('picture', 'Image de profil'); ?>
                                        <div class="form-group mt-4">
                                            <button class="btn btn-primary" type="submit" value="<?=$user->getId()?>" name="change_file">
                                                Modifier Image
                                            </button><!-- reset profil image button -->
                                            <button class="btn btn-danger" type="submit" value="<?=$user->getId()?>" name="del_file">
                                                <i class="fas fa-trash"></i> Supprimer Image
                                            </button><!-- edit profil image button -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Profil picture change card end -->

                    <!-- Profil document change files card start -->
                    <div class="card card-primary" id="change_profil_doc">
                        <div class="card-body">
                            <h2 class="section-title mt-0">Changer son document de profil</h2>
                            <?php if (isset($error, $message) and $error == UC::ERROR_CHANGE_DOC) : ?>
                                <p class="section-lead text-danger"> <?= $message ?></p>
                            <?php endif; ?>
                            <form action="?p=admin.user.changeFile" method="post" class="needs-validation mt-3" enctype="multipart/form-data" novalidate>
                                <?= $form->fileField('doc', 'Document de profil'); ?>
                                <div class="form-group mt-4">
                                    <button class="btn btn-primary" type="submit" value="<?=$user->getId()?>" name="change_file">
                                        Modifier Document de profil
                                    </button>
                                    <button class="btn btn-danger" type="submit" value="<?=$user->getId()?>" name="del_file">
                                        <i class="fas fa-trash"></i> Supprimer Document
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Profil document change card end -->

                    <!-- Profil settings card start -->
                    <div class="card">
                        <form action="?p=admin.user.update" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <div class="card-header">
                                <h4 class="section-title mt-2">Formulaire de Modification d'un Utilisateur</h4>
                                <?php if (isset($error, $message) && $error == UC::ERROR_USER_EDIT): ?>
                                    <div class="section-lead text-danger"><?= $message ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?= $form->inputField('firstname', values: $user->getFirstname() ?? '', label: 'Prénom', required: 'required', class: 'col-md-6') ?>
                                    <?= $form->inputField('lastname', values: $user->getLastname() ?? '', label: 'Nom', required: 'required', class: 'col-md-6') ?>
                                </div>
                                <div class="row">
                                    <?= $form->inputField('tel', 'number', $user->getTel() ?? '', 'Téléphone', required: 'required', class: 'col') ?>
                                    <?= $form->inputField('address', 'text',$user->getAddress() ?? '' ,'Adresse', required: 'required', class: 'col') ?>
                                    <?= $form->inputField('job', 'text',$user->getJob() ?? '' ,'Profession', required: 'required', class: 'col') ?>
                                </div>
                                <div class="form-group row mt-3 mb-2">
                                    <label for="about" class="col-form-label text-left col-12 mb-2">Description</label>
                                    <div class="col-sm-12">
                                        <textarea id="about" name="about" class="summernote"><?= $user->getAbout() ?? '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button name="edit" value="<?= $user->getId() ?? ''?>" type="submit" class="btn btn-primary">Modifier</button>
                            </div>
                        </form>
                    </div>
                    <!-- Profil settings card end -->

                </div>
                <!-- Profil right row end -->
            </div>
            <!-- Profil row end -->
        </div>
        <!-- Profil body end -->
    </section>
</div>
<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <!-- Logo start -->
                <div class="login-brand">
                    <img src="assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
                </div>
                <!--  Logo end -->

                <!-- Compte activation compte card start -->
                <div class="card <?= (isset($error)) ? 'card-danger' : 'card-primary' ?>">
                    <div class="card-body">
                        <h4 class="section-title">Activation de compte</h4>
                        <p class="section-lead">
                            Vous-y êtes presque !<br/>Veuillez saisir le code à 10 chiffre envoyé à votre compte
                            email <?= substr_replace($_SESSION['user']['email'], "********",  0, strlen($_SESSION['user']['email'])-12 ) ?>
                        </p>

                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="POST" action="?p=auth.activate" class="needs-validation mt-3" novalidate="">
                            <div class="form-group">
                                <div class="d-block">
                                    <label for="code" class="control-label">Code</label>
                                    <div class="float-right">
                                        <a href="" class="text-small">
                                            Changer mon compte d'activation!
                                        </a>
                                    </div>
                                </div>
                                <input id="code" type="number" class="form-control" name="code" tabindex="2" required>
                                <div class="invalid-feedback">
                                    please fill the activation code
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="activate" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                    Activer votre compte
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Compte activation compte card end -->

                <!-- Auth footer start -->
                <div class="simple-footer">
                    Copyright &copy; Edem Claude K. 2023
                </div>
                <!-- Auth footer end -->
            </div>
        </div>
    </div>
</section>
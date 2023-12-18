<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="login-brand">
                    <img src="assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
                </div>
                <div class="card card-primary">
                    <div class="card-header"><h4>Login</h4></div>
                    <?php  if (isset($error)) : ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <div class="card-body">
                        <form method="POST" action="?p=auth.log" class="needs-validation" novalidate="">
                            <?= /* @var \Class\Form $form */ $form->inputField('login', 'text', required: "required"); ?>
                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label">Password</label>
                                    <div class="float-right">
                                        <a href="" class="text-small">
                                            Forgot Password?
                                        </a>
                                    </div>
                                </div>
                                <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                                <div class="invalid-feedback">
                                    please fill in your password
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="log" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="simple-footer">
                    Copyright &copy; Edem Claude K. 2023
                </div>
            </div>
        </div>
    </div>
</section>
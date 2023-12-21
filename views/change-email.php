<?php /* @var Class\Form $form */ ?>
<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <!-- Logo start -->
                <div class="login-brand">
                    <img src="assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
                </div>
                <!--  Logo end -->

                <!-- Change email card start -->
                <div class="card <?= (isset($error)) ? 'card-danger' : 'card-primary' ?>">
                    <div class="card-body">
                        <h4 class="section-title">Changer son adresse mail</h4>
                        <p class="section-lead"> </p>
                        <form method="POST" action="?p=auth.change_mail" class="needs-validation mt-3" novalidate="">
                            <?= $form->inputField('email', 'email', required: 'required') ?>
                            <div class="form-group">
                                <button type="submit" name="change_mail" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                    Changer votre adresse mail
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Change email card end -->

                <!-- Auth footer start -->
                <div class="simple-footer">
                    Copyright &copy; Edem Claude K. 2023
                </div>
                <!-- Auth footer end -->
            </div>
        </div>
    </div>
</section>
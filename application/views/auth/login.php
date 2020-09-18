<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

            <div class="login-logo">
                <!-- Brand Logo -->
                <div class="row d-flex justify-content-center">
                    <a href="<?= base_url() ?>" class="brand-link p-0 pt-2" id="login-brand-logo">
                        <div class="media m-0 p-0">
                            <img src="<?php echo base_url($dist_dir . '/img/ksu_logo.png'); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"style="opacity: .8">
                            <div class="media-body text-left m-0 p-0">
                                <h2 class="brand-text text-light text-left text-md text-bold text-uppercase">Kogi State University</h2>
                                <p class="brand-text text-light text-md text-uppercase">Assessment Portal</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
             <!-- /.login-logo -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-bold">
                        Login
                    </h3>
                </div>
                <div class="card-body login-card-body">
                    <form action="<?php echo base_url('auth/login_data'); ?>" method="post" class="ajax_submit" >
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="<?php echo lang('auth_your_email'); ?>" name="identity">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="<?php echo lang('auth_your_password'); ?>" name="password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-7">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember" name="remember">
                                    <label for="remember">
                                        <?php echo lang('auth_remember_me'); ?>
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-5">
                                <button type="submit" class="btn btn-primary btn-block ajax_button"><?php echo lang('auth_login'); ?></button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                </div>
                <!-- /.login-card-body -->
                <div class="card-footer">
<?php if ($auth_social_network == TRUE): ?>
                        <div class="social-auth-links text-center mb-3">
                            <p>- <?php echo lang('auth_or'); ?> -</p>
                                <a href="#" class="btn btn-block btn-primary">
                            <i class="fab fa-facebook mr-2"></i> <?php echo lang('auth_sign_facebook'); ?>
                            </a>
                            <a href="#" class="btn btn-block btn-danger">
                                <i class="fab fa-google-plus mr-2"></i> <?php echo lang('auth_sign_google'); ?>
                            </a>
                        </div>
                    <!-- /.social-auth-links -->
<?php endif; ?>
<?php if ($forgot_password == TRUE): ?>
                    <p class="mb-1">
                        <a href="<?php echo base_url() ?>auth/forgot_password">I forgot my password</a>
                    </p>
<?php endif; ?>
<?php if ($new_membership == TRUE): ?>
                    <p class="mb-0">
                        <a href="<?php echo base_url() ?>auth/register" class="text-center">Register</a>
                    </p>
<?php endif; ?>

                </div>
            </div>

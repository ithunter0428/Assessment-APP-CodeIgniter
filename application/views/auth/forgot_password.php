
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
<!-- /.login-logo -->
<div class="card">
      <div class="card-body login-card-body">
            <p class="login-box-msg"><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>

            <div id="infoMessage"><?php echo $message;?></div>

            <form action="<?php echo base_url('auth/forgot_password')?>" method="post">
                  <div class="input-group mb-3">
                        <!-- <input type="email" class="form-control" placeholder="Email"> -->
                        <?php echo form_input($email);?>
                        <div class="input-group-append">
                              <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                              </div>
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-12">
                              <button type="submit" class="btn btn-primary btn-block">Request new password</button>
                        </div>
                        <!-- /.col -->
                  </div>
            </form>

            <p class="mt-3 mb-1">
                  <a href="<?= base_url() ?>auth/login">Login</a>
            </p>
            <p class="mb-0">
                  <a href="<?= base_url() ?>auth/register" class="text-center">Register</a>
            </p>
      </div>
      <!-- /.login-card-body -->
</div>
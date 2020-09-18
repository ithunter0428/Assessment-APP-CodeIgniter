<div class="login-logo">
      <a href="<?php echo base_url(); ?>"><b>Admin</b><?php echo $title_lg; ?></a>
</div>

<div class="card">
      <div class="card-body register-card-body">
            <p class="login-box-msg" ><?php echo lang('create_user_subheading');?></p>
            
            <?php echo form_open("auth/create_user_data",['class' => 'ajax_submit']);?>
            
                  <div class="input-group mb-3">
                        <?php echo form_input($first_name);?>
                        <div class="input-group-append">
                              <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                              </div>
                        </div>
                  </div>
            
                  <div class="input-group mb-3">
                        <?php echo form_input($last_name);?>
                        <div class="input-group-append">
                              <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                              </div>
                        </div>
                  </div>
            
                  <div class="input-group mb-3">
                        <?php echo form_input($company);?>
                        <div class="input-group-append">
                              <div class="input-group-text">
                                    <span class="fas fa-university"></span>
                              </div>
                        </div>
                  </div>
            
                  <div class="input-group mb-3">
                        <?php echo form_input($email);?>
                        <div class="input-group-append">
                              <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                              </div>
                        </div>
                  </div>
            
                  <div class="input-group mb-3">
                        <?php echo form_input($phone);?>
                        <div class="input-group-append">
                              <div class="input-group-text">
                                    <span class="fas fa-phone"></span>
                              </div>
                        </div>
                  </div>
            
                  <div class="input-group mb-3">
                        <?php echo form_input($password);?>
                        <div class="input-group-append">
                              <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                              </div>
                        </div>
                  </div>
            
                  <div class="input-group mb-3">
                        <?php echo form_input($password_confirm);?>
                        <div class="input-group-append">
                              <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                              </div>
                        </div>
                  </div>
            
                  <div class="row">
                        <div class="col-5">
                              <button type="submit" class="ajax_button btn btn-primary btn-block ">
                                    <?php echo lang('create_user_submit_btn') ?>
                              </button>
                        </div>
                  </div>
            
            <?php echo form_close();?>

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

      </div>
</div>

            

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

                <!-- /.content-wrapper -->
                <footer class="main-footer">
                        <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
                        All rights reserved.
                        <div class="float-right d-none d-sm-inline-block">
                                <?php echo lang('footer_version'); ?> Development
                        </div>
                        <strong><?php echo lang('footer_copyright'); ?> &copy; 2014-<?php echo date('Y'); ?> <a href="http://almsaeedstudio.com" target="_blank">Almsaeed Studio</a> &amp; <a href="https://domprojects.com" target="_blank">domProjects</a>.</strong> <?php echo lang('footer_all_rights_reserved'); ?>.
                </footer>

                <!-- Control Sidebar -->
                <aside class="control-sidebar control-sidebar-dark">
                        <!-- Control sidebar content goes here -->
                </aside>
                <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="<?php echo base_url($plugins_dir . '/jquery/jquery.min.js'); ?>"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="<?php echo base_url($plugins_dir . '/jquery-ui/jquery-ui.min.js'); ?>"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
                $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script src="<?php echo base_url($plugins_dir . '/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
        <!-- Toastr -->
        <script src="<?php echo base_url($plugins_dir . '/toastr/toastr.min.js'); ?>"></script>
        <!-- ChartJS -->
        <script src="<?php echo base_url($plugins_dir . '/chart.js/Chart.min.js'); ?>"></script>
        <!-- overlayScrollbars -->
        <script src="<?php echo base_url($plugins_dir . '/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); ?>"></script>
        <!-- DataTables -->
        <script src="<?php echo base_url($plugins_dir . '/datatables/jquery.dataTables.js'); ?>"></script>
        <script src="<?php echo base_url($plugins_dir . '/datatables-bs4/js/dataTables.bootstrap4.js'); ?>"></script>

<?php if ($mobile == TRUE): ?>
        <script src="<?php echo base_url($plugins_dir . '/fastclick/fastclick.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($admin_prefs['transition_page'] == TRUE): ?>
        <script src="<?php echo base_url($plugins_dir . '/animsition/animsition.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->router->fetch_class() == 'users' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
        <script src="<?php echo base_url($plugins_dir . '/pwstrength/pwstrength.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->router->fetch_class() == 'groups' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
        <script src="<?php echo base_url($plugins_dir . '/tinycolor/tinycolor.min.js'); ?>"></script>
        <script src="<?php echo base_url($plugins_dir . '/colorpickersliders/colorpickersliders.min.js'); ?>"></script>
<?php endif; ?>
        
        <!-- AdminLTE App -->
        <script src="<?php echo base_url($dist_dir . '/js/adminlte.js'); ?>"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url($dist_dir . '/js/demo.js'); ?>"></script>
        <!-- Main Script -->
        <script src="<?php echo base_url($frameworks_dir . '/public/js/script.js'); ?>"></script>

    </body>
</html>
<!-- jQuery -->
<script src="<?php echo ASSETURL . 'plugins/jquery/jquery.min.js'; ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo ASSETURL . 'plugins/jquery-ui/jquery-ui.min.js'; ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo ASSETURL . 'plugins/bootstrap/js/bootstrap.bundle.min.js'; ?>"></script>
<!-- ChartJS -->
<script src="<?php echo ASSETURL . 'plugins/chart.js/Chart.min.js'; ?>"></script>
<!-- Sparkline -->
<script src="<?php echo ASSETURL . 'plugins/sparklines/sparkline.js'; ?>"></script>
<!-- JQVMap -->
<script src="<?php echo ASSETURL . 'plugins/jqvmap/jquery.vmap.min.js'; ?>"></script>
<script src="<?php echo ASSETURL . 'plugins/jqvmap/maps/jquery.vmap.usa.js'; ?>"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo ASSETURL . 'plugins/jquery-knob/jquery.knob.min.js'; ?>"></script>
<!-- daterangepicker -->
<script src="<?php echo ASSETURL . 'plugins/moment/moment.min.js'; ?>"></script>
<script src="<?php echo ASSETURL . 'plugins/daterangepicker/daterangepicker.js'; ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo ASSETURL . 'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'; ?>"></script>
<!-- Summernote -->
<script src="<?php echo ASSETURL . 'plugins/summernote/summernote-bs4.min.js'; ?>"></script>
<!-- overlayScrollbars -->
<script src="<?php echo ASSETURL . 'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'; ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo ASSETURL . 'dist/js/adminlte.js?v=3.2.0'; ?>"></script>
<!-- Bootstrap tags -->
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<!-- Dropzone -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<!-- Chosen -->
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<!-- Magnifix Popup -->
<script src="<?php echo ASSETURL . 'plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js'; ?>"></script>
<!-- manifest JS -->
<script src="<?php echo ASSETURL . 'js/manifest.js'; ?>"></script>
<!-- Clipboard -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="<?php echo ASSETURL . 'plugins/popper/umd/popper.min.js'; ?>"></script>
<!-- Bootstrap -->
<script src="<?php echo ASSETURL . 'plugins/bootstrap/js/bootstrap.min.js'; ?>"></script>
<!--stickey kit -->
<script src="<?php echo ASSETURL . 'plugins/sticky-kit-master/sticky-kit.min.js'; ?>"></script>
<script src="<?php echo ASSETURL . 'plugins/toastr/toastr.min.js'; ?>"></script>
<script src="<?php echo ASSETURL . 'plugins/sweetalert/sweetalert.min.js'; ?>"></script>
<script src="<?php echo ASSETURL . 'plugins/moment/moment.min.js'; ?>"></script>
<script src="<?php echo ASSETURL . 'plugins/daterangepicker/daterangepicker.js'; ?>"></script>
<script src="<?php echo ASSETURL . 'plugins/clipboard/clipboard.min.js'; ?>"></script>
<script src="<?php echo ASSETURL . 'plugins/select2/js/select2.min.js'; ?>"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="<?php echo ASSETURL . 'js/jquery.slimscroll.js'; ?>"></script>
<!-- custom JS -->
<script src="<?php echo ASSETURL . 'js/script.js'; ?>"></script>
<!-- DataTables -->
<script type="text/javascript" src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
<!-- Calendar -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<!-- Chart JS -->
<script type="text/javascript" src="https://adminlte.io/themes/v3/plugins/chart.js/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<?php if ($this->uri->segment(1) == "dashboard") { ?>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.3/angular.min.js"></script>
<?php } ?>

<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"94649c5efac7c7aa","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"version":"2025.4.0-1-g37f21b1","token":"2437d112162f4ec4b63c3ca0eb38fb20"}' crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/node-waves/0.5.3/waves.min.js" integrity="sha512-X55hOdevOe9o6meBWUdyPeWhv7F0zPBTMayKW0e+wiqXBLa/AoQ8/pNkbKdPr1RHbjoIjBH+yKo3YW5oFUgQRA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    function alertbox(heading, message, type) {
        if (type == 'success') {
            toastr.success(message);
        }
        if (type == 'error') {
            toastr.error(message);
        }
        if (type == 'warning') {
            toastr.warning(message);
        }
    }
</script>
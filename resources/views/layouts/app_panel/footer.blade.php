<footer class="main-footer">
    <div class="footer-left">
      Copyright &copy; {{date('Y')}} <div class="bullet"></div> Template By <a href="https://nauval.in/">Stisla</a> <div class="bullet"></div> {{$site->site_name ?? 'TheightDev | E-KEHADIRAN.'}}
    </div>
    <div class="footer-right">
      Version 0.0.1
    </div>
  </footer>
</div>
</div>

<!-- General JS Scripts -->
<script src="{{asset('admin_template/dist')}}/assets/modules/jquery.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/popper.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/tooltip.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/bootstrap/js/bootstrap.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/moment.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/js/stisla.js"></script>

<!-- JS Libraies -->
<script src="{{asset('admin_template/dist')}}/assets/modules/jquery.sparkline.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/chart.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/summernote/summernote-bs4.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/datatables/datatables.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/jquery-ui/jquery-ui.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/cleave-js/dist/cleave.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/cleave-js/dist/addons/cleave-phone.us.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/jquery-pwstrength/jquery.pwstrength.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/select2/dist/js/select2.full.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

<!-- Page Specific JS File -->
<script src="{{asset('admin_template/dist')}}assets/js/page/forms-advanced-forms.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/js/page/modules-datatables.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/js/page/index.js"></script>

<!-- Template JS File -->
<script src="{{asset('admin_template/dist')}}/assets/js/scripts.js"></script>
<script src="{{asset('admin_template/dist')}}/assets/js/custom.js"></script>

<script>
  $(document).ready(function() {
    setTimeout(function() {
        $('.splash-screen').fadeOut();
    }, 900);
    setTimeout(function() {
        $('.alert').fadeOut('fast');
    }, 5500); // <-- time in milliseconds
  });
</script>
@stack('scripts')
</body>
</html>
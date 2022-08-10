<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $config->siteName ?> | <?= $config->pageTitle ?></title>

    <!-- plugins:css -->
    <!--link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css"-->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css">
    
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- Page Specific Plugins -->
    <?php
        if (@$plugins) {
            foreach ($plugins as $plugin) {
              ?>
                <?= $this->include('plugins/'.$plugin.'/style.php') ?>
              <?php
            }
        }
    ?>
    <!-- End Page Specific Plugins -->
    <!--link rel="stylesheet" href="/assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">    <link rel="stylesheet" href="/assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/vendors/owl-carousel-2/owl.theme.default.min.css"-->
    <!-- End plugin css for this page -->

    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/modern-vertical/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/favicon.ico" />
  </head>

  <body>
    <div class="container-scroller">

    <?php if (isset($banner)) { ?>
    <?= $this->include('admin/dashboard/widgets/banner') ?>
    <?php } ?>

    <?= $this->include('layout/'.$theme.'/menu/'.$sidebar.'/sidebar') ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
      <?= $this->include('admin/dashboard/partials/navbar') ?>

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <?php
             $session = \Config\Services::session();
             $this->error = $session->get('errors') ?? NULL;
              if ( $this->error ) {
                //dd($error);
            ?>
            <?= $this->include('admin/dashboard/partials/errorbanner') ?>
            <?php
              }
            ?>

<?= $this->renderSection('main') ?>

</div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block"><?= getCopyright() ?></span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> <!-- footer right message --></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
        <!-- Page Specific Plugins -->
<?php
    if (@$plugins) {
        foreach ($plugins as $plugin) {
?>
    <?= $this->include('admin/dashboard/plugins/'.$plugin.'/js.php') ?>
<?php
        }
    }
?>

    <!-- End Page Specific Plugins -->
    <script src="/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="/assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <script src="/assets/js/jquery.cookie.js" type="text/javascript"></script>



    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/hoverable-collapse.js"></script>
    <script src="/assets/js/misc.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="/assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->

    

  </body>
</html>

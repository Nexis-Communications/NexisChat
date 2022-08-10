<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Nexis">
  <link rel="icon" href="/favicon.ico">

  <title>The Park Chat<?= ($config->pageTitle) ? ' | ' . $config->pageTitle:'' ?></title>

  <!-- Bootstrap core CSS -->
  <link href="https://bootstrapbuildspace.sfo2.cdn.digitaloceanspaces.com//TMaMyMrlnsMn/oTSyrHrTRWMH/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Cookie Consent CSS -->
  <link href="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@v2.7.1/dist/cookieconsent.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="https://bootstrapbuildspace.sfo2.cdn.digitaloceanspaces.com//TMaMyMrlnsMn/oTSyrHrTRWMH/bootstrap.min.css" rel="stylesheet">
  
  <?= $this->renderSection('pageStyles') ?>
</head>

<body class="d-flex flex-column min-vh-100">
<!-- Load Messenger Plugin-->
<?= view('plugins/fb-messenger/main') ?>

<div class="header">
    <?= view('Views\_navbar') ?>
</div>

<main role="main" class="container flex-grow-1 pt-3">
<?php 
$hasError = session()->get('error');
$hasMessage = session()->get('message');
?>
<?php if ($hasMessage) { 
           /*
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <p><?= $message ?></p>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
         */ } ?>
              
      <?php if ($hasError) { ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
<?php if (is_array($hasError)) { ?>
    <?php print_r('reCaptcha: ' . $hasError['reCaptcha3']) ?>
<?php } else { ?>
        <?= $hasError ?>
<?php  } ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php } ?>

  <?= $this->renderSection('main') ?>
</main> <!-- ./main-container -->

<footer class="footer pt-1">
  <div class="col">
    <p><?= getCopyright() ?></p>
  </div>
</footer>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> 
<script>window.jQuery || document.write('<script src="https://code.jquery.com/jquery-3.5.1.slim.js" integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM=" crossorigin="anonymous"><\/script>')</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script defer src="https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@v2.7.1/dist/cookieconsent.js"></script>


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-6GW8Y4K4H4" data-cookiecategory="analytics"></script>


<script type="text/plain" data-cookiecategory="analytics">
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-6GW8Y4K4H4');
</script>

<script defer src="/js/cookieconsent-init.js"></script>

<?= $this->renderSection('pageScripts') ?>
</body>
</html>

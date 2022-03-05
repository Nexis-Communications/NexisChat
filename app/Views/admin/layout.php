<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Nexis">
    <link rel="icon" href="/favicon.ico">

    <title>The Park Chat<?= ($pageTitle) ? ' | ' . $pageTitle:'' ?></title>

    <!-- Bootstrap core CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css">


    <!-- Custom styles for this template -->
    <link href="/css/cover.css" rel="stylesheet">
    <link href="/css/admin.css" rel="stylesheet">

    
    <?= $this->renderSection('pageStyles') ?>
</head>

<body class="d-flex flex-column min-vh-100">


    <?= view('Views/admin/_sidebar') ?>



       	<main role="main" class="container flex-grow-1">
        <div class="header">

    <?= view('Views\_navbar') ?>
</div>
        <div class="content">
			<?= $this->renderSection('main') ?>
        </div>

        <footer class="footer mt-auto fixed-bottom">
          <div class="col">
            <p>Copyright &copy; Y2K21 Nexis Communications. <br class="responsive d-md-none" />All Rights Reserved. </p>
          </div>
        </footer>
		</main> <!-- ./main-container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> 
<script>window.jQuery || document.write('<script src="https://code.jquery.com/jquery-3.5.1.slim.js" integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM=" crossorigin="anonymous"><\/script>')</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-6GW8Y4K4H4"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-6GW8Y4K4H4');
</script>

<?= $this->renderSection('pageScripts') ?>
</body>
</html>

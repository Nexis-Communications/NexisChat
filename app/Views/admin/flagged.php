<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Nexis">
    <link rel="icon" href="/favicon.ico">

    <title>The Park Chat | Flagged Messages</title>

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



    <!-- Custom styles for this template -->
    <link href="/css/cover.css" rel="stylesheet">
  </head>

  <body>
    <div class="container ">
      <div class="header">
      <nav>
          <ul class="nav nav-pills float-right">
            <li class="nav-item">
              <a class="nav-link active" href="/" style="background-color: rgb(36, 36, 36);">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/login">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/contact">Contact</a>
            </li>
          </ul>
        </nav>
        <h3 class="">The Park Chat</h3>
      </div>
     

      <a href="/admin/flagged">Flagged Messages</a>

      <table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">Action</th>
      <th scope="col">Reported User</th>
      <th scope="col">Handle</th>
      <th scope="col">Room</th>
      <th scope="col">Message</th>
      <th scope="col">Reporter</th>
      <th scope="col">Report Time</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($flaggedMessages as $message) { ?>
    <tr>
      <th scope="row">
        <button type="button" class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Open">
          <i class="fa fa-file"></i>
        </button>
        <button type="button" class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Delete">
          <i class="fa fa-trash"></i>
        </button>
      </th>
      <td><?= $message['sus_user'] ?></td>
      <td><?= $message['sus_handle'] ?></td>
      <td><?= $message['sus_room'] ?></td>
      <td><?= $message['sus_message'] ?></td>
      <td><?= $message['rp_user'] ?></td>
      <td><?= $message['rt'] ?> </td>
    </tr>
<?php } ?>
  </tbody>
</table>

      <div class="row">
        <footer class="footer mt-auto fixed-bottom">
          <div class="col">
            <p>Copyright &copy; Y2K21 Nexis Communications. All Rights Reserved. </p>
          </div>
        </footer>
      </div>
    </div>


  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> 
    <script>window.jQuery || document.write('<script src="https://code.jquery.com/jquery-3.5.1.slim.js"
          integrity="sha256-DrT5NfxfbHvMHux31Lkhxg42LY6of8TaYyK50jnxRnM="
          crossorigin="anonymous"><\/script>')</script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-6GW8Y4K4H4"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-6GW8Y4K4H4');
  </script>

  </body>
</html>


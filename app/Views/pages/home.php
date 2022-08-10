<?= $this->extend('layout/layout') ?>
<?= $this->section('main') ?>
     
      <div class="jumbotron " style="background:transparent !important">
        <h1 class="display-3">Nostalgic 90's Chat</h1>
        <p class="lead">Tired of all the groups, snaps, insta's, tweets, dms, and want to get back to the nostalgic 90's chat rooms?</p>
        <p>Enjoy a taste of the 90's! Chat with others around the globe in a 90's style chat. Choose a handle and message everyone or send private messages!</p>
        <p><a class="btn btn-lg btn-success" href="/<?= ($loggedin) ? 'chat/lobby':'register' ?>" role="button"><?= ($loggedin) ? 'Join the lobby!':'Sign up today!' ?></a></p>
      </div>
<div class="row">
  <div class="col-sm-6">
      <div class="card">
  <div class="card-body">
    <h5 class="card-title">Learn More!</h5>
    <h6 class="card-subtitle mb-2 text-muted">Curious about theparkchat.com? Contact Us!</h6>
    <p class="card-text">Information is available in our <a href="<?= site_url('support') ?>">Support Page</a>! You can even post a message in the Lobby!</p>
    <a href="//www.facebook.com/theparkchat" target="_new" class="card-link">Facebook</a>
    <a href="//www.twitter.com/theparkchat" target="_new" class="card-link">Twitter</a>
  </div>
</div>
</div>
<div class="col-sm-6">

<div class="card" >
  <div class="card-body">
    <h5 class="card-title">Lifetime VIP!</h5>
    <h6 class="card-subtitle mb-2 text-muted">Available for a limited time!</h6>
    <p class="card-text">As a special thanks to our visitors, we're giving away Lifetime VIP memberships to our first 200 registered visitors!</p>
    <a href="<?= site_url('register') ?>" target="_new" class="card-link">Register Today!</a>
  </div>
</div>
</div>
</div>

<?= $this->endSection() ?>

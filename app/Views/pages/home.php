<?= $this->extend('layout/layout') ?>
<?= $this->section('main') ?>
     
      <div class="jumbotron " style="background:transparent !important">
        <h1 class="display-3">Nostalgic 90's Chat</h1>
        <p class="lead">Tired of all the groups, snaps, insta's, tweets, dms, and want to get back to the nostalgic 90's chat rooms?</p>
        <p>Enjoy a taste of the 90's! Chat with others around the globe in a 90's style chat. Choose a handle and message everyone or send private messages!</p>
        <p>Please be aware that it's under construction at this time while we work on adding additional features and making tweaks. Please contact us if you have any issues, comments or requests.</p>
        <p><a class="btn btn-lg btn-success" href="/<?= ($loggedin) ? 'chat/lobby':'register' ?>" role="button"><?= ($loggedin) ? 'Join the lobby!':'Sign up today!' ?></a></p>
      </div>

<?= $this->endSection() ?>

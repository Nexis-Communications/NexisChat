<?= $this->extend('layout/layout') ?>
<?= $this->section('main') ?>

<?php 
$hasError = session()->get('error');
$hasMessage = session()->get('message');

?>
<div class="container">
<?php if ($hasError) { ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= $hasError ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php } ?>
<?php if ($hasMessage) { ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= $hasMessage ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php } ?>
      <div class="row">
    <h1>View Profile</h1>
  	<hr>
</div>
	<div class="row">
      <!-- left column -->
      <div class="col">
        <div class="card">
          <div class="card-body bg-dark">
            <h5 class="user-name"><?= $user->username ?></h5>
            <h6 class="user-email"><?= $user->email ?></h6>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card">
          <div class="card-body bg-dark">
            <form action="/profile/update" method="POST">
              <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
              <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <h6>Personal Details</h6>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="fullusernameName" name="username" placeholder="Enter Username" value="<?= $user->username ?>">
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?= $user->email ?>">
                  </div>
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <p>You may reset your password by using the <a href="/forgot">Forgot Password</a> form.</p>
                </div>
              <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                  <div class="form-group ">
                    <button type="reset" id="cancel" name="cancel" class="btn btn-secondary">Cancel</button>
                    <button type="submit" id="submit" name="submit" class="btn btn-primary">Update</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div> <!-- ./col -->

      <div class="col">
        <div class="card">
          <div class="card-body bg-dark">
            <form action="/profile/tags" method="POST">
              <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
              <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <h6>Reconnection Keywords</h6>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="form-group">
                    <label for="tags">Keywords</label>
                    <script type="module">
                      import Tags from "/js/tags.min.js";
                      Tags.init();
                      // Tags.init(selector, opts);
                      // You can pass global settings in opts that will apply
                      // to all Tags instances
                    </script>
                    <select class="form-select" id="tags-input" name="tags[]" placeholder="Enter Keywords" multiple data-allow-new="true" data-separator="|," data-allow-clear="true">
<?php
if ($tags) {
  foreach ($tags as $tag) {
?>
                      <option value="<?= $tag ?>" selected="selected"><?= $tag ?></option>
<?php
  }
}
?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                  <div class="form-group ">
                    <button type="reset" id="cancel" name="cancel" class="btn btn-secondary">Cancel</button>
                    <button type="submit" id="submit" name="submit" class="btn btn-primary">Update</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div> <!-- ./col -->

    </div> <!-- ./row -->
</div> <!-- ./container -->
<?= $this->endSection() ?>
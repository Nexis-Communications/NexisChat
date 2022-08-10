<?= $this->extend('admin/dashboard/layout') ?>
<?= $this->section('main') ?>

<?php
  if ($room) {
?>
<div class="row">
  <div class="col grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="card-title">
          <h1><?= getRoomInfo($room)->name ?></h1>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
  }
?>


<div class="row">
  <div class="col-sm-4 grid-margin">
    <?= view('admin/dashboard/widgets/cards/totalmessages') ?>
  </div>
  <div class="col-sm-4 grid-margin">
    <?php
      if ($room) {
    ?>
    <?= view('admin/dashboard/widgets/cards/flaggedMessages') ?>
    <?php
      } else {
    ?>
    <?= view('admin/dashboard/widgets/cards/totalflaggedMessages') ?>
    <?php 
      }
    ?>
  </div>
  <div class="col-sm-4 grid-margin">
    <?= view('admin/dashboard/widgets/cards/messageLookup') ?>
  </div>
</div>
 
<div class="row">
  <div class="col">
    <?= view('admin/dashboard/widgets/tables/flaggedMessages') ?>
  </div>
</div>

<div class="row">
  <div class="col">
    <?= view('admin/dashboard/widgets/tables/latestMessages') ?>
  </div>
</div>


<?= $this->endsection() ?>
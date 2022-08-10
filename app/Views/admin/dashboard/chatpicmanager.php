<?= $this->extend('admin/dashboard/layout') ?>
<?= $this->section('main') ?>



<div class="row">
  <div class="col-sm-4 grid-margin">
    <?= view('admin/dashboard/widgets/cards/totalchatpics') ?>
  </div>
  <div class="col-sm-4 grid-margin">
    <?= view('admin/dashboard/widgets/cards/totalprivatechatpics') ?>
  </div>
  <div class="col-sm-4 grid-margin">
    <?= view('admin/dashboard/widgets/cards/chatpicLookup') ?>
  </div>
</div>
 
<div class="row">
</div>


<?= $this->endsection() ?>
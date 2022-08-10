<?= $this->extend('admin/dashboard/layout') ?>
<?= $this->section('main') ?>



<div class="row">
  <div class="col-sm-4 grid-margin">
    <?= view('admin/dashboard/widgets/cards/chatpics/totalGroups') ?>
  </div>
  <div class="col-sm-4 grid-margin">
  </div>
  <div class="col-sm-4 grid-margin">
  </div>
</div>
 
<div class="row">
    <?= view('admin/dashboard/widgets/tables/chatpics/groupList') ?>
</div>


<?= $this->endsection() ?>
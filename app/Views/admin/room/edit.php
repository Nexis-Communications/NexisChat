<?= $this->extend('admin/layout') ?>
<?= $this->section('main') ?>

<div class="row main-header"> 
  <div class="col-12">
    <h3>Room Editor</h3>
  </div>
</div> <!-- ./row -->
<?php if (session()->get('error')) { ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= session()->get('error') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php } ?>
<?php if (session()->get('message')) { ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->get('message') ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php } ?>
<?php
//print_r($room);
?>
<div class="row">
  <div class="col">
    <form action="/admin/room/edit/<?= $room['id'] ?>" method="POST">
    <input type="hidden"<div class="row gutters">
      <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $room['name'] ?>">
      </div>
      <div class="mb-3">
        <label for="alias" class="form-label">Alias:</label>
        <input type="text" class="form-control" id="alias" name="alias" value="<?= $room['alias'] ?>">
      </div>

      <div class="row gutters mb-2">
                  <div class="col-12">                   
                    <div class="form-group">
                      <label for="group">Group:</label>
                      <select class="form-select" id="group" name="group">
                        <option>Select Group</option>
<?php
$groups = getRoomGroups();                        
foreach ($groups as $group) {
  $selected = null;
  foreach ($room['groups'] as $roomGroup) {
    if ($roomGroup->gid == $group->id) {
      $selected = true;
      //print_r($room['groups']);
    }
    
  }
  ?>
                        <option value="<?= $group->id ?>"<?= ($selected) ? ' selected':'' ?>><?= $group->name ?></option>
<?php
}
?>
                      </select>
                    </div>  <!-- ./form-group -->
                  </div>  <!-- ./col-12 -->
                </div> <!-- ./row gutters -->

      <div class="form-check form-switch mb-3">
        <input class="form-check-input" type="checkbox" id="private" name="private" <?= ($room['private']) ? 'checked':'' ?>>
        <label class="form-check-label" for="private">Private Room</label>
      </div>
      
      <div class="form-check form-switch mb-3">
        <input class="form-check-input" type="checkbox" id="active" name="active" <?= ($room['active']) ? 'checked':'' ?>>
        <label class="form-check-label" for="active">Active</label>
      </div>
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                    <div class="form-group ">
                    <button type="reset" id="reset" name="reset" class="btn btn-primary">Cancel</button>
                    <button type="submit" id="submit" name="submit" class="btn btn-primary">Save</button>
                    </div> <!-- ./form-group -->
                  </div> <!-- ./col-12 -->
                </div> <!-- ./row gutters -->
    </form>
  </div>
</div>


<?= $this->endsection() ?>
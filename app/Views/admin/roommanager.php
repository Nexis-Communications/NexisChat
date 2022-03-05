<?= $this->extend('admin/layout') ?>
<?= $this->section('main') ?>

<div class="row main-header"> 
  <div class="col-12">
    <h3>Room Manager</h3>
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
<div class="row">
  <div class="col-8">
    <div class="row mb-2">
      <div class="col">
        <div class="card bg-dark">
          <div class="card-body">
            <h3 class="card-title">Rooms</h3>
            <div class="card-text">
              <table class="table table-dark">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Groups</th>
                    <th scope="col">Users</th>
                    <th scope="col">Created</th>
                    <th scope="col">Private</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
<?php
foreach ($rooms as $room) {
?>
                  <tr>
                    <th scope="row"><?= $room->id ?></th>
                    <td><?= $room->name ?></td>
                    <td>
<?php
$roomGroups = json_decode($room->roomgroups);

if ($roomGroups) {
  $i = 0;
  foreach ($roomGroups as $group) {
    $i++;
?>
                    <a href="/admin/group/view/<?= $group->gid ?>"><?= getRoomGroup($group->gid)->name ?></a>
<?php
    if ($i != count($roomGroups)) {
      ?>
, 
<?php
    }
  }
} else {
?>
                      None
<?php 
} 
?>
                    </td>
                    <td><?= count($room->currentusers) ?></td>
                    <td><?= $room->created_at ?></td>
                    <td><?= $room->private ?></td>
                    <td>
<?php
switch ($room->active) {
  case 0:
    $color = 'danger';
    $status = lang('Chat.inactiveStatus');
    break;
  case 1:
    $color = 'success';
    $status = lang('Chat.activeStatus');
    break;
  default:
    $color = 'danger';
    $status = lang('Chat.unknownStatus');
}
?>
                      <span class="status text-<?= $color ?>">•</span> <?= $status ?>
                    </td>
                    <td>
                      <a href="/admin/room/edit/<?= $room->id ?>" class="settings" title="" data-toggle="tooltip" data-original-title="Settings"><i class="material-icons"></i></a>
                    </td>
                  </tr>
<?php
}
?>
                </tbody>
              </table>
            </div> <!-- ./card-text -->
          </div> <!-- ./card-body -->
        </div> <!-- ./card -->
      </div> <!-- ./col -->
    </div> <!-- ./row -->

    <div class="row">
      <div class="col">
        <div class="card bg-dark">
          <div class="card-body">
            <h3 class="card-title">Groups</h3>
            <div class="card-text">
              <table class="table table-dark">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
<?php
foreach ($groups as $group) {
?>
                  <tr>
                    <th scope="row"><?= $group->id ?></th>
                    <td><?= $group->name ?></td>
                    <td>
<?php
switch ($group->active) {
  case 0:
    $color = 'danger';
    $status = lang('Chat.inactiveStatus');
    break;
  case 1:
    $color = 'success';
    $status = lang('Chat.activeStatus');
    break;
  default:
    $color = 'danger';
    $status = lang('Chat.unknownStatus');
}
?>
                      <span class="status text-<?= $color ?>">•</span> <?= $status ?>
                    </td>
                    <td>
                      <a href="#" class="settings" title="" data-toggle="tooltip" data-original-title="Settings"><i class="material-icons"></i></a>
                    </td>
                  </tr>
<?php } ?>
                </tbody>
              </table>
              </div> <!-- ./card-text -->
            </div> <!-- ./card-body -->
          </div> <!-- ./card -->
        </div> <!-- ./col -->
      </div> <!-- ./row -->
    </div> <!-- ./col-8 -->
    <div class="col-4">
      <div class="row">
        <div class="col-12">
          <div class="card bg-dark mb-2">
            <div class="card-body">
              <h5 class="card-title">Add Room</h5>
              <form action="/roommanager/addroom" method="POST">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                <div class="row gutters mb-2">
                  <div class="col-12">                   
                    <div class="form-group">
                      <label for="room">Room:</label>
                      <input type="text" class="form-control" id="room" name="room" placeholder="Enter Room">
                    </div>  <!-- ./form-group -->
                  </div>  <!-- ./col-12 -->
                </div> <!-- ./row gutters -->
                <div class="row gutters mb-2">
                  <div class="col-12">                   
                    <div class="form-group">
                      <label for="alias">Alias:</label>
                      <input type="text" class="form-control" id="alias" name="alias" placeholder="Enter Alias">
                    </div>  <!-- ./form-group -->
                  </div>  <!-- ./col-12 -->
                </div> <!-- ./row gutters -->
                <div class="row gutters mb-2">
                  <div class="col-12">                   
                    <div class="form-group">
                      <label for="group">Group:</label>
                      <select class="form-select" id="group" name="group">
                        <option selected>Select group</option>
<?php
$groups = getRoomGroups();                        
foreach ($groups as $group) {
  ?>
                        <option value="<?= $group->id ?>"><?= $group->name ?></option>
<?php
}
?>
                      </select>
                    </div>  <!-- ./form-group -->
                  </div>  <!-- ./col-12 -->
                </div> <!-- ./row gutters -->
                <div class="row gutters">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                    <div class="form-group ">
                      <button type="submit" id="submit" name="submit" class="btn btn-primary">Add Room</button>
                    </div> <!-- ./form-group-->
                  </div> <!-- ./col-12 -->
                </div>  <!-- ./row gutters -->
              </form>
            </div> <!-- ./card-body -->
          </div> <!-- ./card -->
        </div> <!-- ./col-12 -->
      </div> <!-- ./row -->

      <div class="row">
        <div class="col-12">
          <div class="card bg-dark">
            <div class="card-body">
              <h5 class="card-title">Add Group</h5>
              <form action="/roommanager/addgroup" method="POST">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                <div class="row gutters mb-2">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="group">Group:</label>
                      <input type="text" class="form-control" id="group" name="group" placeholder="Enter Group">
                    </div> <!-- ./form-group -->
                  </div> <!-- ./col-12 -->
                </div>  <!-- ./row gutters -->
                <div class="row gutters mb-2">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="alias">Alias:</label>
                      <input type="text" class="form-control" id="alias" name="alias" placeholder="Enter Alias">
                    </div> <!-- ./form-group -->
                  </div> <!-- ./col-12 -->
                </div>  <!-- ./row gutters -->
                <div class="row gutters">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                    <div class="form-group ">
                      <button type="submit" id="submit" name="submit" class="btn btn-primary">Add Group</button>
                    </div> <!-- ./form-group -->
                  </div> <!-- ./col-12 -->
                </div> <!-- ./row gutters -->
              </form>
            </div>  <!-- ./card-body -->
          </div> <!-- ./card -->
        </div> <!-- ./col-12 -->
      </div> <!-- ./row -->

    </div> <!-- ./col-4 -->  
  </div> <!-- ./row -->
      
<?= $this->endsection() ?>
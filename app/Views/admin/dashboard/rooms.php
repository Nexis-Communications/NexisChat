<?= $this->extend('admin/dashboard/layout') ?>
<?= $this->section('main') ?>



            <div class="row">
              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Rooms</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0"><?= getRoomCount() ?></h2>
                        </div>
                        <h6 class="text-muted font-weight-normal">Available Rooms</h6>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-codepen text-primary ms-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>

            <div class="row grid-margin">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Rooms</h4>
                    <p class="card-description">Chat system rooms</p>
                    <div class="table-responsive" >
                    <table class="table" id="data-table"> 
                    <thead>
                    <tr>
                    <th>Name</th>
                      <th>Users</th>
                      <th>Group</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
<?php
foreach ($rooms as $room) {
  ?>
                    <tr>
                    <td><?= $room->name ?></td>
                      <td><?= getRoomUserCount($room->id) ?></td>
                      <td>
<?php 
  foreach (getRoomGroup($room->id) as $group) {
  ?>
                        <a href="/admin/dashboard/group/view/<?= getGroup($group->gid)->alias ?>"><?= getGroup($group->gid)->name ?></a>
<?php 
  } 
?>
                    </td>
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
                        <a href="/admin/dashboard/room/view/<?= $room->id ?>" class="btn btn-outline-primary">View</a>
                      </td>
                    </tr>
                    <?php
}
?>
                    </tbody>
                  </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>




<?= $this->endsection() ?>
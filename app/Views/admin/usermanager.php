<?= $this->extend('admin/layout') ?>
<?= $this->section('main') ?>

<div class="row main-header"> 
<h3>User Manager</h3>
</div>
      
 <table class="table table-dark">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
        <th scope="col">Role</th>
          <th scope="col">Date Joined</th>
        <th scope="col">Last Login</th>
        <th scope="col">Status</th>
        <th scope="col">Current Room</th>
        <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
<?php
foreach ($users as $user) {
?>
      <tr>
      <th scope="row"><?= $user->id ?></th>
      <td><?= $user->username ?></td>
      <td>
<?php
foreach (getUserGroups($user->id) as $groups) {
?>
<?= $groups->description ?>
<?php
}
?>
      </td>
      <td><?= $user->created_at ?></td>
      <td><?= getLastLogin($user->id)['date'] ?> (<?= getLastLogin($user->id)['ip_address'] ?>)</td>
      <td>
<?php
switch (getUserStatus($user->id)->status) {
  case 0:
    $color = 'danger';
    $status = lang('Chat.inactiveStatus');
    break;
  case 1:
    $color = 'success';
    $status = lang('Chat.activeStatus');
    break;
  case 2:
    $color = 'warning';
    $status = lang('Chat.bannedStatus');
    break;
  default:
    $color = 'danger';
    $status = lang('Chat.unknownStatus');
}
?>
<span class="status text-<?= $color ?>">•</span> <?= $status ?>

      </td>
      <td>
<?php
$roomlist = getUserRooms($user->id);
if (!empty($roomlist)) {
  foreach ($roomlist as $room) {
?>
<?= getRoomInfo($room['rid'])['name'] ?>
<?php
  }
} else {
  print_r(lang('Chat.none'));
}
 ?></td>
      <td>
            <a href="#" class="settings" title="" data-toggle="tooltip" data-original-title="Settings"><i class="material-icons"></i></a>
            <a href="#" class="delete" title="" data-toggle="tooltip" data-original-title="Delete"><i class="material-icons"></i></a>
        </td>
      </tr>
<?php
}
?>
       
      </tbody>
    </table>
      
<?= $this->endsection() ?>
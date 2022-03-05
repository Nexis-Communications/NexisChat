<?= $this->extend('admin/layout') ?>
<?= $this->section('main') ?>

<div class="row main-header"> 
<h3>Alert Center</h3>
</div>
      
 <table class="table table-dark">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Flagged By</th>
          <th scope="col">Message</th>
          <th scope="col">Date Flagged</th>
        <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
<?php
foreach ($flagged as $flag) {
?>
      <tr>
      <th scope="row"><?= $flag['id'] ?></th>
      <td><?= userLookup($flag['uid'])->username ?></td>
      <td><?= messageLookup($flag['mid'])['data'] ?></td>
      <td><?= $flag['created_at'] ?></td>
      <td>
            <a href="#" class="settings" title="" data-toggle="tooltip" data-original-title="Open"><i class="material-icons">file_open</i></a>
            <a href="#" class="delete" title="" data-toggle="tooltip" data-original-title="Delete"><i class="material-icons">delete</i></a>
        </td>
      </tr>
<?php
}
?>
       
      </tbody>
    </table>
      
<?= $this->endsection() ?>
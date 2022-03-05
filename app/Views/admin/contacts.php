<?= $this->extend('admin/layout') ?>
<?= $this->section('main') ?>

<div class="row main-header"> 
<h3>Contact Manager</h3>
</div>
      
 <table class="table table-dark">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
        <th scope="col">E-Mail</th>
          <th scope="col">Message</th>
        <th scope="col">IP</th>
        <th scope="col">Date</th>
        <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
<?php
foreach ($contacts as $contact) {
?>
      <tr>
      <th scope="row"><?= $contact['id'] ?></th>
      <td><?= $contact['name'] ?></td>
      <td><?= $contact['email'] ?></td>
      <td><?= $contact['message'] ?></td>
      <td><?= $contact['ip'] ?></td>
      <td><?= $contact['created_at'] ?></td>
      <td>
            <a href="#" class="settings" title="" data-toggle="tooltip" data-original-title="Reply"><i class="material-icons">reply</i></a>
            <a href="#" class="delete" title="" data-toggle="tooltip" data-original-title="Delete"><i class="material-icons">delete</i></a>
        </td>
      </tr>
<?php
}
?>
       
      </tbody>
    </table>
      
<?= $this->endsection() ?>
<?= $this->extend('admin/dashboard/layout') ?>
<?= $this->section('main') ?>

            <div class="row">
              <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between mb-2">
                      <h3 class="card-title mb-1">User Group Details</h4>
                      <p class="text-muted mb-1"><button class="btn btn-outline-primary">Edit</button></p>
                    </div>
                    <div class=" row">
                      <h6 for="name" class="col-sm-3">Name:</h6>
                      <div class="col-sm-9"><p><?= $group->description ?></p></div>
                    </div>
                    <div class=" row">
                      <h6 for="name" class="col-sm-3">Count:</h6>
                      <div class="col-sm-9"><p><?= $count ?></p></div>
                    </div>
                    

                  </div>
                </div>
              </div>
              
            </div>

            <div class="row grid-margin">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">User</h4>
                    <p class="card-description">User assigned to group</p>
                    <div class="table-responsive" >
                    <table class="table" id="data-table"> 
                    <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                      //print_r($users);
                      //d($users);
                      foreach ($users as $user) {
                        //print_r($user);
                        ?>
                      <tr>
                        <td><a href="/admin/dashboard/user/view/<?= $user['detail']->id ?>"><?= $user['detail']->username ?></a></td>
                        <td><?= $user['detail']->email ?></td>

                      <td>
                      <a href="/admin/dashboard/user/view/<?= $user['detail']->id ?? NULL ?>" class="btn btn-outline-primary">View</a>
                      <a href="/admin/dashboard/users/group/remove/<?= $user['detail']->id ?? NULL ?>" class="btn btn-outline-danger">Remove</a>
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
<?= $this->extend('admin/dashboard/layout') ?>
<?= $this->section('main') ?>



            <div class="row">
              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Users</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0"><?= getUserTotal() ?></h2>
                        </div>
                        <h6 class="text-muted font-weight-normal">Current Users</h6>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-account-group text-primary ms-auto"></i>
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
                    <h4 class="card-title">Users</h4>
                    <p class="card-description">Registered and Temporary Users</p>
                    <div class="table-responsive" >
                    <table class="table" id="data-table"> 
                    <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Group</th>
                      <th>Status</th>
                      <th>Active</th>
                      <th>Join Date</th>
                      <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($users as $user) {
                        ?>
                      <tr>
                        <td><a href="/admin/dashboard/user/view/<?= $user->id ?>"><?= $user->username ?></a></td>
                          <td><?= $user->email ?></td>
                          <td><a href="/admin/dashboard/users/group/view/<?= getUserGroup($user->id)['id'] ?>"><?= getUserGroup($user->id)['description'] ?></a></td>
                          <td><?= $user->status ?></td>
                          <td><?= getStatusHTML($user->active) ?></td>
                          <td><?= getJoinDate($user->created_at) ?></td>

                      <td>
                      <a href="/admin/dashboard/user/view/<?= $user->id ?>" class="btn btn-outline-primary">View</a>
                      <a href="/admin/dashboard/user/kick/<?= $user->id ?>" class="btn btn-outline-warning">Kick</a>
                      <a href="/admin/dashboard/user/ban/<?= $user->id ?>" class="btn btn-outline-danger">Ban</a>
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
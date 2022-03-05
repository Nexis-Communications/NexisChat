<?= $this->extend('admin/dashboard/layout') ?>
<?= $this->section('main') ?>



            <div class="row">
              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Groups</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0"><?= count($groups) ?></h2>
                        </div>
                        <h6 class="text-muted font-weight-normal">Total User Groups</h6>
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
                    <h4 class="card-title">User Groups</h4>
                    <p class="card-description">User groups for all users</p>
                    <div class="table-responsive" >
                    <table class="table" id="data-table"> 
                    <thead>
                    <tr>
                      <th>Name</th>
                      <th>User Count</th>
                      <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($groups as $group) {
                        ?>
                      <tr>
                        <td><?= $group->description ?></td>
                          <td><?= getGroupUsersCount($group->id) ?></td>

                      <td>
                        <a href="/admin/dashboard/users/group/view/<?= $user->id ?>" class="btn btn-outline-primary">View</a>
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
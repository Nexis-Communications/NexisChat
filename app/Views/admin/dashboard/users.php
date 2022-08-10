<?= $this->extend('admin/dashboard/layout') ?>
<?= $this->section('main') ?>



            <div class="row">
              <div class="col-sm-4 grid-margin">
                <?= view('admin/dashboard/widgets/cards/users/totalUsers') ?>
              </div>
              <div class="col-sm-4 grid-margin">
                <?= view('admin/dashboard/widgets/cards/users/totalAdmins') ?>
              </div>
              <div class="col-sm-4 grid-margin">
                <?= view('admin/dashboard/widgets/cards/users/totalRangers') ?>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4 grid-margin">
                <?= view('admin/dashboard/widgets/cards/users/totalGuests') ?>
              </div>
              <div class="col-sm-4 grid-margin">
              <?= view('admin/dashboard/widgets/cards/users/totalLifetime') ?>
              </div>
              <div class="col-sm-4 grid-margin">
              <?= view('admin/dashboard/widgets/cards/users/totalHosts') ?>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4 grid-margin">
                <?= view('admin/dashboard/widgets/cards/users/totalGeneral') ?>
              </div>
              <div class="col-sm-4 grid-margin">
              <?= view('admin/dashboard/widgets/cards/users/totalActiveInactive',['active'=>1]) ?>
              </div>
              <div class="col-sm-4 grid-margin">
              <?= view('admin/dashboard/widgets/cards/users/totalActiveInactive',['active'=>0]) ?>
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
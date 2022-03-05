<?= $this->extend('admin/dashboard/layout') ?>
<?= $this->section('main') ?>


            <div class="row">
            <?= view('admin/dashboard/widgets/cards/currentUsers',['width'=>4]) ?>
            <?= view('admin/dashboard/widgets/cards/flaggedMessages',['width'=>4]) ?>
            </div> <!-- ./row -->

            <div class="row">
              <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between mb-2">
                      <h3 class="card-title mb-1">Room Details</h4>
                      <p class="text-muted mb-1"><button class="btn btn-outline-primary">Edit</button></p>
                    </div>
                    <div class=" row">
                      <h6 for="name" class="col-sm-3">Name:</h6>
                      <div class="col-sm-9"><p><?= $room->name ?></p></div>
                    </div>

                    <div class=" row">
                      <h6 for="name" class="col-sm-3">Group:</h6>
                      <div class="col-sm-9">
                        <p>
                          <?php 
                          foreach (getRoomGroup($room->id) as $group) {
                          ?>
                          <a href="/admin/dashboard/group/view/<?= getGroup($group->gid)->alias ?>"><?= getGroup($group->gid)->name ?></a>
                          <?php 
                            } 
                          ?>
                        </p>
                      </div>
                    </div>
                    
                    <div class=" row">
                      <h6 for="name" class="col-sm-3">Status:</h6>
                      <div class="col-sm-9"><p><?= getStatusHTML($room->active) ?></p></div>
                    </div>

                  </div>
                </div>
              </div>
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Top Active Users</h4>
                    <?php 
                    foreach (getRoomUserCount($room->id,1,5) as $topuser) {
                    ?>
                    <div class="bg-gray-dark d-flex d-xl-flex flex-row d-md-block py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                      <div class="text-md-center text-xl-left">
                        <h6 class="mb-1">User</h6>
                        <p class="text-muted mb-0"><a href="/admin/dashboard/user/view/<?= $topuser->id ?>"><?= $topuser->username ?></a></p>
                      </div>
                      <div class="align-self-center flex-grow text-end text-md-center text-xl-right py-md-2 py-xl-0">
                        <h6 class="font-weight-bold mb-0">#</h6>
                      </div>
                    </div>
                    <?php
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between mb-2">
                      <h3 class="card-title mb-1">Flagged Messages</h4>
                      <p class="text-muted mb-1"><button class="btn btn-outline-primary">Action</button></p>
                    </div>

                    <table class="table">
                      <thead>
                        <tr class="">
                          <th>#</th>
                          <th>Reported User</th>
                          <th>Reported Handle</th>
                          <th>Reported Source</th>
                          <th>Message</th>
                          <th>Reporting Pary</th>
                          <th>Report Time</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          foreach ( getRoomFlagged($room->id,1) as $flagged ) {
                            //print_r($flagged);
                        ?>
                        <tr>
                          <td scope="row"><?= $flagged->id?></td>
                          <td><a href="/admin/dashboard/user/view/<?= $flagged->sus_id ?>"><?= $flagged->sus_user ?></a></td>
                          <td><?= $flagged->sus_handle ?></td>
                          <td><?= $flagged->sus_source ?></td>
                          <td><?= $flagged->sus_message ?></td>
                          <td><a href="/admin/dashboard/user/view/<?= $flagged->rpid ?>"><?= $flagged->rp_user ?></a></td>
                          <td><?= $flagged->rt ?></td>
                          <td><a href="/admin/dashboard/flagged/view/<?= $flagged->id ?>" type="button" class="btn btn-outline-primary btn-icon-text"><i class="mdi mdi-file-check-outline btn-icon-prepend"></i> View</a></td>
                          <td><a href="/admin/dashboard/flagged/delete/<?= $flagged->id ?>" type="button" class="btn btn-outline-danger btn-icon-text">
                            <i class="mdi mdi-delete btn-icon-prepend"></i> Delete </a></td>
                        </tr> 
                        <?php 
                          }
                        ?>
                      </tbody>
                    </table>
                    
                  </div> <!-- ./card-body -->
                </div> <!-- ./card -->
              </div> <!-- ./col -->
            </div> <!-- ./row -->




<?= $this->endsection() ?>
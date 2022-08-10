<?= $this->extend('admin/dashboard/layout') ?>
<?= $this->section('main') ?>


            <div class="row">
              <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between mb-2">
                      <h3 class="card-title mb-1">User Details</h4>
                      <p class="text-muted mb-1"><a href="/admin/dashboard/user/edit/<?= $user->id ?>" class="btn btn-outline-primary">Edit</a></p>
                    </div>
                    <div class=" row">
                      <h6 for="name" class="col-sm-3">Name:</h6>
                      <div class="col-sm-9"><p><?= $user->username ?></p></div>
                    </div>
                    
                    <div class=" row">
                      <h6 for="name" class="col-sm-3">Email:</h6>
                      <div class="col-sm-9"><p><?= $user->email ?></p></div>
                    </div>

                    <div class=" row">
                      <h6 for="name" class="col-sm-3">Status:</h6>
                      <div class="col-sm-9"><p><?= $user->status ?></p></div>
                    </div>

                    <div class=" row">
                      <h6 for="name" class="col-sm-3">Active:</h6>
                      <div class="col-sm-9"><p><?= getStatusHTML($user->active) ?></p></div>
                    </div>

                    <div class=" row">
                      <h6 for="name" class="col-sm-3">Created:</h6>
                      <div class="col-sm-9"><p><?= $user->created_at ?? "&nbsp;" ?></p></div>
                    </div>

                    <div class=" row">
                      <h6 for="name" class="col-sm-3">Updated:</h6>
                      <div class="col-sm-9"><p><?= $user->updated_at ?? "&nbsp;" ?></p></div>
                    </div>

                    <div class=" row">
                      <h6 for="name" class="col-sm-3">Deleted:</h6>
                      <div class="col-sm-9"><p><?= $user->deleted_at ?? "&nbsp;" ?></p></div>
                    </div>

                    <div class=" row">
                      <h6 for="name" class="col-sm-3">Groups:</h6>
                      <div class="col-sm-9">
                        <p><?= getUserGroups($user->id,1) ?></p>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="col-md-4 grid-margin">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Stats</h4>

                      <div class=" row">
                        <h6 for="name" class="col-sm-6">Rooms Visited:</h6>
                        <div class="col-sm-6">
                          <p><?= $userStats['roomsVisited'] ?></p>
                        </div>
                      </div>

                      <div class=" row">
                        <h6 for="name" class="col-sm-6">Nicks Used:</h6>
                        <div class="col-sm-6">
                          <p><?= $userStats['nicksUsed'] ?></p>
                        </div>
                      </div>

                      <div class=" row">
                        <h6 for="name" class="col-sm-6">Messages:</h6>
                        <div class="col-sm-6">
                          <p><?= $userStats['messagesSent'] ?></p>
                        </div>
                      </div>

                      <div class=" row">
                        <h6 for="name" class="col-sm-6">Private Messages:</h6>
                        <div class="col-sm-6">
                          <p><?= $userStats['messagesPrivate'] ?></p>
                        </div>
                      </div>

                      <div class=" row">
                        <h6 for="name" class="col-sm-6">Chatpics Used:</h6>
                        <div class="col-sm-6">
                          <p><?= $userStats['chatpicsUsed'] ?> </p>
                        </div>
                      </div>

                      <div class=" row">
                        <h6 for="name" class="col-sm-6">Genders Used:</h6>
                        <div class="col-sm-6">
                          <p><?= count($userStats['actions']['gender'] ?? array()) ?></p>
                        </div>
                      </div>

                      <div class=" row">
                        <h6 for="name" class="col-sm-6">Moods Used:</h6>
                        <div class="col-sm-6">
                          <p><?= count($userStats['actions']['mood'] ?? array()) ?></p>
                        </div>
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
                    <h4 class="card-title">User's Rooms</h4>
                    <p class="card-description">User's Frequented Rooms</p>
                    <div class="table-responsive" >
                    <table class="table" id="data-table"> 
                    <thead>
                    <tr>
                      <th>Room</th>
                      <th>Active</th>
                      <th>Action Count</th>
                      <th>Last Visit</th>
                      <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                      //print_r($users);
                      //d($users);
                      if (is_array($userStats['actions']['rid'])) {
                        foreach ($userStats['actions']['rid'] as $rid=>$actionCount) {
                          $roomInfo = getRoomInfo($rid);
                        ?>
                      <tr>
                        <td><?= $roomInfo->name ?></td>

                        <td></td>
                        <td></td>
                        <td></td>
                      <td>
                      <a href="/admin/dashboard/user/view/" class="btn btn-outline-primary">View</a>
                      <a href="/admin/dashboard/users/group/remove/" class="btn btn-outline-danger">Remove</a>
                      </td>
                    </tr>
                    <?php
                        }
                      }
                    ?>
                    </tbody>
                  </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <?php //d($userStats) ?>
<?= $this->endsection() ?>
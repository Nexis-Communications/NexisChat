<?= $this->extend('admin/dashboard/layout') ?>
<?= $this->section('main') ?>


            <div class="row">
              <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <form action="/admin/dashboard/user/save/<?= $user->id ?>" method="POST">
                      <div class="d-flex flex-row justify-content-between mb-2">
                        <h3 class="card-title mb-1">User Details</h4>
                        <p class="text-muted mb-1"><button type="submit" class="btn btn-outline-success">Save</button> <a href="/admin/dashboard/user/view/<?= $user->id ?>" class="btn btn-outline-danger">Cancel</a></p>
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
                          <p>
                            <div class="col-sm-6">
                              <div class="row">
                                <div th:each="group : ${usergroups}">
                                  <?php 
                                  $i = 0;
                                    foreach ($groupsAvailable as $agroup) {
                                      if (($i % 3) == 0) {
                                        ?><div class="col-xs-6"><?php
                                      }
                                      //d($agroup);
                                      ?>
                                      <div class="checkbox">
                                      <label>
                                        <input type="checkbox" name="groups[]" value="<?= $agroup['id'] ?>"
                                        <?php 
                                        foreach($groups as $group) 
                                          if ($group->id == $agroup['id']) {
                                          ?> 
                                          checked
                                          <?php } ?>
                                          >
                                        <?= $agroup['description'] ?>
                                      </label>
                                    </div>
                                    <?php
                                      $i++;
                                      if (($i % 3) == 0) {
                                        ?></div><?php
                                      }
                                    }
                                  
                                    ?>


                                </div>
                              </div>

                            </div>

                          </p>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              
            </div>

<?= $this->endsection() ?>
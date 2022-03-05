<div class="col-sm-<?= $width ?> grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Current Users</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0"><?= getRoomUserCount($room->id) ?></h2>
                        </div>
                        <h6 class="text-muted font-weight-normal">Current Users in room.</h6>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-account-group text-primary ms-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
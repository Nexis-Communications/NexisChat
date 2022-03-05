<?= $this->extend('admin/dashboard/layout') ?>
<?= $this->section('main') ?>


            <div class="row">
              <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between mb-2">
                      <h3 class="card-title mb-1">User Details</h4>
                      <p class="text-muted mb-1"><button class="btn btn-outline-primary">Edit</button></p>
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
                      <div class="col-sm-9"><p><?= $user->created_at ?></p></div>
                    </div>

                    <div class=" row">
                      <h6 for="name" class="col-sm-3">Updated:</h6>
                      <div class="col-sm-9"><p><?= $user->updated_at ?></p></div>
                    </div>

                    <div class=" row">
                      <h6 for="name" class="col-sm-3">Deleted:</h6>
                      <div class="col-sm-9"><p><?= $user->deleted_at ?></p></div>
                    </div>

                  </div>
                </div>
              </div>
              
            </div>

<?= $this->endsection() ?>
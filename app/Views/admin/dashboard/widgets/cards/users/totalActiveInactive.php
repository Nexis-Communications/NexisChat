<div class="card">
    <div class="card-body">
    <h5><?= ($active) ? 'Active':'Inactive' ?> Users</h5>
    <div class="row">
        <div class="col-8 col-sm-12 col-xl-8 my-auto">
        <div class="d-flex d-sm-block d-md-flex align-items-center">
            <h2 class="mb-0"><?= getActiveUsers($active,1) ?></h2>
        </div>
        <h6 class="text-muted font-weight-normal">Total Users</h6>
        </div>
        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
        <i class="icon-lg mdi mdi-account-group text-primary ms-auto"></i>
        </div>
    </div>
    </div>
</div>
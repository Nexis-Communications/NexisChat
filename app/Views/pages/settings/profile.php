<?= $this->extend($layout) ?>
<?= $this->section('main') ?>

<div class="page-header">
    <h3 class="page-title"> General Profile Settings </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input name="name" type="text" class="form-control" id="name" placeholder="<?= $user->username ?>">
                    </div>
                    <div class="form-group">
                        <label for="name">Username</label>
                        <input name="name" type="text" class="form-control" id="name" placeholder="<?= site_url() ?>profile/<?= $user->username ?>">
                    </div>
                    <div class="form-group">
                        <label>Profile Picture</label>
                        <input type="file" name="img[]" class="file-upload-default">
                        <div class="input-group col-xs-12">
                          <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
                          <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                          </span>
                        </div>
                      </div>
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-dark">Cancel</button>
                </form>
            </div>
        </div>
    </div>

</div>

<?= $this->endsection() ?>
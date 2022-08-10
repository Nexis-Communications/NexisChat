<?= $this->extend($layout) ?>
<?= $this->section('main') ?>

<div class="page-header">
    <h3 class="page-title"> Privacy Settings and Tools </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/settings">Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">Privacy</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2">
                        <h4>Privacy Shortcuts</h4>
                    </div>
                    <div class="col-xl-10">
                        <ul class="nav">
                            <li class="nav-link">
                                <a href="/settings/profile" class="text-reset text-decoration-none">
                                    <div>Manage Your Profile</div>
                                    <div class="text-secondary">Go to your profile to change your profile info privacy, like who can see your birthday or relationships.</div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endsection() ?>
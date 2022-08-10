<?= $this->extend($layout) ?>
<?= $this->section('main') ?>

<div class="page-header">
    <h3 class="page-title"> Blocking </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/settings">Settings</a></li>
            <li class="breadcrumb-item active" aria-current="page">Blocking</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2">
                        <h4>Manage Blocking</h4>
                    </div>
                    <div class="col-xl-10">
                            <div class="row">
                                <div class="col-12">
                                    <div class="accordion accordion-flush" id="accordion" role="tablist">
                                        <div class="card">
                                            <div class="card-header" role="tab" id="heading-1">
                                                <h6 class="mb-0">
                                                    <a href="#collapse-1" class="collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse-1">
                                                        <div>Ignored Users</div>
                                                        <div class="text-secondary">When you ignore someone, that person can see your messages but you will not see theirs.</div>
                                                    </a>
                                                </h6>
                                            </div>
                                            <div id="collapse-1" class="accordion-collapse collapse" aria-labelledby="heading-1" data-bs-parent="#heading-1">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        Content
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                <li class="nav-link">
                                    <a href="#" class="text-reset text-decoration-none">
                                        <div>Blocked Users</div>
                                        <div class="text-secondary">When you block someone, that person can no longer see your messages, or send you messages.</div>
                                    </a>
                                </li>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endsection() ?>
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
                                                <div class="row px-4">
                                                    <div class="col-12">
                                                        <?php if ($ignoredUsers) { 
                                                            foreach ($ignoredUsers as $ignoredUser) { 
                                                                ?>
                                                                <div class="row mb-2">
                                                                    <div class="col-8">
                                                                        <?= getUserbyID($ignoredUser->iid)->username ?>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <a class="btn btn-primary" href="/settings/blocking/ignored/delete/<?= $ignoredUser->id ?>">Remove</a>
                                                                    </div>
                                                                </div>
                                                                <?php 
                                                                }
                                                            } else {
                                                        ?>
                                                            <p>There are no ignored users. </p>
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="accordion accordion-flush" id="accordion" role="tablist">
                                    <div class="card">
                                        <div class="card-header" role="tab" id="heading-2">
                                            <h6 class="mb-0">
                                                <a href="#collapse-2" class="collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse-2">
                                                    <div>Blocked Users</div>
                                                    <div class="text-secondary">When you block someone, that person can no longer see your messages, or send you messages.</div>
                                                </a>
                                            </h6>
                                    </div>
                                    <div id="collapse-2" class="accordion-collapse collapse" aria-labelledby="heading-1" data-bs-parent="#heading-2">
                                        <div class="accordion-body">
                                            <div class="row px-4">
                                                <div class="col-12">
                                                    <?php if ($blockedUsers) { 
                                                        foreach ($blockedUsers as $blockedUser) { 
                                                            ?>
                                                            <div class="row mb-2">
                                                                <div class="col-8">
                                                                    <?= getUserbyID($blockedUser->iid)->username ?>
                                                                </div>
                                                                <div class="col-4">
                                                                    <a class="btn btn-primary" href="/settings/blocking/blocked/delete/<?= $blockedUser->id ?>">Remove</a>
                                                                </div>
                                                            </div>
                                                            <?php 
                                                            }
                                                        } else {
                                                    ?>
                                                        <p>There are no blocked users. </p>
                                                    <?php
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endsection() ?>
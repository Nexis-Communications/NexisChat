<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">
    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            <div class="card bg-transparent">
            <div class="card-header"><h2>Login as Guest</h2></div>
                <div class="card-body">

                    <?= view('Myth\Auth\Views\_message_block') ?>

                    <form action="<?= route_to('registerguest') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="guest" value="1">

                        <div class="form-group">
                            <label for="username"><?=lang('Auth.username')?></label>
                            <input type="text" class="form-control <?php if(session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?=lang('Auth.username')?>" value="<?= old('username') ?>">
                        <small id="usernameHelp" class="form-text">Your username is your handle, your name, your identity. Your username will be yours while you remain active. Your username will be reserved only for you in chat but some may try to steal it.  </small>
                        </div>

                        <br>

                        <button type="submit" class="btn btn-primary btn-block">Login as Guest</button>
                    </form>


                    <hr>

                    <p><?=lang('Auth.alreadyRegistered')?> <a href="<?= route_to('login') ?>"><?=lang('Auth.signIn')?></a></p>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>

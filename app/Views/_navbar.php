<?php $uri = service('uri'); ?>

<nav class="navbar navbar-expand-lg navbar-primary bg-primary">
        <span class="navbar-brand h3">The Park Chat</span>
      <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
		<div class="collapse  navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
        <a class="nav-link<?= ($uri->getPath() == '/') ? ' ':''?>" href="/"><?=lang('Auth.home')?></a>
 </li>
            <li class="nav-item active">
              <a class="nav-link" href="/chat">Chat</a>
            </li>
            <li class="nav-item">
              <?php if (!service('authentication')->check()) : ?>
        <a class="nav-link" href="/login">Login</a>
<?php else : ?>
        <a class="nav-link" href="/logout">Logout</a>
<?php endif ?>
            </li>
            
<?php if (!service('authentication')->check()) : ?>
<?php else : ?>
  <li class="nav-item">
        <a class="nav-link" href="/profile">Profile</a>
        </li>
<?php endif ?>
            
            <li class="nav-item">
              <a class="nav-link" href="/support">Support</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/contact">Contact</a>
            </li>
            <?php 
            //print_r(service('authentication')->user()); 
            if (!service('authentication')->check()) {
            } else {
            if (service('authorization')->inGroup([3,4],service('authentication')->user()->id)) {
              ?>
              <li class="nav-item">
                <a class="nav-link" href="/admin/dashboard">Admin</a>
            </li>
            <?php
            }
          }
            ?>
          </ul>
      </div>
        </nav>
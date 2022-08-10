<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <a class="sidebar-brand brand-logo" href="/"><img src="/assets/images/logo.svg" alt="logo" /></a>
          <a class="sidebar-brand brand-logo-mini" href="/"><img src="/assets/images/logo-mini.svg" alt="logo" /></a>
        </div>
        <ul class="nav">
          <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <img class="img-xs rounded-circle " src="/assets/images/faces/face15.jpg" alt="">
                  <span class="count bg-success"></span>
                </div>
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal"><?= $user->username ?></h5>
                  <span><?= getUserLevel($user->id,1) ?></span>
                </div>
              </div>
              <a href="#" id="profile-dropdown" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                <a href="/settings/profile" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-settings text-primary"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-onepassword  text-info"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-calendar-today text-success"></i>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Settings</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="/settings/profile">
              <span class="menu-icon">
                <i class="mdi mdi-settings"></i>
              </span>
              <span class="menu-title">General</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="/settings/privacy">
              <span class="menu-icon">
                <i class="mdi mdi-lock"></i>
              </span>
              <span class="menu-title">Privacy</span>
            </a>
          <li class="nav-item menu-items">
            <a class="nav-link" href="/settings/notifications">
              <span class="menu-icon">
                <i class="mdi mdi-bell"></i>
              </span>
              <span class="menu-title">Notifications</span>
            </a>
          </li>
          
          <li class="nav-item menu-items">
            <a class="nav-link" href="/settings/account">
              <span class="menu-icon">
                <i class="mdi mdi-account"></i>
              </span>
              <span class="menu-title">Account</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="/settings/security">
              <span class="menu-icon">
                <i class="mdi mdi-shield"></i>
              </span>
              <span class="menu-title">Security and Login</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="/support/">
              <span class="menu-icon">
                <i class="mdi mdi-help"></i>
              </span>
              <span class="menu-title">Support</span>
            </a>
          </li>
          
        </ul>
      </nav>
<?= $this->extend('admin/dashboard/layout') ?>
<?= $this->section('main') ?>
 
<div class="row">
  <div class="col-md-8 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex flex-row justify-content-between mb-2">
          <h3 class="card-title mb-1">Message Details</h4>
        </div>
        <div class=" row">
          <h6 for="name" class="col-sm-3">User:</h6>
          <div class="col-sm-9"><p><?= $message->user ?? "N/A" ?></p></div>
        </div>

        <div class=" row">
          <h6 for="name" class="col-sm-3">Room:</h6>
          <div class="col-sm-9"><p><?= getRoomInfo($message->room ?? 0)->name ?? "N/A" ?></p></div>
        </div>
        
        <div class=" row">
          <h6 for="name" class="col-sm-3">Source:</h6>
          <div class="col-sm-9"><p><?= $message->source ?? "N/A" ?></p></div>
        </div>

        <div class=" row">
          <h6 for="name" class="col-sm-3">Recipient:</h6>
          <div class="col-sm-9"><p><?= getUserbyID($message->rcpt ?? 0)->username ?? "N/A" ?></p></div>
        </div>

        <div class=" row">
          <h6 for="name" class="col-sm-3">Created:</h6>
          <div class="col-sm-9"><p><?= $message->created_at ?? "N/A" ?></p></div>
        </div>

        <div class=" row">
          <h6 for="name" class="col-sm-3">Updated:</h6>
          <div class="col-sm-9"><p><?= $message->updated_at ?? "N/A"  ?></p></div>
        </div>

        <div class=" row">
          <h6 for="name" class="col-sm-3">Deleted:</h6>
          <div class="col-sm-9"><p><?= $message->deleted_at ?? "N/A"  ?></p></div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Actions</h4>
        
      </div>
    </div>
  </div>
</div>


<div class="row">
  <?php
    if ( $chatpic = chatpicExists($message->chatpic)) {
  ?>
  <div class="col-xl-3 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Chatpic</h4>
        <p> 
          <img src="/img/chatpics/<?= $chatpic->filename ?>">
        </p>
      </div>
    </div>
  </div>
  <?php
    }
  ?>
  <div class="col col-xl-9 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
      <div class="d-flex flex-row justify-content-between mb-2">
          <h3 class="card-title mb-1">Message</h4>
        </div>
        <p> <?= $message->user ?? "N/A"  ?>: [ <?= getGender($message->mood) ?? "N/A"  ?> <?= getGender($message->gender) ?? "N/A"  ?> ]</p>
        <p> <?= $message->data ?? "N/A"  ?> </p>
        <p>Location: <?= $message->location ?? "N/A"  ?> </p>
      </div>
    </div>
  </div>

</div> <!-- /.row -->

<?php
  if ($flagged = checkFlagged($message->id)) {
?>
<div class="row">
  <div class="col grid-margin">
    <div class="card">
      <div class="card-body">
      <div class="d-flex flex-row justify-content-between mb-2">
          <h3 class="card-title mb-1">Flagged </h4>
        </div>
        <div class=" row">
          <h6 for="name" class="col-sm-3"><?= (count($flagged) > 1 ) ? 'First ':''?>Flagged:</h6>
          <div class="col-sm-9"><p><?= $flagged[0]->created_at ?? "N/A" ?></p></div>
        </div>
        <div class=" row">
          <h6 for="name" class="col-sm-3">Flagged By:</h6>
          <div class="col-sm-9">
            <p>
            <?php 
              if (count($flagged) > 1 ) {
                foreach ($flagged as $fk=>$flag) {
                
                  $links[] = anchor('/admin/dashboard/user/view/'.$flagged[$fk]->uid,getUserbyID($flagged[$fk]->uid)->username);

                }
            ?>
                <?= implode(' , ',$links) ?>
            <?php
              } else {
            ?>
            <?= anchor('/admin/dashboard/user/view/'.$flagged[0]->uid,getUserbyID($flagged[0]->uid)->username) ?>
            <?php
              }
              ?>
           </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> <!-- /.row -->
<?php
  }
?>

<div class="row grid-margin">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex flex-row justify-content-between mb-2">
            <h3 class="card-title mb-1">Message Response</h4>
        </div>
        <p class="card-description">Respond to users message.</p>
        <form class="form" action="/admin/message/send/<?= $message->id ?>" method="POST">
          <input type="hidden" name="uid" value="<?= $user->id ?>">
          <input type="hidden" name="location" value="The Park Chat">
          <div class="mb-3">
            <label for="user" class="form-label">From:</label>
            <select name="user" class="form-control" id="user">
              <option value="<?= $user->username ?>"><?= $user->username ?></option>
              <option value="SYSTEM MESSAGE">SYSTEM MESSAGE</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="chatpic" class="form-label">Chatpic:</label>
            <select name="chatpic" class="form-control" id="chatpic">
              <option value="xxtpc">xxtpc</option>
              <option value="xxtpcdark">xxtpcdark</option>
              <option value="pollights">pollights</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="to" class="form-label">To:</label>
            <select name="to" class="form-control" id="to">
            <option value="2"><?= $message->user ?> (Public)</option>
            <option value="1"><?= $message->user ?> (PM)</option>
              <option value="3">All Users</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="room" class="form-label">Room:</label>
            <select name="room" class="form-control" id="room">
              <option value="<?= $message->room ?>"><?= getRoomInfo($message->room)->name ?></option>
              <option value="0">System Wide</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Message:</label>
            <textarea name="message" class="form-control" id="message" rows="5"></textarea>
          </div>
          <button type="submit" class="btn btn-primary mb-3">Send Message</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endsection() ?>
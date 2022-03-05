<?= $this->extend('layout/chat') ?>
<?= $this->section('pageStyles') ?>
<link href="/css/style.css" rel="stylesheet">
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<?php if ($options->autorefresh) { ?>
  <script defer src="/js/autorefresh.js"></script>
<?php } ?>
<?= $this->endSection() ?>
<?= $this->section('main') ?>

<?php 
use CodeIgniter\I18n\Time;



$hasMessage = session()->get('message');


?>

         <?php if ($hasMessage) { 
           /*
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <p><?= $message ?></p>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
         */ } ?>
              
          <?php if (\Config\Services::validation()->getErrors()) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?= \Config\Services::validation()->listErrors(); ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php } ?>
    
          <div class="row">
              <div class="col-lg-1">
                <h2><?= $room->details->name ?></h2>
              </div>
         
              <div class="col-1 mb-3">
                <a href="/chat/<?= $room->details->alias ?>/leave" type="button" class="btn btn-primary">Leave Room</a>
              </div>
              <?php if ($room->details->private) { ?>
              <div class="col-2 mb-3">
                <a href="/chat/<?= $room->details->alias ?>/return" type="button" class="btn btn-primary">Return to Room</a>
              </div>
              <?php } ?>

          </div> 
          

          <?php if ($vip) { ?>
            <form action="/chat/<?= $room->details->alias ?>" method="post" name="privateForm" id="privateForm">
            <?= csrf_field() ?>
              <div class="row">
                <div class="col-lg-3 col-xl-2 mb-2">
                  <button class="btn btn-light form-control" type="submit" name="action" id="createPrivate" value="4"><?= lang('Chat.enterpriv') ?></button>
                </div>
                <div class="col-lg-3 col-xl-2 mb-2">
                  <input type="text" class="form-control" name="private" id="inputRoomname" placeholder="<?= lang('Chat.privateroomName') ?>" size="14" maxlength="14" >
                  <small id="inputRoomnameHelp" class="form-text"><?= lang('Chat.privatenameHelper') ?></small>
                </div>
              </div> <!-- ./row -->
            </form>
          <?php } ?>

          <form action="/chat/<?= $room->details->alias ?>" method="post" name="chatForm" id="chatForm">
          <?= csrf_field() ?>
          <div class="row">
            <div class="col-lg-3 col-xl-2 mb-2">
              <button class="btn btn-light form-control" type="submit" name="action" id="listen" value="2"><?= lang('Chat.pushListen') ?></button>
              <small id="listenHelp" class="form-text"><?= lang('Chat.pushListenHelper') ?></small>
            </div>
          </div> <!-- ./row -->

          <?php if ($vip) { ?>
            <div class="row pb-sm-0 ml-1">
              <div class="col-lg-3 mb-sm-4 mb-2">
                <div class="row">
                  <label for="inputChatpic" class="form-label"><?= lang('Chat.chatpic') ?>:</label>
                  <div class="col"> 
                    <input type="text" class="form-control" name="chatpic" id="inputChatpic" placeholder="Chatpic" value="<?= $options->chatpic ?>" maxlength="30" size="20">
                  </div>
                </div>
              </div>
              <div class="col-lg-3 mb-sm-4 mb-2">
                <div class="row">
                  <label for="autoRefresh" class="form-label"><?= lang('Chat.autoRefresh') ?>:</label>
                  <div class="col">
                    <p class="h5"><input type="checkbox"  class="form-control<?= ($options->autorefresh) ? ' active':'' ?>" name="autorefresh" id="autoRefresh"<?= ($options->autorefresh) ? ' checked="checked"':'' ?>></p>
                    <!--small id="refreshHelp" class="form-text"><?= lang('Chat.autoRefreshHelper') ?></small-->
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>

          <?php if ($vip) { ?>
            <div class="row pb-sm-0 ml-1">
              <div class="col-lg-3 mb-sm-4 mb-2">
                <div class="row">
                  <label for="maxMessages" class="form-label"><?= lang('Chat.maxMessages') ?>:</label>
                  <div class="col">                      
                    <select  class="form-control" name="maxmessages" id="maxMessages">
                      <?php
                        foreach ($settings['messages.maxmessageoptions'] as $maxCount) {
                          ?>
                          <option value="<?= $maxCount ?>"<?= ($options->maxmessages == $maxCount) ? ' SELECTED':'' ?>><?= $maxCount ?></option>
                          <?php
                        }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 mb-sm-4 mb-2">
                <div class="row">
                  <label for="newMessages" class="form-label"><?= lang('Chat.onlyNew') ?>:</label>
                  <div class="col">
                    <p class="h5"><input type="checkbox" class="form-control<?= ($options->newmessages) ? ' active':'' ?>" name="newmessages" id="newMessages"<?= ($options->newmessages) ? ' checked="checked"':'' ?>></p>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>

          <div class="row pb-sm-0 ml-1">
            <div class="col-lg-3 mb-sm-4 mb-2">
            	<div class="row">
                <label for="inputName" class="form-label"><?= lang('Chat.nickname') ?>:</label>
                <div class="col">
                  <input type="text" class="form-control" name="name" id="inputName" placeholder="Nick" value="<?= ($options->name == $user->username) ? $user->username:$options->name ?>" maxlength="30" size="20">
                </div>
              </div>
            </div>
            <div class="col-lg-3 mb-2">
              <div class="row">
                <label for="inputLocation" class="form-label"><?= lang('Chat.location') ?>:</label>
                <div class="col">
                  <input type="text" class="form-control" name="location" id="inputLocation" placeholder="Location" value="<?= $options->location ?>" maxlength="30" size="20">
                </div>
              </div>
            </div>
          </div> <!-- ./row -->

          <div class="row ml-1">
            <div class="col-lg-3 mb-sm-4 mb-2">
              <div class="row">
                <label for="inputGender" class="form-label"><?= lang('Chat.gender') ?>:</label>
                <div class="col">
                  <select class="form-control" name="gender" id="inputGender">
                    <?php
                      if ($genders) {
                        foreach ($genders as $gender) {?>
                          <option value="<?= $gender->id ?>"<?= ($options->gender == $gender->id) ? ' SELECTED':''?>><?= $gender->description ?></option>
                          <?php
                        }
                      }
                    ?>
                 </select>
                </div>
              </div>
            </div>
            <div class="col-lg-3 mb-2">
              <div class="row">
                <label for="inputMood" class="form-label"><?= lang('Chat.mood') ?>:</label>
                <div class="col">
                  <select class="form-control" name="mood" id="inputMood">
                    <?php
                      if ($moods) {
                        foreach ($moods as $mood) {?>
                          <option value="<?= $mood->id ?>"<?= ($options->mood == $mood->id) ? ' SELECTED':''?>><?= $mood->description ?></option>
                          <?php
                        }
                      }
                    ?>
                  </select>
                </div>
              </div>
            </div>
          </div> <!-- ./row -->

          <div class="row ml-0">
            <div class="col-lg-2">
                <button class="btn btn-light form-control" type="submit" name="action" value="3"><?= lang('Chat.pushSpeak') ?></button>
            </div>
            <div class="col-lg-4 m-sm-2">
              <div class="row ">
                <label for="inputTowhom" class="form-label"><?= lang('Chat.towhom') ?>:</label>
                <div class="col-lg-6">
                  <select class="form-control" name="towhom" id="inputTowhom">
                    <option value="0" selected>ALL USERS</option>
                    <?php
                      if ($room->users->active) { 
                        foreach ($room->users->active as $_user) {?>
                          <option value="<?= $_user->id ?>"><?= ($_user->handle) ? $_user->handle:$_user->username ?><?= ($user->id == $_user->id) ? ' (You)':'' ?></option>
                          <?php
                        }
                      }
                    ?>
                  </select>
                </div>
              </div>
            </div>
          </div> <!-- ./row -->

          <div class="row ml-1">
            <label for="inputMessage" class="form-label"><?= lang('Chat.message') ?>:</label>
            <div class="col-lg-5">
              <textarea class="form-control" id="inputMessage" rows="4" cols="60" name="message"><?= session()->get('_ci_old_input')['post']['message'] ?? '' ?></textarea>
            </div>
          </div> <!-- ./row -->

          <div class="mt-3 pb-3 border-bottom">
            <span><?= $room->users->count ?> <?= ($room->users->count != 1) ? lang('Chat.nicksinuse'):lang('Chat.nickinuse') ?></span>
            <!--span><?= $messages->count ?> message<?= ($messages->count != 1) ? 's':'' ?>.</span-->
            <?php if ($messages->ignored->count) { ?>
              <span><?= $messages->ignored->count ?> <?= ($messages->ignored->count != 1) ? lang('Chat.ignoredmessages'):lang('Chat.ignoredmessage') ?></span>
            <?php } ?>
          </div> <!-- ./row -->

          <?php //($messagesquery) ? print_r($messagesquery): '' ?>
<?php 
if ($messages->current) {
  //dd($messages);
    foreach ($messages->current as $message) {
      if ($message->ignored ?? 0 == 1) {
        continue;
      }
      //dd($message);
      $color = '';
      $class = '';

      // PM Send
      if ($message->rcpt != 0 && $message->rcpt != $user->id) {
        $color = 'color:#9ebefb !important';
        $class = 'pm-send';

      }
      // PM Receive
      if ($message->rcpt != 0 && $message->rcpt == $user->id) { 
        $color = 'color:#f54242 !important';
        $class = 'pm-receive';
      }
?>
        <div class="<?= ($class) ? $class . ' ': '' ?>text-left border-bottom d-flex align-items-start<?= (isset($message->ignored)) ? ' text-muted':'' ?>" style="<?= $color ?>">
            <?php 
            if ($message->chatpic) {
              ?>
              <div style="max-height:90px; max-width:120px" class="mr-2 mt-3">
             <img src="/chatpics/<?= $message->chatpic ?>.gif" alt="profile" class="img-fluid">
            </div>
                
              <?php
            }
            ?>
            <div class="ms-4">
              <h4 class="font-weight-normal mt-2">
                <?php
                  if ($message->rcpt != 0 && $message->rcpt != $user->id) {
                   // $rcpt = $this->userModel->find($message->rcpt);
                ?>
                
                <?= lang('Chat.privateMessage') ?> <?= lang('Chat.to') ?> <?= $message->rcpt_handle ?? '(User Unknown)' ?>
                <?php 
                    }  elseif ($message->rcpt != 0 && $message->rcpt == $user->id) {
                ?>
                <?= lang('Chat.privateMessage') ?> <?= lang('Chat.from') ?> <?= $message->user ?>
                <?php } else {?>
                            <?= $message->user ?>
                <?php } ?>
                :
                <?php
                $hasMood = 0;
                $hasGender = 0;
                if ($message->mood || $message->gender) {
                  if (is_numeric($message->mood)) {
                    if ($message->mood > 1) {
                      $hasMood = 1;
                    }
                  } else {
                    $hasMood = 2;
                  }
                  if (is_numeric($message->gender)) {
                    if ($message->gender > 1) {
                      $hasGender = 1;
                    }
                  } else {
                    $hasGender = 2;
                  }
                }
                ?>
                <?= ($hasMood || $hasGender) ? '<small>[ ':'' ?>
                <?= ($hasMood == 1 ) ? $moods[$message->mood]->description:'' ?><?= ($hasMood == 2 ) ? $message->mood:'' ?> <?= ($hasGender == 1 ) ? $genders[$message->gender]->description:'' ?><?= ($hasGender == 2 ) ? $message->gender:'' ?>
                <?= ($hasMood || $hasGender) ? ' ]</small>':''?>
              </h4>
              <p>
                <?= nl2br($message->data) ?>
              </p>
              <p class="small">
                <?= ($message->location) ? lang('Chat.from') . ' ' . $message->location:lang('Chat.sent') ?> <?= lang('Chat.on') ?> <?= Time::parse($message->created_at)->toLocalizedString('E MMM d, yyyy') ?> <?= lang('Chat.on') ?> <?= Time::parse($message->created_at)->toLocalizedString('hh:mm:ss') ?>
                <?php if (($user->id != $message->uid) && ($message->uid != 0)): ?>
                <?= lang('Chat.checkIgnore') ?>: <input type="checkbox" name="ignore" value="<?= $message->id ?>">
                <?php if (isset($user->email)) { ?>
                <?= lang('Chat.flagMessage') ?>: <?= ($message->flagged ?? 0 == 1) ? lang('Chat.flagged'):'<input type="checkbox" name="flag[]" value="'. $message->id .'">' ?>
                <?php } ?>
                <?php endif ?>
              </p>
            </div>
        </div>
<?php
    }
} else {
?>
<div class="text-left border-bottom pb-3 pt-4">
  <p><?= lang('Chat.eol') ?></p>
</div>
<?php } ?>
</form>
<!-- This is just for a little 80's/90's fun. If you get in, sent us a screenshot! -->
<i id="pi" style="position: fixed; bottom:50px; right:10px;color:#424242!important;cursor:default;">&pi;</i>
<script type="text/javascript" src="/js/pi.js"></script>

<?= $this->endSection() ?>
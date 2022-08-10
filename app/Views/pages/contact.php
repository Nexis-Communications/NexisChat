<?= $this->extend('layout/layout') ?>
<?= $this->section('main') ?>

     <?php if ($message) { ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <h4 class="alert-heading">Message Submitted!</h4>
  <p>Thank you for your feedback and comments! We are always looking for ways to improve our service.</p>
  <hr>
  <p class="mb-0">Please don't hesitate to let us know how we're doing.</p>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php } ?>

<div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card bg-transparent">
        <?php $validation = \Config\Services::validation(); ?>
        <?= form_open() ?>
        <?= reCaptcha3('reCaptcha3', ['id' => 'recaptcha_v3'], ['action' => 'contactForm']); ?>
          <!--form class="form-horizontal" action="/contact" method="post" id="contactForm"-->
            <h2 class="card-header">Contact Us</h2>
            <div class="card-body">

            <!-- Name input-->
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" name="name" type="text" placeholder="Your name" class="form-control"<?= ($loggedin) ? ' value="' . $userName . '"':'' ?>>
              <!-- Error -->
<?php if($validation->getError('name')) {?>
            <div class='alert alert-danger mt-2'>
                <?= $error = $validation->getError('name'); ?>
            </div>
<?php }?>
            </div>

            <!-- Email input-->
            <div class="form-group">
                <label for="email">E-mail</label>
                <input id="email" name="email" type="text" placeholder="Your email" class="form-control"<?= ($loggedin) ? ' value="' . $userEmail . '"':'' ?>>
                <!-- Error -->
<?php if($validation->getError('email')) {?>
                <div class='alert alert-danger mt-2'>
                    <?= $error = $validation->getError('email'); ?>
                </div>
<?php }?>
            </div>

            
<?php 
if ($topics = getTopics()) { 
?>
   <!-- Subject input-->
   <div class="form-group">
                <label for="subject">Subject</label>
                <select id="subject" name="subject" class="form-control">
                  <option value="0">-- Select a Topic --</option>
                  <?php
                  foreach ($topics->data->topics as $topic) {
                  ?>

                    <option value="<?= $topic->id ?>"><?= $topic->topic ?></option>
                    <?php
                  }
                  ?>
                  </select>
            </div>

<?php
}
?>
            
    

            <!-- Message body -->
            <div class="form-group">
                <label  for="message">Message</label>
                <textarea class="form-control" id="message" name="message" placeholder="Please enter your message here..." rows="5"></textarea>
                <!-- Error -->
<?php if($validation->getError('message')) {?>
                <div class='alert alert-danger mt-2'>
                    <?= $error = $validation->getError('message'); ?>
                </div>
<?php }?>
            </div>

            <!-- reCaptcha v3 -->
          
            <div class="form-group">
               This site is protected by reCAPTCHA and the Google
    <a href="https://policies.google.com/privacy">Privacy Policy</a> and
    <a href="https://policies.google.com/terms">Terms of Service</a> apply.
            </div>
            <style type="text/css">
              .grecaptcha-badge { visibility: hidden; }
              </style>
            <!-- Form actions -->            
            <button class="btn btn-primary btn-block" type="submit">Submit</button>
            </div>

          </form>
           <!-- reCaptcha v3 -->
           <!--script src="https://www.google.com/recaptcha/api.js"></script-->
            <script>
              function onSubmit(token) {
                document.getElementById("contactForm").submit();
              }
            </script>
        </div>
      </div>
	</div>
<?= $this->endSection() ?>
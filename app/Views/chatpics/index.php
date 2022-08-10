<?= $this->extend('layout/layout') ?>
<?= $this->section('pageStyles') ?>
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<?= $this->endSection() ?>
<?= $this->section('main') ?>
<div class="row">
    <div class="col">
        <h2>Chatpics</h2>
        <p>
            Chatpics are used in chat as your avatar. They are your way to represent who you are. They can be used to provide your with a posona, identity, and distinguish you from everyone else.
        </p>
        <p class="font-weight-bold">Current Image Count: <?= chatpicCount() ?></p>
    </div>
</div>
<div class="row">
    <div class="col">
        <h3>Submit your own!</h3>
        <p>
            In the case that you can't find an image that you would like to use as a chatpic, you may submit your own. 
            To submit your own, send a 150px x 100px (Max WxH) gif, jpg, or png image to <a href="mailto:support@theparkchat.com?subject=Chatpic Submission">support@theparkchat.com</a>. Please include "Chatpic Submission" as the subject the name you would like to for your image with a link to the images source. If you made the image yourself, you can include your website address or social media link if you wish. 
        </p>
        <p> Once your image has been approved for use in chat, you will be notified with the final name assigned to your private chatpic.</p>
    </div>
</div>
<div class="row pb-3">
    <div class="col">
        <h2>Public Chatpic Search</h2>
        <p>
            You can search for a chatpic to use in chat. Please be aware that others may also use the same image. Staff and Private icons will not be listed in search or by browsing keywords.
        </p>
        <p class="text-danger font-weight-bold bg-primary p-1">Note: Some images are provided by a 3rd-party service and as a result, some may contain content only suitable for adults. If you are under the age of 18 or not permitted to view content of an adult nature, do not continue searching in this area.</p>
    <?= view('Views/chatpics/searchbar') ?>
    </div>
</div>
<div class="row d-block">
    <div class="col">
        <h2>Browse Keywords</h2>
        <p>
            Some keywords are provided below to help you on your way to finding your identity. 
        </p>
    </div>
</div>
<div class="container mt-4">

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
<?php 
foreach ($keywords as $keyword) {
?>

    <div class="col mb-4">
        <div class="card h-100 text-center" style="">
            <div class="card-body">

                <p class="card-text"><?= anchor(site_url(['chatpics','browser','keyword',urlencode($keyword->keyword)]),$keyword->keyword);  ?></p>
            </div> <!-- ./card-body -->
        </div> <!-- ./card -->
    </div> <!-- ./col -->


<?php
}
?>
</div> <!-- ./row -->

<?= $this->endSection() ?>

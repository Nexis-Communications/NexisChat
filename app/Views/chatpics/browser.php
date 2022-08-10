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
<div class="row pb-3">
    <div class="col">
        <h2>Public Chatpic Search</h2>
        <p>
            You can search for a chatpic to use in chat. Please be aware that others may also use the same image. Staff and Private icons will not be listed in search or by browsing keywords.
        </p>
    <?= view('Views/chatpics/searchbar') ?>
    </div>
</div>
<div class="row d-block">
    <div class="col">
        <h2>Browse Chatpics</h2>
        <p>
            Below you will find images results based on your search parameters. To use an image in chat, use the image tag provided in the chatpic field in chat.  
        </p>
    </div>
</div>
<div class="container">
<?php
if ($results) {
?>


<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">

<?php
    foreach ($results as $hit) {
       
?>
        <div class="col mb-4">
            <div class="card h-100" style="">
                <img class="card-img-top mx-auto p-2" src="/chatpics/view/pb<?= $hit['sid'] ?>" style="max-width: <?= $hit['previewWidth'] ?>px">
                <ul class="list-group">
                    <li class="list-group-item ">
                        
                        <p class="mb-0"><i class="fas fa-tag fa-sm"></i> <?= keywordtags($hit['tags']) ?></p>
                    </li>
                </ul>
                <div class="card-body d-flex">

                    <p class="card-text mt-auto mb-0">Image Tag:  pb<?= $hit['sid']?> </p>
                </div> <!-- ./card-body -->
            </div> <!-- ./card -->
        </div> <!-- ./col -->
<?php
    }
?>
    </form>
    </div> <!-- ./row -->
    <?php //d($results,$pager) ?>
<?php 
//if ($total>20) { 
    ?>
    <?= $pager->links('default', 'bs_full') ?>

    <?php //$pager->makeLinks($page,20, $total, 'bs_full',$segment ?? 5) ?>
<?php
  //  }
} else {
?>

<p> No Results Found</p>
<?php
}
?>
</div>

<?= $this->endSection() ?>

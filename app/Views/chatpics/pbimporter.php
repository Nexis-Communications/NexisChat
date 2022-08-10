<?= $this->extend('layout/layout') ?>
<?= $this->section('pageStyles') ?>
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<?= $this->endSection() ?>
<?= $this->section('main') ?>
<div class="row">
<?= view('Views/chatpics/searchbar') ?>
</div>
<?php
if ($results) {
?>
<div class="row">
    <h2>Search Results</h2>
</div>
<div class="container">
<form action="/chatpics/import" method="POST">

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
        <?= csrf_field() ?>
        <input type="hidden" name="source" value="pixabay">
<?php
    foreach ($results as $hit) {
       
?>
        <div class="col mb-4">
            <div class="card h-100" style="">
                <img class="card-img-top mx-auto p-2" src="<?= $hit['previewURL'] ?>" style="max-width: <?= $hit['previewWidth'] ?>px">
                <ul class="list-group">
                    <li class="list-group-item ">
                        
                        <p class="mb-0"><i class="fas fa-hashtag fa-sm"></i> <?= $hit['sid'] ?></p>
                    </li>
                    <li class="list-group-item ">
                        
                        <p class="mb-0"><i class="fas fa-tag fa-sm"></i> <?= keywordtags($hit['tags']) ?></p>
                    </li>
                </ul>
                <div class="card-body d-flex">

                    <p class="mt-auto mb-0">Import Image: <input type="checkbox" name="images[]" value="<?= $hit['sid']?>"> </p>
                </div> <!-- ./card-body -->
            </div> <!-- ./card -->
        </div> <!-- ./col -->
<?php
    }
?>
    </form>
    </div> <!-- ./row -->
    <?php d($results,$pager) ?>
    <?= $pager->makeLinks(1,20, count($results), 'bs_full',5) ?>
</div>
<?php
}
?>

<?= $this->endSection() ?>

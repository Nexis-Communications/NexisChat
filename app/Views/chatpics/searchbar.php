<div class="row mx-1">
<div class="col">
<form action="<?= $config->searchUrl ?>" method="POST" class="form-inline">
  <?= csrf_field() ?>
  <input type="text" name="query" id="query" class="form-control mr-sm-2" placeholder="Search" value="<?= $query->keywords ?? NULL ?>">
  <div class="form-check display-block">
  <input class="form-check-input" name="exact" type="checkbox" value="1" id="flexCheckDefault">
  <label class="form-check-label" for="flexCheckDefault">
    Exact Match
  </label>
  <button type="submit" class="btn btn-primary mx-2">
    <i class="fas fa-search"> </i> Search
  </button>
  
</div>
</form>
</div>
</div>
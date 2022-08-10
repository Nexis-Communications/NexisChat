<div class="search-item pb-3 mb-3 border-bottom">
    <div class="media mt-1"><i class="fa-solid fa-user p-1"></i>
        <div class="media-body">
            <h5 class="media-heading mt-0"><?= $handle ?></h5>
            <!--p class="font-13"><b>Email:</b> <span><a href="#" class="text-muted">[email]</a></span></p -->

            <p class="mb-0 font-13"><b>First Seen: </b><span class="text-muted">  <?= $created_at ?></span></p>
            <p class="mb-0 font-13"><b>Last Used: </b><span class="text-muted">  <?= $updated_at ?></span></p>
        </div>
    </div>
</div>
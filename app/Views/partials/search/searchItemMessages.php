<div class="search-item">
    <h4 class="mb-1"></i><a href="<?= base_url() ?>/chat/<?= getRoomInfo($room)->alias ?>"><?= getRoomInfo($room)->name ?></a></h4>
    <div class="font-13 mb-3"><a href="<?= base_url() ?>/chat/<?= getRoomInfo($room)->alias ?>"><?= base_url() ?>/chat/<?= getRoomInfo($room)->alias ?></a></div>
    <p class="font-13"><i class="fa-solid fa-user p-1"></i><b>User:</b> <span><?= $user ?></span></p>
    <p class="mb-0 text-muted"><b>Message:</b> <?= $data ?></p>
    <p class="mb-0 text-muted"><b>Date:</b> <?= $created_at ?></p>
    
</div>
<div class="row grid-margin">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Latest Messages</h4>
                <p class="card-description">Latest Public Messages Messages. </p>
                <div class="table-responsive" >
                    <table class="table table-sm" id="data-table"> 
                        <thead>
                            <tr>
                            <th>Message ID</th>
                            <th>Sent By</th>
                            <th>Sent On</th>
                            <th>Room</th>
                            <th>Message</th>
                            <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($messages) {
                                    foreach ($messages as $message) {
                            ?>
                            <tr>
                            <td><a href="/admin/dashboard/message/view/<?= $message->id ?>"><?= $message->id ?></a></td>
                            <td><a href="/admin/dashboard/users/view/<?= $message->uid ?>"><?= getUserbyID($message->uid)->username ?? '"' . (messageLookup($message->id ?? 0)->user ?? NULL ) . '"'  ?></a></td>
                            <td><?=$message->created_at ?? NULL ?></td>
                            <td><?= ($message->room > 0) ? getRoomInfo($message->room)->name : 'System Wide' ?></td>
                            <td><?=shortenString($message->data ,30) ?></td>
                            <td>
                                <a href="/admin/dashboard/message/view/<?= $message->id ?>" class="btn btn-outline-primary">View</a>
                                <a href="/admin/dashboard/flags/delete/<?= $message->id ?>" class="btn btn-outline-danger">Delete</a>
                            </td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
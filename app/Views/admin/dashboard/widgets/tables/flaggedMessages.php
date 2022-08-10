<div class="row grid-margin">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Flagged Messages</h4>
                <p class="card-description">All system flagged messages. </p>
                <div class="table-responsive" >
                    <table class="table" id="data-table"> 
                        <thead>
                            <tr>
                            <th>Message ID</th>
                            <th>Reported By</th>
                            <th>Reported On</th>
                            <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($flagged) {
                                    foreach ($flagged as $flag) {
                            ?>
                            <tr>
                            <td><a href="/admin/dashboard/message/view/<?= $flag->mid ?>"><?= $flag->mid ?></a></td>
                            <td><a href="/admin/dashboard/users/view/<?= $flag->uid ?>"><?= getUserbyID($flag->uid)->username ?? '"' . (messageLookup($flag->mid)->user ?? NULL ) . '"'  ?></a></td>
                            <td><?=$flag->created_at ?? NULL ?></td>
                            <td>
                                <a href="/admin/dashboard/message/view/<?= $flag->mid ?>" class="btn btn-outline-primary">View</a>
                                <a href="/admin/dashboard/flags/delete/<?= $flag->id ?>" class="btn btn-outline-danger">Delete</a>
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
<div class="row grid-margin">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Chatpic Groups</h4>
                <p class="card-description">Chatpic groups</p>
                <div class="table-responsive" >
                    <table class="table" id="data-table"> 
                        <thead>
                            <tr>
                            <th>Group</th>
                            <th>Enabled</th>
                            <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($groups) {
                                    foreach ($groups as $group) {
                            ?>
                            <tr>
                            <td><a href="/admin/chatpics/group/view/<?= $group->id ?>"><?= $group->keyword ?></a></td>
                            <td><?=$group->enabled ?? NULL ?></td>
                            <td>
                                <a href="/admin/chatpics/group/view/<?= $group->id ?>" class="btn btn-outline-primary">View</a>
                                <a href="/admin/chatpics/group/delete/<?= $group->id ?>" class="btn btn-outline-danger">Delete</a>
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
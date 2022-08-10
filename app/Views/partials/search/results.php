<?= $this->section('pageStyles') ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"/>
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<script src="/assets/vendors/datatables.net/jquery.dataTables.js" /></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#keywordResults').DataTable({
            "ordering": false,
            "searching": false
        });
        $('#keywordResultsUser').DataTable({
            "ordering": false,
            "searching": false
        });
        $('#keywordResultsMessages').DataTable({
            "ordering": false,
            "searching": false
        });
        $('#keywordResultsHandle').DataTable({
            "ordering": false,
            "searching": false
        });
        $('.dataTables_length').addClass('bs-select');
    });
</script>
<?= $this->endSection() ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="search-result-box card">
                    <div class="card-body bg-dark">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="pt-3 pb-4">
                               
                                <div class="mt-4 text-center">
                                    <h4>Keyword Search Results</h4></div>
                                    <?php //print_r( $tagsearchresults ) ?>

                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                    <ul class="nav nav-tabs tabs-bordered">
                        <li class="nav-item"><a href="#home" data-toggle="tab" aria-expanded="true" class="nav-link active">All results <span class="badge badge-success ml-1"><?php $i=0; foreach ($tagsearchresults as $type) {$i=$i+count($type); } echo $i; ?></span></a></li>
                        <li class="nav-item"><a href="#users" data-toggle="tab" aria-expanded="false" class="nav-link">Users <span class="badge badge-danger ml-1"><?= count($tagsearchresults['user']) ?></span></a></li>
                        <li class="nav-item"><a href="#messages" data-toggle="tab" aria-expanded="false" class="nav-link">Messages <span class="badge badge-danger ml-1"><?= count($tagsearchresults['messages']) ?></span></a></li>
                        <li class="nav-item"><a href="#handles" data-toggle="tab" aria-expanded="false" class="nav-link">Handles <span class="badge badge-danger ml-1"><?= count($tagsearchresults['handle']) ?></span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="home">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="keywordResults" class="table" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Results</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    foreach ($tagsearchresults as $type=>$result) {
                                                        foreach ($result as $item) {
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <?= view('Views/partials/search/searchItem'.ucfirst($type),(array) $item) ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                            
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end All results tab -->
                        <!-- Users tab -->
                        <div class="tab-pane" id="users">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="keywordResultsUser" class="table" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Results</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    foreach ($tagsearchresults['user'] as $item) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?= view('Views/partials/search/searchItemUser',(array) $item) ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- end Users tab -->
                        <!-- Messages tab -->
                        <div class="tab-pane" id="messages">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="keywordResultsMessages" class="table" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Results</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    foreach ($tagsearchresults['messages'] as $item) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?= view('Views/partials/search/searchItemMessages',(array) $item) ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- end Messages tab -->
                        <!-- Handles tab -->
                        <div class="tab-pane" id="handles">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="keywordResultsHandle" class="table" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Results</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                foreach ($tagsearchresults['handle'] as $item) {
                                    ?>
                                    <tr>
                                        <td>
                                    <?= view('Views/partials/search/searchItemHandle',(array) $item) ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- end Handles tab -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
</div> <!-- ./card-body -->

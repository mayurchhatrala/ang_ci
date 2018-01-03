<div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Manage Category</h1>
</div>
<div class="wrapper-md" ng-controller="CategoryDatatableCtrl">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row padding-0 margin-0">
                <div class="pull-left text-lg">Category List</div>
                <div class="pull-right">
                    <a href="<?= BASE_URL; ?>#/app/category/form" class="btn btn-dark btn-sm btn-rounded">
                        <i class="fa fa-plus-circle"></i>&nbsp; Add New Record
                    </a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table  ui-jq="dataTable" ui-options="options" class="table table-striped table-bordered b-t b-b">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Category Icon</th>
                        <th>Created Date</th>
                        <th>Last Updated</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

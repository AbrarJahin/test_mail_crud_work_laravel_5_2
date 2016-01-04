@extends('layouts.app')

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Users</div>

                <div class="panel-body">

                    <table id="employee-grid"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                            <thead>
                                <tr>
                                    <th>Employee name</th>
                                    <th>Salary</th>
                                    <th>Age</th>
                                    <th style="width: 1px;"><input type="checkbox" name="select_all" id="select_all"></th>
                                    <th  style="width: 70px;">Action</th>
                                </tr>
                            </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

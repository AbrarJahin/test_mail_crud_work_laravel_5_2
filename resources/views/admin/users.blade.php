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
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>UserType</th>
                                    <th>Status</th>
                                    <th>Signed Up Time</th>
                                    <th  style="width: 70px;">Action</th>
                                </tr>
                            </thead>
                    </table>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <meta name="terget_ajax_url" content="{{ route('users_list') }}">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

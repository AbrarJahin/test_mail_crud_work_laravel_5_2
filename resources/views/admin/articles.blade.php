@extends('layouts.app')

@section('content')
<div class="container spark-screen">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    <div class="panel-body">
                        @if($errors->any())
                            <div class="alert alert-success">
                              <strong>{{$errors->first()}}</strong>
                            </div>
                        @endif

                        <table id="admin_articles"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                                <thead>
                                    <tr>
                                        <th>Article Writer</th>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th>Status</th>
                                        <th>Writing Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                        </table>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <meta name="terget_ajax_url" content="{{ route('articles_list') }}">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container spark-screen">
    <!-- Add Data Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                Add New Article
                </h4>
            </div>

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/balance') }}">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="title">Amount</label>
                      <div class="col-sm-10">
                        <input name="balance" required type="number" class="form-control" placeholder="Enter Amount">
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Add Balance</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>

      </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Balance And Payments </div>

                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1">Current Balance</span>
                  <input disabled type="text" value="{{ $balance }}" class="form-control" aria-describedby="basic-addon1">
                  <span class="input-group-addon" id="basic-addon1"><button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#myModal">Add Balance</button></span>
                </div>

                <div class="panel-body">
                    @if($errors->any())
                        <div class="alert alert-success">
                          <strong>{{$errors->first()}}</strong>
                        </div>
                    @endif

                    @if(count($transections) > 0)
                    <table id="balance"  cellpadding="0" cellspacing="0" border="0" class="table display" width="100%">
                            <thead>
                                <tr>
                                    <th>Transaction Time</th>
                                    <th>Money Amount</th>
                                    <th>Transectio Done By</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($transections as $transection)
                                <tr>
                                  <td>{{$transection['created_at']}}</td>
                                  <td>{{$transection['money_amount']}}</td>
                                  <td>{{$transection['transection_by']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                    </table>
                    @endif

                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <meta name="terget_ajax_url" content="{{ route('my_articles_list') }}">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

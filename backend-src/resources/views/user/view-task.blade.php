@extends('layouts.app')

@section('content')
<style>
    .change-item-card {
        margin-top: 12px;
        padding: 10px;
        border: solid 1px #ccc;
    }
</style>
    <div class="container">
    <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body"  style="text-align: center;">

                        <a href="{{ url('/dashboard') }}" title="Back" class="float-left">
                            <button class="btn btn-secondary  btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
                        </a>

                        <span style="font-size: x-large">
                            {{ $changerequest->title }}
                        </span>






                    </div>
                    </div>
                    </div>
                    </div>
        <div class="row">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header markdown-section">
                            <h1 class="hdr1">Change Request</h1>
                    </div>
                    <div class="card-body">


                        <table class="table table-responsive" style="margin-top: 10px;">
                            <tbody>
                                <tr>
                                    <th  class="table-active">Creator</th>
                                    <td> {{ $changerequest->reported_by->name }} </td>
                                </tr>
                                <tr>
                                    <th  class="table-active">Status</th>
                                    <td> {{ $changerequest->statusTitle() }} </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="markdown-section">
                            {!! $changerequest->description !!}
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header markdown-section">
                            <h1 class="hdr1">Change Plan</h1>
                    </div>
                    <div class="card-body">

                    <div class="dropdown float-right" >
                        <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 140px">
                            Actions
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" data-toggle="modal" data-target="#formDescriptionModal" href="#">Edit Description</a>
                            <a class="dropdown-item" href="#">Change Status</a>
                            <a class="dropdown-item" href="#">Add Item</a>
                        </div>
                    </div>




                    <table class="table table-responsive" style="margin-top: 10px;">
                            <tbody>
                                <tr>
                                    <th class="table-active">Assigned to</th>
                                    <td> {{ $changerequest->assigned_to->name }} </td>
                                </tr>
                                <tr>
                                    <th  class="table-active">Status</th>
                                    <td> {{ $changeplan['statusTitle'] }} </td>
                                </tr>
                            </tbody>
                        </table>


                        <div class="markdown-section"
                            style="padding:20px;">
                            {!! $changeplan['description'] !!}
                        </div>
                        <hr/>
                        <div class="markdown-section">

                            <h1 class="hdr2">Change Plan Items</h1>
                        </div>

                        <div class="change-item-section">
                        @foreach ($changeitems as $changeitem)
                            <div class="change-item-card">
                                <div class="change-item-title">
                                    {{ $changeitem['title'] }}
                                </div>
                                <div class="change-item-description markdown-section">
                                    {{ $changeitem['description'] }}
                                </div>

                            </div>
                        @endforeach
                        </div>



                    </div>
                </div>
            </div>


        </div>
    </div>



    <div class="modal fade" id="formDescriptionModal" tabindex="-1" role="dialog" aria-labelledby="formDescriptionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formDescriptionModalLabel">General description</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="form-save-message" action="/task/{{ $changerequest->id }}/description">
        {{ csrf_field() }}
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" name="description"
            rows="10"
            cols="50"
             id="message-text">{{ $changeplan['description'] }}</textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" onclick="$('#form-save-message').submit()" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

@endsection

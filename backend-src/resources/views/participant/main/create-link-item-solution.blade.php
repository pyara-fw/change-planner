@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Create New Item Solution Link</div>
                    <div class="card-body">
                        <a href="{{ url('/participant/item-solution-link') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="/solution/{{ $solutionId }}/item/{{ $itemId }}/link" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="item_solution_id" value="{{ $itemId }}" />
                            <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Title' }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ isset($itemsolutionlink->title) ? $itemsolutionlink->title : ''}}" >
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">{{ 'Description' }}</label>
    <textarea class="form-control" rows="5" name="description" type="textarea" id="description" >{{ isset($itemsolutionlink->description) ? $itemsolutionlink->description : ''}}</textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('url') ? 'has-error' : ''}}">
    <label for="url" class="control-label">{{ 'Url' }}</label>
    <input class="form-control" name="url" type="text" id="url" value="{{ isset($itemsolutionlink->url) ? $itemsolutionlink->url : ''}}" required>
    {!! $errors->first('url', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
    <label for="type" class="control-label">{{ 'Type' }}</label>
    <select name="type" class="form-control" id="type" >
    @foreach (json_decode('{"image":"Image","document":"Document","video":"Video","external":"External page","other":"Other"}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($itemsolutionlink->type) && $itemsolutionlink->type == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group float-right">
    <input class="btn btn-primary btn-lg" type="submit" value="Create">
</div>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

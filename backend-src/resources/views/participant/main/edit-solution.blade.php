@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Edit the solution for task <code>{{ $task->title }}</code></div>
                    <div class="card-body">
                        <a href="/task/{{ $task->id }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="/solution/{{ $solution->id }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}


                            <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">{{ 'Description' }}</label>
    <textarea class="form-control" rows="20" name="description" type="textarea" id="description" >{{ isset($solution->description) ? $solution->description : ''}}</textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<input type="hidden" name="task_id" value="{{ $task->id }}"/>
<input type="hidden" name="user_id" value="{{ $userId }}"/>


<div class="form-group float-right">
    <input class="btn btn-primary btn-lg" type="submit" value="Update">
</div>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

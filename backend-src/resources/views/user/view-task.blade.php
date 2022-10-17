@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $changerequest->title }}</div>
                    <div class="card-body">

                        <a href="{{ url('/dashboard') }}" title="Back">
                            <button class="btn btn-secondary  btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
                        </a>


                        <form method="POST" action="/task/{{  $changerequest->id }}" accept-charset="UTF-8" style="display:inline" class="float-right">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary btn-sm" title="Get task" >
                                Get it <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                        </form>

                        <div class="table-responsive">
                            {!! html_entity_decode($changerequest->description) !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')

    <div class="container">
    <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body"  style="text-align: center;">

                        <a href="{{ url('/dashboard') }}" title="Back" class="float-left">
                            <button class="btn btn-secondary  btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button>
                        </a>

                        <span style="font-size: x-large">
                            {{ $task->title }}
                        </span>






                    </div>
                    </div>
                    </div>
                    </div>
        <div class="row">

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header markdown-section">
                            <h1 class="hdr1">Change Request</h1>
                    </div>
                    <div class="card-body">



                        <div class="markdown-section">
                            {!! $task->description !!}
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header markdown-section">
                            <h1 class="hdr1">Solution Plan</h1>
                    </div>
                    <div class="card-body">


@if (is_null($solution))
    <div style="text-align:center">
        <h2>There is no solution for this task.</h2>
        <a class="btn btn-lg btn-success" style="color:white"
            href="/task/{{ $task->id }}/solution/create"
        >Create a solution for this task</a>
    </div>
@else

<div class="dropdown float-right" >


@if ($solution->status != \App\Models\Solution::STATUS_SUBMITTED)
                        <a class="btn btn-info btn-sm " href="/solution/{{ $solution->id }}/edit" style="width: 140px">
                            <i class="fa fa-edit"></i>
                            Edit solution
                        </a>
@endif

                        <form method="POST" action="/solution/{{  $solution->id }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
                            @if ($solution->status == \App\Models\Solution::STATUS_SUBMITTED)
                            <input type="hidden" name="status" value="{{ \App\Models\Solution::STATUS_IN_PROGRESS }}"/>
                            <button type="submit" class="btn btn-warning btn-sm" title="Back solution in progress" onclick="return confirm(&quot;Confirm back in progress?&quot;)"><i class="fa fa-recycle" aria-hidden="true"></i> Back in progress</button>
                            @else
                            <input type="hidden" name="status" value="{{ \App\Models\Solution::STATUS_SUBMITTED }}"/>
                            <button type="submit" class="btn btn-warning btn-sm" title="Submit solution" onclick="return confirm(&quot;Confirm submission?&quot;)"><i class="fa fa-upload" aria-hidden="true"></i> Submit solution</button>
                            @endif
                        </form>
                    </div>


                    <table class="table table-responsive" style="margin-top: 10px;">
                            <tbody>
                                <tr>
                                    <th  class="table-active">Status</th>
                                    <td> {{ $solution->status() }} </td>
                                </tr>
                            </tbody>
                        </table>


                        <div class="markdown-section"
                            style="padding:20px;">
                            <label>Description</label> <br/>
                            {!! $solution->getFormattedDescription() !!}
                        </div>
                        <hr/>
                        <div class="markdown-section">
@if ($solution->status != \App\Models\Solution::STATUS_SUBMITTED)
                            <div class="float-right btn-bar">
                                <a class="btn btn-sm btn-success "
                                    href="/solution/{{ $solution['id'] }}/item/create"
                                >
                                    <i class="fa fa-plus"></i>
                                    Add
                                </a>
                            </div>
@endif
                            <h1 class="hdr2">Solution Plan Items</h1>
                        </div>

                        <div class="change-item-section">
                        @foreach ($itemSolutions as $itemSolution)
                            <div class="change-item-card">
                                <div class="change-item-title">

@if ($solution->status != \App\Models\Solution::STATUS_SUBMITTED)
                                    <div class="float-right btn-bar">
                                        <a class="btn btn-sm btn-primary"
                                            href="/solution/{{ $solution['id'] }}/item/{{ $itemSolution['id'] }}"
                                            >
                                            <i class="fa fa-pencil"></i>
                                            Edit
                                        </a>
                                        &nbsp;
                                        <a class="btn btn-sm btn-danger ">
                                            <i class="fa fa-trash"></i>
                                            Del</a>
                                    </div>
@endif
                                    {{ $itemSolution['title'] }}
                                </div>
                                <div class="change-item-description markdown-section">
                                    {{ $itemSolution['description'] }}
                                </div>

                                @if ($itemSolution['links'])
                                    @foreach ($itemSolution['links'] as $link)
                                    <div style="font-size:small; color: navy;">
                                    <i class="fa fa-link"></i>  {{ $link['title'] }}
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                        </div>

@endif

                    </div>
                </div>
            </div>


        </div>
    </div>



@endsection

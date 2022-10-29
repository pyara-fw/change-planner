<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>
    @section('content')

    <div class="row" style='margin-top: 24px'>
        <div class="col-md-1">&nbsp;</div>
        <div class="col-md-10 ">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Tags</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td><span class="badge badge-{{$task->formattedStatus[0]}}">{{ $task->formattedStatus[1]}}</span></td>
                        <td>
                        @foreach ($task->formattedTags as $formattedTag)
                            <span class="badge {{ $formattedTag['class'] }}">{{ $formattedTag['text'] }}</span>
                        @endforeach
                        </td>
                        <td>
                            <a href="/task/{{ $task->id }}" class="btn btn-sm btn-primary"> <i class="fa fa-eye"></i> View</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    @endsection
</x-app-layout>

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


    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:larger;font-weight:bolder">Congrats, you finished all tasks!</h5>
      </div>
      <div class="modal-body">
        Now, please fill this last survey.
      </div>
      <div class="modal-footer">
        <a href="{{ $postSurveyURL }}" class="btn btn-primary">Survey</a>
      </div>
    </div>
  </div>
</div>
@if (isset($statusCount['Pending']) || isset($statusCount['In Progress']))
    @else
    <script>
        $('#exampleModalCenter').modal('show');
    </script>
    @endif

    @endsection
</x-app-layout>

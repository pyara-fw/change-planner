<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>
    @section('content')

        <div class="row" style='margin-top: 24px'>

            @foreach ($tasks as $task)
                @include('user.task-item', $task)
            @endforeach

        </div>

    @endsection
</x-app-layout>

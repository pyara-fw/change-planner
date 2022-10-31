<div class="col-sm-4">
    <div class="card" style="width: 26rem;">
        <div class="card-header">
            {{ $title }}
        </div>
        <div class="card-body" style="overflow-y: auto;">
            <div class="markdown-section" style="height: 250px; font-size: small;">
                {!! $description !!}
            </div>



        </div>
        <div class="card-footer">
            <div>
                Status: <span class="badge badge-{{$formattedStatus[0]}}">{{ $formattedStatus[1]}}</span>
            </div>
            <div>
                @foreach ($formattedTags as $formattedTag)
                <span class="badge {{ $formattedTag['class'] }}">{{ $formattedTag['text'] }}</span>
                @endforeach

            </div>

        <hr/>
            <a href='/task/{{ $id }}' class="btn btn-dark btn-block">View</a>
        </div>
    </div>
</div>



<div class="col-sm-4">
    <div class="card" style="width: 26rem;">
        <div class="card-header">
            {{ $title }}
        </div>
        <div class="card-body" style="overflow-y: auto;">
            <p class="card-text" style="height: 8rem; ">
                {{ $description }}
            </p>
        </div>
        <div class="card-footer">
            <a href='/task/{{ $id }}' class="btn btn-primary">View</a>
        </div>
    </div>
</div>



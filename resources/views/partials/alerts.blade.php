<div class="text-center">
    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session()->get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(session()->has('failure'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session()->get('failure') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

</div>
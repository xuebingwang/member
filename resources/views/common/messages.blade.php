<div class="col-md-12">
    @if (isset($message))
        <div class="alert alert-success alert-dismissible" role="alert" style="margin-bottom: 15px;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <p><strong>提示：</strong></p>
            <p><strong>{{ $message }}</strong></p>
        </div>
    @endif

    @if (isset($errors) && count($errors) > 0)
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            @foreach ($errors->all() as $error)
                <p><strong>{{ $error }}</strong></p>
            @endforeach
        </div>
    @endif
</div>
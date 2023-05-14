<!-- Alerts -->
<div class="">
    @if ($message = Session::get('success'))
    <div class="alert alert-dismissible alert-success bd bd-success-400" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex align-items-center justify-content-start">
            <i class="icon ion-ios-checkmark alert-icon text-32 mg-t-5 mg-xs-t-0"></i>
            <span><strong>Well done!</strong> {{ $message }}</span>
        </div><!-- d-flex -->
    </div><!-- alert -->
    @elseif ($message = Session::get('error'))
    <div class="alert alert-dismissible alert-danger bd bd-danger-400" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex align-items-center justify-content-start">
            <i class="icon ion-ios-checkmark alert-icon text-32 mg-t-5 mg-xs-t-0"></i>
            <span><strong>Sorry,</strong> {{ $message }}</span>
        </div><!-- d-flex -->
    </div><!-- alert -->
    @elseif ($errors->all())
    <div class="alert alert-dismissible alert-danger bd bd-danger-400" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex align-items-center justify-content-start">
            <i class="icon ion-ios-checkmark alert-icon text-32 mg-t-5 mg-xs-t-0"></i>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><!-- d-flex -->
    </div><!-- alert -->
    @endif
</div>
<!-- alerts end -->
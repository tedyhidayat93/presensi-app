@extends('layouts.admin.app', [
'title' => 'Site Setting ',
'head_title_per_page' => "Site Setting",
'sub_title_per_page' => "",
'breadcrumbs' => [
[
'title' => 'Dashboard',
'link' => route('adm.dashboard'),
'is_active' => false,
],
[
'title' => 'Site Setting',
'link' => '#',
'is_active' => true,
],
]
])


@section('content')
<div class="section">
    <div class="pd-10 bd rounded bg-light">
        <ul class="nav nav-pills flex-column flex-md-row" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#general" role="tab">General
                    Setting</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#company" role="tab">Company</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#contact" role="tab">Contacts</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#socialmedia" role="tab">Social Media</a>
            </li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#copyright" role="tab">Copyright</a></li>
        </ul>
    </div>

    <div class="row mt-3">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">General</div>
                <div class="tab-pane fade show" id="company" role="tabpanel" aria-labelledby="company-tab">Company</div>
                <div class="tab-pane fade show" id="contact" role="tabpanel" aria-labelledby="contact-tab">Contacts</div>
                <div class="tab-pane fade show" id="socialmedia" role="tabpanel" aria-labelledby="socialmedia-tab">Social Media
                </div>
                <div class="tab-pane fade show" id="copyright" role="tabpanel" aria-labelledby="copyright-tab">Copyright</div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection


@push('active-client')
active
@endpush

@push('menuOpen-client')
style="display: block;"
@endpush

@push('showSub-client')
show-sub
@endpush

@push('styles')
@endpush

@push('scripts')
@endpush

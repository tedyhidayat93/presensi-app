@include('layouts.app_panel.header')
@include('layouts.app_panel.navbar')
@include('layouts.app_panel.sidebar')      


<div class="main-content">
    @include('layouts.app_panel.alerts')      
    
@yield('content')
</div>

@include('layouts.app_panel.footer')


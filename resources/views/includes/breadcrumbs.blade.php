<div class="breadcrumbs mb-4">
    <div style="text-align: center">
        <h4>{{ $page }}</h4>
        @if (isset($isService) && $isService)
        <div class="bread-links">
            <a href="{{ route('welcome',['lang'=>$lang]) }}">Home  /</a>
            <a href="{{ route('services',['lang'=>$lang]) }}">Services  /</a>
            <a> {{ $page }}</a>
        </div>
        @else
        <div class="bread-links">
            <a href="{{ route('welcome',['lang'=>$lang]) }}">Home  /</a>
            <a> {{ $page }}</a>
        </div>
        @endif
    </div>
</div>

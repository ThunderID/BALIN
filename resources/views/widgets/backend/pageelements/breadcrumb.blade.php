<ol class="breadcrumb">
    <li>
        <a href="{{ route('backend.home') }}">Home</a>
    </li>
    @foreach($WB_breadcrumbs as $b_title => $b_url)
        @if($b_url == end($WB_breadcrumbs))
            <li class="active">
                <a href="{{ $b_url }}"><strong>{{$b_title }}</strong></a>
            </li>
        @else
            <li>
                <a href="{{ $b_url }}"> {{$b_title}} </a>
            </li>
        @endif
    @endforeach
</ol>
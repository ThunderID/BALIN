<div class="row">
    <div class="col-lg-12">        
        <ol class="breadcrumb">
            <li class="active">
                <a href="{{ URL::route('backend.home') }}"><i class="fa fa-home"></i> Home </a>
            </li>
            @foreach($WB_breadcrumbs as $b_title => $b_url)
                <li class="active">
                    @if($b_url == end($WB_breadcrumbs))
                        {{$b_title}} 
                    @else
                        <a href="{{ route($b_url) }}"> {{$b_title}} </a>
                    @endif
	            </li>
            @endforeach
        </ol>
    </div>
</div>
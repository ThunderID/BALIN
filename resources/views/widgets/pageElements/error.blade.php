<div class="container">
    <div class="row page404">
        <div class="col-lg-12 col-md-12 text-center">
        	<h1 style="font-size:150px;">{{$errorCode}}</h1>
            @if($errorCode == 404)
            	<h3>Page not found</h3>
            @else
                <h3>Something wrong</h3>
            @endif
        </div>            
    </div>
</br>
    <div class="row">
    	<div class="col-lg-12 col-md-12">
    		<div class="row">
    			<div class="col-md-5">
    			</div>        			
    			<div class="col-md-2">
                    <a class="btn btn-default btn-primary btn-block" href="{{ URL::route('frontend.index') }}">Back Home</a>
    			</div>        			
    			<div class="col-md-5">
    			</div>
    		</div>	
    	</div>
    </div>
</div>
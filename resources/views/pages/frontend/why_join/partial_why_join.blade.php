<div class="container">
    <div class="row">
        <div class="col-lg-12">
            @include('widgets.pageelements.pagetitle', array('pagetitle' => 'Why Join'))

            @include('widgets.descriptionWithImageRight')  

            @include('widgets.descriptionWithImageLeft') 

            @include('widgets.descriptionWithImageRight')                           

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 text-center">
                    <H2 class="text-center">What are you waiting for?</H2>
                    <a class="btn-hollow hollow-black btn-block" href="{{ URL::route('frontend.join.index') }}">JOIN NOW</a>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
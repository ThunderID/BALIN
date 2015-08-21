<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::route('frontend.home.index') }}">{!! HTML::image('Balin/image/logo.png') !!}</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-right" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li @if($controller_name == 'home') class=active @endif  }}>
                    <a href="{{ URL::route('frontend.home.index') }}">Home</a>
                </li>
                <li @if($controller_name == 'product') class=active @endif >
                    <a href="{{ URL::route('frontend.product.index') }}">Products</a>
                </li>
                <li @if($controller_name == 'join') class=active @endif >
                    <a href="{{ URL::route('frontend.join.index') }}">Join</a>
                </li>
                <li @if($controller_name == 'whyjoin') class=active @endif>
                    <a href="{{ URL::route('frontend.whyjoin.index') }}">Why Join</a>
                </li>    
                <li @if($controller_name == 'profile') class=active @endif>
                    <a href="{{ URL::route('frontend.profile.index') }}">Profile</a>
                </li> 
                <li @if($controller_name == 'cart') class=active @endif class="dropdown">
                    <!-- <a href="{{ URL::route('frontend.cart.index') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cart</a> -->
                     
                    <a href="{{ URL::route('frontend.cart.index') }}" class="dropdown-toggle">Cart</a>

                    <ul class="dropdown-menu dropdown-menu-right chart-dropdown" aria-labelledby="dLabel">
                        <li class="chart-dropdown-item-grid">
                            <div class="row">
                                <div class="col-xs-12" style="margin:5px;">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <a href="#">
                                                <img class="image-responsive" style="height:80px;width:60px;"  src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-2/72/product-icon.png" >
                                            </a>
                                        </div>
                                        <div class="col-xs-8">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <h4>Batik Andong Cap Jagung</h4>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top:0px;">
                                                <div class="col-xs-12">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <p>Qty</p>
                                                        </div>
                                                        <div class="col-xs-1">
                                                            <p>:</p>
                                                        </div>
                                                        <div class="col-xs-6" style="padding-left: 2px;">
                                                            <p>1</p>
                                                        </div>                                                                                                                
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top:0px;">
                                                <div class="col-xs-12">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <p>Price/Item</p>
                                                        </div>
                                                        <div class="col-xs-1">
                                                            <p>:</p>
                                                        </div>
                                                        <div class="col-xs-6" style="padding-left: 2px;">
                                                            <p>RP 80.000</p>
                                                        </div>                                                                                                                
                                                    </div>                                                    
                                                </div>
                                            </div>                                                    
                                            <div class="row" style="margin-top:0px;">
                                                <div class="col-xs-12"> 
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <p>Total</p>
                                                        </div>
                                                        <div class="col-xs-1">
                                                            <p>:</p>
                                                        </div>
                                                        <div class="col-xs-6" style="padding-left: 2px;">
                                                            <p>RP 12.080.000</p>
                                                        </div>                                                                                                                
                                                    </div>                                             
                                                </div>                                                
                                            </div>                                                                                         
                                        </div> 
                                    </div>
                                </div>                                                                                                                       
                            </div>
                        </li>
                        <li class="chart-lowLine">
                            <div class="row">
                                <div class="col-xs-12" style="margin:5px;">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <a href="#">
                                                <img class="image-responsive" style="height:80px;width:60px;"  src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-2/72/product-icon.png" >
                                            </a>
                                        </div>
                                        <div class="col-xs-8">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <h4>Batik Andong Cap Jagung</h4>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top:0px;">
                                                <div class="col-xs-12">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <p>Qty</p>
                                                        </div>
                                                        <div class="col-xs-1">
                                                            <p>:</p>
                                                        </div>
                                                        <div class="col-xs-6" style="padding-left: 2px;">
                                                            <p>1</p>
                                                        </div>                                                                                                                
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top:0px;">
                                                <div class="col-xs-12">
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <p>Price/Item</p>
                                                        </div>
                                                        <div class="col-xs-1">
                                                            <p>:</p>
                                                        </div>
                                                        <div class="col-xs-6" style="padding-left: 2px;">
                                                            <p>RP 80.000</p>
                                                        </div>                                                                                                                
                                                    </div>                                                    
                                                </div>
                                            </div>                                                    
                                            <div class="row" style="margin-top:0px;">
                                                <div class="col-xs-12"> 
                                                    <div class="row">
                                                        <div class="col-xs-4">
                                                            <p>Total</p>
                                                        </div>
                                                        <div class="col-xs-1">
                                                            <p>:</p>
                                                        </div>
                                                        <div class="col-xs-6" style="padding-left: 2px;">
                                                            <p>RP 12.080.000</p>
                                                        </div>                                                                                                                
                                                    </div>                                             
                                                </div>                                                
                                            </div>                                                                                         
                                        </div> 
                                    </div>
                                </div>                                                                                                                       
                            </div>
                        </li>                        
                        <li class="chart-dropdown-subtotal chart-lowLine">
                            <div class="row">
                                <div class="col-sm-12" style="margin:5px;">
                                    <p class="text-center">SUBTOTAL <Span style="font-weight:400;margin-left:25px;"> RP 11.234.123</span></p>
                                </div>
                            </div>
                        </li>  
                        <li>
                            <div class="row">
                                <div class="col-xs-12 text-center" style=" ">
                                    <button type="button" class="btn btn-sm btn-info">
                                        Open Cart
                                    </button>                                     
                                    <button type="button" class="btn btn-sm btn-success">
                                        Checkout
                                    </button>   
                                </div>
                            </div>
                        </li>                                                                    
                    </ul>
                </li>                                                    
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
</nav>
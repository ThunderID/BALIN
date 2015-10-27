<ul class="dropdown-menu dropdown-menu-right chart-dropdown m-t-md" aria-labelledby="dLabel" style="margin-top:3px">
    <li class="chart-dropdown-item-grid">
        @include('widgets.frontend.cart.cartItem', array(
            'labelName'             => 'Batik Andong Cap Jagung',
            'labelQty'              => '1',
            'labelPrice'            => 'RP 1.200.000',
            'labelTotal'            => 'Rp 1.200.000'
        ))
    </li>
    <li class="chart-lowLine">
        @include('widgets.frontend.cart.cartItem', array(
            'labelName'             => 'Batik Polong Cap Singkong',
            'labelQty'              => '2',
            'labelPrice'            => 'RP 600.000',
            'labelTotal'            => 'Rp 1.200.000'
        ))
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
                <a href="{{ URL::route('frontend.cart.index') }}" class="btn btn-sm btn-info btn-text-white">Open Cart</a>                                   
                <button type="button" class="btn btn-sm btn-success">
                    Checkout
                </button>   
            </div>
        </div>
    </li>                                                                    
</ul>
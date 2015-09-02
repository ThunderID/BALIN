<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top backend-top-navbar" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="{{ URL::route('frontend.home.index') }}">{!! HTML::image('Balin/admin/image/logo.png') !!}</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
            <ul class="dropdown-menu alert-dropdown">
                <li>
                    <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                </li>
                <li>
                    <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#">View All</a>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> John Smith <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse ex3" role="navigation" id="side-menu" aria-expanded="">
        <ul class="nav navbar-nav side-nav ex3">
            <li>
                <a href="{{ URL::route('backend.home') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard </a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#down-administrative"><i class="fa fa-fw fa-unlock-alt"></i> Administrative <i class="fa arrow pull-right"></i></a>
                <ul id="down-administrative" class="collapse">
                    <li>
                        <a href="#">Admin</a>
                    </li>                                                                                                                
                    <li>
                        <a href="#">Data User</a>
                    </li>    
                    <li>
                        <a href="#">Ganti Password User</a>
                    </li>   
                    <li>
                        <a href="#">Blokir User</a>
                    </li>  
                    <li>
                        <a href="#">Log User</a>
                    </li>                      
                    <li>
                        <a href="#">Log Aplikasi</a>
                    </li>                      
                </ul>                    
            </li>  
            <li>
                <a href="#"><i class="fa fa-fw fa-users"></i> Customer </a>               
            </li>            
            <li>
                <a href="#"><i class="fa fa-fw fa-archive"></i> inventory </a>
            </li>    
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#down-transaction"><i class="fa fa-fw fa-briefcase"></i> Transaksi <i class="fa arrow pull-right"></i></a>
                <ul id="down-transaction" class="collapse">
                    <li>
                        <a href="#">Penjualan</a>
                    </li>  
                    <li>
                        <a href="#">Retur</a>
                    </li>       
                    <li>
                        <a href="#">Kupon</a>
                    </li>                                                                               
                </ul>                    
            </li>  
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#down-payment"><i class="fa fa-fw fa-money"></i> Pembayaran <i class="fa arrow pull-right"></i></a>
                <ul id="down-payment" class="collapse">
                    <li>
                        <a href="#">Validasi Pembayaran</a>
                    </li>  
                    <li>
                        <a href="#">Data Pembayaran</a>
                    </li>                                                               
                </ul>                
            </li>     
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#down-shipping"><i class="fa fa-fw fa-truck"></i> Pengiriman Barang <i class="fa arrow pull-right"></i></a>
                <ul id="down-shipping" class="collapse">
                    <li>
                        <a href="#">Kirim Barang</a>
                    </li>   
                    <li>
                        <a href="#">Data Pengiriman</a>
                    </li>   
                    <li>
                        <a href="#">Kurir</a>
                    </li>                                                                                              
                </ul>                
            </li>   
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#down-report"><i class="fa fa-fw fa-file"></i> Laporan <i class="fa arrow pull-right"></i></a>
                <ul id="down-report" class="collapse">
                    <li>
                        <a href="#">Laporan Penjualan</a>
                    </li>  
                    <li>
                        <a href="#">Laporan Kupon</a>
                    </li>                           
                    <li>
                        <a href="#">Laporan Stock</a>
                    </li>                                                                           
                </ul>                
            </li>                               
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#down-setting"><i class="fa fa-fw fa-cogs"></i> Settings <i class="fa arrow pull-right"></i></a>
                <ul id="down-setting" class="collapse">
                    <li>
                        <a href="#">Homepage config</a>
                    </li>                                          
                </ul>
            </li>                              
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>

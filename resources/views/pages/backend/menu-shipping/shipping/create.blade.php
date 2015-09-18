{!! Form::open(array('route' => 'backend.shipping.save', 'class' => 'modal1')) !!}
    {!!Form::input('hidden', 'id', NULL,  ['class' => 'mod_id']) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="nota_transaksi">Nota Transaksi</label>
                {!! Form::text('nota_transaksi', null, ['class' => 'form-control mod_nota_transaksi',  'id' => 'find_nota', 'required' => 'required', 'tabindex' => '1'] ) !!}
            </div>
            <div class="form-group">
                <label for="courier">Kurir</label>
                {!! Form::text('courier', null, ['class' => 'form-control mod_courier', 'id' => 'find_courier', 'required' => 'required', 'tabindex' => '1'] ) !!}
            </div>
            <div class="form-group">
                <label for="resi">Resi Pengiriman</label>
                {!! Form::text('resi', null, ['class' => 'form-control mod_resi', 'required' => 'required', 'tabindex' => '1'] ) !!}
            </div>
            <div class="form-group">
                <label for="cost">Biaya Pengiriman</label>
                {!! Form::text('cost', null, ['class' => 'form-control mod_cost', 'required' => 'required', 'tabindex' => '1'] ) !!}
            </div>            
            <div class="form-group">
                <label for="date">Tanggal Pengiriman</label>
                {!! Form::input('date','date', null, ['class' => 'form-control mod_date', 'required' => 'required', 'tabindex' => '1'] ) !!}
            </div>              
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Nama Penerima</label>
                {!! Form::text('name', null, ['class' => 'form-control mod_name', 'required' => 'required', 'tabindex' => '1'] ) !!}
            </div>   
            <div class="form-group">
                <label for="phone">Nomor Telepon Penerima</label>
                {!! Form::text('phone', null, ['class' => 'form-control mod_phone', 'required' => 'required', 'tabindex' => '1'] ) !!}
            </div>   
            <div class="form-group">
                <label for="address">Alamat Penerima</label>
                {!! Form::textarea('address', null, ['class' => 'form-control mod_address', 'rows' => '3', 'tabindex' => '1', 'style' => 'resize:none;'] ) !!}
            </div> 
            <div class="form-group">
                <label for="zip">Kode Pos</label>
                {!! Form::text('zip', null, ['class' => 'form-control mod_zip', 'required' => 'required', 'tabindex' => '1'] ) !!}
            </div>                    
        </div>                                          
    </div>
	</br>
	<div class="form-group">
	    <button type="submit" class="btn btn-md btn-block btn-success mod_button" tabindex="1"></button>
	</div>
    <div class="form-group">
        <button type="button" class="btn btn-md btn-block btn-default" tabindex="1" data-dismiss="modal">Batal</button>
    </div>    
{!! Form::close() !!}



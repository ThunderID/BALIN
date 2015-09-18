{!! Form::open(array('route' => 'backend.courier.detail.save', 'class' => 'modal1')) !!}
    {!!Form::input('hidden', 'id', NULL,  ['class' => 'mod_id']) !!}                                          
    {!!Form::input('hidden', 'courier_id', $data['id']) !!}                                          
    <div class="form-group">
        <label for="nota_transaksi">Nota Transaksi</label>
        {!! Form::text('nota_transaksi', null, ['class' => 'form-control mod_nota_transaksi', 'required' => 'required', 'tabindex' => '1'] ) !!}
    </div>    
    <div class="form-group">
        <label for="name">Nama</label>
        {!! Form::text('name', null, ['class' => 'form-control mod_name', 'required' => 'required', 'tabindex' => '1'] ) !!}
    </div>
    <div class="form-group">
        <label for="bank">Bank</label>
        {!! Form::text('bank', null, ['class' => 'form-control mod_bank', 'required' => 'required', 'tabindex' => '1'] ) !!}
    </div>  
    <div class="form-group">
        <label for="acc_no">Nomor Rekening</label>
        {!! Form::text('acc_no', null, ['class' => 'form-control mod_acc_no', 'required' => 'required', 'tabindex' => '1'] ) !!}
    </div> 
    <div class="form-group">
        <label for="date">Tanggal Pembayaran</label>
        {!! Form::input('date','date', null, ['class' => 'form-control mod_date', 'required' => 'required', 'tabindex' => '1'] ) !!}
    </div>           
	</br>
	<div class="form-group">
	    <button type="submit" class="btn btn-md btn-block btn-success mod_button" tabindex="1"></button>
	</div>
    <div class="form-group">
        <button type="button" class="btn btn-md btn-block btn-default" tabindex="1" data-dismiss="modal">Batal</button>
    </div>    
{!! Form::close() !!}

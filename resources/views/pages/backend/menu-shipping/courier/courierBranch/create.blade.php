{!! Form::open(array('route' => 'backend.courier.detail.save', 'class' => 'modal1')) !!}
    {!!Form::input('hidden', 'id', NULL,  ['class' => 'mod_id']) !!}                                          
    {!!Form::input('hidden', 'courier_id', $data['id']) !!}                                          
    <div class="form-group">
        <label for="name">Nama Cabang</label>
        {!! Form::text('name', null, ['class' => 'form-control mod_name', 'required' => 'required', 'tabindex' => '1'] ) !!}
    </div>
    <div class="form-group">
        <label for="status">Status Kantor Cabang</label>
        {!! Form::select('status', array('0' => 'Tidak Aktif', '1' => 'Aktif'),null,['class' => 'form-control mod_status', 'rows' => '3', 'tabindex' => '1', 'style' => 'padding-left:7px;']) !!}
    </div>					
    <div class="form-group">
        <label for="phone">Nomor Telepon</label>
        {!! Form::text('phone', null, ['class' => 'form-control mod_phone', 'required' => 'required', 'tabindex' => '1'] ) !!}
    </div>
    <div class="form-group">
	    <label for="address">Alamat</label>
	    {!! Form::textarea('address', null, ['class' => 'form-control mod_address', 'rows' => '3', 'tabindex' => '1', 'style' => 'resize:none;'] ) !!}
	</div>
	</br>
	<div class="form-group">
	    <button type="submit" class="btn btn-md btn-block btn-success mod_button" tabindex="1"></button>
	</div>
    <div class="form-group">
        <button type="button" class="btn btn-md btn-block btn-default" tabindex="1" data-dismiss="modal">Batal</button>
    </div>    
{!! Form::close() !!}


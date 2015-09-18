{!! Form::open(array('route' => 'backend.courier.save', 'class' => 'modal1')) !!}
    {!!Form::input('hidden', 'id', NULL,  ['class' => 'mod_id']) !!}
    <div class="row">
    	<div class="col-md-6">
			<div class="form-group">
		        <label for="name">Nama Lengkap</label>
		        {!! Form::text('name', null, ['class' => 'form-control mod_name', 'required' => 'required', 'tabindex' => '1'] ) !!}
		    </div>
			<div class="form-group">
		        <label for="gender">Jenis Kelamin</label>
		        {!! Form::text('gender', null, ['class' => 'form-control mod_gender', 'required' => 'required', 'tabindex' => '1'] ) !!}
		    </div>                                      
			<div class="form-group">
		        <label for="dob">Tanggal Lahir</label>
		        {!! Form::text('dob', null, ['class' => 'form-control mod_dob', 'required' => 'required', 'tabindex' => '1'] ) !!}
		    </div>  
			<div class="form-group">
		        <label for="email">Email</label>
		        {!! Form::text('email', null, ['class' => 'form-control mod_email', 'required' => 'required', 'tabindex' => '1'] ) !!}
		    </div>  
    	</div>
    	<div class="col-md-6">
			<div class="form-group">
		        <label for="phone">Nomor Telepon</label>
		        {!! Form::text('phone', null, ['class' => 'form-control mod_phone', 'required' => 'required', 'tabindex' => '1'] ) !!}
		    </div> 
			<div class="form-group">
		        <label for="address">Alamat lengkap</label>
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
{!! Form::open(array('route' => 'backend.customer.destroy', 'class' => 'modal1')) !!}
    {!!Form::input('hidden', 'id', NULL,  ['class' => 'mod_id']) !!}   
    <div class="form-group">
        <p>Isikan password Anda sebagai konfirmasi penghapusan data.</p>
    </div>                  
    <div class="form-group">
        <label for="pwd">Password</label>
        {!! Form::Password('pwd', ['class' => 'form-control mod_pwd', 'required' => 'required', 'tabindex' => '1'] ) !!}
    </div>
	</br>
    <div class="form-group">
        <button type="submit" class="btn btn-md btn-block btn-danger mod_button" tabindex="1"></button>
    </div>
    <div class="form-group">
        <button type="button" class="btn btn-md btn-block btn-default" tabindex="1" data-dismiss="modal">Batal</button>
    </div>    
{!! Form::close() !!}


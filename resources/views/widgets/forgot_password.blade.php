{!! Form::open(['url' => route('frontend.dologin')]) !!}
    <div class="form-group">
        <label for="email">Email</label>
        {!! Form::email('email', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Email', 'required' => 'required']) !!}
    </div>
    <div class="clearfix">&nbsp;</div>
	<div class="form-group">
	    <button type="submit" class="btn-hollow hollow-black-border" tabindex="1">Kirim</button>
	    <a class="btn-hollow hollow-black-border btn-cancel" tabindex="1">Batal</a>
	</div>
{!! Form::close() !!}
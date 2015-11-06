{!! Form::open(['url' => route('frontend.dologin')]) !!}
    <div class="form-group">
        <label for="email">Email</label>
        {!! Form::email('email', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Email', 'required' => 'required']) !!}
    </div>
    <div class="clearfix">&nbsp;</div>
	<div class="form-group">
	    <button type="submit" class="btn-hollow hollow-black" tabindex="1">Kirim</button>
	    <a class="btn-hollow hollow-black btn-cancel" tabindex="1">Cancel</a>
	</div>
{!! Form::close() !!}
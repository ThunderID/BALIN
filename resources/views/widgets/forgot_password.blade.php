{!! Form::open(['url' => route('frontend.doforgot')]) !!}
    <div class="form-group">
        <label for="email">Email</label>
        {!! Form::email('email', null, ['class' => 'form-control hollow', 'placeholder' => 'Masukkan Email', 'required' => 'required']) !!}
    </div>
    <div class="clearfix">&nbsp;</div>
	<div class="form-group text-right">
		<a href="#" class="link-black btn-cancel">Cancel</a>&nbsp;&nbsp;&nbsp;
	    <button type="submit" class="btn-hollow hollow-black-border" tabindex="1">Kirim</button>
	</div>
{!! Form::close() !!}
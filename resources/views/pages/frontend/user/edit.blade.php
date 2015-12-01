<?php
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
?>	
	<div class="row">
		<div class="col-sm-12">
		    {!! Form::open(['url' => route('frontend.user.update'), 'method' => 'POST', 'class' => 'form']) !!}
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="hollow-label">Nama Lengkap</label>
							{!! Form::text('name', Auth::user()['name'], ['class' => 'form-control hollow mod_name', 'required' => 'required', 'tabindex' => '1', 'placeholder' => 'Masukkan nama lengkap'] ) !!}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="hollow-label">Email</label>
							{!! Form::text('email', Auth::user()['email'], ['class' => 'form-control hollow mod_email', 'tabindex' => '2', 'placeholder' => 'Masukkan email', 'disable']) !!}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="hollow-label">Tanggal Lahir</label>
							@if(isMobile())
								<?php
									$date = null;
									if(strtotime(Auth::user()['date_of_birth']) != 0){$date = date_format(Auth::user()['date_of_birth'],"Y-m-d");}
								?>
								{!! Form::input('date','date_of_birth', $date, ['class' => 'form-control hollow mod_dob date-format', 'id' => 'coba', 'tabindex' => '3', 'placeholder' => 'Masukkan tanggal lahir', 'data-date' => '01-01-1950'] ) !!}
							@else
								<?php
									$date = null;
									if(strtotime(Auth::user()['date_of_birth']) != 0){$date = date_format(Auth::user()['date_of_birth'],"d-m-Y");}
								?>
								{!! Form::text('date_of_birth', $date, ['class' => 'form-control hollow mod_dob date-format', 'id' => 'coba', 'tabindex' => '3', 'placeholder' => 'Masukkan tanggal lahir', 'data-date' => '01-01-1950'] ) !!}
							@endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="hollow-label">Jenis Kelamin</label>
							{!! Form::select('gender', ['male' => 'Pria', 'female' => 'Wanita'], Auth::user()['gender'], ['class' => 'form-control hollow', 'required' => 'required', 'tabindex' => '4']) !!}
						</div>  
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="hollow-label">Password</label>
							{!! Form::password('password', ['class' => 'form-control hollow', 'placeholder' => 'Masukkan password', 'tabindex' => '5']) !!}
							<span class="help-block m-b-none">* Biarkan kosong jika tidak ingin mengubah password</span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="hollow-label">Konfirmasi Password</label>
							{!! Form::password('password_confirmation', ['class' => 'form-control hollow', 'placeholder' => 'Masukkan konfirmasi password', 'tabindex' => '6']) !!}
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group text-right">
							<button type="button" class="btn-hollow hollow-black hollow-black-border" data-dismiss="modal">Batal</button>
							<button type="submit" class="btn-hollow hollow-black hollow-black-border" tabindex="7">Simpan</button>
						</div>        
					</div>        
				</div>    
			{!! Form::close() !!}
		</div>
	</div>

@if(!isMobile())
<script>
    $(".date-format").inputmask({
        mask: "d-m-y",
        placeholder: "dd-mm-yyyy",
        alias: "date",
    }); 
</script>
@endif
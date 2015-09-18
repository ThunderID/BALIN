{!! Form::open(array('route' => 'backend.courier.save', 'class' => 'modal1')) !!}
    {!!Form::input('hidden', 'id', NULL,  ['class' => 'mod_id']) !!}    
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="name">Nama Kurir</label>
                {!! Form::text('name', null, ['class' => 'form-control mod_name', 'required' => 'required', 'tabindex' => '1'] ) !!}
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                {!! Form::select('status', array('0' => 'Tidak Aktif', '1' => 'Aktif'),null,['class' => 'form-control mod_status', 'rows' => '3', 'tabindex' => '1', 'style' => 'padding-left:7px;']) !!}
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>Logo</label>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <img class="img-responsive" src="http://placehold.it/240x240" alt="">
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="row">
                            <p style="font-size:12px;">ajs hadhadah sdh sad hadhjdh sajdh akd hadjk</p>
                        </div>
                        <div class="row">
                            <button type="button" class="btn btn-md  btn-default" tabindex="1">Browse</button>
                        </div>
                    </div>
                </div>
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


@extends('template.email.layout')

@section('content')
	<table class="row">
	  <tr>
	    <td class="wrapper last">

	      <table class="twelve columns">
	        <tr>
	          <td>

	            <h3>Billing Information</h3>
	            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

	          </td>
	          <td class="expander"></td>
	        </tr>
	      </table>

	    </td>
	  </tr>
	</table>


	<table  class="twelve columns">
		<thead>
			<tr>
				<th>No.</th>
				<th>Nama Produk</th>
				<th>Qty</th>
				<th>Harga</th>
			</tr>
		</thead>
		<tbody>
			@foreach($transactions as $transaction)
				<tr>
					<td>1</td>
					<td>{{$data['transaction']['transaction_detail']['product']['name']}}</td>
					<td>{{$data['transaction']['transaction_detail']['quantity']}}</td>
					<td>{{$data['transaction']['transaction_detail']['price'] * $data['transaction']['transaction_detail']['quantity']}}</td>
				</tr>
			@endforeach
			<tr>
				<td colspan="3">Ongkos Kirim</td>
				<td>{{ $data['transaction']['shipping_cost'] }}</td>
			</tr>
			<tr>
				<td colspan="3">Diskon Referral</td>
				<td>{{ $data['transaction']['referral_discount'] }}</td>
			</tr>
			<tr>
				<td colspan="3">Grand Total</td>
				<td>{{ $data['transaction']['amount'] }}</td>
			</tr>										
		</tbody>
	</table>

	</br>

	<table class="row footer">
	  <tr>
	    <td class="wrapper">

	      <table class="six columns">
	        <tr>
	          <td class="left-text-pad">

	            <h5>Connect With Us:</h5>

	            <table class="tiny-button facebook">
	              <tr>
	                <td>
	                  <a href="#">Facebook</a>
	                </td>
	              </tr>
	            </table>

	            <br>

	            <table class="tiny-button twitter">
	              <tr>
	                <td>
	                  <a href="#">Twitter</a>
	                </td>
	              </tr>
	            </table>

	            <br>

	            <table class="tiny-button google-plus">
	              <tr>
	                <td>
	                  <a href="#">Google +</a>
	                </td>
	              </tr>
	            </table>

	          </td>
	          <td class="expander"></td>
	        </tr>
	      </table>

	    </td>
	    <td class="wrapper last">

	      <table class="six columns">
	        <tr>
	          <td class="last right-text-pad">
	            <h5>Contact Info:</h5>
	            <p>Phone: 408.341.0600</p>
	            <p>Email: <a href="mailto:hseldon@trantor.com">hseldon@trantor.com</a></p>
	          </td>
	          <td class="expander"></td>
	        </tr>
	      </table>

	    </td>
	  </tr>
	</table>


	<table class="row">
	  <tr>
	    <td class="wrapper last">

	      <table class="twelve columns">
	        <tr>
	          <td align="center">
	            <center>
	              <p style="text-align:center;"><a href="#">Terms</a> | <a href="#">Privacy</a> | <a href="#">Unsubscribe</a></p>
	            </center>
	          </td>
	          <td class="expander"></td>
	        </tr>
	      </table>

	    </td>
	  </tr>
	</table>
@stop

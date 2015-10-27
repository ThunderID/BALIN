@extends('template.email.layout')

@section('content')
	<?php
// dd($data)
	// <table class="row">
	//   <tr>
	//     <td class="wrapper last">

	//       <table class="twelve columns">
	//         <tr>
	//           <td>

	//             <h1>Hi, {{$data['name']}}</h1>
	//             <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.</p>
	//             // <img  src="/Balin/web/Image/3.jpg">
	//           </td>
	//           <td class="expander"></td>
	//         </tr>
	//       </table>

	//     </td>
	//   </tr>
	// </table>

	// <table class="row callout">
	//   <tr>
	//     <td class="wrapper last">

	//       <table class="twelve columns">
	//         <tr>
	//           <td class="panel">

	//             <p>Phasellus dictum sapien a neque luctus cursus. Pellentesque sem dolor, fringilla et pharetra vitae. <a href="#">Click it! »</a></p>

	//           </td>
	//           <td class="expander"></td>
	//         </tr>
	//       </table>

	//     </td>
	//   </tr>
	// </table>
	?>


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
			<tr>
				<td>1</td>
				<td>{{$data['products'][0]['product']['name']}}</td>
				<td>{{$data['products'][0]['quantity']}}</td>
				<td>{{$data['products'][0]['price'] * $data['products'][0]['quantity']}}</td>
			</tr>
			<tr>
				<td colspan="3">Ongkos Kirim</td>
				<td>1</td>
			</tr>
			<tr>
				<td colspan="3">Voucher</td>
				<td>1</td>
			</tr>
			<tr>
				<td colspan="3">Grand Total</td>
				<td>1</td>
			</tr>										
		</tbody>
	</table>

	<?php
	// <table class="row">
	//   <tr>
	//     <td class="wrapper last">

	//       <table class="three columns">
	//         <tr>
	//           <td>

	//             <table class="button">
	//               <tr>
	//                 <td>
	//                   <a href="{!!route('balin.email.activation', $data['activation_link'] )!!}">Activate</a>
	//                 </td>
	//               </tr>
	//             </table>

	//           </td>
	//           <td class="expander"></td>
	//         </tr>
	//       </table>

	//     </td>
	//   </tr>
	// </table>
	?>

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

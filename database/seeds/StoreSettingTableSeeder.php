<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\StoreSetting;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class StoreSettingTableSeeder extends Seeder
{
	function run()
	{
		DB::table('tmp_store_settings')->truncate();

		$types 										= ['url', 'logo', 'facebook_url', 'twitter_url', 'email', 'phone', 'address', 'pages', 'pages', 'pages', 'bank_information'];
		$values 									= ['http://balin.id', 'http://balin.id/logo.png', 'http://www.facebook.com/balin.id', 'http://www.twitter.com/balin.id', 'cs@balin.id', ' ', ' ', 'about-us', 'why-join', 'term-condition', 'http://bca.com/logo.png'];
		$contents 									= ['','', '', '', '', 'ok', '0888 8888 8888', 'Ruko Puri Niaga A10 - Araya Kota Malang', 
														'<h1>About Us</h1><br/>
														<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget mauris a arcu maximus malesuada ultrices iaculis ipsum. Curabitur consectetur, sem non rhoncus vulputate, nibh ex iaculis sem, a fermentum purus metus ut diam. Nulla suscipit magna vel fermentum dictum. Pellentesque interdum blandit purus, vitae tempor risus molestie quis. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas volutpat nisl a luctus fermentum. Duis purus tellus, facilisis in nisi quis, condimentum consectetur ipsum. Integer neque felis, mollis at molestie ac, sagittis eu urna. Nulla hendrerit facilisis porttitor. Vestibulum vel ultrices eros. Duis auctor quam quis sem porta, id dictum libero finibus. Aenean ut fringilla est, at lacinia tellus. Sed pharetra felis et velit eleifend, et consectetur nibh placerat. Vestibulum in volutpat est.</p>
														<p>Pellentesque rhoncus magna nec porttitor hendrerit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean vulputate, magna eget tristique pellentesque, lorem justo efficitur nisl, at gravida risus diam quis nisl. Phasellus eros massa, ornare non accumsan at, mattis ut velit. Fusce sed tortor sit amet augue rhoncus sodales. Sed a ante non velit interdum vehicula ac sit amet elit. Curabitur eu sagittis massa. Pellentesque eget molestie mi, ut scelerisque diam. Phasellus commodo egestas sem sit amet euismod. Proin vulputate consectetur suscipit. </p>', 
														'<h1>Why Join</h1><br/>
														<p>Pellentesque quis sagittis mi, ac tempus nulla. Cras ut enim ut neque hendrerit faucibus. Praesent fringilla dignissim augue quis faucibus. Curabitur dapibus nulla maximus elementum volutpat. Nam faucibus tristique hendrerit. Nulla facilisi. Vivamus nisl nibh, blandit malesuada egestas ut, congue at enim. Proin non semper velit. Vivamus sit amet aliquam velit, eget pretium lectus. Nullam aliquet dignissim mauris a semper. Fusce sollicitudin hendrerit convallis. Sed sed posuere justo. Proin eleifend nisl vel urna sagittis euismod. Pellentesque consequat elementum est, vehicula vestibulum magna. Pellentesque commodo ultrices iaculis.</p>
														<p>Donec ut volutpat mi. Donec blandit, metus congue lobortis laoreet, tortor mauris varius urna, sed imperdiet arcu urna non elit. Suspendisse consequat dapibus sapien id sollicitudin. Nam id lacus nec mi malesuada luctus. Vestibulum aliquet sapien nec est dapibus, in lobortis nunc accumsan. Sed congue accumsan urna in maximus. Nunc lorem nulla, fringilla ac blandit quis, euismod posuere tortor. Donec ut congue tellus. Nunc tempus maximus arcu ac euismod. Maecenas tempus varius leo, egestas interdum lectus vestibulum at. Ut placerat consequat nisl in luctus. Nullam congue, quam quis malesuada tempus, eros nulla sagittis nulla, ut porttitor orci purus scelerisque erat. Mauris euismod est convallis scelerisque ultricies. Aenean eget velit tellus.</p>', 
														'<h1>Term and Condition</h1><br/>
														<p>Aliquam sit amet lectus aliquet, tincidunt lectus pulvinar, iaculis ligula. Pellentesque malesuada mi nec urna tincidunt, in suscipit leo varius. Vivamus ac velit ultrices, mattis mauris a, pellentesque lacus. Sed consequat lorem et condimentum varius. Sed orci nisi, dictum sed lorem sed, accumsan pharetra nisl. Pellentesque viverra lacus id vestibulum elementum. Cras rutrum ex sed neque varius, ac elementum nulla blandit. Nullam vel vestibulum urna.</p>
														<p>Vivamus ultricies eleifend aliquet. Sed vel arcu vel mi feugiat dictum. Integer eget sem augue. Pellentesque sit amet lorem vulputate, congue turpis non, dignissim leo. Nullam mattis erat tortor, a lobortis lectus accumsan imperdiet. Cras sit amet pretium velit, id eleifend lorem. Phasellus leo neque, sollicitudin ac nisi et, rhoncus pretium metus. </p>
														<p>BCA</p>
														<p>No.Rek 088 88 88</p>
														<p>A.N. BALINDOTID</p>
														'];
		try
		{
			$i 										= 0;
			foreach($types as $key => $value)
			{
				$data 								= new StoreSetting;
				$data->fill([
					'type'							=> $value,
					'url'							=> $values[$key],
					'content'						=> $contents[$key],
				]);

				if (!$data->save())
				{
					print_r($data->getError());
					exit;
				}
			}	
		}
		catch (Exception $e) 
		{
    		echo 'Caught exception: ',  $e->getMessage(), "\n";
    		echo 'Caught exception: ',  $e->getFile(), "\n";
    		echo 'Caught exception: ',  $e->getLine(), "\n";
		}		
	}
}			
<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\StoreSetting;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Product;
use App\Models\Varian;
use App\Models\Image;
use App\Models\Price;
use App\Models\Lable;
use App\Models\Address;
use App\Models\Supplier;
use App\Models\Courier;
use App\Models\ShippingCost;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class SoftLaunchTableSeeder extends Seeder
{
	function run()
	{
		$faker 										= Factory::create();
		DB::table('tmp_store_settings')->truncate();

		//store setting related to basic information
		$types 										= ['url', 'logo', 'facebook_url', 'twitter_url', 'instagram_url', 'email', 'phone', 'address', 'about_us', 'why_join', 'term_and_condition', 'bank_information'];
		$values 									= ['http://balin.id','http://balin.id/logo.png', 'http://www.facebook.com/balin.id', 'https://twitter.com/balinid', 'https://www.instagram.com/balinid', 'help@balin.id', '0888 8888 8888', 'M.T Haryono 116 Kav 2 Malang', 
														'<h1>About Us</h1></br>
														<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget mauris a arcu maximus malesuada ultrices iaculis ipsum. Curabitur consectetur, sem non rhoncus vulputate, nibh ex iaculis sem, a fermentum purus metus ut diam. Nulla suscipit magna vel fermentum dictum. Pellentesque interdum blandit purus, vitae tempor risus molestie quis. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas volutpat nisl a luctus fermentum. Duis purus tellus, facilisis in nisi quis, condimentum consectetur ipsum. Integer neque felis, mollis at molestie ac, sagittis eu urna. Nulla hendrerit facilisis porttitor. Vestibulum vel ultrices eros. Duis auctor quam quis sem porta, id dictum libero finibus. Aenean ut fringilla est, at lacinia tellus. Sed pharetra felis et velit eleifend, et consectetur nibh placerat. Vestibulum in volutpat est.</p>
														<p>Pellentesque rhoncus magna nec porttitor hendrerit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean vulputate, magna eget tristique pellentesque, lorem justo efficitur nisl, at gravida risus diam quis nisl. Phasellus eros massa, ornare non accumsan at, mattis ut velit. Fusce sed tortor sit amet augue rhoncus sodales. Sed a ante non velit interdum vehicula ac sit amet elit. Curabitur eu sagittis massa. Pellentesque eget molestie mi, ut scelerisque diam. Phasellus commodo egestas sem sit amet euismod. Proin vulputate consectetur suscipit. </p>', 
														'<p>Pellentesque quis sagittis mi, ac tempus nulla. Cras ut enim ut neque hendrerit faucibus. Praesent fringilla dignissim augue quis faucibus. Curabitur dapibus nulla maximus elementum volutpat. Nam faucibus tristique hendrerit. Nulla facilisi. Vivamus nisl nibh, blandit malesuada egestas ut, congue at enim. Proin non semper velit. Vivamus sit amet aliquam velit, eget pretium lectus. Nullam aliquet dignissim mauris a semper. Fusce sollicitudin hendrerit convallis. Sed sed posuere justo. Proin eleifend nisl vel urna sagittis euismod. Pellentesque consequat elementum est, vehicula vestibulum magna. Pellentesque commodo ultrices iaculis.</p>
														<p>Donec ut volutpat mi. Donec blandit, metus congue lobortis laoreet, tortor mauris varius urna, sed imperdiet arcu urna non elit. Suspendisse consequat dapibus sapien id sollicitudin. Nam id lacus nec mi malesuada luctus. Vestibulum aliquet sapien nec est dapibus, in lobortis nunc accumsan. Sed congue accumsan urna in maximus. Nunc lorem nulla, fringilla ac blandit quis, euismod posuere tortor. Donec ut congue tellus. Nunc tempus maximus arcu ac euismod. Maecenas tempus varius leo, egestas interdum lectus vestibulum at. Ut placerat consequat nisl in luctus. Nullam congue, quam quis malesuada tempus, eros nulla sagittis nulla, ut porttitor orci purus scelerisque erat. Mauris euismod est convallis scelerisque ultricies. Aenean eget velit tellus.</p>', 
														'<p>Aliquam sit amet lectus aliquet, tincidunt lectus pulvinar, iaculis ligula. Pellentesque malesuada mi nec urna tincidunt, in suscipit leo varius. Vivamus ac velit ultrices, mattis mauris a, pellentesque lacus. Sed consequat lorem et condimentum varius. Sed orci nisi, dictum sed lorem sed, accumsan pharetra nisl. Pellentesque viverra lacus id vestibulum elementum. Cras rutrum ex sed neque varius, ac elementum nulla blandit. Nullam vel vestibulum urna.</p>
														<p>Vivamus ultricies eleifend aliquet. Sed vel arcu vel mi feugiat dictum. Integer eget sem augue. Pellentesque sit amet lorem vulputate, congue turpis non, dignissim leo. Nullam mattis erat tortor, a lobortis lectus accumsan imperdiet. Cras sit amet pretium velit, id eleifend lorem. Phasellus leo neque, sollicitudin ac nisi et, rhoncus pretium metus. </p>',
														'<p>BCA</p>
														<p>No.Rek 088 88 88</p>
														<p>A.N. BALINDOTID</p>
														'];
		//store setting related to slider
		$slides										= ['slider', 'slider', 'slider'];
		$slidevals 									= [
														'{"title":{"title_active":"1","slider_title_location":"Top-Left","slider_title":"PRODUK TERLARIS KAMI"},"content":{"content_active":"1","slider_content_location":"Center-Left","slider_content":"BERSERAT RAPAT <br>DAN TIDAK MUDAH PANAS"},"button":{"button_active":"1","slider_button_location":"Bottom-Left","slider_button":"TAMBAHKAN DIKERANJANG","slider_button_url":"http:\/\/localhost:8000\/products"}}',
														'{"title":{"title_active":"1","slider_title_location":"Top-Right","slider_title":"PRODUK BATIK UNGGULAN"},"content":{"content_active":"1","slider_content_location":"Center-Right","slider_content":"BATIK BERKUALITAS BAGUS"},"button":{"button_active":"1","slider_button_location":"Bottom-Right","slider_button":"LIHAT PRODUK KAMI","slider_button_url":"http:\/\/localhost:8000\/products"}}',
														'{"title":{"title_active":"1","slider_title_location":"Top-Left","slider_title":"BATIK TULIS"},"content":{"content_active":"1","slider_content_location":"Center-Left","slider_content":"DESAIN SIMPLE...<br>MINIMALIS...ELEGAN..."},"button":{"button_active":"1","slider_button_location":"Bottom-Left","slider_button":"BATIK PREMIUM","slider_button_url":"http:\/\/localhost:8000\/products"}}',
														];
		
		$slidevalues								= ['http://localhost:8000/Balin/web/balin/wallpaper1.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper2.jpg', 'http://localhost:8000/Balin/web/balin/wallpaper3.jpg'];
		
		//store setting related to policy
		$policies 									= ['expired_cart', 'expired_paid', 'expired_shipped', 'expired_point', 'referral_royalty', 'invitation_royalty', 'limit_unique_number', 'expired_link_duration', 'first_quota', 'downline_purchase_bonus', 'downline_purchase_bonus_expired', 'downline_purchase_quota_bonus', 'voucher_point_expired', 'welcome_gift', 'critical_stock', 'min_margin', 'item_for_one_package'];
		$polvals 									= [' + 1 day', ' - 2 days', '+ 5 days', '+ 1 year', '10000', '50000', '100', '+ 2 hours', '10', '10000', ' + 3 months', '1', '+ 3 months', '10000', '2', '50000', '2'];

		try
		{
			//store setting related to basic information
			foreach($types as $key => $value)
			{
				$data 								= new StoreSetting;
				$data->fill([
					'type'							=> $value,
					'value'							=> $values[$key],
					'started_at'					=> date('Y-m-d H:i:s' , strtotime('- 1 day')),
				]);

				if (!$data->save())
				{
					print_r($data->getError());
					exit;
				}
			}	

			//store setting related to slider
			foreach($slides as $key => $value)
			{
				$data 								= new StoreSetting;
				$data->fill([
					'type'							=> $value,
					'value'							=> $slidevals[$key],
					'started_at'					=> date('Y-m-d H:i:s' , strtotime('- 1 day')),
					'ended_at'						=> date('Y-m-d H:i:s' , strtotime('+ 1 year')),
				]);

				if (!$data->save())
				{
					print_r($data->getError());
					exit;
				}

				$image 						= new Image;
				$image->fill([
						'thumbnail'			=> $slidevalues[$key],
						'image_xs'			=> $slidevalues[$key],
						'image_sm'			=> $slidevalues[$key],
						'image_md'			=> $slidevalues[$key],
						'image_lg'			=> $slidevalues[$key],
				]);
				if (!$image->save())
				{
					print_r($image->getError());
					exit;
				}

				$image->imageable()->associate($data);
				
				if (!$image->save())
				{
					print_r($image->getError());
					exit;
				}
			}	

			//store setting related to policy
			foreach($policies as $key => $value)
			{
				$data 								= new StoreSetting;
				$data->fill([
					'type'							=> $value,
					'value'							=> $polvals[$key],
					'started_at'					=> date('Y-m-d H:i:s' , strtotime('- 1 day')),
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

		//seed admin
		DB::table('users')->truncate();
	    factory(App\Models\User::class, 'admin', 1)->create();
	    factory(App\Models\User::class, 'staff', 1)->create();
	    factory(App\Models\User::class, 'store_manager', 1)->create();

	    //seed tag & cat
	    DB::table('categories')->truncate();
		try
		{
			$categories								= [
														'Balin Cap Basic',
														'Balin Cap Premium',
														'Balin Tulis Premium'
													  ];

			$i 										= 0;
			foreach($categories as $key => $value)
			{
				if(is_array($value))
				{
					$name 							= $key;
				}
				else
				{
					$name 							= $value;
				}

				$i++;
				$j 									= $i;
				$data 								= new Category;
				$data->fill([
					'name'							=> $name,
					'type'							=> 'category',
					'path'							=> $i,
				]);

				if (!$data->save())
				{
					print_r($data->getError());
					exit;
				}
			}	

			$categories								= [
														'Lengan'		=> 	['Pendek'],
														'Warna'			=> 	[
																				'Merah',
																				'Putih',
																				'Turqoise',
																				'Abu Abu',
																				'Biru',
																				'Cream',
																				'Pink',
																				'Hitam',
																				'Kuning',
																				'Cokelat',
																			],
													  ];

			foreach($categories as $key => $value)
			{
				if(is_array($value))
				{
					$name 							= $key;
				}
				else
				{
					$name 							= $value;
				}
				$i++;
				$j 									= $i;
				$data 								= new Tag;
				$data->fill([
					'name'							=> $name,
					'type'							=> 'tag',
					'path'							=> $i,
				]);

				if (!$data->save())
				{
					print_r($data->getError());
					exit;
				}
				elseif(is_array($value))
				{
					foreach ($value as $key2 => $value2) 
					{
						if(is_array($value2))
						{
							$name 							= $key2;
						}
						else
						{
							$name 							= $value2;
						}

						$i++;
						$k 									= $i;
						$data 								= new Tag;
						$data->fill([
							'category_id'					=> $j,
							'type'							=> 'tag',
							'name'							=> $name,
							'path'							=> $j.','.$i,
						]);

						if (!$data->save())
						{
							print_r($data->getError());
							exit;
						}
					}
				}
			}
		}
		catch (Exception $e) 
		{
    		echo 'Caught exception: ',  $e->getMessage(), "\n";
    		echo 'Caught exception: ',  $e->getFile(), "\n";
    		echo 'Caught exception: ',  $e->getLine(), "\n";
		}	

	    //seed product &category & image &label &price & varians
		DB::table('products')->truncate();
		DB::table('prices')->truncate();
		DB::table('categories_products')->truncate();

		$name 										= ['Hem Batik Semi Sutera', 'Abstract Pattern Mixed Kawung Slimfit Shirt', 'Hem Batik Cumikan Pelangi', 'Hem Batik Ikan Moorish', 'Hem Pendek Motif Mina Ginaris', 'Hem Pdk Pa Koi Nandang Roso 53', 'Hem Pdk Pa Sekar Jamur 20', 'Hem Pdk Ctn Silk Sisik Manggar ', 'Hem Pendek Pa Sekar Jagat '];
		$labels 									= [['hot_item','sale'], ['new_item','sale'], ['best_seller','sale'], ['sale','hot_item'], ['new_item'], ['sale'], ['sale'], [], ['hot_item', 'sale']];
		$desc 										= ['Tambah koleksi gaya modern preppy dengan kemeja classy dari Waskito. Hem Batik Semi Sutera tampil berbeda melalui detail dual tone dan motif batik print pilihan.', 
														'Stay fabulous with Bateeq. Abstract Pattern Mixed Kawung Slimfit Shirt memadukan motif batik dengan desain klasik serta warna tegas. Koleksi yang siap menemani acara-acara spesial.', 
														'Tetap terlihat modern dengan koleksi kemeja batik klasik dari Arjuna Weda. Hem Batik Cumikan Pelangi hadir dengan desain simpel serta kombinasi motif batik print khas nusantara. Pilihan tepat untuk momen spesial.', 
														'Koleksi kemeja batik yang terkesan kuno dihadirkan lebih modern dan dinamis pada koleksi Arjuna Weda. Hem Batik Ikan Moorish menghadirkan batik print kontemporer dalam nuansa warna cool tone.', 
														'Etnik dan maskulin dengan koleksi batik dari Danar Hadi. Hem Pendek Motif Mina Ginaris memadukan motif batik modern dan nuansa kontras pada hem line. Koleksi yang tepat digunakan saat momen spesial.', 
														'Tambah koleksi batik dengan keluaran terbaru dari BATIK SEMAR. Hem Pdk Sekar Jamur 20 hadir dengan kombinasi desain klasik dan motif batik print dalam pilihan warna gelap. Effortlessly masculine!', 
														'Tambah koleksi batik dengan keluaran terbaru dari BATIK SEMAR. Hem Pdk Pa Koi Nandang Roso 53 hadir dengan kombinasi desain klasik dan motif batik print dalam pilihan warna solid. Effortlessly masculine!', 
														'Tampil effortless stylish dengan koleksi BATIK SEMAR. Hem Pdk Ctn Silk Sisik Manggar Asri 53 menghadirkan kesan maskulin lewat potongan klasik dan motif batik yang modern. Simply fit for your special occasion.', 
														'Kemeja batik print dari BATIK SEMAR. Hem Pendek Pa Sekar Jagat Plataran menampilkan kombinasi warna classy dan potongan timeless straight.'
														];
		$globalcategories 							= [['1','5','7','8','9'], ['1','5','7','10','11'], ['3','5','7','11'], ['2','5','7','8','11'], ['1','5','8','9','11'], ['3','5','9','12','13'], ['1','5','14','15'], ['1','5','12','14','16'], ['1','5','8','14','16']];
		$sizes 										= [['15', '15.5', '16'], ['15', '15.5', '16'], ['15', '15.5', '16'], ['15', '15.5'], ['16'], ['15'], ['15', '15.5', '16'], null, ['16']];

		foreach (range(0, 8) as $key) 
		{
			$data 									= new Product;
			$data->fill([
				'name'								=> $name[$key],
				'upc'								=> $faker->ean8,
				'slug'								=> Str::slug($name[$key]),
				'description'						=> json_encode(['description' => $desc[$key], 'fit' => '<img src="http://www.shirtdetective.com/wp-content/uploads/2014/04/marks-spencer-shirt-size.jpg" class="img-responsive" </img>']),
			]);

			if (!$data->save())
			{
				print_r($data->getError());
				exit;
			}
			else
			{
				foreach (range(0, count($sizes[$key])-1) as $key2) 
				{
					if(!is_null($sizes[$key]))
					{
						$varian 				= new Varian;
						$varian->fill([
							'product_id'		=> $data->id,
							'sku'				=> $data->upc.$sizes[$key][$key2],
							'size'				=> $sizes[$key][$key2],
						]);

						if (!$varian->save())
						{
							print_r($varian->getError());
							exit;
						}
					}
				}

				$data->globalcategories()->sync($globalcategories[$key]);

				//add images
				$verbs 						= ['a', 'b', 'c', 'd', 'e', 'f'];
				foreach ($verbs as $idxx => $value3) 
				{
					$image 						= new Image;
					$image->fill([
							'thumbnail'			=> 'http://localhost:8000/Balin/web/balin/softlaunch/'.($key+1).'-'.$value3.'.jpg',
							'image_xs'			=> 'http://localhost:8000/Balin/web/balin/softlaunch/'.($key+1).'-'.$value3.'.jpg',
							'image_sm'			=> 'http://localhost:8000/Balin/web/balin/softlaunch/'.($key+1).'-'.$value3.'.jpg',
							'image_md'			=> 'http://localhost:8000/Balin/web/balin/softlaunch/'.($key+1).'-'.$value3.'.jpg',
							'image_lg'			=> 'http://localhost:8000/Balin/web/balin/softlaunch/'.($key+1).'-'.$value3.'-large.jpg',
					]);
					if (!$image->save())
					{
						print_r($image->getError());
						exit;
					}

					$image->imageable()->associate($data);
					
					if (!$image->save())
					{
						print_r($image->getError());
						exit;
					}
				}

				//add prices
				$price 						= new Price;
				$price->fill([
						'product_id'		=> $data->id,
						'price'				=> 299000,
						'promo_price'		=> 249000,
						'started_at'		=> date('Y-m-d H:i:s', strtotime('+ 2 seconds')),
				]);
				if (!$price->save())
				{
					print_r($price->getError());
					exit;
				}

				if($labels[$key])
				{
					foreach ($labels[$key] as $value) 
					{
						switch ($value) 
						{
							case 'new_item': case 'best_seller' :
								$class 							= 'square-label';
								break;
							case 'sale':
								$class 							= 'circle-label';
								break;
							default:
								$class 							= 'tag-label';
								break;
						}
						$label 									= new Lable;

						$label->fill([
							'product_id'						=> $data->id,
							'lable'								=> str_replace('_', ' ', $value),
							'value'								=> json_encode(['class' => $class, 'color' => 'red']),
							'started_at'						=> date('Y-m-d H:i:s'),
						]);

						if(!$label->save())
						{
							$errors->add('Product', $label->getError());
						}
					}
				}
			}
		}

		DB::table('suppliers')->truncate();

		$name 										= ['Arjuna Weda', 'Bateeq', 'Batik Semar', 'Balin Tailor', 'Balin Supplier Chain', 'Pak Suprapto'];

		foreach (range(0, 5) as $key) 
		{
			$data 					= new Supplier;

			$data->fill([
				'name'				=> $name[$key],
			]);

			if (!$data->save())
			{
				print_r($data->getError());
				exit;
			}

			$address				= new Address;			

			$address->fill([
				'phone' 			=> $faker->phoneNumber,
				'zipcode' 			=> $faker->postcode,
				'address' 			=> $faker->address,
			]);

			$address->owner()->associate($data);

			if (!$address->save())
			{
				print_r($address->getError());
				exit;
			}
		}

		DB::table('couriers')->truncate();

		$name 										= ['Balin Expedisi', 'JNE'];
		$logo 										= ['http://localhost:8000/Balin/web/image/logo.png', 'https://jakethoodiemurah.files.wordpress.com/2014/04/logo-jne.jpg'];

		foreach (range(0, 1) as $key) 
		{
			$data 					= new Courier;

			$data->fill([
				'name'				=> $name[$key],
			]);

			if (!$data->save())
			{
				print_r($data->getError());
				exit;
			}

			$address				= new Address;			

			$address->fill([
				'phone' 			=> $faker->phoneNumber,
				'zipcode' 			=> $faker->postcode,
				'address' 			=> $faker->address,
			]);

			$address->owner()->associate($data);

			if (!$address->save())
			{
				print_r($address->getError());
				exit;
			}

			$ship					= new ShippingCost;			

			$ship->fill([
				'courier_id'		=> $data->id,
				'start_postal_code'	=> 60000,
				'end_postal_code'	=> 70000,
				'started_at'		=> date('Y-m-d H:i:s', strtotime('+ '.($key+2).' minutes')),
				'cost'				=> 20000,
			]);

			if (!$ship->save())
			{
				print_r($ship->getError());
				exit;
			}


			//add images
			$image 						= new Image;
			$image->fill([
					'thumbnail'			=> $logo[$key],
					'image_xs'			=> $logo[$key],
					'image_sm'			=> $logo[$key],
					'image_md'			=> $logo[$key],
					'image_lg'			=> $logo[$key],
			]);
			if (!$image->save())
			{
				print_r($image->getError());
				exit;
			}

			$image->imageable()->associate($data);
			
			if (!$image->save())
			{
				print_r($image->getError());
				exit;
			}

		}
	}
}			
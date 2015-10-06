<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
	function run()
	{
		DB::table('categories')->truncate();
		$faker 										= Factory::create();
		try
		{
			$categories								= [
														'Baju Batik Wanita'		=> 	[
																						'Batik Lengan Pendek',
																						'Batik Lengan Panjang',
																						'Batik Kantor',
																						'Batik Dress',
																						'Batik Baleto',
																						'Batik Gamis',
																					],
														'Baju Batik Pria'		=> 	[
																						'Batik Lengan Pendek',
																						'Batik Lengan Panjang',
																					],
														'Baju Batik Sarimbit',
														'Cardigan',
														'Batik Tulis'			=>	[
																						'Batik Jogjakarta' 	=>
																												[
																													'Batik Sekar Jagat',
																													'Batik Pamiluto',
																													'Batik Ciptoning',
																													'Batik Wahyu Tumurun Cantel',
																													'Batik Wahyu Tumurun',
																													'Batik Udan Liris',
																													'Batik Truntum Sri Kuncoro',
																													'Parang Kusumo seling Debyah'
																												],
																						'Batik Banyuwangi' 	=>
																												[
																													'Batik Gajah Uling',
																												],
																					],
														'Batik Cap'				=>	[
																						'Batik Jamblang Bintang',
																						'Batik Parang Kusumo',
																						'Batik Parang Barong',
																						'Batik Cap Halus'	=> 
																												[
																													'Batik Parang Barong',
																												],
																					],
														'Batik Cap Kombinasi Tulis'	=>
																					[
																						'Batik Pekalongan'	=>
																												[
																													'Batik Buketan Tumpal Buketan',
																												],
																						'Batik Solo'		=>
																												[
																													'Batik Lereng gagah Seto- Mlinjon',
																													'Batik Sidomukti',
																													'Batik Peksi Dewata',
																													'Batik Banyak Angrem',
																												],
																						'Batik Batang'		=>
																												[
																													'Batik Ceplok Kembang',
																													'Batik Ceplok Ksatriyan',
																													'Batik Pisan Mbali',
																												],
																						'Batik Jogjakarta'	=>
																												[
																													'Batik Sidoasih Bledak',
																													'Batik Lereng',
																												],
																						'Batik Surakarta'	=>
																												[
																													'Batik Parang Ron seling udan Liris',
																													'Batik Stambulan',
																													'Batik Sidomukti',
																													'Batik Sidoasih Cemengan',
																												],
																					],
														'Batik Printing',
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
						$data 								= new Category;
						$data->fill([
							'category_id'					=> $j,
							'name'							=> $name,
							'path'							=> $j.','.$i,
						]);

						if (!$data->save())
						{
							print_r($data->getError());
							exit;
						}
						elseif(is_array($value2))
						{
							foreach ($value2 as $key3 => $value3) 
							{
								if(is_array($value3))
								{
									$name 							= $key3;
								}
								else
								{
									$name 							= $value3;
								}

								$i++;
								$data 								= new Category;
								$data->fill([
									'category_id'					=> $k,
									'name'							=> $name,
									'path'							=> $j.','.$k.','.$i,
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
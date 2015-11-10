<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductUniversal;
use App\Models\ProductAttribute;
use App\Models\Image;
use App\Models\Price;
use App\Models\Discount;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
	function run()
	{
		DB::table('images')->truncate();
		DB::table('products')->truncate();
		DB::table('categories_products')->truncate();
		$faker 										= Factory::create();
		$categories 								= Category::all();

		$colors 									= ['red', 'blue', 'yellow', 'green', 'pink', 'black', 'white', 'masonry', 'maroon', 'cyan'];
		$hexs 										= ['ffcccc', 'ccccff', 'fffdcc', 'ddffcc', 'ffccfc', '000000', 'bababa', '00ffae', 'a0000a', '00fff0'];
		$sizes 										= ['S', 'M', 'XL', 'XXL', 'XXXL'];
		$brands 									= ['Narada', 'Danar Hadi', 'Batik Keris', 'Batik Semar', 'Irwan Tirta', 'Parang Kencana', 'Wirokuto Batik', 'Alleira Batik', 'Kencana Ungu', 'Bateeq', 'Galeri Batik Jawa', 'BALIN', 'Balin Basic'];

		try
		{
			foreach($categories as $key => $value)
			{
				foreach (range(0, 2) as $key2) 
				{
					$clridx							= rand(0, count($colors)-1);
					$color 							= $colors[$clridx];
					$size 							= $sizes[rand(0, count($sizes)-1)];
					$brand 							= $brands[rand(0, count($brands)-1)];
					$data 							= new Product;
					$data->fill([
						'name'						=> $value->name.' '.$brand.' '.$color.' '.$size,
						'upc'						=> $faker->ean8,
						'slug'						=> $faker->slug($nbWords = 3),			
						'description'				=> $faker->sentence($nbWords = 6),			
					]);

					if (!$data->save())
					{
						print_r($data->getError());
						exit;
					}
					else
					{
						//sync category
						$cats[] 					= $key+1;
						if($key <= 12)
						{
							$cats[]					= rand(13,51);
						}
						else
						{
							$cats[]					= rand(1,12);
						}

						$data->categories()->sync($cats);

						// //add attributes
						// $attributes 				= ['color', 'brand', 'size'];
						// $values 					= [$color, $brand, $size];

						// foreach (range(0, count($attributes)-1) as $index2) 
						// {
						// 	$attribute 				= new ProductAttribute;
						// 	$attribute->fill([
						// 			'product_id'	=> $data->id,
						// 			'attribute'		=> $attributes[$index2],
						// 			'value'			=> $values[$index2],
						// 	]);
						// 	if (!$attribute->save())
						// 	{
						// 		print_r($attribute->getError());
						// 		exit;
						// 	}
						// }

						//add images
						$imagetotal 				= rand(1, 2);
						foreach (range(0, $imagetotal) as $idxxx) 
						{
							if($idxxx==0)
							{
								$hex 					= $hexs[$clridx];
							}
							else
							{
								$hex 					= $hexs[rand(0, count($hexs)-1)];
							}
							
							$image 						= new Image;
							$image->fill([
									'thumbnail'			=> 'http://placehold.it/75x100/'.$hex.'/000000',
									'image_xs'			=> 'http://placehold.it/150x200/'.$hex.'/000000',
									'image_sm'			=> 'http://placehold.it/300x400/'.$hex.'/000000',
									'image_md'			=> 'http://placehold.it/450x600/'.$hex.'/000000',
									'image_lg'			=> 'http://placehold.it/600x800/'.$hex.'/000000',
									// 'published_at'		=> date('Y-m-d H:i:s'),
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
								'price'				=> (date('i')*10000) + (date('s')*500),
								'started_at'		=> date('Y-m-d H:i:s', strtotime('+ 5 minutes')),
						]);
						if (!$price->save())
						{
							print_r($price->getError());
							exit;
						}
					}				
				}
			}
		}
		catch (Exception $e) 
		{
    		echo 'Caught exception: ',  $e->getMessage(), "\n";
    		echo 'Caught exception: ',  $e->getLine(), "\n";
    		echo 'Caught exception: ',  $e->getFile(), "\n";
		}		
	}
}			
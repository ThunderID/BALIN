<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\Price;
use App\Models\Discount;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class ProductTableSeeder extends Seeder
{
	function run()
	{
		DB::table('products')->truncate();
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
				foreach (range(0, rand(3,10)) as $key) 
				{
					$clridx							= rand(0, count($colors)-1);
					$color 							= $colors[$clridx];
					$size 							= $sizes[rand(0, count($sizes)-1)];
					$brand 							= $brands[rand(0, count($brands)-1)];
					$data 							= new Product;
					$data->fill([
						'name'						=> $value->name.' '.$brand.' '.$color.' '.$size,
						'sku'						=> $faker->ean8,
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
						$cats[] 					= $key;
						if($key <= 12)
						{
							$cats[]					= rand(13,51);
						}
						else
						{
							$cats[]					= rand(1,12);
						}

						$data->categories()->sync($cats);

						//add attributes
						$attributes 				= ['color', 'brand', 'size'];
						$values 					= [$color, $brand, $size];

						foreach (range(0, count($attributes)-1) as $index2) 
						{
							$attribute 				= new ProductAttribute;
							$attribute->fill([
									'product_id'	=> $data->id,
									'attribute'		=> $attributes[$index2],
									'value'			=> $values[$index2],
							]);
							if (!$attribute->save())
							{
								print_r($attribute->getError());
								exit;
							}
						}

						//add images
						$image 						= new ProductImage;
						$image->fill([
								'product_id'		=> $data->id,
								'thumbnail'			=> 'http://placehold.it/75x100/'.$clridx.'/000000',
								'image_xs'			=> 'http://placehold.it/150x200/'.$clridx.'/000000',
								'image_sm'			=> 'http://placehold.it/300x400/'.$clridx.'/000000',
								'image_md'			=> 'http://placehold.it/450x600/'.$clridx.'/000000',
								'image_l'			=> 'http://placehold.it/600x800/'.$clridx.'/000000',
								'published_at'		=> date('Y-m-d H:i:s'),
						]);
						if (!$image->save())
						{
							print_r($image->getError());
							exit;
						}

						//add prices
						$price 						= new Price;
						$price->fill([
								'product_id'		=> $data->id,
								'price'				=> (date('i')*10000) + (date('s')*500),
								'started_at'		=> date('Y-m-d H:i:s'),
						]);
						if (!$price->save())
						{
							print_r($price->getError());
							exit;
						}

						//add discounts
						$discount 					= new Discount;
						$discount->fill([
								'product_id'		=> $data->id,
								'promo_price'		=> $price->price - ($price->price * (rand(0,100)/100)),
								'started_at'		=> date('Y-m-d H:i:s'),
								'ended_at'			=> date('Y-m-d H:i:s', strtotime('+ '.rand(2,30).' days')),
						]);
						if (!$discount->save())
						{
							print_r($discount->getError());
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
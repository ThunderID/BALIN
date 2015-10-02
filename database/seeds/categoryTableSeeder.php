<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Models\Category;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class categoryTableSeeder extends Seeder
{
	function run()
	{
		DB::table('categories')->truncate();
		$faker 										= Factory::create();
		try
		{
			$parent									= ['lengan','warna','jenis batik','tipe batik'];					
			foreach(range(1, 4) as $index)
			{
				$data = new category;
				$data->fill([
					'name'							=> $parent[$index-1],
					'path'							=> $index,
				]);

				if (!$data->save())
				{
					print_r($data->getError());
					exit;
				}					
			}	

			$parent									= ['panjang','pendek'];					
			foreach(range(1, 2) as $index)
			{
				$data = new category;
				$data->fill([
					'name'							=> $parent[$index-1],
					'path'							=> '1,' . $index,
				]);

				$data->category()->associate('1');

				if (!$data->save())
				{
					print_r($data->getError());
					exit;
				}					
			}	

			$parent									= ['merah','kuning','hijau','biru','oranye','putih','hitam','ungu','abu-abu','magenta','maroon','coklat'];					
			foreach(range(1, 12) as $index)
			{
				$data = new category;
				$data->fill([
					'name'							=> $parent[$index-1],
					'path'							=> '2,' . $index,
				]);

				$data->category()->associate('2');

				if (!$data->save())
				{
					print_r($data->getError());
					exit;
				}					
			}	

			$parent									= ['batik tulis','batik celup','batik print','batik cap'];					
			foreach(range(1, 4) as $index)
			{
				$data = new category;
				$data->fill([
					'name'							=> $parent[$index-1],
					'path'							=> '3,' . $index,
				]);

				$data->category()->associate('3');

				if (!$data->save())
				{
					print_r($data->getError());
					exit;
				}					
			}	

			$parent									= ['batik madura','batik klaten','batik kawung','batik jombang'];					
			foreach(range(1, 4) as $index)
			{
				$data = new category;
				$data->fill([
					'name'							=> $parent[$index-1],
					'path'							=> '4,' . $index,
				]);

				$data->category()->associate('4');

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
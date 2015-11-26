<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Models\StoreSetting;

use App\Jobs\Mailman;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Libraries\JSend;

use Input, Redirect, Config;

class ContactUsController extends BaseController 
{
	/**
	* Instantiate a new UserController instance.
	*/
	public function __construct()
	{
		parent::__construct();
	}

	protected $controller_name 					= 'contactus';

	public function index()
	{		
		$breadcrumb								= ['Contact Us' => route('frontend.contactus.index')];
		$this->layout->page 					= view('pages.frontend.contact_us.index')
													->with('controller_name', $this->controller_name)
													->with('breadcrumb', $breadcrumb)
													;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Contact Us';

		$this->layout->page->metas 				= 	[
														'og:type' 			=> 'website', 
														'og:title' 			=> 'BALIN.ID', 
														'og:description' 	=> 'Contact Us',
														'og:url' 			=> route('frontend.contactus.index'),
														'og:image' 			=> $this->stores['logo'],
														'og:site_name' 		=> 'balin.id',
														'fb:app_id' 		=> Config::get('fb_app.id'),
													];

		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;
	}

	public function submit()
	{
		$inputs 								= Input::only('name','email','message');


		//get default email
        $info           = StoreSetting::storeinfo(true)->take(8)->get();
        $infos          = [];

        foreach ($info as $key => $value) 
        {
            $infos[$value->type]    = $value->value;
        }

		//send email to cs
        $datas          = ['input' => $inputs, 'balin' => $infos];

        $mail_data      						= 	[
							                            'view'          => 'emails.cs', 
							                            'datas'         => $datas,
							                            'dest_email'    => $infos['email'], 
							                            'dest_name'     => 'Customer Service', 
							                            'subject'       => 'BALIN - Customer Feedback', 
							                        ];

        // call email send job
        $result 								= 	$this->dispatch(new Mailman($mail_data));

        if($result->getStatus() != 'success')
        {
   			return Redirect::back()
					->withErrors('Maaf sistem kami sedang sibuk, silahkan coba beberapa saat lagi.')
					->with('msg-type', 'danger')
					;
        }


        return Redirect::route('contactus.thanks');
	}


	public function thanks()
	{
		//return thanks page
		$breadcrumb								= ['contact Us' => route('frontend.contactus.index')];
		$this->layout->page 					= view('pages.frontend.contact_us.thanks')
													->with('controller_name', $this->controller_name)
													->with('breadcrumb', $breadcrumb)
													;

		$this->layout->page->page_title 		= 'BALIN.ID';
		$this->layout->page->page_subtitle 		= 'Contact Us';

		$this->layout->page->metas 				= 	[
														'og:type' 			=> 'website', 
														'og:title' 			=> 'BALIN.ID', 
														'og:description' 	=> 'contact Us',
														'og:url' 			=> route('frontend.contactus.index'),
														'og:image' 			=> $this->stores['logo'],
														'og:site_name' 		=> 'balin.id',
													];

		$this->layout->controller_name			= $this->controller_name;

		return $this->layout;		
	}

}
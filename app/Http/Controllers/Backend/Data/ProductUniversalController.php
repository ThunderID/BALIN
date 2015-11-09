<?php namespace App\Http\Controllers\Backend\Data;

use App\Http\Controllers\BaseController;
use App\Models\Product;
use App\Models\ProductUniversal;
use App\Models\Price;
use Illuminate\Support\MessageBag;
use Input, Session, DB, Redirect;

class ProductUniversalController extends BaseController 
{
    /**
     * Instantiate a new UserController instance.
     */
    
    public function __construct()
    {
        $this->middleware('passwordneeded', ['only' => ['destroy']]);

    	parent::__construct();
    }

	protected $view_name 						= 'Produk';
	
    public function index()
    {       
        $breadcrumb                                     = ['Data Produk' => route('backend.data.productuniversal.index')];
        
        $filters                                        = null;

        if(Input::has('q'))
        {
            $filters                                    = ['name' => Input::get('q')];
            $searchResult                               = Input::get('q');
        }
        else
        {
            $searchResult                               = null;
        }

        $this->layout->page                             = view('pages.backend.data.product.productUniversal.index')
                                                            ->with('WT_pagetitle', $this->view_name )
                                                            ->with('WT_pageSubTitle','Index')
                                                            ->with('WB_breadcrumbs', $breadcrumb)
                                                            ->with('filters', $filters)
                                                            ->with('searchResult', $searchResult)
                                                            ->with('nav_active', 'data')
                                                            ->with('subnav_active', 'products');

        return $this->layout;   
    }
    public function create($id = null)
    {
        if($id) 
        {
            $product                                    = ProductUniversal::findorfail($id);

            $breadcrumb                                 =   [   'Data Produk'           => route('backend.data.productuniversal.index'),
                                                                'Edit ' .$product->name => route('backend.data.productuniversal.edit', $id),
                                                            ];

            $title                                      =   'Edit '.$product->name;
        }
        else
        {
            $product                                    = new ProductUniversal;

            $breadcrumb                                 =   [   'Data Produk'   => route('backend.data.productuniversal.index'),
                                                                'Baru'          => route('backend.data.productuniversal.create'),
                                                            ];

            $title                                      =   'Baru';
        }

        $this->layout->page                             = view('pages.backend.data.product.productUniversal.create')
                                                                ->with('WT_pagetitle', $this->view_name )
                                                                ->with('WT_pageSubTitle', $title)       
                                                                ->with('WB_breadcrumbs', $breadcrumb)
                                                                ->with('id', $id)
                                                                ->with('nav_active', 'data')
                                                                ->with('product', $product)
                                                                ->with('subnav_active', 'products');

        return $this->layout;           
    }

    public function edit($id)
    {
        return $this->create($id);      
    }

    public function show($id)
    {
        $product                                        = ProductUniversal::findorfail($id);

        $breadcrumb                                     =   [   'Data Produk'   => route('backend.data.productuniversal.index'),
                                                                $product->name  => route('backend.data.productuniversal.show', $id),
                                                            ];

        if(Input::has('q'))
        {
            $filters                                    = ['name' => Input::get('q')];
            $searchResult                               = Input::get('q');
        }
        else
        {
            $searchResult                               = null;
            $filters                                    = null;
        }

        $this->layout->page                             = view('pages.backend.data.product.productUniversal.show')
                                                                        ->with('WT_pagetitle', $this->view_name )
                                                                        ->with('WT_pageSubTitle', $product->name)
                                                                        ->with('WB_breadcrumbs', $breadcrumb)
                                                                        ->with('searchResult', $searchResult)
                                                                        ->with('filters', $filters)
                                                                        ->with('id', $id)
                                                                        ->with('nav_active', 'data')
                                                                        ->with('subnav_active', 'products')
                                                                        ->with('product', $product)
                                                                        ;

        return $this->layout;
    }


    public function store($id = null)
    {
        $inputs                                         = Input::only('name','upc','description');

        if ($id)
        {
            $data                                       = ProductUniversal::find($id);
        }
        else
        {
            $data                                       = new ProductUniversal;  
        }

        $data->fill([
            'name'                                      => $inputs['name'],
            'upc'                                       => $inputs['upc'],
            'description'                               => $inputs['description'],
        ]);

        $errors                                         = new MessageBag();

        DB::beginTransaction();

        if (!$data->save())
        {
            $errors->add('Product', $data->getError());
        }
    
        if ($errors->count())
        {
            DB::rollback();

            return Redirect::route('backend.data.productuniversal.index')
                    ->withErrors($errors)
                    ->with('msg-type', 'danger')
                    ;
        }
        else
        {
            DB::commit();

            return Redirect::route('backend.data.productuniversal.index')
                    ->with('msg','Produk sudah disimpan')
                    ->with('msg-type', 'success')
                    ;
        }    
    }

    public function Update($id)
    {
        return $this->store($id);       
    } 

    public function destroy($id)
    {
        $data                               = ProductUniversal::findorfail($id);

        DB::beginTransaction();

        if (!$data->delete())
        {
            DB::rollback();
            
            return Redirect::back()
                ->withErrors($data->getError())
                ->with('msg-type','danger');
        }
        else
        {
            DB::commit();

            return Redirect::route('backend.data.productuniversal.index')
                ->with('msg', 'Produk telah dihapus')
                ->with('msg-type','success');
        }        
    }    
}
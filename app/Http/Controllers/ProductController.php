<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ProductImage;
use App\Models\User;

use Carbon\Carbon;
use File;
use Cviebrock\EloquentSluggable\Services\SlugService;

use Image;
use Auth;
use Validator;

class ProductController extends Controller
{
    function __construct()
    {
        //  $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
         $this->middleware('permission:product-list', ['only' => ['index']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
          $this->middleware('permission:product-status', ['only' => ['status']]);
         
    }
    
    public function index()
	{
		$products = Product::latest('id')->get();
	    return view('product.index')->with('products',$products);
	}

    public function create(Request $request){
        $categories = Category::get();
        $subcat = SubCategory::get();
        $vendors = User::get();
        return view('product.create')->with('subcat',$subcat)->with('categories',$categories)->with('vendors',$vendors);
    }

    public function store(Request $request){
        
        // return $request->all();
        $vendor_id =  Category::where('id',$request->category_id)->first()->vendor_id;
        
        $request->validate([
            'product_name' => 'required',
            'regular_price' => 'required',
            'category_id' =>'required',
            'pr_item_price' =>'required',
            'stock'         =>'required',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ],
         [
        'category_id.required' => 'Shop is required!',
        ]);
        
        $vendor_id =  Category::where('id',$request->category_id)->first()->vendor_id;
        $product = new Product();
        $product->user_id = Auth::id();
        $product->product_name = $request->product_name;

        $product->product_slug=SlugService::createSlug(Product::class, 'product_slug', $request->product_name);

        $product->regular_price = $request->regular_price;
        $product->pr_item_price = $request->pr_item_price;
        $product->sale_price = $request->regular_price;
        $product->stock = $request->stock;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        /////////////////
        $product->category_id =$request->category_id;
        $product->subcat_id =$request->subcat_id;
        $product->vendor_id = $vendor_id;

        // $product->color = json_encode(array_values(array_filter($request->colors)));
        // $product->size = json_encode(array_values(array_filter($request->sizes)));


        if($request->file('product_image'))
        {
            $image = $request->file('product_image');
            $input['imagename'] = Carbon::now()->timestamp.'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/assets/images/product');
            $img = Image::make($image->getRealPath());
            $img->resize(460, 480, function ($constraint){
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);
            $product->product_image = $input['imagename'];
        }
        $product->save();

        $product->categories()->attach($request->category_id);

        $request->session()->flash('SUCCESSS' , 'Product inserted!');

        return redirect('admin/product');

    }

    public function edit($id)
    {
        
        $product = Product::find($id);
        $categories = Category::where('status',1)->get();
        $subcat = SubCategory::where('status',1)->get();
        $vendors = User::where(['type' => 'vendor'])->get();
        return view('product.edit')->with('subcat',$subcat)->with('product',$product)->with('categories',$categories)->with('vendors',$vendors);
    }


    public function update(Request $request, $id)
	{
	   
		$request->validate([
            'product_name'=>'required',
            'regular_price'=>'required'
        ]);

		$product = Product::find($id);
		$product->user_id=Auth::id();
        $product->product_name=$request->product_name;

        $product->product_slug=SlugService::createSlug(Product::class, 'product_slug', $request->product_name);

        $product->regular_price=$request->regular_price;
        $product->pr_item_price = $request->pr_item_price;
        $product->sale_price=$request->sale_price;
        $product->short_description=$request->short_description;
        $product->description=$request->description;
        $product->stock = $request->stock;
        $product->category_id=$request->category_id;
        $product->subcat_id=$request->subcat_id;
        $product->vendor_id =$request->vendor_id;

        // $product->color=json_encode(array_values(array_filter($request->colors)));
        // $product->size=json_encode(array_values(array_filter($request->sizes)));

        if($request->file('product_image'))
        {
            if(File::exists(public_path('assets/images/product/'.$product->product_image)))
            	File::delete(public_path('assets/images/product/'.$product->product_image));

            $image = $request->file('product_image');
            $input['imagename'] = Carbon::now()->timestamp.'.'.$image->getClientOriginalExtension();

            $destinationPath = public_path('/assets/images/product');
            $img = Image::make($image->getRealPath());
            $img->resize(460, 480, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);
            $product->product_image=$input['imagename'];
		}

		$product->save();

		$product->categories()->detach();
      	$product->categories()->attach($request->category_id);

		$request->session()->flash('SUCCESS', 'Product updated!');
        return redirect('admin/product');

	}

    public function images($id)
	{
		$product=Product::find($id);
        // return ProductImage::where('product_id',$id)->get();
        // dd($product);
		return view('product.images')->with('product',$product);
	}


    public function postImages(Request $request, $id)
	{
        // return  $id;
		$request->validate([
          'images' => 'required',
          'images.*' => 'mimes:jpeg,jpg,png,gif'
        ]);

		$images=array();

        if ($request->hasfile('images')) {
            $images = $request->file('images');
            foreach($images as $key => $image) {
			    $name = Carbon::now()->timestamp.$image->getClientOriginalName();

                //$destinationPath = public_path('assets/images/product/gallery',$name);
                $image->move(public_path("assets/images/product/gallery"), $name);


                ////////////////////////
                // $img = Image::make($image->getRealPath());
                // $img->resize(460, 480, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save($destinationPath.'/'.$name);


                $prImg = new ProductImage();
                $prImg->product_id = $id;
                $prImg->product_image = $name;
                $prImg->save();
			}
		}

		return back()->with('SUCCESS', 'Images uploaded successfully');
	}


    public function imgDelete(Request $request, $img_id){
        $pr_img = ProductImage::find($img_id);
        if(FIle::exists(public_path('assets/images/product/gallery/'.$pr_img->product_image)))
            File::delete(public_path('assest/image/product/gallery'.$pr_img->product));
        $pr_img->delete();

        $request->session()->flash('SUCCESS' , 'Image Delete Successfully');
        return back();

    }

    public function status(Request $request, $id){
        $product = Product::find($id);
        $product->status = $request->status;
        $product->save();

        return $product->product_name;
    }
    public function productdelete($id){
        $product = Product::find($id)->delete();

      return back()->with('SUCCESS' , 'Product Delete Successfully');

    }
    
    public function vendorProduct($id)
    {
        // return $id;
        $products = Product::where('vendor_id',$id)->get();
	    return view('product.vendor-product')->with('products',$products);
        
        // products
    }
}

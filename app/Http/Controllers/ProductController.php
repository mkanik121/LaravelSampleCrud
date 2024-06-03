<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    // This Method Will Show Product Page
    public function index(){
        $product = Product::orderBy('created_at', 'DESC')->get();
        return view("products.list",['products'=>$product]);

    }
    
    // This Method Will Show Create Product Page
    public function create(){
    return view("products.create");
    }
    
    // This Method Will store a Product In db
    public function store(Request $req){
    
        $rules = [
            "name"  => "required|unique:products|min:4",
            "sku"  => "required|min:4",
            "price"  => "required|numeric"
        ];
     if($req->image != ''){
        $rules['image'] = 'image';
       }
       $validator =  Validator::make($req->all(), $rules);
   
       if($validator->fails()){
         return redirect()->route('Products.Create')->withInput()->withErrors($validator);
       }else{
         $Product = new Product();

         $Product->Name        = $req->name;
         $Product->Sku         = $req->sku;
         $Product->Price       = $req->price;
         $Product->Description = $req->description;

     if($req->image != ''){
        //  Here Will Store Image
        $image = $req->image;
        $ext = $image->getClientOriginalExtension();
        $imageName = time().'.'.$ext;
        $image->move(public_path('uploads/products'),$imageName);
        $Product->Image = $imageName;
     }
     $Product->save();


         return redirect()->route('Products.Index')->with('success', 'Product Added Succesfully');
       }

    }
    

    // This Method Will Show Edit Product Page
    public function edit($id){
        $product = Product::findOrFail($id);
      return view('products.edit',['product'=>$product]);
    }
    
    // This Method Will Show Update Product Page
    public function update($id, Request $req){
        $Product = Product::findOrFail($id);

        $rules = [
            "name"  => "required|unique:products|min:4,".$Product->id,
            "sku"  => "required|min:4",
            "price"  => "required|numeric"
        ];
     if($req->image != ''){
        $rules['image'] = 'image';
       }
       $validator =  Validator::make($req->all(), $rules);
   
       if($validator->fails()){
         return redirect()->route('Products.Edit',$Product->id)->withInput()->withErrors($validator);
       }else{

         $Product->Name        = $req->name;
         $Product->Sku         = $req->sku;
         $Product->Price       = $req->price;
         $Product->Description = $req->description;

     if($req->image != ''){
        //  Here Will Store Image
        File::delete(public_path('uploads/products/'.$Product->Image));
        $image = $req->image;
        $ext = $image->getClientOriginalExtension();
        $imageName = time().'.'.$ext;
        $image->move(public_path('uploads/products'),$imageName);
        $Product->Image = $imageName;
     }
     $Product->save();


         return redirect()->route('Products.Index')->with('success', 'Product Updated Succesfully');
       }
    }
    
    // This Method Will Show Delete Product Page
    public function delete($id){
      $Product = Product::findOrFail($id);

      File::delete(public_path('uploads/products/'.$Product->Image));

    $Product->delete();
    return redirect()->route('Products.Index')->with('success', 'Product Deleted Succesfully');


    }
}

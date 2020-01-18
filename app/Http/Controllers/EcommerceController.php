<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EcommerceCategory;
use App\Models\EcommerceBrand;
use App\Models\EcommerceProduct;
use App\Models\EcommerceOrder;
use App\Models\EcommerceOrderDetail;
use App\Models\Societa;
use App\Models\SocietaFornitori;

use DB;


class EcommerceController extends Controller
{
    public function category(){
        $data = EcommerceCategory :: all();
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['name'=>"eCommerce"], ['name'=>"category"]
        ];
        return view('pages/ecommerce/category',
                ['data' => $data,
                'page'=>'ecommerce',
                'subpage'=>'category',
                'breadcrumbs'=>$breadcrumbs]);
    }
    public function categoryedit(Request $request){
        $category = EcommerceCategory :: find($request->id);
        return response()->json(['data' => $category]);
    }
    public function categorysave(Request $request){
        $arr = ['category','description'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        } 
        
        
        if($request->id == 0){     
            EcommerceCategory :: create($data);       
        }
        else{
            EcommerceCategory :: where('id','=',$request->id)->update($data);
        }        
        return redirect()->route('ecommerce.category');  

    }
    public function categorydelete(Request $request){
        EcommerceCategory :: find($request->id)->delete();
        return response()->json(['data' => 'success']);
    }

    public function brand(){
        $data = EcommerceBrand :: all();
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['name'=>"eCommerce"], ['name'=>"brand"]
        ];
        return view('pages/ecommerce/brand',
                ['data' => $data,
                'page'=>'ecommerce',
                'subpage'=>'brand',
                'breadcrumbs'=>$breadcrumbs]);
    }
    public function brandedit(Request $request){
        $brand = EcommerceBrand :: find($request->id);
        return response()->json(['data' => $brand]);
    }
    public function brandsave(Request $request){
        $arr = ['brand','description'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        } 
        
        
        if($request->id == 0){     
            EcommerceBrand :: create($data);       
        }
        else{
            EcommerceBrand :: where('id','=',$request->id)->update($data);
        }        
        return redirect()->route('ecommerce.brand');  

    }
    public function branddelete(Request $request){
        EcommerceBrand :: find($request->id)->delete();
        return response()->json(['data' => 'success']);
    }

    public function product(){
        $data = EcommerceProduct :: join('shopping_category','shopping_category.id','=','shopping_product.categoryid')
                                ->join('shopping_brand','shopping_brand.id','=','shopping_product.brandid')
                                ->select('*', 'shopping_product.id as productid')
                                ->get();
        
        $categories = EcommerceCategory :: all();
        $brands = EcommerceBrand :: all();
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['name'=>"eCommerce"], ['name'=>"product"]
        ];
        return view('pages/ecommerce/product',
                ['data' => $data,
                'categories' => $categories,
                'brands' => $brands,
                'page'=>'ecommerce',
                'subpage'=>'product',
                'breadcrumbs'=>$breadcrumbs]);
    }
    
    public function productedit(Request $request){
        $product = EcommerceProduct :: join('shopping_category','shopping_category.id','=','shopping_product.categoryid')
                                    ->join('shopping_brand','shopping_brand.id','=','shopping_product.brandid')
                                    ->where('shopping_product.id','=',$request->id)
                                    ->select('*', 'shopping_product.id as productid')
                                    ->first();
        return response()->json(['data' => $product]);
    }
    
    public function productsave(Request $request){
        $arr = ['product','categoryid','productdescription','cost','brandid'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        } 
        $file = $request->file('image');
        if($file){
            $filename = $file->getClientOriginalName();
            $data['image']= $filename;
            $file->move('uploads/product',$filename);
        }
        
        if($request->id == 0){     
            EcommerceProduct :: create($data);       
        }
        else{
            EcommerceProduct :: where('id','=',$request->id)->update($data);
        }        
        return redirect()->route('ecommerce.product');  

    }
    
    public function productdelete(Request $request){
        EcommerceProduct :: find($request->id)->delete();
        return response()->json(['data' => 'success']);
    }

    public function order(){
        $data = EcommerceOrder :: join('societa','societa.id','=','shopping_order.companyid')
                                ->join('societa_fornitori','societa_fornitori.id','=','shopping_order.supplierid')
                                ->select('*', 'shopping_order.id as orderid', 'societa.ragione_sociale as companyname', 'societa_fornitori.ragione_sociale as suppliername')
                                ->get();
        
        $companies = Societa :: all();
        $supplies = SocietaFornitori :: all();
        
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['name'=>"eCommerce"], ['name'=>"order"]
        ];
        return view('pages/ecommerce/order',
                ['data' => $data,
                'companies' => $companies,
                'supplies' => $supplies,
                'page'=>'ecommerce',
                'subpage'=>'order',
                'breadcrumbs'=>$breadcrumbs]);
    }
    public function orderedit(Request $request){
        $order = EcommerceOrder :: join('societa','societa.id','=','shopping_order.companyid')
                                ->join('societa_fornitori','societa_fornitori.id','=','shopping_order.supplierid')
                                ->where('shopping_order.id','=',$request->id)
                                ->select('*', 'shopping_order.id as orderid', 'societa.ragione_sociale as companyname', 'societa_fornitori.ragione_sociale as suppliername')
                                ->first();
        return response()->json(['data' => $order]);
    }
    public function orderno(Request $request){
        if($request->id == 0){
            $no = EcommerceOrder::where('companyid','=', $request->companyid)->where('anno','=',date('Y'))->max('no');
            $no++;
            $anno = date("Y");
        }
        else{
            $companyid = EcommerceOrder :: find($request->id)->companyid;
            $no = EcommerceOrder::find($request->id)->no;
            $anno = EcommerceOrder::find($request->id)->anno;
            if($request->companyid != $companyid){
                $no = EcommerceOrder::where('companyid','=', $request->companyid)->where('anno','=',date('Y'))->max('no'); 
                $anno = date("Y");
                $no++;
            }
            
        }
        return response()->json(['orderno' => $no, 'anno'=>$anno]);
    }
    public function ordersave(Request $request){
        $arr = ['companyid','supplierid'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        } 
        
        
        if($request->id == 0){   
            $data['anno'] = date('Y');
            $maxno = EcommerceOrder::where('companyid','=', $request->companyid)->where('anno','=',date('Y'))->max('no');
            $data['no'] = $maxno+1;  
            EcommerceOrder :: create($data);       
        }
        else{
            $companyid = EcommerceOrder :: find($request->id)->companyid;
            if($data['companyid'] != $companyid){
                $maxno = EcommerceOrder::where('companyid','=', $request->companyid)->where('anno','=',date('Y'))->max('no'); 
                $data['no'] = $maxno+1;
            }
            EcommerceOrder :: where('id','=',$request->id)->update($data);
        }        
        return redirect()->route('ecommerce.order');  

    }
    public function orderdelete(Request $request){
        EcommerceOrder :: find($request->id)->delete();
        return response()->json(['data' => 'success']);
    }



    public function shop($id){
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['name'=>"eCommerce"],['link'=>"/order",'name'=>"Order"], ['name'=>"shop"]
        ];
        $products = EcommerceProduct :: join('shopping_category','shopping_category.id','=','shopping_product.categoryid')
                                    ->join('shopping_brand','shopping_brand.id','=','shopping_product.brandid')
                                    ->select('*', 'shopping_product.id as productid')
                                    ->get();
        $categories = EcommerceCategory :: all();
        $brands = EcommerceBrand :: all();

        $data = EcommerceOrder :: join('shopping_orderdetail','shopping_orderdetail.orderid','=','shopping_order.id')
                                ->where('shopping_order.id','=',$id)
                                ->get();
        $product_arr = [];
        if(count($data)>0){
            foreach($data as $value){
                array_push($product_arr,$value->productid);
            }
        }
        return view('pages/ecommerce/shop',
            ['page'=>'ecommerce',
            'products' => $products,
            'categories' => $categories,
            'count' => count($products),
            'product_arr' => $product_arr,
            'brands' => $brands,
            'orderid' => $id,
            'subpage'=>'order',
            'breadcrumbs'=>$breadcrumbs]);
    }
    public function productdetail(Request $request){
        $id = $request->id;
        $product = EcommerceProduct :: join('shopping_category','shopping_category.id','=','shopping_product.categoryid')
                                    ->join('shopping_brand','shopping_brand.id','=','shopping_product.brandid')
                                    ->where('shopping_product.id','=',$id)
                                    ->select('*', 'shopping_product.id as productid')
                                    ->first();
        return response()->json(['data' => $product]); 
    }

    public function checkout(Request $request){
        $orderid = $request->orderid;
        $productids = $request->productids;
        $ids = explode(',',$productids);
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['name'=>"eCommerce"],['link'=>"/order",'name'=>"Order"], ['link'=>"/shop/".$orderid,'name'=>"shop"], ['name'=>"checkout"]
        ];

        $products = EcommerceProduct :: join('shopping_category','shopping_category.id','=','shopping_product.categoryid')
                        ->join('shopping_brand','shopping_brand.id','=','shopping_product.brandid')                        
                        ->whereIn('shopping_product.id', $ids) 
                        ->select('*', 'shopping_product.id as productid')                                 
                        ->get();
        $total_cost = $products->sum('cost'); 
        $data = EcommerceOrder :: find($orderid);               
        return view('pages/ecommerce/checkout',
        ['page'=>'ecommerce', 
        'products' => $products,
        'total_cost' => $total_cost,                
        'orderid' => $orderid,
        'data' => $data,                
        'subpage'=>'order',
        'breadcrumbs'=>$breadcrumbs]);

    }
    public function checkoutsave(Request $request){
        $id = $request->orderid;
        $arr = ['fname','mnumber','aptnumber','landmark','city','pincode','state','payment'];
        for($i=0; $i<count($arr); $i++){
            $data[$arr[$i]] = $request[$arr[$i]];
        }   

        $productids = explode(',',$request->productids);
        $amounts = explode(',',$request->amounts);

        EcommerceOrder::where('id','=', $id)->update($data);

        $detail = EcommerceOrderDetail :: where('orderid','=',$id)->get();
        
        if(count($detail) > 0){
            EcommerceOrderDetail :: where('orderid','=',$id)->delete();            
        }
        for($i=0; $i<count($productids); $i++){
            $data1['orderid'] = $id;
            $data1['productid'] = $productids[$i];
            $data1['amount'] = $amounts[$i];
            EcommerceOrderDetail :: create($data1);
        }
        

        return redirect()->route("ecommerce.order");
    }
    public function orderprint($id){
        $breadcrumbs = [
            ['link'=>"/dashboard",'name'=>"Home"],['name'=>"eCommerce"],['link'=>"/order",'name'=>"Order"], ['name'=>"print"]
        ]; 
        $order = EcommerceOrder :: join('societa','societa.id','=','shopping_order.companyid')
                                ->join('societa_fornitori','societa_fornitori.id','shopping_order.supplierid')
                                ->where('shopping_order.id','=',$id)
                                ->select('*','shopping_order.id as orderid', 'societa.ragione_sociale as companyname','societa_fornitori.ragione_sociale as suppliername', 'societa.logo as companylogo','societa_fornitori.logo as supplierlogo','shopping_order.created_at as createdate')
                                ->first();
        $products = EcommerceOrderDetail :: join('shopping_order','shopping_orderdetail.orderid','=','shopping_order.id')
                                ->join('shopping_product','shopping_product.id','=','shopping_orderdetail.productid')
                                ->join('shopping_category','shopping_category.id','=','shopping_product.categoryid')
                                ->join('shopping_brand','shopping_brand.id','=','shopping_product.brandid')
                                ->where('shopping_order.id','=',$id)                                
                                ->get(); 
        return view('pages/ecommerce/print',
            ['page'=>'ecommerce', 
            'products' => $products,
            'order' => $order,                         
            'subpage'=>'order',
            'breadcrumbs'=>$breadcrumbs]);
    }
}

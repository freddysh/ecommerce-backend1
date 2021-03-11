<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ProductCollectionImport;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPhotos;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_view()
    {
        //
        return view('admin.products.index');
    }
    public function index_import_view()
    {
        //
        return view('admin.products.index_import');
    }

    public function index()
    {
        //
        return Product::with(['categorias','photos'])->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            //code...

            $validated=$request->validate([
                'code'=>'required|unique:products',
                'name'=>'required',
                'url'=>'required',
                'description'=>'required',
                'detail'=>'required',
                'discount'=>'required',
                'price'=>'required',
                'regular_price'=>'required',
                'stock'=>'required',
                'limit'=>'required',
                'rango_fecha'=>'required',
                'unit'=>'required',
                'brand'=>'required',
                'categorias'=>'required',
                'state'=>'required',
                // 'photos'=>'required',
            ]);

// return $request->all();
            $product=new Product();
                $product->code=$request->code;
                $product->name=$request->name;
                $product->url=$request->url;
                $product->description=$request->description;
                $product->detail=$request->detail;
                $product->price=$request->price;
                $product->discount=$request->discount;
                $product->regular_price=$request->regular_price;
                $product->stock=$request->stock;
                $product->limit=$request->limit;
                $product->valido_desde=explode('T',$request->rango_fecha[0])[0];
                $product->valido_hasta=explode('T',$request->rango_fecha[1])[0];
                $product->unit=$request->unit;
                $product->brand=$request->brand;
                $product->state=$request->state;
                $product->quantity=1;
                $product->save();

                // //agregamos las categorias
                $arreglo=null;
                $i=0;
                foreach($request->categorias as $categoria){
                    $temp=Category::where('name',$categoria)->first();
                    $arreglo[$i]=$temp->id;
                    $i++;
                }
                $product->categorias()->attach($arreglo);

                // Agregamos las imagenes
                foreach ($request->photos as $imagen) {
                    $imagen_ = $imagen['imgSrc'];
                    $state = $imagen['state'];
                    if ($imagen_) {
                        $img=new ProductPhotos();
                        $img->photo='';
                        $img->state=$state?1:0;
                        $img->product_id=$product->id;
                        $img->save();
                        $imagen_explode = explode(',', $imagen_);
                        $imagen_decode = base64_decode($imagen_explode[1]);
                        // $photo = IImage::make($imagen_)
                        //     ->resize(350, 250, function ($constraint) { $constraint->aspectRatio(); } )
                        //     ->encode('jpg');
                        $src = 'product_' . $product->id.'_'.$img->id . '.jpg';
                        Storage::disk('product')->put($src,  $imagen_decode);

                        $img->photo=$src;
                        $img->save();
                    }
                }
                return response()->json(['state'=>'1']);
        } catch (\Exception $th) {
            //throw $th;

            return response()->json(['state'=>$th]);
        }




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        return Product::with(['categorias','photos'])->where('id',$product->id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //

// return $request->all();
        try {
            //code...
            $validated=$request->validate([
                'code'=>'required',
                'name'=>'required',
                'url'=>'required',
                'description'=>'required',
                'detail'=>'required',
                'discount'=>'required',
                'price'=>'required',
                'regular_price'=>'required',
                'stock'=>'required',
                'limit'=>'required',
                'rango_fecha'=>'required',
                'unit'=>'required',
                'brand'=>'required',
                'categorias'=>'required',
                'state'=>'required',
                // 'photos'=>'required',
            ]);
            // $product=Product::findorfail($product_->id);
                $product->code=$request->code;
                $product->name=$request->name;
                $product->url=$request->url;
                $product->description=$request->description;
                $product->detail=$request->detail;
                $product->price=$request->price;
                $product->discount=$request->discount;
                $product->regular_price=$request->regular_price;
                $product->stock=$request->stock;
                $product->limit=$request->limit;
                $product->valido_desde=explode('T',$request->rango_fecha[0])[0];
                $product->valido_hasta=explode('T',$request->rango_fecha[1])[0];
                $product->unit=$request->unit;
                $product->brand=$request->brand;
                $product->state=$request->state;
                $product->save();

                //agregamos las categorias
                $arreglo=null;
                $i=0;
                foreach($request->categorias as $categoria){
                    $temp=Category::where('name',$categoria)->first();
                    $arreglo[$i]=$temp->id;
                    $i++;
                }
                $product->categorias()->detach();
                $product->categorias()->attach($arreglo);

                // limpiamos la db de imagenes que se borraron
                $todas_imagenes=ProductPhotos::where('product_id',$product->id)->get();

                $arregloNoBorrado=Array();
                $i=0;
                foreach ($request->photos as $imagen) {
                    if($imagen['id']>0){
                        $arregloNoBorrado[$i] = $imagen['id'];
                        $i++;
                    }
                }

                foreach ($todas_imagenes as $imagenEnDb) {
                    if(!in_array($imagenEnDb->id,$arregloNoBorrado)){
                        $temp=ProductPhotos::findorfail($imagenEnDb->id);
                        $temp->delete();
                        Storage::disk('product')->delete($imagenEnDb->photo);
                    }
                }

            // procedemos a agregar las nuevas imagenes
                foreach ($request->photos as $imagen) {
                    $imagen_ = $imagen['imgSrc'];
                    $imagen_id = $imagen['id'];
                    $state = $imagen['state'];
                    if ($imagen_) {
                        if($imagen_id==0){
                            $img=new ProductPhotos();
                            $img->photo='';
                            $img->state=$state?1:0;
                            $img->product_id=$product->id;
                            $img->save();
                            $imagen_explode = explode(',', $imagen_);
                            $imagen_decode = base64_decode($imagen_explode[1]);
                            // $photo = IImage::make($imagen_)
                            //     ->resize(350, 250, function ($constraint) { $constraint->aspectRatio(); } )
                            //     ->encode('jpg');
                            $src = 'product_' . $product->id.'_'.$img->id . '.jpg';
                            Storage::disk('product')->put($src,  $imagen_decode);

                            $img->photo=$src;
                            $img->save();
                        }
                    }
                }

                return response()->json(['state'=>'1']);
        } catch (\Exception $e) {
            //throw $th;

            return response()->json(['state'=>$e]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //

        $objeto= Product::findorfail($product->id);
        $objeto->delete();
        return response()->json(['status'=>'1']);
    }

    public function listado($categorias)
    {
        //
        $listado=Category::whereIn('name',[$categorias])->get()->pluck('id')->toArray();
        // return $listado;
        if(!count($listado)){
            return response()->json([]);
        }
        // return Product::with(['categorias'=>function ($query)use($listado){
        //     $query->whereIn('category_id',[$listado]);
        // },'photos'])->get();

        return Product::whereHas('categorias',function ($query)use($listado){
            $query->whereIn('category_id',[$listado]);
        })->with('photos')->get();

    }
    public function tops()
    {
        //
         $rpt= DB::table('order_products')
         ->select('product_id',DB::raw('SUM(quantity) as cantidad'))
        //  ->groupBy('id')
         ->groupBy('product_id')
         ->orderBy('cantidad','desc')
         ->take(5)
         ->get()
         ->pluck('product_id')
         ->toArray();
         $productosTop=Product::whereIn('id',$rpt)->get();
         return $productosTop;
    }
    public function tops5()
    {
        //
         $rpt= DB::table('order_products')
         ->join('products','order_products.product_id','=','products.id')
        //  ->groupBy('id')
         ->groupBy('product_id')
         ->orderBy('cantidad','desc')
         ->take(5)
         ->select('products.*',DB::raw('SUM(order_products.quantity) as cantidad'))
         ->get()
        //  ->pluck('product_id')
         ->toArray();
        //  $productosTop=Product::whereIn('id',$rpt)->get();
         return $rpt;
    }
    public function get_imagen($filename)
    {
        $file = Storage::disk('product')->get($filename);
        return response($file, 200);
    }
    public function switch_state($product_id,$state)
    {
        // return "$product_id,$state";

        $objeto= Product::findorfail($product_id);
        $objeto->state=$state=='false'?1:0;
        $objeto->save();
        return response()->json(['status'=>'1']);
    }
    public function importar_excel(Request $request)
    {
        try {
            //code...
            $request->validate([
                'import_file' => 'required|file|mimes:xls,xlsx'
            ]);

            $path = $request->file('import_file');
            $data = Excel::toArray(new ProductCollectionImport, $path)[0];
            $valor='';
            $arreglo=Array();
            $correctos=0;
            $advertencias=0;
            $errores=0;
            foreach ($data as $key => $value) {
                # code...
                $codigo=$value['codigo']?$value['codigo']:null;
                $marca=$value['marca']?$value['marca']:null;
                $unidad=$value['unidad']?$value['unidad']:null;
                $categoria=$value['categoria']?$value['categoria']:null;
                $nombre=$value['nombre']?$value['nombre']:null;
                $descripcion=$value['descripcion']?$value['descripcion']:null;
                $detalle=$value['detalle']?$value['detalle']:null;
                $limite=$value['limite']?($value['limite']=='si'||$value['limite']=='SI'?1:0):null;
                $precio=$value['precio']?$value['precio']:null;
                $precio_web=$value['precio_web']?$value['precio_web']:null;
                $stock=$value['stock']?$value['stock']:null;



                if($codigo!=null){
                    if(Product::where('code',$codigo)->get()->count()==0){
                        $codigo_msj= Array('msj'=>'Producto nuevo','error'=>'0');
                        $correctos++;
                    }
                    elseif(Product::where('code',$codigo)->get()->count()==1){
                        $codigo_msj= Array('msj'=>'Producto ya existe','error'=>'1');
                        $advertencias++;
                    }
                    elseif(Product::where('code',$codigo)->get()->count()>1){
                        $codigo_msj= Array('msj'=>'Hay mas de 1 producto','error'=>'1');
                        $advertencias++;
                    }
                }
                else{
                    $codigo_msj= Array('msj'=>'Celda vacia','error'=>'2');
                    $errores++;
                }

                if($marca!=null){
                    if(Brand::where('name',$marca)->get()->count()==0){
                        $marca_msj= Array('msj'=>'Marca nueva','error'=>'0');
                        $correctos++;
                    }
                    elseif(Brand::where('name',$marca)->get()->count()>=1){
                        $marca_msj= Array('msj'=>'Marca ya existe','error'=>'1');
                        $advertencias++;
                    }
                }
                else{
                    $marca_msj=  Array('msj'=>'Celda vacia','error'=>'2');
                    $errores++;
                }

                if($unidad!=null){
                    if(Unit::where('name',$unidad)->get()->count()==0){
                        $unidad_msj= Array('msj'=>'Unidad nueva','error'=>'0');
                        $correctos++;
                    }
                    elseif(Unit::where('name',$unidad)->get()->count()>=1){
                        $unidad_msj= Array('msj'=>'Unidad ya existe','error'=>'1');
                        $advertencias++;
                    }
                }
                else{
                    $unidad_msj= Array('msj'=>'Celda vacia','error'=>'2');
                    $errores++;
                }

                if($categoria!=null){
                    if(Category::where('name',$categoria)->get()->count()==0){
                        $categoria_msj= Array('msj'=>'Nueva categoria','error'=>'0');
                        $correctos++;
                    }
                    elseif(Category::where('name',$categoria)->get()->count()>=1){
                        $categoria_msj= Array('msj'=>'Categoria ya existe','error'=>'1');
                        $advertencias++;
                    }
                }
                else{
                    $categoria_msj= Array('msj'=>'Celda vacia','error'=>'2');
                    $errores++;
                }

                if($nombre!=null){
                    if(Product::where('name',$nombre)->get()->count()==0){
                        $nombre_msj= Array('msj'=>'Nuevo nombre','error'=>'0');
                        $correctos++;
                    }
                    elseif(Product::where('name',$nombre)->get()->count()>=1){
                        $nombre_msj= Array('msj'=>'Nombre ya existe','error'=>'1');
                        $advertencias++;
                    }
                }
                else{
                    $nombre_msj= Array('msj'=>'Celda vacia','error'=>'2');
                    $errores++;
                }

                $descripcion_msj= Array('msj'=>'','error'=>'0');
                if($descripcion==null){
                    $descripcion_msj= Array('msj'=>'Celda vacia','error'=>'2');
                    $errores++;
                }
                $limite_msj= Array('msj'=>'','error'=>'0');
                if($limite===null){
                    $limite_msj= Array('msj'=>'Celda vacia','error'=>'2');
                    $errores++;
                }
                $detalle_msj=  Array('msj'=>'','error'=>'0');
                if($detalle===null){
                    $detalle_msj= Array('msj'=>'Celda vacia','error'=>'2');
                    $errores++;
                }

                if($precio!=null){
                    if(is_numeric($precio)){
                        $precio_msj= Array('msj'=>'Es un numero','error'=>'0');
                        $correctos++;
                    }
                    else{
                        $precio_msj= Array('msj'=>'No es un numero','error'=>'2');
                        $errores++;
                    }
                }
                else{
                    $precio_msj= Array('msj'=>'Celda vacia','error'=>'2');
                    $errores++;
                }

                if($precio_web!=null){
                    if(is_numeric($precio_web)){
                        $precio_web_msj= Array('msj'=>'Es un numero','error'=>'0');
                        $correctos++;
                    }
                    else{
                        $precio_web_msj= Array('msj'=>'No es un numero','error'=>'2');
                        $errores++;
                    }
                }
                else{
                    $precio_web_msj= Array('msj'=>'Celda vacia','error'=>'2');
                    $errores++;
                }

                if($stock!=null){
                    if(is_numeric($stock)){
                        $stock_msj= Array('msj'=>'Es un numero','error'=>'0');
                        $correctos++;
                    }
                    else{
                        $stock_msj= Array('msj'=>'No es un numero','error'=>'2');
                        $errores++;
                    }
                }
                else{
                    $stock_msj= Array('msj'=>'Celda vacia','error'=>'2');
                    $errores++;
                }

                if($limite===0||$limite===1){

                    if($limite===1){
                        $valido_desde=$value['valido_desde']?$value['valido_desde']:null;
                        $valido_hasta=$value['valido_hasta']?$value['valido_hasta']:null;
                        $valido_desde_msj=  Array('msj'=>'','error'=>'0');
                        if($valido_desde===null){
                            $valido_desde_msj= Array('msj'=>'Celda vacia1','error'=>'2');
                            $errores++;
                        }
                        $valido_hasta_msj=  Array('msj'=>'','error'=>'0');
                        if($valido_hasta===null){
                            $valido_hasta_msj= Array('msj'=>'Celda vacia2','error'=>'2');
                            $errores++;
                        }
                    }
                    else{
                        $valido_desde=null;
                        $valido_hasta=null;
                        $valido_desde_msj=  Array('msj'=>'','error'=>'0');
                        // if($valido_desde===null){
                        //     $valido_desde_msj= Array('msj'=>'Celda vacia1','error'=>'2');
                        //     $errores++;
                        // }
                        $valido_hasta_msj=  Array('msj'=>'','error'=>'0');
                        // if($valido_hasta===null){
                        //     $valido_hasta_msj= Array('msj'=>'Celda vacia2','error'=>'2');
                        //     $errores++;
                        // }
                    }


                }
                else{

                    $valido_desde=$value['valido_desde']?$value['valido_desde']:null;
                    $valido_hasta=$value['valido_hasta']?$value['valido_hasta']:null;
                    $valido_desde_msj=  Array('msj'=>'','error'=>'0');
                    if($valido_desde==null){
                        $valido_desde_msj= Array('msj'=>'Celda vacia','error'=>'2');
                        $errores++;
                    }
                    $valido_hasta_msj=  Array('msj'=>'','error'=>'0');
                    if($valido_hasta==null){
                        $valido_hasta_msj= Array('msj'=>'Celda vacia','error'=>'2');
                        $errores++;
                    }
                }
                $arreglo[$key]=Array(
                    'codigo'=>Array('dato'=>$codigo,'error'=>$codigo_msj),
                    'marca'=>Array('dato'=>$marca,'error'=>$marca_msj),
                    'unidad'=>Array('dato'=>$unidad,'error'=>$unidad_msj),
                    'categoria'=>Array('dato'=>$categoria,'error'=>$categoria_msj),
                    'nombre'=>Array('dato'=>$nombre,'error'=>$nombre_msj),
                    'descripcion'=>Array('dato'=>$descripcion,'error'=>$descripcion_msj),
                    'detalle'=>Array('dato'=>$detalle,'error'=>$detalle_msj),
                    'precio'=>Array('dato'=>$precio,'error'=>$precio_msj),
                    'precio_web'=>Array('dato'=>$precio_web,'error'=>$precio_web_msj),
                    'stock'=>Array('dato'=>$stock,'error'=>$stock_msj),
                    'limite'=>Array('dato'=>$limite,'error'=>$limite_msj),

                    'valido_desde'=>Array('dato'=>$valido_desde,'error'=>$valido_desde_msj),
                    'valido_hasta'=>Array('dato'=>$valido_hasta,'error'=>$valido_hasta_msj),

                );

            }

            return response()->json(['datos'=>$arreglo,'correctos'=>$correctos,'advertencias'=>$advertencias,'errores'=>$errores], 200);

        } catch (\Exception $th) {
            //throw $th;
            return response()->json(['state'=>'0']);
        }
       }
    public function importar_excel_ya(Request $request)
    {

        try {
            //code...
            $request->validate([
                'import_file' => 'required|file|mimes:xls,xlsx'
            ]);

            $path = $request->file('import_file');
            $data = Excel::toArray(new ProductCollectionImport, $path)[0];
            $valor='';
            $arreglo=Array();
            $correctos=0;
            $advertencias=0;
            $errores=0;
            foreach ($data as $key => $value) {
                # code...
                $codigo=$value['codigo']?$value['codigo']:null;
                $marca=$value['marca']?$value['marca']:null;
                $unidad=$value['unidad']?$value['unidad']:null;
                $categoria=$value['categoria']?$value['categoria']:null;
                $nombre=$value['nombre']?$value['nombre']:null;
                $descripcion=$value['descripcion']?$value['descripcion']:null;
                $detalle=$value['detalle']?$value['detalle']:null;
                $precio=$value['precio']?$value['precio']:null;
                $limit=$value['limite']?($value['limite']=='si'||$value['limite']=='SI'?1:0):null;
                $precio_web=$value['precio_web']?$value['precio_web']:null;
                $stock=$value['stock']?$value['stock']:null;
                $valido_desde=$value['valido_desde']?$value['valido_desde']:null;
                $valido_hasta=$value['valido_hasta']?$value['valido_hasta']:null;


                if($codigo!=null){
                    if(Product::where('code',$codigo)->get()->count()==0){
                        $temp_marca=null;
                        if(Brand::where('name',$marca)->get()->count()==0){
                            $temp_marca=new Brand();
                            $temp_marca->name=$marca;
                            $temp_marca->state=1;
                            $temp_marca->save();
                        }
                        else
                            $temp_marca=Brand::where('name',$marca)->get()->first();


                        $temp_unidad=null;
                        if(Unit::where('name',$unidad)->get()->count()==0){
                            $temp_unidad=new Unit();
                            $temp_unidad->name=$unidad;
                            $temp_unidad->state=1;
                            $temp_unidad->save();
                        }
                        else
                            $temp_unidad=Unit::where('name',$unidad)->get()->first();


                        $temp_categoria=null;
                        if(Category::where('name',$categoria)->get()->count()==0){
                            $temp_categoria=new Category();
                            $temp_categoria->name=$categoria;
                            $temp_categoria->description='';
                            $temp_categoria->photo='';
                            $temp_categoria->father_id=1;
                            $temp_categoria->state=1;
                            $temp_categoria->save();
                        }
                        else
                            $temp_categoria=Category::where('name',$categoria)->get()->first();

                        $temp_producto=new Product();
                        $temp_producto->code=$codigo;
                        $temp_producto->name=$nombre;
                        $temp_producto->url=$nombre;
                        $temp_producto->description=$descripcion;
                        $temp_producto->detail=$detalle;
                        $temp_producto->regular_price=$precio_web+(($precio_web*5)/100);
                        $temp_producto->discount=5;
                        $temp_producto->price=$precio_web;
                        $temp_producto->stock=$stock;
                        $temp_producto->limit=$limit;
                        $temp_producto->valido_desde=$valido_desde;
                        $temp_producto->valido_hasta=$valido_hasta;
                        $temp_producto->unit=$temp_unidad->name;
                        $temp_producto->brand=$temp_marca->name;
                        $temp_producto->state=1;
                        $temp_producto->quantity=1;
                        $temp_producto->save();

                        $temp_producto->categorias()->attach($temp_categoria->id);

                    }
                    else{
                        $temp_producto=Product::where('code',$codigo)->get()->first();
                        $temp_producto->price=$precio_web;
                        $temp_producto->stock=$temp_producto->stock+$stock;
                        $temp_producto->save();
                    }

                }

            }

                return response()->json(['state'=>'1']);
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json(['state'=>'0']);
        }


    }
}

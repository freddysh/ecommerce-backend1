<?php

namespace App\Http\Controllers\Store;

use App\Helpers\PasarelaNiubiz;
use App\Helpers\PasarelaNiubizApi;
use App\Http\Controllers\Controller;
use App\Mail\Mail\OrderMail;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fecha($fecha='08 Diciembre 2021'){
        return $this->formatearFecha($fecha);
    }
    protected function formatearFecha($fecha){
        // $fecha='04 Marzo 2021';
        $fechaE=explode(' ',$fecha);
        $meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
        $mes =array_search(strtolower(trim($fechaE[1])), $meses)+1;
        if($mes<10)
            $mes='0'.$mes;
        $fecha_= $fechaE[2].'-'.$mes.'-'.$fechaE[0];
        return $fecha_;
    }
    public function index_view()
    {
        //
        return view('store.orders.index');
    }
    public function order_show_view($order_id)
    {
        //
        return view('store.orders.show',['order_id'=>$order_id]);
    }
    public function order_entregadas_show_view($order_id)
    {
        //
        return view('store.orders.show',['order_id'=>$order_id]);
    }
    public function order_entregar_show_view($order_id)
    {
        //
        return view('store.orders.show',['order_id'=>$order_id]);
    }
    public function orders_entregadas()
    {
        //
        return view('store.orders.orders-entregadas');
    }
    public function orders_entregar()
    {
        //
        return view('store.orders.orders-entregar');
    }
    public function orders_empacar()
    {
        //
        return view('store.orders.orders-empacar');
    }
    public function index()
    {
        //
        // $fecha='04 Marzo 2021';
        // $fechaE=explode(' ',$fecha);
        // $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        // $mes =array_search($fechaE[1], $meses)+1;
        // if($mes<10)
        //     $mes='0'.$mes;
        // $fecha_= $fechaE[2].'-'.$mes.'-'.$fechaE[0];
        return Order::all();
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
        DB::beginTransaction();
        try {
            // recojemos los datos
            $form=$request->form_data;
            $cart=$request->cart;

            $cliente_id=$form['id_user'];
            $client=User::findorfail($cliente_id);
            $code='';
            $full_name=$client->name;
            $email=$client->email;
            $phone=$form['celular'];
            $departament='';
            $province='';
            $distrite=$form['distrito'];
            $address=$form['direccion'];
            $reference=$form['referencia'];
            $lat='';
            $long='';
            $coupond_id=0;
            $subcoupond=0;
            $subtotal=0;
            $tax=$form['tax'];
            $total=$form['total_price'];

            $fecha_pedido= Carbon::now('America/Lima')->toDateTimeString();
            $fecha_entrega=$this->formatearFecha($form['picked_fecha']);

            $hora_entrega=$form['picked_hora'];
            $metodo_pago=$form['picked_metodo'];
            $url_comprobante='';
            $imagen_comprobante='';
            $user_id=0;
            $nota_cancelacion_cliente='';
            $state=1;
            $lugar_entrega=0;
            $cliente_id=$form['id_user'];
            $nota_cancelacion_user='';

            $order=new Order();
            $order->code=$code;
            $order->full_name=$full_name;
            $order->email=$email;
            $order->phone=$phone;
            $order->departament=$departament;
            $order->province=$province;
            $order->distrite=$distrite;
            $order->address=$address;
            $order->reference=$reference;
            $order->lat=$lat;
            $order->long=$long;
            $order->coupond_id=$coupond_id;
            $order->subcoupond=$subcoupond;
            $order->subtotal=$subtotal;
            $order->tax=$tax;
            $order->total=$total;
            $order->fecha_pedido=$fecha_pedido;
            $order->url_comprobante=$url_comprobante;
            $order->imagen_comprobante=$imagen_comprobante;
            $order->nota_cancelacion_user=$nota_cancelacion_user;
            $order->user_id=$user_id;
            $order->nota_cancelacion_cliente=$nota_cancelacion_cliente;
            $order->state=$state;
            $order->lugar_entrega=$lugar_entrega;
            $order->cliente_id=$cliente_id;
            $order->fecha_entrega=$fecha_entrega;
            $order->hora_entrega=$hora_entrega;
            $order->metodo_pago=$metodo_pago;
            $order->created_at=$fecha_pedido;
            $order->save();

            $order->code=$order->id;
            $order->save();

            // Creamos el detalle del la orden
            if(count($cart)){
                foreach($cart as $cart_){
                    $product_id=$cart_['id'];
                    $quantity=$cart_['quantity'];
                    if($product_id>0&&$quantity>0){
                        $producto=Product::with(['categorias'])->where('id',$product_id)->get()->first();
                        $categorias_consultar_precio=$producto->categorias()->get()->pluck('name')->toArray();
                        $pu=$producto->price;
                        if(in_array('Consultar precio',$categorias_consultar_precio)){
                            $pu=0;
                            $quantity=1;
                        }
                        if($producto){
                            if($quantity<=$producto->stock){
                                $order_product = new OrderProduct();
                                $order_product->quantity=$quantity;
                                $order_product->pu=$pu;
                                $order_product->state=1;
                                $order_product->product_id=$producto->id;
                                $order_product->order_id=$order->id;
                                $order_product->save();
                                $producto->stock=$producto->stock-$quantity;
                                $producto->save();
                            }
                            else{
                                throw new \Exception("Este producto no tiene stock");
                            }
                        }
                        else{
                            throw new \Exception("No existe el producto");
                        }
                    }
                    else{
                        throw new \Exception("No existe el producto y/o stock");
                    }
                }
            }
            else{
                throw new \Exception("No existe el producto");
            }
            DB::commit();
            // $this->enviarMail($order->id);
            return response()->json(['status'=>'1']);

        } catch (\Exception $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['status'=>'0']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
        return Order::with(['cliente','productos_ordenados.producto.categorias','productos_ordenados.producto.photos'])
        ->where('id',$order->id)->get()->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function getAllClient($client_id)
    {
        //
        $orders=Order::with(['cliente','productos_ordenados.producto.categorias','productos_ordenados.producto.photos'])
        ->where('cliente_id',$client_id)->get();
        return $orders;
    }

    public function enviar($order_id,$state,$user_id)
    {
        //
        $order=Order::findorfail($order_id);
        $order->state=$state;
        if($state==2){
            $order->en_proceso_user=Carbon::now('America/Lima')->toDateTimeString();
            $order->en_proceso_user_id=$user_id;
        }
        elseif($state==3){
            $order->dispached_user=Carbon::now('America/Lima')->toDateTimeString();
            $order->dispached_user_id=$user_id;
        }elseif($state==4){
            $order->entregado_user=Carbon::now('America/Lima')->toDateTimeString();
            $order->entregado_user_id=$user_id;
        }
        $order->save();
        return response()->json(['status'=>'1']);
    }
    public function enviar_mensaje(Request $request)
    {
        // return response()->json(['status'=>$request->all()]);
        $order_id=$request->id;
        $mensaje=$request->mensaje;
        $state=$request->state;
        $user_id=$request->user_id;

        $order=Order::findorfail($order_id);
        $order->state=$state;
        if($state==-1){
            $order->cancelado_user=Carbon::now('America/Lima')->toDateTimeString();
            $order->cancelado_user_id=$user_id;
            $order->nota_cancelacion_user=$mensaje;
        }
        elseif($state==-2){
            $order->cancelado_cliente=Carbon::now('America/Lima')->toDateTimeString();
            $order->cancelado_user_id=$user_id;
            $order->nota_cancelacion_cliente=$mensaje;
        }
        $order->save();
        return response()->json(['status'=>'1']);
    }
    public function enviar_precio(Request $request)
    {

        try {
            //code...
            $id=$request->id;
            $precio=$request->precio;

            $order_product=OrderProduct::findorfail($id);
            $order_product->pu=$precio;
            $order_product->save();
            return response()->json(['status'=>'1']);
        } catch (\Exception $th) {
            //throw $th;
            return response()->json(['status'=>'0']);
        }

    }
    public function reportes(){
        return view('admin.report.index');
    }

    public function pendientes(){
        return Order::where('state',1)->get()->count();
    }
    public function empacados(){
        return Order::where('state',2)->get()->count();
    }
    public function encamino(){
        return Order::where('state',3)->get()->count();
    }
    public function ingresos($desde,$hasta){

        // return "$desde,$hasta";
        $ingresos= DB::table('orders')
        ->join('order_products','order_products.order_id','=','orders.id')
        ->join('products','order_products.product_id','=','products.id')
        ->groupBy('orders.fecha_pedido')
        ->orderBy('fecha_pedido','asc')
        ->select('orders.fecha_pedido',DB::raw('SUM(order_products.quantity*order_products.pu) as ingreso'))
        ->whereBetween('fecha_pedido',[$desde,$hasta])
        ->get();

        $arreglo=Array();
        $total=0;
        foreach ($ingresos as $key => $value) {
            # code...
            $arreglo[$value->fecha_pedido]=$this->numero($value->ingreso);
            $total+=$value->ingreso;
        }

        return response()->json(['ingresos'=>$arreglo,'total'=>$total]);
    }
    protected function numero($num){
        return Round($num * 100) / 100;
    }

    protected function enviarMail($order_id=1){

        $order=Order::with(['cliente','productos_ordenados.producto.categorias','productos_ordenados.producto.photos'])
        ->where('id',$order_id)->get()->first();
        $destinatario = $order->cliente->email;
        // $order = "Listado de ordenes";
        // $nombre = "Luis Cabrera Benito";
        // Armar correo y pasarle datos para el constructor
        $correo = new OrderMail($order);
        # ¡Enviarlo!
        Mail::to($destinatario)->send($correo);
    }

    public function payment(){

        $pasarela=new PasarelaNiubiz();
        $numorden=$pasarela->contador();
        $entorno = 'dev';
        $amount=100;
        $mdd4='silvahfreddy@gmail.com';
        $mdd21='1';
        $mdd32='9123';
        $mdd75='Registrado';
        $mdd77='100';
        $key = $pasarela->securitykey($entorno);
        // return $key;
        setcookie("key",$key);
        // setcookie("key",$key);
        $purchasenumber=$numorden;
        $sessionToken = $pasarela->create_token($entorno,$amount,$mdd4,$mdd21,$mdd32,$mdd75,$mdd77,$key);
        $sessionkey= json_decode($sessionToken)->sessionKey;

        // Obtenemos la url.js para mostrar el boton de pago
        $callbackurl=$pasarela->urljs($entorno);
        $merchantid = $pasarela->merchantidtest();
        $channel='web';
        $language='es';
        $font='https://fonts.googleapis.com/css?family=Montserrat:400&display=swap';
        $recurrencemaxamount='8.5';
        // return response()->json([
        //     'callbackurl'=>$urljs,
        //     'channel'=>'web',
        //     'entorno'=>$entorno,
        //     'purchasenumber'=>$purchasenumber,
        //     'sessionkey'=>$sessionKey,
        //     'merchantid'=>$merchantId,
        //     'amount'=>$amount,
        //     'language'=>'es',
        //     'font'=>'https://fonts.googleapis.com/css?family=Montserrat:400&display=swap',
        //     'language'=>'es',
        //     'recurrencemaxamount'=>'100'
        //     ]);
        // $autorizacion=$pasarela->authorization($entorno,$key,$amount,$sessionKey,$purchaseNumber);
        // return $autorizacion;

            return view('admin.payment',compact('callbackurl','channel','entorno','purchasenumber',
            'sessionkey','merchantid','amount','language','recurrencemaxamount','font'));
    }

    public function payment_respuesta(Request $request,$purchaseNumber,$entorno,$amount,$order_id){
        // $variable=base64_decode($variable);
        // return response()->json("$variable");
        // dd($_POST);

        try {
            //code...
            if (isset($_POST['transactionToken'])){
                $transactionToken = $_POST['transactionToken'];
                // $key =$_COOKIE["clave"];
                $key='';
                if(isset($_COOKIE['clave'])){
                    // dd('No existe la cookie');
                    $key =$_COOKIE["clave"];
                }
                else{
                    dd("No tenemos la key");
                    // return redirect()->back();
                }
                // dd($key);
                $pasarela=new PasarelaNiubiz();
                $respuesta = $pasarela->authorization($entorno,$key,$amount,$transactionToken,$purchaseNumber);

                $data_respuesta = json_decode($respuesta,true);
                // dd($data_respuesta);
                $objeto=json_decode($data_respuesta['1']);
                if($data_respuesta['0']=='200'){
                    // EL pago se proceso correctamente
                    $order=Order::findOrFail($order_id);
                    $order->transaction_token='63ueytruyewtrw==';
                    $order->state=1;
                    $order->save();
                    dd('proceso de pago correcto');
                }
                elseif($objeto){// hubo un aproblema en la transaccion
                    $motivo=$objeto->data->ACTION_DESCRIPTION;
                     dd("Ocurrio un error($objeto->errorCode)");
                    // return redirect()->back();
                    // return redirect()->route('checkout',compact(''))->with(['msj'=>"Ocurrio un error($objeto->errorCode). Vuelva a intentarlo",'motivo'=>$motivo]);
                }
                else{
                    // return redirect()->route('checkout',compact(''))->with(['msj'=>"Ocurrio un error($objeto). Vuelva a intentarlo"]);
                    // return redirect()->back();
                     dd("Ocurrio un error($objeto)");
                }
            // dd($transactionToken);
            }
        } catch (\Exception $ex) {
            //throw $th;

            dd("Ocurrio un error catch($ex)");
            // return redirect()->back();
        }
        // return 'payment';
    }

    public function payment_desacoplado(){
        return view('admin.payment-desacoplado');
    }

    public function payment_desacoplado_api($order_id){

        $orden=Order::findOrFail($order_id);
        $pasarela=new PasarelaNiubiz();
        $numorden=$pasarela->contador();
        $entorno = 'dev';
        $amount=$orden->total+$orden->tax;
        $mdd4=$orden->email;
        $name=$orden->full_name;
        $lastname=$orden->full_name;
        $mdd21='1';//-- indica si es cliente frecuente o no
        $mdd32='987';//-- codigo identificador del cliente o id del cliente
        $mdd75='Registrado';
        $mdd77='20';//-- indica los dias registrados del cliente
        $key = $pasarela->securitykey($entorno);
        // return $key;
        // session_start();
        if(isset($_COOKIE['clave'])){
            unset ($_COOKIE ["clave"]);
        }
        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        setcookie('clave', $key, time()+606024*365, '/', $domain, false);
        // setcookie("clave",$key);
        // setcookie("key",$key);
        $purchasenumber=$numorden;
        $sessionToken = $pasarela->create_token($entorno,$amount,$mdd4,$mdd21,$mdd32,$mdd75,$mdd77,$key);
        $sessionkey= json_decode($sessionToken)->sessionKey;

        // Obtenemos la url.js para mostrar el boton de pago
        $callbackurl="payment_respuesta/$purchasenumber/$entorno/$amount/$order_id";
        $merchantid = $pasarela->merchantidtest();
        $channel='web';
        $language='es';
        $font='https://fonts.googleapis.com/css?family=Montserrat:400&display=swap';
        $recurrencemaxamount='380';
        return response()->json([
            'callbackurl'=>$callbackurl,
            'channel'=>$channel,
            'entorno'=>$entorno,
            'purchasenumber'=>$purchasenumber,
            'sessionkey'=>$sessionkey,
            'merchantid'=>$merchantid,
            'amount'=>$amount,
            'language'=>$language,
            'font'=>$font,
            'recurrencemaxamount'=>$recurrencemaxamount,
            'name'=>$name,
            'lastname'=>$lastname,
            'email'=>$mdd4,
            ]);
        // $autorizacion=$pasarela->authorization($entorno,$key,$amount,$sessionKey,$purchaseNumber);
        // return $autorizacion;

            // return view('admin.payment',compact('callbackurl','channel','entorno','purchasenumber',
            // 'sessionkey','merchantid','amount','language','recurrencemaxamount','font'));
    }

    public function store_api(Request $request)
    {
        DB::beginTransaction();
        try {
            // recojemos los datos
            $form=$request->form_data;
            $cart=$request->cart;

            $cliente_id=$form['id_user'];
            $client=User::findorfail($cliente_id);
            $code='';
            $full_name=$client->name;
            $email=$client->email;
            $phone=$form['celular'];
            $departament='';
            $province='';
            $distrite=$form['distrito'];
            $address=$form['direccion'];
            $reference=$form['referencia'];
            $lat='';
            $long='';
            $coupond_id=0;
            $subcoupond=0;
            $subtotal=0;
            $tax=$form['tax'];
            $total=$form['total_price'];

            $fecha_pedido= Carbon::now('America/Lima')->toDateTimeString();
            $fecha_entrega=$this->formatearFecha($form['picked_fecha']);

            $hora_entrega=$form['picked_hora'];
            $metodo_pago=$form['picked_metodo'];;
            $url_comprobante='';
            $imagen_comprobante='';
            $user_id=0;
            $nota_cancelacion_cliente='';
            $state=0;
            $lugar_entrega=0;
            $cliente_id=$form['id_user'];
            $nota_cancelacion_user='';

            $order=new Order();
            $order->code=$code;
            $order->full_name=$full_name;
            $order->email=$email;
            $order->phone=$phone;
            $order->departament=$departament;
            $order->province=$province;
            $order->distrite=$distrite;
            $order->address=$address;
            $order->reference=$reference;
            $order->lat=$lat;
            $order->long=$long;
            $order->coupond_id=$coupond_id;
            $order->subcoupond=$subcoupond;
            $order->subtotal=$subtotal;
            $order->tax=$tax;
            $order->total=$total;
            $order->fecha_pedido=$fecha_pedido;
            $order->url_comprobante=$url_comprobante;
            $order->imagen_comprobante=$imagen_comprobante;
            $order->nota_cancelacion_user=$nota_cancelacion_user;
            $order->user_id=$user_id;
            $order->nota_cancelacion_cliente=$nota_cancelacion_cliente;
            $order->state=$state;
            $order->lugar_entrega=$lugar_entrega;
            $order->cliente_id=$cliente_id;
            $order->fecha_entrega=$fecha_entrega;
            $order->hora_entrega=$hora_entrega;
            $order->metodo_pago=$metodo_pago;
            $order->created_at=$fecha_pedido;
            $order->save();


            $order->code=$order->id;
            $order->save();
            // Creamos el detalle del la orden
            if(count($cart)){
                foreach($cart as $cart_){
                    $product_id=$cart_['id'];
                    $quantity=$cart_['quantity'];
                    if($product_id>0&&$quantity>0){
                        $producto=Product::with(['categorias'])->where('id',$product_id)->get()->first();
                        $categorias_consultar_precio=$producto->categorias()->get()->pluck('name')->toArray();
                        $pu=$producto->price;
                        if(in_array('Consultar precio',$categorias_consultar_precio)){
                            $pu=0;
                            $quantity=1;
                        }
                        if($producto){
                            if($quantity<=$producto->stock){
                                $order_product = new OrderProduct();
                                $order_product->quantity=$quantity;
                                $order_product->pu=$pu;
                                $order_product->state=1;
                                $order_product->product_id=$producto->id;
                                $order_product->order_id=$order->id;
                                $order_product->save();
                                $producto->stock=$producto->stock-$quantity;
                                $producto->save();
                            }
                            else{
                                throw new \Exception("Este producto no tiene stock");
                            }
                        }
                        else{
                            throw new \Exception("No existe el producto");
                        }
                    }
                    else{
                        throw new \Exception("No existe el producto y/o stock");
                    }
                }
            }
            else{
                throw new \Exception("No existe el producto");
            }
            DB::commit();
            // $this->enviarMail($order->id);
            return response()->json(['status'=>'1','order_id'=>$order->id]);

        } catch (\Exception $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['status'=>'0']);
        }
    }

    public function sesion($order_id){
        // return $order_id;
        $orden=Order::where('id',$order_id)->get()->first();
        $amount=($orden->total+$orden->tax);
        $channel=env('VISA_CHANNEL');
        // return env('VISA_URL_SECURITY');
        $pasarelaNiubizApi=new PasarelaNiubizApi();
        $token = $pasarelaNiubizApi->generateToken();
        // return $token;

        $fechaRegitro=Carbon::parse($orden->cliente->created_at);
        $fechaActual= Carbon::now('America/Lima');
        $date_diff=$fechaActual->diffInDays($fechaRegitro);
        // return $date_diff;
        // $date_diff='63';

        // $mdd4='integraciones.visanet@necomplus.com';
        // $mdd21='1';
        // $mdd32='integraciones.visanet@necomplus.com';
        // $mdd75='Registrado';
        // $mdd77='63';

        $mdd4=$orden->email;//-- email del cliente
        $mdd21='0';//-- cliente frecuente 0,1
        $mdd32=$orden->email;//-- id del cliente
        $mdd75='Registrado';//-- indicar si el cliente es registrado
        $mdd77=$date_diff;//-- diferencias de dias

        $sesion = $pasarelaNiubizApi->generateSesion($amount, $token, $channel, $mdd4, $mdd21, $mdd32, $mdd75, $mdd77);
        // $purchaseNumber = $pasarelaNiubizApi->generatePurchaseNumber();
        $purchaseNumber = $orden->code;

        $data = array(
            "sesionkey" => $sesion,
            "merchantid" => $pasarelaNiubizApi->visa_merchant_id(),
            // "merchantid" => env('VISA_DEV_MERCHANT_ID'),
            "purchasenumber" => $purchaseNumber,
            "amount" => $amount,
            "channel" => $channel
         );
        // return response()->json($data);
        return json_encode($data);
    }
    public function authorization(Request $request){
        $transactionToken=$request->transactionToken;
        $amount=$request->amount;
        $purchase=$request->purchase;
        $pasarelaNiubizApi=new PasarelaNiubizApi();
        $token = $pasarelaNiubizApi->generateToken();
        $authorization = $pasarelaNiubizApi->generateAuthorization($amount, $purchase, $transactionToken, $token);
        // return response()->json($authorization);

        return json_encode($authorization);
    }

    public function store_confirm($order_id,$state,$card,$cardBrand,$traceNumber,$description){
        try {
                //code...
                $order=Order::findorfail($order_id);
                $order->state=$state;
                $order->card=$card;
                $order->cardBrand=$cardBrand;
                $order->traceNumber=$traceNumber;
                $order->card_description=$description;
                if($order->save())
                    return response()->json(['status'=>'1']);
                else
                    return response()->json(['status'=>'0']);
            } catch (\Exception $th) {
                //throw $th;
            return response()->json(['status'=>'0']);
            }
    }
    public function store_denegado($order_id){
        try {
                //code...
                $order=Order::findorfail($order_id);
                $numeroPedido=$order->code;
                $fecha_hora=$order->created_at;
                return response()->json(['numeroPedido'=>$numeroPedido,'fecha_hora'=>$fecha_hora]);
            } catch (\Exception $th) {
                //throw $th;
            return response()->json(['status'=>'0']);
            }
    }

    public function prueba_visa(){

        $pasarelaNiubizApi=new PasarelaNiubizApi();
        return $pasarelaNiubizApi->VISA_USER;
    }
}

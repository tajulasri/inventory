<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repository\OrderRepository;
use App\Entity\Purchase;
use App\Entity\Stock;
use Validator;
use DB;

class OrderController extends Controller
{

    private $order;

    const VIEW_PATH = 'orders.';

    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
        $this->middleware('auth',['except' => ['order','saveOrder']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->order->getPurchase()
                ->where('status',Purchase::PENDING_PURCHASE)
                ->paginate($this->order->getPaginationLimit());

        $counter = 1;
        if(view()->exists(self::VIEW_PATH.'index')) {
            return view(self::VIEW_PATH.'index')->with(compact('orders','counter'));
        }
        return abort(404);
    }

    public function completed()
    {
        $orders = $this->order->getPurchase()
            ->where('status',Purchase::APPROVE_PURCHASE)
            ->paginate($this->order->getPaginationLimit());

        $counter = 1;
        if(view()->exists(self::VIEW_PATH.'completed')) {
            return view(self::VIEW_PATH.'completed')->with(compact('orders','counter'));
        }
        return abort(404);
    }

    public function order($slug)
    {
        $item = $this->order->getItemBySlug($slug);
        if(view()->exists(self::VIEW_PATH.'order-form')) {
            return view(self::VIEW_PATH.'order-form')->with(compact('item'));
        }
        return abort(404);
    }

    /**
     *  "customer" => ""
  "customer_contact" => ""
  "customer_address" => ""
  "remarks" => ""
     * @param  Request $request [description]
     * @param  [type]  $slug    [description]
     * @return [type]           [description]
     */
    public function saveOrder(Request $request,$slug)
    {
        $item = $this->order->getItemBySlug($slug);
        $validator = Validator::make($request->except('_token'),[
            'customer' => 'required',
            'customer_contact' => 'required',
            'customer_address' => 'required',
            'remarks' => 'required'
            ]);

        if($validator->fails()) {
            return redirect()->back()->with(self::ERROR_KEY,self::VALIDATION_MESSAGE);
        }

        $order = new Purchase;
        $order->item_id = $item->id;
        $order->quantity = $request->quantity;
        $order->customer_name = $request->customer;
        $order->customer_address = $request->customer_address;
        $order->customer_contact = $request->customer_contact;
        $order->remarks = $request->remarks;
        
        if($order->save()) {
            return redirect()->back()->with(self::SUCCESS_KEY,self::SUCCESS_MESSAGE.'- ORDER ID ANDA ADALAH - #'.$order->id);
        }

        return redirect()->back()->with(self::ERROR_KEY,self::ERROR_MESSAGE);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(view()->exists(self::VIEW_PATH.'create')) {
            return view(self::VIEW_PATH.'create');
        }
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->except('_token'),[
            'customer' => 'required',
            'customer_contact' => 'required',
            'customer_address' => 'required',
            'remarks' => 'required'
            ]);

        if($validator->fails()) {
            return redirect()->back()->with(self::ERROR_KEY,self::VALIDATION_MESSAGE);
        }

        DB::beginTransaction();

        $order = new Purchase;
        $order->item_id = $request->item_id;
        $order->status = $request->status;
        $order->quantity = $request->quantity;
        $order->customer_name = $request->customer;
        $order->customer_address = $request->customer_address;
        $order->customer_contact = $request->customer_contact;
        $order->remarks = $request->remarks;

        //later fix about this hack flag
        if($request->status == 1) {

            $stock = Stock::where('item_id',$order->item->id)->first();
            if($stock->balance >= 1 ) {
                $stock->balance -= $request->quantity;
                $stock->save();
            }
            else {

                DB::rollBack();
                return redirect()->back()->with(self::ERROR_KEY,self::ERROR_MESSAGE.'- No stock');
            }
        }

        DB::commit();
        if($order->save()) {
            return redirect()->back()->with(self::SUCCESS_KEY,self::SUCCESS_MESSAGE.'- ORDER ID ANDA ADALAH - #'.$order->id);
        }

        return redirect()->back()->with(self::ERROR_KEY,self::ERROR_MESSAGE);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->order->getPurchaseById($id);
        if(view()->exists(self::VIEW_PATH.'edit')) {
            return view(self::VIEW_PATH.'edit')->with(compact('order'));
        }
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     *  "customer": "ADSASDS",
        "status": "0",
        "customer_contact": "ASDASD",
        "customer_address": "ASDAS",
        "remarks": ""
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $order = $this->order->getPurchaseById($id);
        $order->customer_name = $request->customer;
        $order->status = $request->status;
        $order->quantity = $request->quantity;
        $order->customer_contact = $request->customer_contact;
        $order->customer_address = $request->customer_address;
        $order->remarks = $request->remarks;

        //later fix about this hack flag
        if($request->status == Purchase::APPROVE_PURCHASE) {

            $stock = Stock::where('item_id',$order->item->id)->first();
            if($stock->balance >= Stock::TRESHOLD_LIMIT ) {
                $stock->balance -= $request->quantity;
                $stock->save();
            }
            else {

                DB::rollBack();
                return redirect()->back()->with(self::SUCCESS_KEY,self::ERROR_MESSAGE.'- no stock');
            }
        }

        DB::commit();
        if($order->save()) {
            return redirect()->back()->with(self::SUCCESS_KEY,self::SUCCESS_MESSAGE);
        }

        return redirect()->back()->with(self::ERROR_KEY,self::ERROR_MESSAGE);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

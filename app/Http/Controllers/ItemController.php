<?php

namespace App\Http\Controllers;

use App\EzOrder\FileUploadHelper;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Validator;
use App\Entity\Item;
use App\Entity\Stock;
use App\Repository\OrderRepository;

class ItemController extends Controller
{

    private $order;

    private $fileSystem;

    const VIEW_PATH = 'stocks.';


    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->order
                ->getItem()
                ->paginate($this->order->getPaginationLimit());

        $counter = 1;
        if(view()->exists(self::VIEW_PATH.'index')) {
            return view(self::VIEW_PATH.'index')->with(compact('items','counter'));
        }
        return abort(404);
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

    public function stock()
    {
        if(view()->exists(self::VIEW_PATH.'assign-stock')) {
            return view(self::VIEW_PATH.'assign-stock');
        }
        return abort(404);
    }

    /**
     * save stock 
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function saveStock(Request $request)
    {
        $validator = Validator::make($request->except('_token'),[
            'item_id' => 'required',
            'balance' => 'required'
            ]);

        if($validator->fails()) {
            return redirect()->back()->with(self::ERROR_KEY,self::ERROR_MESSAGE);
        }

        $item = Stock::where('item_id',$request->item_id);
        
        try {

            if($item->count()) {
            //topup
            $item = $item->first();
            $item->balance += $request->balance;
            $item->save();
            }
            else {
                //create new
                Stock::firstOrNew($request->except('_token'))->save();
            }
            return redirect()->back()->with(self::SUCCESS_KEY,self::SUCCESS_MESSAGE);

        }
        catch(Exception $e) {

            return redirect()->back()->with(self::ERROR_KEY,self::ERROR_MESSAGE);
        }
    }

    /**
     * Store a newly created resource in storage.
     * "brand": "",
     * "model": "",
     * "sku": "",
     * "category": "1",
     * "buy": "",
     * "sell": ""
     * }
     *
     * @param  \Illuminate\Http\Request $request
     * @param ImageManager $manager
     * @param Filesystem $filesystem
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,
                          ImageManager $manager,
                          Filesystem $filesystem)
    {
        $validator  = Validator::make($request->except('_token'),[
            'brand' => 'required',
            'model' => 'required',
            //'identifier' => 'required',
            'buy' => 'required',
            'sell' => 'required',
            'category_id' => 'required'
            ]);

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $uploadFile = new FileUploadHelper($request->file('image'));
            $uploadFile->workingWithDir($filesystem);
            $uploadFile->enableResizing($manager);

            if (!$uploadFile->isAllow()) {
                return redirect()->back()->with(self::ERROR_KEY, self::ERROR_MESSAGE);
            }

            $uploadFile->upload();
        }

        if($validator->fails()) {
            return redirect()->back()->with(self::ERROR_KEY,self::VALIDATION_MESSAGE);
        }

        try {

            $item = Item::create($request->all());
            Item::where($this->order->getItemModel()->getKeyName(),$item->id)
                    ->update([
                        'identifier' => Item::generateIdentifier($item),
                        'item_slug'=> str_slug($request->brand." ".$request->model,'-'),
                        'image' => $uploadFile->getYear().DIRECTORY_SEPARATOR.$uploadFile->getAfterRename()
                    ]);

            Stock::firstOrNew(['item_id' => $item->id])->save();
            return redirect()->back()->with(self::SUCCESS_KEY,self::SUCCESS_MESSAGE);
        }
        catch(Exception $e) {

            return redirect()->back()->with(self::ERROR_KEY,self::ERROR_MESSAGE);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = $this->order->getItemById($id);

        if(view()->exists(self::VIEW_PATH.'edit')) {
            return view(self::VIEW_PATH.'edit')->with(compact('item'));
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator  = Validator::make($request->except('_token'),[
            'brand' => 'required',
            'model' => 'required',
            'identifier' => 'required',
            'buy' => 'required',
            'sell' => 'required',
            'category_id' => 'required'
            ]);

        if($validator->fails()) {
            return redirect()->back()->with(self::ERROR_KEY,self::VALIDATION_MESSAGE);
        }

        try {

            $filePath = explode('=',$request->image);
            $request->image = base64_decode($filePath[1]);
            $attributes = [

                'brand' =>  $request->brand,
                'item_slug' => $request->item_slug,
                'model' => $request->model,
                'identifier' => $request->identifier,
                'attributes' => $request->get('attributes'), //attributes reserve keywords
                'category_id' => $request->category_id,
                'buy' => $request->buy,
                'sell' => $request->sell,
                'image' => base64_decode($filePath[1]),
            ];

            Item::where($this->order->getItemModel()
                    ->getKeyName(),$id)
                    ->update($attributes);

            return redirect()->back()->with(self::SUCCESS_KEY,self::SUCCESS_MESSAGE);
        }
        catch(Exception $e) {

            return redirect()->back()->with(self::ERROR_KEY,self::ERROR_MESSAGE);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $this->order->getItemById($id)->delete();
            Stock::where('item_id',$id)->delete();
            return redirect()->back()->with(self::SUCCESS_KEY,self::SUCCESS_MESSAGE);
        }
        catch(Exception $e) {

            return redirect()->back()->with(self::ERROR_KEY,self::ERROR_MESSAGE);
        }

    }
}

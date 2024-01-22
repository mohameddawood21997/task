<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Client;
use App\Models\BillDetail;
use App\Http\Requests\Bills\StoreBillRequest;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients=Client::all();
        $products=Product::all();
        return view("bills.addBill",compact('clients','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBillRequest $request)
    {  
        DB::beginTransaction();
        try {
            $totalPrice=0;
            $products=$request->input('product');
            // return $products[0];
                $prices=$request->input('price');
                $quantities=$request->input('quantity');
                $prices=$request->input('price');
                $price_total=$request->input('price_total');
          
        //   foreach ($price_total as $index=>$total) {
        //      $totalPrice+= $prices[$index];
    
        //     }
    
            $count=count($price_total);
            for ($i=0; $i <$count ; $i++) { 
                $totalPrice+= $prices[$i];
            }
           $bill=new Bill();
            $bill->client_id=$request->client_id;
            $bill->totalPrice=$totalPrice;
            $bill->save();
    
            $billDetailsData = [];
    
            // Loop through the data and prepare the bill details data
            foreach ($products as $index => $product) {
                $billDetailsData[] = [
                    'bill_id'=>$bill->id,
                    'product_id' => $product,
                    'price' => $prices[$index]?? null,
                    'quantity' => $quantities[$index]?? null,
                    
                ];
            }
          
            // foreach ($products as $index=>$product) {
            //     $billDetails=new BillDetail();
            //  $billDetails->bill_id=$bill->id;
            //  $billDetails->product_id=$product;
            //  $billDetails->quantity=$quantities[$index];
            //  $billDetails->price=$prices[$index];
            //  $billDetails->save();
            // }
            
            $bill->billDetails()->createMany($billDetailsData);
            if($billDetailsData)
            {
                DB::commit();
                \Session::flash('success', 'Data successfully stored.');
                return back();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'An error occurred. Please try again.');
            return redirect()->back()->withInput();
        }
     
    
       


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        //
    }

    public function getPrice(Request $request)
    {
        try {
        $productId = $request->input('product_id');
        $product = Product::find($productId);
        // return $product;
        // $options = '';

        // if ($product) {
        //     // foreach ($product->prices as $price) {
        //         $options .= '<option value="' . $product->id . '">' . $product->price . '</option>';
        //     // }
        // }
        // // return $options;

        return response()->json([
            'product'=>$product,
            // 'options' => $options,
            'price' => $product->price ? $product->default_price : ''
        ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    
    }
}

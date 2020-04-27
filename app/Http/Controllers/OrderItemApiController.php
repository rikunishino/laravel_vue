<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\OrderItem;

class OrderItemApiController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        for($i = 0; $i < $requestData['putProductsListLength']; $i++) {
            for($j = 0; $j < $requestData['putProductsListLength' . $i]; $j++) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $requestData['order_id'];
                // $orderItem->cart_id = $requestData['cartName' . $i . ':'. $j];
                $orderItem->product_id = $requestData['productId' . $i . ':'. $j];
                $orderItem->amount = $requestData['amount' . $i . ':'. $j];
                $orderItem->timestamps = false;

                try{
                    $orderItem->save();
                } catch(\Exception $e) {
                    return ['message' => $e];
                }
            }
        }
        return ['message' => $requestData];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        //
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

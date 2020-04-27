<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

use App\Models\OrderItem;

class OrderApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Order::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 注文テーブル保存用データ整形
        $order = new Order();
        $order->corporation_id = $request->corporationId;
        $order->name = $request->corporationName;
        $order->mail = $request->mail;
        $order->address = $request->address;
        $order->postal_code = $request->postal_code;
        $order->tel = $request->tel;
        $order->fax = $request->fax;
        $order->total_price = $request->totalPrice;
        $order->tax_rate = '10';
        $order->timestamps = false;

        try{
            $order->save();
        } catch(\Exception $e) {
            return ['order' => $e];
        }

        $order_id = $order->id;

        return ['order_id' => $order_id];
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

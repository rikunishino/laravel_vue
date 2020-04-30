<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\OrderSchool;

class OrderSchoolApiController extends Controller
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
        // $requestData = $request->all();
        // for($i = 0; $i < $requestData['classListLength']; $i++) {
        //     $orderCart = new OrderCart();
        //     $orderCart->order_id = $requestData['order_id'];
        //     $orderCart->cart_name = $requestData['cartName' . $i];
        //     $orderCart->subtotal = $requestData['subtotal' . $i];
        //     $orderCart->timestamps = false;

        //     try{
        //         $orderCart->save();
        //     } catch(\Exception $e) {
        //         return ['message' => $e];
        //     }

        //     $cart_id = $cart->id;
        // }
        return ['message' => '登録しました'];
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

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItems;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $order_code = $request->order_code ? $request->order_code : null;
            $order_date_from = $request->order_date_from ? $request->order_date_from : null;
            $order_date_to = $request->order_date_to ? $request->order_date_to : null;

            $order = Order::with(['order_items'])->when($order_code != null , function ($searchCode) use ($order_code) {
                $searchCode->where('order_no','like' ,'%'. $order_code .'%');
            })->when($order_date_from != null , function($searchDateFrom) use ($order_date_from) {
                $searchDateFrom->where('order_date', '>=',date('Y-m-d',strtotime($order_date_from)));
            })->when($order_date_to != null , function($searchDateTo) use ($order_date_to){
                $searchDateTo->where('order_date' ,'<=' , date('Y-m-d',strtotime($order_date_to)));
            })->get();


            return response()->json($order,200);

        } catch (\Throwable $e){
            return response()->json(['message' => 'Something wrong'],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $order = new Order();
            $order->order_no = $order->getCode();
            $order->customer_name = $request->cust_name;
            $order->order_date = date('Y-m-d',strtotime($request->order_date));
            $order->save();

            $total_order = 0;

            if ($request->item){
                foreach ($request->item as $oi){
                    $order_item = new OrderItems();
                    $order_item->order_id = $order->id;
                    $order_item->product_name = $oi['prod_name'];
                    $order_item->price = $oi['price'];
                    $order_item->qty = $oi['qty'];
                    $order_item->sub_total = $oi['price'] * $oi['qty'];
                    $order_item->save();
                    $total_order += $oi['price'] * $oi['qty'];;
                }
            }
            $order->grand_total = $total_order;
            $order->save();

            $new_order = Order::with(['order_items'])->where('id',$order->id)->first();

            return response()->json($new_order);
        } catch (\Throwable $e){
            return response()->json(['message' => 'Something wrong'],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $order = Order::with(['order_items'])->whereId($id)->first();
            if ($order){
                return response()->json($order,200);
            } else {
                return response()->json(['message' => 'Not found'],404);
            }
        } catch (\Throwable $e){
            return response()->json(['message' => 'Something wrong'],500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $order = Order::with(['order_items'])->whereId($id)->first();
            if ($order){
                $order->customer_name = $request->cust_name;
                $order->order_date = date('Y-m-d',strtotime($request->order_date));
                $order->save();

                $oldOrderItem = OrderItems::where('order_id',$order->id)->get();
                foreach ($oldOrderItem as $ooi){
                    $ooi->delete();
                }
                $total_order = 0;
                if ($request->item){
                    foreach ($request->item as $oi){
                        $newOrderItem = new OrderItems();
                        $newOrderItem->order_id = $order->id;
                        $newOrderItem->product_name = $oi['prod_name'];
                        $newOrderItem->qty = $oi['qty'];
                        $newOrderItem->price = $oi['price'];
                        $newOrderItem->sub_total = $oi['price'] * $oi['qty'];
                        $newOrderItem->save();

                        $total_order += $oi['price'] * $oi['qty'];
                    }
                }

                $order->grand_total = $total_order;
                $order->save();
                return response()->json($order,200);
            } else {
                return response()->json(['message' => 'Not found'],404);
            }
        } catch (\Throwable $e){
            return response()->json(['message' => 'Something wrong'],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $order_items = OrderItems::where('order_id',$id)->get();
            if ($order_items){
                foreach ($order_items as $oi){
                    $oi->delete();
                }
            }

            $order = Order::whereId($id)->first();
            $order->delete();

            return response()->json(['message' => 'Order berhasil dihapus'],200);
        } catch (\Throwable $e){
            return response()->json(['message' => 'Something wrong'],500);
        }
    }
}

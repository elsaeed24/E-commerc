<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate();
        return view('admin.orders.index',compact('orders'));
    }


    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.edit',compact('order'));
    }


    public function update(Request $request,$id)
    {

        $order = Order::find($id);

         Order::where('id',$id)->update(['status'=> $request->status]);

         return redirect()
                ->route('orders.index')
                ->with('success', 'Status Update'); // flash message
    }

    public function destroy(Order $order)
    {
        $order->delete();

          //PRG  post redirect get
       return redirect()
            ->route('orders.index')
            ->with('success', 'Order Deleted'); // flash message
    }

    public function trash()   // هيرجع العناصر المحذوفة فقط
    {
        return view('admin.orders.trash', [
            'orders' => Order::onlyTrashed()->paginate(),
        ]);
    }
    public function restore($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        $order->restore();
        return redirect()
            ->route('orders.trash')
            ->with('success', 'Category restored');
    }

    public function forceDelete($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        $order->forceDelete();
        return redirect()
            ->route('orders.trash')
            ->with('success', 'Category deleted forever.');
    }
}

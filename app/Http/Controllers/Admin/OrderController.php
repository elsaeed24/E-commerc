<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use ArPHP\I18N\Arabic;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $request->validate([
            'status' => 'in:new,processing,in-delivery,completed'
        ]);

        $order = Order::findOrFail($id);

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

    public function print(Order $order)
    {
        $ar = new Arabic();
        $pdf = PDF::loadView('admin.orders.invoice', [
            'order' => $order,
            'ar' => $ar,
        ]);

        return $pdf->stream();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::latest()->paginate();
        return view('admin.coupons.index',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupons.create',[
            'coupon' => new Coupon(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:coupons,code',
            'discount' => 'required|numeric',
            'type' => 'required|in:fixed,percent'
        ]);

         Coupon::create($request->all());

           //PRG  post redirect get
           return redirect()
           ->route('coupons.index')
            ->with('success', 'Discount Coupon Created'); // flash message

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);

        return view('admin.coupons.edit', [
            'coupon' => $coupon,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $id = $coupon->id;

        $request->validate([
            'name' => 'required|string',
            'code' => 'required','string', Rule::unique('coupons','code')->ignore($id),
            'discount' => 'required|numeric',
            'type' => 'required|in:fixed,percent'
        ]);

        $coupon->update($request->all());

          //PRG  post redirect get
       return redirect()
       ->route('coupons.index')
       ->with('success', 'Discount Coupon Updated'); // flash message
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {

        $coupon->delete();

          //PRG  post redirect get
       return redirect()
       ->route('coupons.index')
       ->with('success', ' Discount Coupon Deleted'); // flash message
    }

    }


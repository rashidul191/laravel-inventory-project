<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // show customer page
    public function customerPage()
    {
        return view('pages.dashboard.customer-page');
    }

    // get all customer
    public function customerList()
    {
        $result = Customer::orderBy('created_at', 'desc')->get();

        if ($result) {
            return response()->json([
                'status' => 'success',
                'message' => "Successfully get customer data",
                'data' => $result,
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => "something went wrang!!",
            ], 401);
        }
    }

    // Create Customer
    public function customerCreate(Request $request)
    {
        $user_id = $request->header('userId');
        $customerName = $request->input('name');
        $customerEmail = $request->input('email');
        $customerMobile = $request->input('mobile');
        return  Customer::create([
            'name' => $customerName,
            'email' => $customerEmail,
            'mobile' => $customerMobile,
            'user_id' =>  $user_id
        ]);
    }
}

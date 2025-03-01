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
    public function customerList(Request $request)
    {
        $user_id = $request->header('userId');
        $result = Customer::where('user_id', '=', $user_id)->orderBy('created_at', 'desc')->get();

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

    // Delete Customer id

    public function customerDelete(Request $request, $id)
    {
        $user_id = $request->header('userId');
        return Customer::where('id', $id)->where('user_id', $user_id)->delete();
    }
}

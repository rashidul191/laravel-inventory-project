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
        $result = Customer::all();
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
}

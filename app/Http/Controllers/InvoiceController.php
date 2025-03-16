<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    // get invoice page

    public function invoicePage()
    {
        return view('pages.dashboard.invoice-page');
    }

    public function salePage()
    {
        return view('pages.dashboard.sale-page');
    }
    public function invoiceCreate(Request $request)
    {

        // jokhon same time a 2er odhik data table a data insert kora hoi tokhon jeno sokol table data dula inser hoi er jonno DB::beginTransaction();, DB::commit(); user kora hoi. r jokhon kono korone data kono 1 table data insert na hoi tahle DB::rollBack(); user kora hoi jeno ai method/operation again suru theke start hoi. tahole data mace miss hobe na.
        DB::beginTransaction();
        try {
            $user_id = $request->header('id');
            $total = $request->input('total');
            $discount = $request->input('discount');
            $vat = $request->input('vat');
            $payable = $request->input('payable');

            $customer_id = $request->input('customer_id');

            $invoice = Invoice::create([
                "total" => $total,
                "discount" => $discount,
                "vat" => $vat,
                "payable" => $payable,
                "user_id" => $user_id,
                "customer_id" => $customer_id,

            ]);

            $invoiceId =  $invoice->id;
            $products  = $request->input('products');

            foreach ($products as $product) {
                InvoiceProduct::create([
                    'invoice_id' => $invoiceId,
                    'user_id' => $user_id,
                    'product_id' => $product['product_id'],
                    'qty' => $product['qty'],
                    'sale_price' => $product['sale_price'],
                ]);
            }
            DB::commit();

            return 1;
        } catch (Exception $e) {
            DB::rollBack();
            return 0;
        }
    }
    public function invoiceSelect(Request $request)
    {
        $user_id = $request->header('id');
        return Invoice::where('user_id', '=', $user_id)->with('customer')->get();
    }
    public function invoiceDetails(Request $request)
    {
        $user_id = $request->header('id');
        $customer_id = $request->input('cus_id');
        $invoice_id = $request->input('inv_id');

        $customerDetails = Customer::where('user_id', "=", $user_id)->where('id', "=", $customer_id)->first();
        $invoiceTotal = Invoice::where('user_id', "=", $user_id)->where('id', "=", $invoice_id)->first();
        $invoiceProduct = InvoiceProduct::where('invoice_id', "=", $invoice_id)->where('user_id', "=", $user_id)->first();

        return [
            'customer' => $customerDetails,
            'invoice' => $invoiceTotal,
            'product' => $invoiceProduct,
        ];
    }
    public function invoiceDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id = $request->header('id');
            $invoice_id = $request->input('inv_id');

            InvoiceProduct::where('invoice_id', "=", $invoice_id)->where('user_id', "=", $user_id)->delete();

            Invoice::where('id', "=", $invoice_id)->delete();
            DB::commit();

            return 1;
        } catch (Exception $e) {
            DB::rollBack();
            return 0;
        }
    }
}

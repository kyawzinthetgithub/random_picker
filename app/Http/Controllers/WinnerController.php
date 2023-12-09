<?php

namespace App\Http\Controllers;

use App\Exports\WinnersExport;
use App\Models\Title;
use App\Models\Winner;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;


class WinnerController extends Controller
{
    //direct to winner picker page

    public function goPickWinner()
    {
        $winners = Winner::all();
        $customers = Customer::all();
        $products = Product::all();
        $title = Title::get()->last();
        return view("pick", compact("winners", "title", "customers", "products"));
    }



    //direct winner list page
    public function goWinnerList()
    {
        $title = Title::get()->last();
        $customers = Customer::all();
        $products = Product::all();
        $winners = Winner::orderBy('created_at','desc')->get();

        return view("winnerList", compact("winners", "title", "products", "customers"));
    }


    public function uploadWinner(Request $request)
    {
        $cus_id = $request->cus_id;
        $prod_id = $request->prod_id;
        $customer = Customer::find($cus_id);

        $customer_name = $customer->name;
        $customer_phone = $customer->phone;
        $customer_address = $customer->address;

        $product = Product::find($prod_id);
        $product_name = $product->name;
        $product_description = $product->description;

        $winner = new Winner();
        $winner->customer_name = $customer_name;
        $winner->customer_phone = $customer_phone;
        $winner->customer_address = $customer_address;
        $winner->product_name = $product_name;
        $winner->product_details = $product_description;
        $winner->save();

        $customer->delete();
        $product->delete();

        return redirect()->back()->with("success", "Winner List Update Successfully");

    }

    public function exportWinnerList()
    {
        return Excel::download(new WinnersExport, 'winners.xlsx');
    }

    public function clearWinnerTable()
    {
        $winner = Winner::all();

        if (is_null($winner)) {
            return redirect()->back()->with('error', 'No Data to delete');
        } else {
            Winner::truncate();
            return redirect()->back()->with('success', 'Winner Table Clear Successfully');
        }
    }
}

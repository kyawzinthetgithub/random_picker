<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Title;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller {
    //direct to excel upload page
    public function getCustomer() {
        $customers = Customer::all()->toArray();
        $products = Product::all()->toArray();
        $response = [
            'customer' => $customers,
            'product' => $products
        ];
        return response()->json($response);
    }
    public function goUploadPage() {
        $title = Title::get()->last();
        $products = Product::all();
        $customers = Customer::all();
        return view("upload", compact("customers", "products", 'title'));
    }

    public function store(Request $request) {
        $customers = Customer::all();

        $this->checkCustomerUploadValidation($request);

        $customerFile = $request->file("CustomerUpload");
        if(is_null($customers)) {
            Excel::import(new CustomersImport, $customerFile);
            return redirect()->back()->with("success", "Customers upload Successfully");
        } else {
            Customer::truncate();
            Excel::import(new CustomersImport, $customerFile);
            return redirect()->back()->with("success", "Customers upload Successfully");

        }
    }

    public function storeProduct(Request $request) {
        $products = Product::all();
        $productFile = $request->file("ProductUpload");

        $this->checkProductUploadValidation($request);

        if(is_null($productFile)) {
            Excel::import(new ProductsImport, $productFile);
            return redirect()->back()->with("success", "Products upload Successfully");
        } else {
            Product::truncate();
            Excel::import(new ProductsImport, $productFile);
            return redirect()->back()->with("success", "Products upload Successfully");
        }
    }

    private function checkProductUploadValidation(Request $request) {
        Validator::make($request->all(), [
            'ProductUpload' => 'required',
        ])->validate();
    }

    private function checkCustomerUploadValidation(Request $request) {
        Validator::make($request->all(), [
            'CustomerUpload' => 'required',
        ])->validate();
    }


}

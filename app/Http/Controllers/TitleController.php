<?php

namespace App\Http\Controllers;

use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TitleController extends Controller
{
    //upload title
    public function uploadTitle(Request $request)
    {
        $getTitle = Title::all();
        $this->checkTitleValidate($request);
        if ($getTitle->count() > 0) {
            Title::truncate();
            Title::create([
                "title" => $request->EventTitle,
            ]);
            return redirect()->route('Upload');
        } else {
            Title::create([
                "title" => $request->EventTitle,
            ]);
            return redirect()->route('Upload');
        }
    }

    private function checkTitleValidate(Request $request)
    {
        Validator::make($request->all(), [
            "EventTitle" => "required",
        ])->validate();
    }
}

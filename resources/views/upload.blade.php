@extends('layout.master')

@section('content')
    <div>
        <div class="mainHeaders  py-5 bg-white">
            <h1 class="text-5xl font-extrabold">{{ $title->title }}</h1>
        </div>
        @if ($customers->count() > 0 && $products->count() > 0)
            <div class="flex justify-end me-3">
                <a href="{{ route('PickWinner') }}" class="w-fit">
                    <button
                        class="w-[30px] h-[30px] rounded-full TwoColorBtn uppercase text-lg tracking-wider text-slate-500"><i
                            class="fa-regular fa-circle-right"></i></button>
                </a>
            </div>
        @endif
    </div>

    <div class="flex justify-center gap-40 items-starts relative pt-10">
        <div class="w-fit max-h-[780px] mx-5 rounded-xl inside_box p-10">
            <form action="{{ route('uploadCustomer') }}" method="post" enctype="multipart/form-data">
                @csrf
                <h1 class="text-center text-white text-[20px] mt-3">Upload Participant File</h1>
                <div class="inputField gap-3 mt-10 border border-[#490e0e] w-full rounded-xl border-dashed p-5">
                    <input type="file" name="CustomerUpload" id="CustomerUpload" class="w-full cursor-pointer">

                </div>
                @error('CustomerUpload')
                    <div class="text-sm text-[#f84747]">{{ $message }}</div>
                @enderror
                <div class="grid mt-5">
                    <button type="submit" class="bg-white py-2 rounded-full">
                        <i class="fa-solid fa-cloud-arrow-up me-5"></i>Upload
                    </button>
                </div>
            </form>
            @if (count($customers) > 0)
                <div class="CusTable mt-5 overflow-y-scroll max-h-[30vh] p-4 table_box">
                    <table id="CusTB" class="display">

                        <thead>

                            <tr>
                                <th class="">Name</th>
                                <th>Phone</th>
                                <th class="">Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td class="">{{ $customer->name }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td class="">{{ $customer->address }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="w-fit max mx-5 rounded-xl inside_box p-10">
            <form action="{{ route('uploadProduct') }}" method="post" enctype="multipart/form-data">
                @csrf
                <h1 class="text-center text-white text-[20px] mt-3">Upload Gifts File</h1>
                <div class="inputField gap-3 mt-10 border border-[#490e0e] w-full rounded-xl border-dashed p-5">
                    <input type="file" name="ProductUpload" id="ProductUpload" class="w-full cursor-pointer">
                </div>
                @error('ProductUpload')
                    <div class="text-sm text-[#f84747]">{{ $message }}</div>
                @enderror
                <div class="grid mt-5">
                    <button type="submit" class="bg-white py-2 rounded-full">
                        <i class="fa-solid fa-cloud-arrow-up me-5"></i>Upload
                    </button>
                </div>
            </form>
            @if (count($products) > 0)
                <div class="CusTable mt-5 overflow-y-scroll max-h-[30vh] p-4 table_box">
                    <table id="productTB" class="display">

                        <thead>
                            <tr>
                                <th class="">Name</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td class="">{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            @endif
        </div>
    </div>
@endsection

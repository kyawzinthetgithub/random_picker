@extends('layout.master')

@section('content')
    <canvas id="canvas" class="absolute z-[-1]"></canvas>
    <div>
        <div class="mainHeaders  py-5 bg-white">
            <h1 class="text-5xl font-extrabold">{{ $title->title }}</h1>
        </div>
        <div class="flex justify-between items-center">
            <a href="{{ route('Upload') }}" class="flex justify-end mx-5">
                <button class="w-[30px] h-[30px] rounded-full TwoColorBtn uppercase text-lg tracking-wider text-slate-500"><i
                        class="fa-regular fa-circle-left"></i></button>
            </a>

            <a href="{{ route('goWinnerList') }}" class="flex justify-end mx-5">
                <button
                    class="w-[30px] h-[30px] rounded-full TwoColorBtn uppercase text-lg tracking-wider text-slate-500"><i
                        class="fa-regular fa-circle-right"></i></button>
            </a>
        </div>
    </div>
    <div class="flex justify-center items-center py-12">
        <div>
            @if ($customers->count() > 0 && $products->count() > 0)
            <div id="sm" class="inside_box relative">
                <div class="group">

                    <div class="reel"></div>
                    <div class="reel"></div>

                </div>

            </div>
            @endif

            <div class="group lever">
                <button id="startSlot">Start</button>
            </div>

            <!-- hidden input tag for removing winner from the list and to save in the winning list  -->
            <input type="text" name="cus_id" id="cus_id" class="outline-none shadow-none border-none bg-transparent"
                readonly hidden>
            <input type="text" name="prod_id" id="prod_id" class="outline-none shadow-none border-none bg-transparent"
                readonly hidden>

        </div>


    </div>
@endsection

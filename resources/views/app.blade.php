@extends('layout.master')

@section('content')
    <div class="">
        <div>
            <div class="mainHeaders py-3 bg-[#f1ebeb]">
                <h1 class="text-4xl font-extrabold">Winner Picker</h1>
            </div>
        </div>
        <div class="flex justify-center items-center h-[80vh]">
            <div
                class="p-5 bg-slate-700 text-white text-center hover:p-8 transition-[padding] ease-in-out duration-500 rounded-lg inside_box">
                <h3 class="text-2xl my-12 font-extrabold">Welcome from Random Winner Picker</h3>

                @if (!is_null($titles))
                    <form action="{{ route('uploadTitle') }}" method="POST">
                        @csrf
                        <div class="input-group my-8">
                            <input type="text" name="EventTitle" id="EventTitle" value="{{ $titles->title }}"
                                class="w-full text-slate-500 p-2 border-none rounded-xl outline-none "
                                placeholder="Enter Event Name...">

                            @error('EventTitle')
                                class="text-start">{{ $message }}
                            </div>
                        @enderror
            </div>

            <button type="submit" class="border border-[#490e0e] px-3 py-2 my-5 rounded-full">Update Title</button>
            </form>
        @else
            <form action="{{ route('uploadTitle') }}" method="POST">
                @csrf
                <div class="input-group my-8">
                    <input type="text" name="EventTitle" id="EventTitle"
                        class="w-full text-slate-500 p-2 border-none rounded-xl outline-none "
                        placeholder="Enter Event Name...">

                    @error('EventTitle')
                        <div class="text-start">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="border border-[#490e0e] px-3 py-2 my-5 rounded-full">Create Title</button>
            </form>
            @endif
        </div>
    </div>
    </div>
@endsection

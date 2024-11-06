<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('admin/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/hotel.css') }}">
@endsection

<!-- main containts -->
@section('main_contents')
    <div class="page-wrapper search-page-wrapper" id="create-hotel">
        <h2 class="title">Hotel edit</h2>
        <hr>

        <div class="search-hotel-name">
            <form action="{{ route('adminHotelEditSubmit', ['id' => $entity->hotel_id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')
                @include('admin.include.error-validate')
                @include('admin.include.notification')

                <label for="fname">Name *</label>
                <input type="text" id="fname" name="hotel_name" placeholder="Your name.." value="{{ getInputOld(old('hotel_name', session('params.hotel_name')), $entity->hotel_name) }}">

                <label for="prefecture">Prefecture *</label>
                <select id="prefecture" name="prefecture_id">
                    <option value="">--- 選択してください --</option>
                    @foreach($listPrefecture as $item)
                        <option value="{{ $item->prefecture_id }}" {{ getInputOld(old('prefecture_id', session('params.prefecture_id')), $entity->prefecture_id) == $item->prefecture_id ? "selected" : "" }}>{{ $item->prefecture_name_alpha }}</option>
                    @endforeach
                </select>

                <label for="prefecture">File</label>
                <input type="file" id="imgInp" name="file_path" accept="image/*"> <br>
                @if ($entity->file_path)
                    <img id="blah" width="100px" src="{{ asset('assets/img/' . $entity->file_path) }}"/>
                @else
                    <img id="blah" width="100px"/>
                @endif


                <input type="submit" value="提出する">
            </form>
        </div>
    </div>
    @yield('search_results')
@endsection

@section('page_js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function(){
            readURL(this);
        });
    </script>
@endsection

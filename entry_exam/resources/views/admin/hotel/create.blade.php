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
        <h2 class="title">Hotel create</h2>
        <hr>

        <div class="search-hotel-name">
            <form action="{{ route('adminHotelCreateSubmit') }}" method="post">
                @csrf
                @method('POST')
                @include('admin.include.error-validate')
                @include('admin.include.notification')

                <label for="fname">Name *</label>
                <input type="text" id="fname" name="hotel_name" placeholder="Your name.." value="{{ old('hotel_name', session('params.hotel_name')) }}">

                <label for="prefecture">Prefecture *</label>
                <select id="prefecture" name="prefecture_id">
                    <option value="">--- 選択してください --</option>
                    @foreach($listPrefecture as $item)
                        <option value="{{ $item->prefecture_id }}" {{ old('prefecture_id', session('params.prefecture_id')) == $item->prefecture_id ? "selected" : "" }}>{{ $item->prefecture_name_alpha }}</option>
                    @endforeach
                </select>

                <input type="submit" value="提出する">
            </form>
        </div>
    </div>
    @yield('search_results')
@endsection

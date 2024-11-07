<!-- base view -->
@extends('common.user.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/user/home.scss')
@endsection

<!-- main contents -->
@section('main_contents')
    <header class="g-header">
        <a href="{{ route('top') }}">THK VN HANOI TRAVEL</a>
    </header>
    <div class="container">
        <div class="prefecture_container">
            <p class="text">お探しのエリアを選択ください</p>
            <div class="area_container">
                <div class="side-wrapper" style="width: 100%">
                    @foreach($listPrefecture as $item)
                        <a href="{{ route('hotelList', ['prefecture_name_alpha' => $item->prefecture_name_alpha ]) }}" class="pref">{{ $item->prefecture_name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

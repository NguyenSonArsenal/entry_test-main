<!-- base view -->
@extends('common.user.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/user/hotellist.scss')
@endsection

<!-- main contents -->
@section('main_contents')
    <header class="g-header">
        <a href="{{ route('top') }}">THK VN HANOI TRAVEL</a>
    </header>
    <div class="container">
        <div class="hotellist_container">
            Prefecture: {{ $prefecture->prefecture_name_alpha }}
            @foreach ($hotels as $hotel)
                <a href="{{ route('hotelDetail', ['hotel_id' => $hotel->hotel_id]) }}" class="hotel_link">
                    <div class="hotellist_wrapper">
                        <div class="left_wrapper">
                            @if ($hotel->file_path)
                                <img src="{{ asset('assets/img/' . $hotel->file_path) }}" alt="{{ $hotel->hotel_name }}">
                            @else
                                <img src="{{ asset('assets/img/default.avif') }}">
                            @endif
                        </div>
                        <div class="right_wrapper">
                            <p class="hotel_title">{{ $hotel->hotel_name }}</p>
                            <p class="hotel_information">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam esse beatae dolor, et facere animi distinctio facilis laboriosam obcaecati expedita minus voluptatibus aut amet, commodi quos aliquid vitae! Consequuntur, autem!
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection

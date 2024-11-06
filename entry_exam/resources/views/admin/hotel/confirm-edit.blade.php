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
        <h2 class="title">Hotel edit - confirm</h2>
        <hr>

        <div class="search-hotel-name">
            <div>入力した情報をもう一度ご確認ください</div>
            <div class="form-group row">
                <p><b>Hotel name:</b> {{ data_get($params, 'hotel_name') }}</p>
            </div>
            <div class="form-group row">
                <p><b>Prefecture:</b> {{ data_get($params, 'prefecture_name') }}</p>
            </div>

            <div class="form-group row">
                <p>
                    <b>File path:</b>
                    @if (session('params_edit.file_path'))
                        <img src="{{ asset('tmp/' . session('params_edit.file_path')) }}" alt="Uploaded Image" width="100px">
                    @elseif ($entity->file_path)
                        <img src="{{ asset('assets/img/' . $entity->file_path) }}" alt="Uploaded Image" width="100px">
                    @endif
                </p>
            </div>

            <div style="display: flex">
                <form action="{{ route('adminHotelBackFromEditConfirm') }}" method="GET">
                    @csrf
                    @method('GET')
                    <button><- 戻る</button>
                </form>
                <form action="{{ route('adminHotelEditStore', ['id' => session('params_edit.hotel_id')]) }}" method="POST">
                    @csrf
                    @method('POST')
                    <button>提出する -></button>
                </form>
            </div>
        </div>
    </div>
    @yield('search_results')
@endsection

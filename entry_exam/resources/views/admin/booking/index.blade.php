<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')

    <link rel="stylesheet" href="{{ asset('admin/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/search.css') }}">
@endsection

<!-- main containts -->
@section('main_contents')
    <div class="page-wrapper search-page-wrapper">
        <h2 class="title">Booking index</h2>
        <hr>
        <div class="search-hotel-name">
            <form action="{{ route('admin.booking.index') }}" method="get" style="margin-bottom: 15px" id="form-search">
                <input type="text" name="hotel_name" value="{{ request('hotel_name') }}" placeholder="ホテル名">
                <input type="text" name="customer_name" value="{{ request('customer_name') }}" placeholder="顧客名">
                <button type="button" id="btn-search">検索</button>
            </form>

            <p id="warningMessage" style="color: red; display: none;">何も入力されていません</p>

            @include('admin.include.notification')

            @if ($data->isEmpty())
                <p>空の</p>
            @else
                <table>
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Hotel name</th>
                        <th>Customer name</th>
                        <th>Customer info</th>
                        <th>Checkin time</th>
                        <th>Checkout time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ getSTT($data, $key) }}</td>
                            <td>{{ !empty($item->hotel) ? $item->hotel->hotel_name : "" }}</td>
                            <td>{{ $item->customer_name }}</td>
                            <td width="50%">{{ $item->customer_contact }}</td>
                            <td>{{ date('d-m-Y H:i:s', strtotime($item->checkin_time)) }}</td>
                            <td>{{ date('d-m-Y H:i:s', strtotime($item->checkout_time)) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $data->appends(request()->all())->links('pagination::bootstrap-4') }}
            @endif
        </div>
        <hr>
    </div>
    @yield('search_results')
@endsection

@section('page_js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $( document ).ready(function() {
            $('#btn-search').click(function () {
                const hotel_name = $("input[name='hotel_name']").val();
                const customer_name = $("input[name='customer_name']").val();
                if (customer_name === '' && hotel_name == '') {
                    $('#warningMessage').show();
                } else {
                    $('#warningMessage').hide();
                    $('#form-search').submit();
                }
            })
        });
    </script>
@endsection

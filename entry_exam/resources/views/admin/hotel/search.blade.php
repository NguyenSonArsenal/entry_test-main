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
        <h2 class="title">検索画面</h2>
        <hr>
        <div class="search-hotel-name">
            <form action="{{ route('adminHotelSearchPage') }}" method="get" style="margin-bottom: 15px" id="form-search">
                <input type="text" name="hotel_name" value="{{ request('hotel_name') }}" placeholder="ホテル名">
                <select id="prefecture" name="prefecture_id">
                    <option value="">--- 選択してください --</option>
                    @foreach($listPrefecture as $item)
                        <option value="{{ $item->prefecture_id }}" {{ request('prefecture_id') == $item->prefecture_id ? "selected" : "" }}>{{ $item->prefecture_name_alpha }}</option>
                    @endforeach
                </select>

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
                        <th>Name</th>
                        <th>Prefecture</th>
                        <th>File</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ getSTT($data, $key) }}</td>
                            <td>{{ $item->hotel_name }}</td>
                            <td>{{ !empty($item->prefecture) ? $item->prefecture->prefecture_name_alpha : '' }}</td>
                            <td>
                                <a target="_blank" href="{{ asset('assets/img/' . $item->file_path) }}">
                                    <img width="50px" src="{{ asset('assets/img/' . $item->file_path) }}" alt="">
                                </a>
                            </td>
                            <td>{{ $item->created_at->format('d-m-Y H:i:s') }}</td>
                            <td>
                                <div class="comment-footer">
                                    <a href="{{ route('adminHotelEditPage', ['id' => $item->hotel_id]) }}"><button>Sửa</button></a>
                                    <form action="{{ route('adminHotelDeleteProcess', $item->hotel_id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" onclick="return confirmDelete(event)">Xóa</button>
                                    </form>
                                </div>
                            </td>
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
        // Hàm xác nhận trước khi xóa
        function confirmDelete(event) {
            if (!confirm("ホテル情報を削除したい場合 ?")) {
                event.preventDefault();
            }
        }

        $( document ).ready(function() {
            $('#btn-search').click(function () {
                const hotel_name = $("input[name='hotel_name']").val();
                const prefecture_id = $("select[name='prefecture_id']").val();
                if (hotel_name === '' && prefecture_id == '') {
                    $('#warningMessage').show();
                } else {
                    $('#warningMessage').hide();
                    $('#form-search').submit();
                }
            })
        });
    </script>
@endsection

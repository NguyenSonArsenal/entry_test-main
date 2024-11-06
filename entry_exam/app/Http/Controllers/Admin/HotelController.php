<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prefecture;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Models\Hotel;
use Illuminate\Support\Facades\File;

class HotelController extends Controller
{
    public $uploadFile;

    public function __construct(UploadFile $uploadFile)
    {
        $this->uploadFile = $uploadFile;
    }

    /** get methods */
    public function showSearch(): View
    {
        session()->forget('params');
        $listPrefecture = Prefecture::all();
        $query = Hotel::query();

        if (request('hotel_name')) {
            $query->where('hotel_name', 'like', '%' . request('hotel_name') . '%');
        }
        if (request('prefecture_id')) {
            $query->where('prefecture_id', request('prefecture_id'));
        }

        $data = $query->orderBy('hotel_id', 'desc')->paginate(getAdminPagination());

        $viewData = [
            'data' => $data,
            'listPrefecture' => $listPrefecture,
        ];

        return view('admin.hotel.search', $viewData);
    }

    public function showResult(): View
    {
        return view('admin.hotel.result');
    }

    /** ========== CREATE HOTEL FUNCTION ========== */
    public function showCreate(): View
    {
        $listPrefecture = Prefecture::all();
        $viewData = [
            'listPrefecture' => $listPrefecture,
        ];

        return view('admin.hotel.create', $viewData);
    }

    public function postHotelCreateSubmit(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'hotel_name' => 'required|max:255|unique:hotels',
                'prefecture_id' => 'required'
            ],[
                'hotel_name.required' => 'Hotel name is required',
                'hotel_name.unique' => 'Hotel name is exits',
                'hotel_name.max' => 'Hotel name max 255 charactor',
                'prefecture_id.required' => 'Prefecture is required',
            ]);

            session(['params' => $validatedData]);

            return redirect()->to(route('adminHotelCreateConfirm'));
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        }
    }

    public function showHotelCreateConfirm()
    {
        $params = session('params');
        if (empty($params)) {
            return redirect()->to(route('adminHotelCreatePage'));

        }
        $prefecture = Prefecture::where('prefecture_id', data_get($params, 'prefecture_id'))->first();
        if (empty($prefecture)) {
            return redirect()->to(route('adminHotelCreatePage'))->with('notification_error', 'System error');
        }
        $params['prefecture_name'] = $prefecture->prefecture_name;
        return view('admin.hotel.confirm', ['params' => $params]);
    }

    public function postHotelCreateStore()
    {
        $postData = session('params');
        Hotel::create($postData);
        session()->forget('params');
        return redirect()->route('adminHotelSearchPage')->with('success', '成功');
    }

    public function adminHotelBackFromConfirm()
    {
        $postData = session('params');
        return redirect()->route('adminHotelCreatePage')->with('params', $postData);
    }
    /** ========== END CREATE HOTEL FUNCTION ========== */


    /** ========== EDIT HOTEL FUNCTION ========== */
    public function showEdit($id)
    {
        $listPrefecture = Prefecture::all();
        $entity = Hotel::where('hotel_id', $id)->first();
        if (empty($entity)) {
            return redirect()->to(route('adminHotelSearchPage'));
        }

        $viewData = [
            'listPrefecture' => $listPrefecture,
            'entity' => $entity,
        ];

        return view('admin.hotel.edit', $viewData);
    }

    public function postHotelEditSubmit($id, Request $request)
    {
        try {
            $entity = Hotel::where('hotel_id', $id)->first();
            $validatedData = $request->validate([
                'hotel_name' => 'required|max:255|unique:hotels,hotel_name,' . $entity->hotel_id . ',hotel_id',
                'prefecture_id' => 'required',
                'file_path' => 'bail|nullable|mimes:jpeg,jpg,png,gif', // 100KB, 1024kb = 1 MB
            ],[
                'hotel_name.required' => 'Hotel name is required',
                'hotel_name.unique' => 'Hotel name is exits',
                'hotel_name.max' => 'Hotel name max 255 charactor',
                'prefecture_id.required' => 'Prefecture is required',
                'file_path.mimes' => 'file_path only file image type',
            ]);

            if ($request->hasFile('file_path')) {
                $file = $request->file('file_path');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();

                // Lưu file vào thư mục tạm trong storage/tmp
                $path = $file->move(public_path('tmp'), $filename);

                // Lưu đường dẫn của file vào session để dùng sau
                $validatedData['file_path'] =  $filename;
            }

            $validatedData['hotel_id'] = $entity->hotel_id;
            session(['params_edit' => $validatedData]);

            return redirect()->to(route('adminHotelEditConfirm', ['id' => $id]));
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        }
    }

    public function showHotelEditConfirm()
    {
        $params = session('params_edit');
        if (empty($params)) {
            return redirect()->to(route('adminHotelSearchPage'));

        }
        $prefecture = Prefecture::where('prefecture_id', data_get($params, 'prefecture_id'))->first();
        if (empty($prefecture)) {
            return redirect()->to(route('adminHotelCreatePage'))->with('notification_error', 'System error');
        }
        $params['prefecture_name'] = $prefecture->prefecture_name;
        $entity = Hotel::where('hotel_id', $params['hotel_id'])->first();

        $viewData = [
            'params' => $params,
            'entity' => $entity,
        ];
        return view('admin.hotel.confirm-edit', $viewData);
    }

    public function adminHotelBackFromEditConfirm()
    {
        $postData = session('params_edit');
        return redirect()->route('adminHotelEditPage', ['id' => data_get($postData, 'hotel_id')])->with('params', $postData);
    }

    public function postHotelEditStore()
    {
        $postData = session('params_edit');
        $entity = Hotel::where('hotel_id', data_get($postData, 'hotel_id'))->first();
        $hasUpload = false;
        $filePathOrigin = $entity->file_path;

        if (!empty($postData['file_path'])) {
            $filename = $postData['file_path'];
            $tmpPath = public_path('tmp/' . $filename);            // Đường dẫn file trong tmp
            $uploadPath = public_path('assets/img/hotel/' . $filename);      // Đường dẫn đến upload
            File::move($tmpPath, $uploadPath);
            File::cleanDirectory($tmpPath);
            $postData['file_path'] = 'hotel/' . $filename;
            $hasUpload = true;
        }
        $entity->update($postData);
        session()->forget('params_edit');
        if ($hasUpload) {
            $oldImage = public_path('assets/img/' . $filePathOrigin);
            if (File::exists($oldImage)) {
                File::delete($oldImage);
            }
        }
        return redirect()->route('adminHotelSearchPage')->with('success', '成功');
    }

    /** ========== END EDIT HOTEL FUNCTION ========== */


    public function searchResult(Request $request): View
    {
        $var = [];

        $hotelNameToSearch = $request->input('hotel_name');
        $hotelList = Hotel::getHotelListByName($hotelNameToSearch);

        $var['hotelList'] = $hotelList;

        return view('admin.hotel.result', $var);
    }

    public function delete($id)
    {
        try {
            $entity = Hotel::where('hotel_id', $id)->first();
            if (empty($entity)) {
                return redirect()->back()->with('notification_error', 'Not found');
            }
            $entity->delete();
            return redirect()->back()->with('success', 'Delete success');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->with('notification_error', 'System error');
        }
    }
}

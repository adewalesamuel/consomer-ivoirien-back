<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreFileUploadRequest;

class FileUploadController extends Controller
{
    public function store(StoreFileUploadRequest $request) {
        if ($request->hasFile('img')) {
            $img_url =  str_replace('public', 'storage', $request->img->store('storage', 'public'));
            $data = [
                'success' => true,
                'img_url' => $img_url
            ];
            return response()->json($data);
        }

    }
}

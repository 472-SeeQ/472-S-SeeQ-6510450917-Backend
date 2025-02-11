<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function show(Request $request, string $image) {
        $image = str_replace( '+', '/', $image);
        return response(Storage::disk('s3')->get($image))
            ->header('Content-Type', 'image/png');
    }
}

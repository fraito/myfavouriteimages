<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function images()
    {
        $user = auth()->user();

        $images = $user->images;

        return response()->json($images);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createImage()
    {
        $user = auth()->user();

        $image = Image::create([
            'user_id' => $user_id,
            'title' => request('title'),
            'image'=> request('image'),
        ]);

        $image->save();

        return response()->json(['message' => 'Image successfully created', 'image' => $image], 201);
    }

    /**
     * Display the specified resource.
     */
    public function showImage(string $id)
    {
        $user = auth()->user();

        $image = Image::find($id);

        if ($user->id !== $image->user_id) {
            return response()->json(['message' =>'Not allowed to view this image'], 403);
        }

        return response()->json($image);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateImage(Request $request, string $id)
    {
        $user = auth()->user();

        $image = Image::find($id);

        if ($user->id !== $image->user_id) {
            return response()->json(['message' =>'Not allowed to update this image'], 403);
        }

        $image->update([
            'title' => request('title'),
            'image'=> request('image'),
        ]);

        $image->save();

        return response()->json(['message' => 'Image successfully modified'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteImage(string $id)
    {
        $user = auth()->user();

        $image = Image::find($id);

        if ($user->id !== $image->user_id) {
            return response()->json(['message' =>'Not allowed to delete this image'], 403);
        }

        $image->delete();

        return response()->json(['message' => 'Image successfully deleted'], 200);
    }
}

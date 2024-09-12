<?php

namespace App\Http\Controllers;

use App\Models\Reel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ReelController extends Controller
{
    /**
     * Upload a new reel with an optional thumbnail.
     *
     * Validates the request, stores the video and thumbnail files, creates a new `Reel` record,
     * and returns a success message with the reel data.
     *
     * @param \Illuminate\Http\Request $request The request instance.
     * @return \Illuminate\Http\JsonResponse A JSON response with the reel data.
    */
    public function uploadReel(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'reel' => 'required|file|mimetypes:video/mp4,video/x-matroska|max:10240',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $reel = $request->file('reel');
        $reelPath = $reel->store('reels', 'public');

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailPath = $thumbnail->store('thumbnails', 'public');
        }

        $reel = Reel::create([
            'user_id' => Auth::id(),
            'title' => $request->input('title'),
            'reel_path' => $reelPath,
            'thumbnail_path' => $thumbnailPath,
        ]);

        return response()->json([
            'message' => 'Reel uploaded successfully',
            'reel' => $reel,
        ], 201);
    }

    /**
     * Retrieve a list of reels along with their associated user details.
     *
     * This function fetches all reels from the database, includes the associated user information,
     * and maps the reel and thumbnail paths to publicly accessible URLs using Laravel's storage system.
     * The reels are returned in the latest order.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing a list of reels with public URLs.
    */
    public function getReels()
    {
        $reels = Reel::with('user')->latest()->get()->map(function ($reel) {
            $reel->reel_path = Storage::disk('public')->url($reel->reel_path);
            $reel->thumbnail_path = $reel->thumbnail_path ? Storage::disk('public')->url($reel->thumbnail_path) : null;
            return $reel;
        });

        return response()->json($reels);
    }
}


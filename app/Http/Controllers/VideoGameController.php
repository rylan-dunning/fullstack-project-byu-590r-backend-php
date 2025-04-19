<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\VideoGame;
use App\Models\EsrbRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VideoGameController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = VideoGame::all();
        
        foreach ($games as $game) {
            if ($game->file) {
                $game->file_url = $this->getS3Url($game->file);            }
        }
        
        return $this->sendResponse($games, 'Video games retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year' => 'required|string|max:4',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'esrb_rating_id' => 'nullable|exists:esrb_ratings,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
            
            // Handle file upload to S3
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'images/' . $fileName;
            
            // Store file in S3
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            
            $input['file'] = $filePath;
        }
        
        $game = VideoGame::create($input);
        
        if ($game->file) {
            $game->file_url = $this->getS3Url($game->file);
        }

        $game->load('esrbRating');
        
        return $this->sendResponse($game, 'Video game created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $game = VideoGame::with('esrbRating')->find($id);
        
        if (is_null($game)) {
            return $this->sendError('Video game not found.');
        }
        
        if ($game->file) {
            $game->file_url = url('storage/' . $game->file);
        }
        
        return $this->sendResponse($game, 'Video game retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'year' => 'nullable|string|max:4',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'esrb_rating_id' => 'nullable|exists:esrb_ratings,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $game = VideoGame::find($id);
        
        if (is_null($game)) {
            return $this->sendError('Video game not found.');
        }
        
        $input = $request->all();
        
        // Handle file upload if present
        if ($request->hasFile('file')) {
            // Delete old file from S3 if it exists
            if ($game->file) {
                Storage::disk('s3')->delete($game->file);
            }
            
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'images/' . $fileName;
            
            // Store file in S3
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            
            $input['file'] = $filePath;
        }
        
        $game->update($input);
        
        if ($game->file) {
            $game->file_url = $this->getS3Url($game->file);
        }

        // Load the ESRB rating
        $game->load('esrbRating');
        
        return $this->sendResponse($game, 'Video game updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $game = VideoGame::find($id);
        
        if (is_null($game)) {
            return $this->sendError('Video game not found.');
        }
        
        // Delete file from S3 if it exists
        if ($game->file) {
            Storage::disk('s3')->delete($game->file);
        }
        
        $game->delete();
        
        return $this->sendResponse([], 'Video game deleted successfully.');
    }

    /**
     * Get all ESRB ratings.
     */
    public function ratings()
    {
        $ratings = EsrbRating::all();
        
        return $this->sendResponse($ratings, 'ESRB ratings retrieved successfully.');
    }
}

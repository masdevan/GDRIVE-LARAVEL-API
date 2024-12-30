<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GoogleDriveService;

class GoogleDriveController extends Controller
{
    protected $googleDriveService;

    public function __construct(GoogleDriveService $googleDriveService)
    {
        $this->googleDriveService = $googleDriveService;
    }

    public function index()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        try {
            $filePath = $request->file('file')->getRealPath();
            $fileName = $request->file('file')->getClientOriginalName();

            $result = $this->googleDriveService->uploadFile($filePath, $fileName);

            return redirect()->route('upload.form')->with([
                'success' => 'File uploaded successfully!',
                'viewLink' => $result['viewLink'],
                'downloadLink' => $result['downloadLink'],
            ]);
        } catch (\Exception $e) {
            return redirect()->route('upload.form')->with([
                'error' => 'Failed to upload file: ' . $e->getMessage(),
            ]);
        }
    }

    public function createFolder(Request $request, GoogleDriveService $googleDriveService)
    {
        $validatedData = $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);

        $folder = $googleDriveService->createFolder($validatedData['folder_name']);

        return back()->with('success', "Folder '{$folder['name']}' created successfully with ID: {$folder['id']}");
    }
}
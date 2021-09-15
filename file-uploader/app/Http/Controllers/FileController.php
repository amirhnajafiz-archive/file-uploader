<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Models\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response
     */
    public function index()
    {
        $live_files = File::all()->count();
        $dead_files = File::onlyTrashed()->count();

        return \response()
            ->json([
                'FILES_ON_SERVER' => $live_files + $dead_files,
                'ACTIVE_FILES' => $live_files,
                'RESPONSE' => 'true-result'
            ])
            ->header('Content-Type', 'application/json')
            ->header('x-header-one', 'OFFICIAL-FO');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return RedirectResponse
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('files.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFileRequest $request
     * @return JsonResponse|Response
     */
    public function store(StoreFileRequest $request)
    {
        $validated = $request->validated();

        $name = time() . "_" . $request->file('file')->getClientOriginalName();

        Storage::disk('public')->putFileAs('files/', $request->file('file'), $name);

        $file = File::query()->create([
            'title' => $validated['title'],
            'path' => $name
        ]);

        return \response()->json([
            'STATUS' => 'OK',
            'ID' => $file->id,
            'CREATED' => 'true'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return BinaryFileResponse|StreamedResponse
     */
    public function show($id)
    {
        $file = File::query()->findOrFail($id);
        $path = $file->path;

        return Storage::disk('public')->download('/files/' . $path);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return BinaryFileResponse
     */
    public function edit($id): BinaryFileResponse
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse|Response
     */
    public function destroy($id)
    {
        File::query()->findOrFail($id)->delete();
        return \response()->json([
            'STATUS' => 'OK',
            'FILE' => 'DELETE'
        ]);
    }

    /**
     * Force remove a file.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function force(Request $request, $id): JsonResponse
    {
        $file = File::onlyTrashed()->findOrFail($id);
        if ($request->has('_token')) {
            if ($request->get('_token') == '2298') {
                $path = $file->path;
                Storage::disk('public')->delete('/files/' . $path);
                $status = 'OK';
            } else {
                $status = 'WRONG_TOKEN';
            }
        } else {
            $status = 'NO_TOKEN';
        }

        return \response()->json([
            'RESPONSE' => $status
        ]);
    }
}

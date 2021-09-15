<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Models\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

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
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
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
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Force remove a file.
     *
     * @param Request $request
     * @param $id
     */
    public function force(Request $request, $id)
    {
        //
    }
}

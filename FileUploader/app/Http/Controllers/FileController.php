<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return \response()->json([
            'status' => 'OK'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        return \response()->json([
            'status' => 'OK'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        if ($request->file('file')) {
            $name = time() . $request->file('file')->getClientOriginalName();
            Storage::disk('public')->putFileAs('/file', $request->file('file'), $name);
            File::query()->create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'img' => 'link',
                'link' => $name,
                'user_id' => 1
            ]);
            $status = 'OK';
        } else {
            $status = 'FAIL';
        }

        return \response()->json([
            'status' => $status
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return \response()->json([
            'status' => 'OK'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        return \response()->json([
            'status' => 'OK'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        return \response()->json([
            'status' => 'OK'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {

        $file = File::query()->find($id);
        Storage::disk('public')->delete('/file/' . $file->link);
        $file->delete();
        return \response()->json([
            'status' => 'ok'
        ]);
    }
}

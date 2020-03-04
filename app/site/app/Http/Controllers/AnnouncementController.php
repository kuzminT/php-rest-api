<?php

namespace App\Http\Controllers;

use App\Announcement as Ann;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        return Ann::all();
    }

    public function show(Ann $ann)
    {
        return $ann;
    }

    public function store(Request $request)
    {
        $ann = Ann::create($request->all());
        return response()->json($ann, 201);
    }

    public function update(Request $request, Ann $ann)
    {
        $ann->update($request->all());

        return response()->json($ann, 200);
    }

    public function delete(Request $request, Ann $ann)
    {
        $ann->delete();

        return response()->json(null, 204);
    }
}

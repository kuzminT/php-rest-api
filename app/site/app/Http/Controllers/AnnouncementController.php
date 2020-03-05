<?php

namespace App\Http\Controllers;

use App\Announcement as Ann;
use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    public function index()
    {

        return DB::table('announcements as a')->leftJoin('photos as p',
            function ($join) {
                $join->on('a.id', '=', 'p.announcement_id')->on('p.created_at', '=',
                    DB::raw('(select min(created_at) from photos where announcement_id = p.announcement_id)'));
            })->select('a.id', 'a.title', 'a.price', 'p.url')->paginate(10);
    }

    public function show(int $ann_id)
    {
        $ann = DB::table('announcements as a')->where('a.id', $ann_id)->leftJoin('photos as p',
            function ($join) {
                $join->on('a.id', '=', 'p.announcement_id')->on('p.created_at', '=',
                    DB::raw('(select min(created_at) from photos where announcement_id = p.announcement_id)'));
            })->select('a.title', 'a.price', 'p.url')->first();

        return json_encode($ann);
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

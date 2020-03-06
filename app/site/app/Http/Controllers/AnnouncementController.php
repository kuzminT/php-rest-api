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
            })->select('a.id', 'a.title', 'a.price', 'p.url as main_photo')->orderByDesc('a.created_at')->paginate(10);
    }

    public function show(int $ann_id)
    {
        $ann = DB::table('announcements as a')->where('a.id', $ann_id)->leftJoin('photos as p',
            function ($join) {
                $join->on('a.id', '=', 'p.announcement_id')->on('p.created_at', '=',
                    DB::raw('(select min(created_at) from photos where announcement_id = p.announcement_id)'));
            })->select('a.title', 'a.price', 'p.url as main_photo')->first();

        return json_encode($ann);
    }

    /**
     * Create new Announcement with photos and return result
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $photos_input = $request->input('photos');

//        $request->validate([
//            'photos' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
//        ]);

        $ann = Ann::create($request->all());

        if ($photos_input) {
            $photos = array_map(function($photo) {
                return ['url' => $photo];
            }, $photos_input);

            $result_photos = $ann->photos()->createMany($photos);
            $main_photo = ['main_photo' => ($result_photos->toArray())[0]['url'] ];
        }

        $result = array_merge($ann->toArray(), $main_photo);

        return response()->json($result, 201);
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

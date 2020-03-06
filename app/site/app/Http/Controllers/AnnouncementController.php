<?php

namespace App\Http\Controllers;

use App\Announcement as Ann;
use App\Photo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $sortCol = $request->input('sort', '-created_at');
        $sortDir = Str::startsWith($sortCol, '-') ? 'desc' : 'asc';
        $sortCol = ltrim($sortCol, '-');

        if (!in_array($sortCol, ['created_at', 'price'])) {
            $sortCol = 'created_at';
        }

        return DB::table('announcements as a')->leftJoin('photos as p',
            function ($join) {
                $join->on('a.id', '=', 'p.announcement_id')->on('p.created_at', '=',
                    DB::raw('(select min(created_at) from photos where announcement_id = p.announcement_id)'));
            })->select('a.id', 'a.title', 'a.price', 'p.url as main_photo')->orderBy('a.' . $sortCol, $sortDir)->paginate(10);
    }

    public function show(Request $request, int $ann_id)
    {

        $fields = $request->input('fields', []);

        $fields = array_intersect($fields, ['photos', 'description']);

        $select = ['p.url as main_photo', 'a.title', 'a.price'];

        if (in_array('description', $fields)) {
            $select[] = 'a.description';
        }


        $ann = DB::table('announcements as a')->where('a.id', $ann_id)->leftJoin('photos as p',
            function ($join) {
                $join->on('a.id', '=', 'p.announcement_id')->on('p.created_at', '=',
                    DB::raw('(select min(created_at) from photos where announcement_id = p.announcement_id)'));
            })->select($select)->first();

        if (!$ann) {
            throw new ModelNotFoundException();
        }

        if (in_array('photos', $fields)) {
            $photos = Photo::where('announcement_id', $ann_id)->select('url')->get()->toArray();

            $photos = array_map(function ($p) {
                return $p['url'];
            }, $photos);


            $ann->photos = $photos;
        }

        return json_encode(['data' => $ann]);
    }

    /**
     * Create new Announcement with photos and return result
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $photos_input = $request->input('photos');

        $ann = Ann::create($request->all());

        if ($photos_input) {
            $photos = array_map(function ($photo) {
                return ['url' => $photo];
            }, $photos_input);

            $result_photos = $ann->photos()->createMany($photos);
            $main_photo = ['main_photo' => ($result_photos->toArray())[0]['url']];
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

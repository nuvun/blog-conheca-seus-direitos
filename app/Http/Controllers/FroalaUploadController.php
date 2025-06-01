<?php

namespace App\Http\Controllers;

use App\Models\{ContentPage, Image, Post};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use stdClass;
use Symfony\Component\HttpFoundation\Response;

class FroalaUploadController extends Controller
{

    public function uploadFile(Request $request): JsonResponse
    {
        $data = $request->validate([
            'crud_id' => 'required',
            'model'   => 'required',
            'upload'  => 'required|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,xls,xlsx,ppt,pptx,mp4,mp3|max:15000'
        ]);

        $model         = $this->getModel($data['model']);
        $model->id     = $data['crud_id'];
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()
            ->json([
                'name' => $data['upload']->getClientOriginalName(),
                'link' => $media->getUrl()
            ], Response::HTTP_CREATED);
    }

    public function uploadVideo(Request $request)
    {
        $data = $request->validate([
            'upload'  => ['required', 'mimes:mp4', 'max:15000']
        ]);

        $model         = $this->getModel('Post');
        $model->id     = 0;
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()
            ->json([
                'name' => $data['upload']->getClientOriginalName(),
                'link' => $media->getUrl()
            ], Response::HTTP_CREATED);
    }

    private function getModel($model)
    {
        return match ($model) {
            'contentPage' => new ContentPage(),
            'Post'        => new Post(),
            'Image'       => new Image(),
            default       => 'unknown',
        };
    }
}

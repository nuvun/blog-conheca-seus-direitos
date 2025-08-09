<?php

namespace App\Http\Controllers\Api\V1\Data;

use App\Http\Controllers\Controller;
use App\Models\ChatUserData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ChatController extends Controller
{

    public function index(): JsonResponse
    {
        try {
            $chatUserData = ChatUserData::query()
                ->with(['chatMessages'])
                ->orderByDesc('id')
                ->paginate()
                ->withQueryString();

            return response()->json([
                'message' => 'Chat user data retrieved successfully.',
                'data' => $chatUserData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}

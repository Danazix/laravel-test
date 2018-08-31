<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Services\ApiAuthService;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Response;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $quit_id
     * @param MessageService $messageService
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request, $quit_id, MessageService $messageService): JsonResponse
    {
        return Response::json($messageService->listReplies(
            $quit_id,
            $request->input('page', 0),
            $request->input('perPage', 10)
        ), 200, ['X-total-count' => $messageService->countReplies($quit_id)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $quit_id
     * @param MessageRequest $request
     * @param MessageService $messageService
     * @param ApiAuthService $authService
     * @return void
     */
    public function create($quit_id, MessageRequest $request, MessageService $messageService)
    {
        $messageService->reply(\Auth::id(), $quit_id, $request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param $quit_id
     * @param  int $id
     * @param MessageService $messageService
     * @return JsonResponse
     */
    public function show($quit_id, $id, MessageService $messageService)
    {
        return Response::json($messageService->getReply($quit_id, $id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $quit_id
     * @param  int $id
     * @param MessageRequest $request
     * @param MessageService $messageService
     * @param ApiAuthService $authService
     * @return void
     */
    public function update(int $quit_id, int $id, MessageRequest $request, MessageService $messageService)
    {
        $messageService->updateReply(\Auth::id(), $quit_id, $id, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $quit_id
     * @param  int $id
     * @param MessageService $messageService
     * @param ApiAuthService $authService
     * @return void
     */
    public function destroy(int $quit_id, int $id, MessageService $messageService)
    {
        $messageService->deleteReply(\Auth::id(), $quit_id, $id);
    }
}

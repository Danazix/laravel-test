<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Services\ApiAuthService;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Response;

class QuitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param MessageService $messageService
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request, MessageService $messageService)
    {
        return Response::json(
            $messageService->listQuits(
                $request->input('page', 0),
                $request->input('perPage', 10)
            ), 200, ['X-total-count' => $messageService->countQuits()]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MessageRequest $request
     * @param MessageService $messageService
     * @param ApiAuthService $authService
     * @return void
     */
    public function create(MessageRequest $request, MessageService $messageService)
    {
        $messageService->quit(\Auth::id(), $request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param MessageService $messageService
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id, MessageService $messageService)
    {
        return Response::json($messageService->getQuit($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param MessageRequest $request
     * @param MessageService $messageService
     * @param ApiAuthService $authService
     * @return void
     */
    public function update(int $id, MessageRequest $request, MessageService $messageService)
    {
        $messageService->updateQuit(\Auth::id(), $id, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @param MessageService $messageService
     * @param ApiAuthService $authService
     * @return void
     */
    public function destroy(int $id, MessageService $messageService)
    {
        $messageService->deleteQuit(\Auth::id(), $id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\ApiAuthService;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Response;

class UserController extends Controller
{
    /**
     * List all users.
     *
     * @param Request $request
     * @param UserService $userService
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request, UserService $userService)
    {
        return Response::json(
            $userService->list(
                $request->input('page', 0),
                $request->input('perPage', 10)
            ), 200, ['X-total-count' => $userService->count()]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RegistrationRequest $request
     * @param ApiAuthService $authService
     * @return void
     */
    public function store(RegistrationRequest $request, ApiAuthService $authService)
    {
        $authService->register($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param UserService $userService
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id, UserService $userService)
    {
        return Response::json($userService->get($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param  int $id
     * @param ApiAuthService $authService
     * @param UserService $userService
     * @return bool
     * @throws AuthorizationException
     */
    public function update(UpdateUserRequest $request, int $id, ApiAuthService $authService, UserService $userService)
    {
        if(\Auth::id() === $id) {
            return $userService->update($id, $request->validated());
        }

        throw new AuthorizationException('Can not edit others.');
    }
}

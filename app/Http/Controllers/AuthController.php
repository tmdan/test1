<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLogInRequest;
use App\Http\Requests\AuthSingInRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    /**
     *
     * @OA\Post (
     *     path="/api/login",
     *     operationId="post.api.login",
     *     summary="Вход для пользователя",
     *     tags={"Auth"},
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *                  required={"email","password"},
     *                  @OA\Property(property="email", type="string", example="admin@mail.ru"),
     *                  @OA\Property(property="password", type="string", example="password"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Created",
     *          @OA\JsonContent(
     *               @OA\Property(property="access_token", type="string", example="72|SuM9ZUXyXDvt42zTL3CX9Pp7IOj8JaqerSiLJZll"),
     *               @OA\Property(property="type", type="string", example="Bearer"),
     *          )
     *      ),
     *      @OA\Response(
     *         response=422,
     *         description="Error: Unprocessable Entity",
     *         @OA\JsonContent(
     *            @OA\Property(property="message", type="string", example="The given data was invalid."),
     *            @OA\Property(
     *               property="errors",
     *               type="object",
     *               @OA\Property(
     *                  property="email",
     *                  type="array",
     *                  collectionFormat="multi",
     *                  @OA\Items(
     *                     type="string",
     *                     example={
     *                              "The provided credentials are incorrect.",
     *                              "The email must be a valid email address.",
     *                              "The email field is required.",
     *                      },
     *                  ),
     *               ),
     *               @OA\Property(
     *                  property="password",
     *                  type="array",
     *                  collectionFormat="multi",
     *                  @OA\Items(
     *                     type="string",
     *                     example={
     *                              "The password field is required.",
     *                      },
     *                  ),
     *               ),
     *            )
     *         )
     *      )
     *
     * )
     *
     *
     *
     *
     * @param AuthLogInRequest $authLogInRequest
     * @return JsonResponse
     * @throws ValidationException
     */
    public function logIn(AuthLogInRequest $authLogInRequest)
    {
        $user = User::where('email', $authLogInRequest->email)->first();

        if (!$user || !Hash::check($authLogInRequest->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json(['access_token' => $user->createToken($user->id)->plainTextToken, 'type' => 'Bearer'], Response::HTTP_OK);
    }

    /**
     *
     *
     * @OA\Post (
     *     path="/api/singin",
     *     operationId="post.api.singin",
     *     summary="Регистрация нового пользователя",
     *     tags={"Auth"},
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *                  required={"email","password"},
     *                  @OA\Property(property="email", type="string", example="admin@mail.ru"),
     *                  @OA\Property(property="password", type="string", example="password"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *               @OA\Property(property="access_token", type="string", example="72|SuM9ZUXyXDvt42zTL3CX9Pp7IOj8JaqerSiLJZll"),
     *               @OA\Property(property="type", type="string", example="Bearer"),
     *          )
     *      ),
     *      @OA\Response(
     *         response=422,
     *         description="Error: Unprocessable Entity",
     *         @OA\JsonContent(
     *            @OA\Property(property="message", type="string", example="The given data was invalid."),
     *            @OA\Property(
     *               property="errors",
     *               type="object",
     *               @OA\Property(
     *                  property="email",
     *                  type="array",
     *                  collectionFormat="multi",
     *                  @OA\Items(
     *                     type="string",
     *                     example={
     *                         "The email must be a valid email address.",
     *                         "The email field is required.",
     *                      },
     *                  ),
     *               ),
     *               @OA\Property(
     *                  property="password",
     *                  type="array",
     *                  collectionFormat="multi",
     *                  @OA\Items(
     *                     type="string",
     *                     example={
     *                          "The password field is required.",
     *                      },
     *                  ),
     *               ),
     *            )
     *         )
     *      )
     *
     * )
     *
     *
     *
     * @param AuthSingInRequest $authSingInRequest
     * @return JsonResponse
     */
    public function singIn(AuthSingInRequest $authSingInRequest)
    {
        $user = User::create([
            'email' => $authSingInRequest->email,
            'password' => bcrypt($authSingInRequest->password),
        ]);

        return response()->json(['access_token' => $user->createToken($user->id)->plainTextToken, 'type' => 'Bearer'], Response::HTTP_CREATED);
    }
}

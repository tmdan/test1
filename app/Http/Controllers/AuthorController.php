<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorStoreRequest;
use App\Http\Resources\AuthorBooksResource;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     *
     *
     *
     * @OA\Post  (
     *     path="/api/authors",
     *     tags={"Authors"},
     *     summary="Добавление нового автора",
     *     security={{"Bearer Token": {}}},
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *                  required={"name"},
     *                  @OA\Property(property="name", type="string", example="Иван Иваныч"),
     *          ),
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
     *                  property="name",
     *                  type="array",
     *                  collectionFormat="multi",
     *                  @OA\Items(
     *                     type="string",
     *                     example={
     *                          "The name has already been taken.",
     *                          "The name field is required.",
     *                           "The name must be at least 2 characters.",
     *                           "The name must be a string.",
     *                      },
     *                  ),
     *               ),
     *            )
     *         )
     *      ),
     *     @OA\Response(
     *         response=401,
     *         description="Error: Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated."),
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Created",
     *          @OA\JsonContent(
     *          )
     *      ),
     * )
     *
     *
     *
     *
     * @param AuthorStoreRequest $request
     * @return AuthorBooksResource
     */
    public function store(AuthorStoreRequest $request)
    {
        return new AuthorBooksResource(Author::create($request->validated()));
    }


    /**
     *
     *
     *
     * @OA\Get  (
     *     path="/api/authors/{id}/books",
     *     tags={"Authors"},
     *     summary="Получить список книг по конкретному автору",
     *     security={{"Bearer Token": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
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
     *                  property="name",
     *                  type="array",
     *                  collectionFormat="multi",
     *                  @OA\Items(
     *                     type="string",
     *                     example={
     *                          "The name has already been taken.",
     *                          "The name field is required.",
     *                           "The name must be at least 2 characters.",
     *                           "The name must be a string.",
     *                      },
     *                  ),
     *               ),
     *            )
     *         )
     *      ),
     *     @OA\Response(
     *         response=401,
     *         description="Error: Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated."),
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Created",
     *          @OA\JsonContent(
     *          )
     *      ),
     * )
     *
     *
     *
     *
     * @param Request $request
     * @param Author $author
     * @return AuthorBooksResource
     */
    public function show(Request $request, Author $author)
    {
        return new AuthorBooksResource($author);
    }
}

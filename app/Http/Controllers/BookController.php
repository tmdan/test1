<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookFindRequest;
use App\Http\Requests\BookIndexRequest;
use App\Http\Requests\BookStoreRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookResources;
use App\Models\Book;

class BookController extends Controller
{
    /**
     *
     *
     *
     * @OA\Get  (
     *     path="/api/books",
     *     summary="Получить список книг",
     *     tags={"Books"},
     *     operationId="Journals",
     *     security={{"Bearer Token": {}}},
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
     * @param BookIndexRequest $request
     * @return BookResources
     */
    public function index(BookIndexRequest $request)
    {
        return new BookResources(Book::with('authors')->get());
    }

    /**
     *
     *
     * @OA\Get  (
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Получить одну книгу со всеми авторами",
     *     security={{"Bearer Token": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
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
     *     @OA\Response(
     *         response=404,
     *         description="Error: Not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Not found."),
     *         )
     *     ),
     * )
     *
     *
     *
     *
     * @param Book $book
     * @return BookResource
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }


    /**
     *
     *
     *
     *
     * @OA\Post  (
     *     path="/api/books",
     *     tags={"Books"},
     *     summary="Добавление новой книги",
     *     security={{"Bearer Token": {}}},
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *                  required={"title","authors_ids"},
     *                  @OA\Property(property="title", type="string", example="hello world"),
     *                   @OA\Property(
     *                      property="author_ids",
     *                      type="array",
     *                      @OA\Items(type="enum", enum={1,2,3,4,5,6,7,8,9}),
     *                      example={1,2}
     *                   ),
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
     *                  property="title",
     *                  type="array",
     *                  collectionFormat="multi",
     *                  @OA\Items(
     *                     type="string",
     *                     example={
     *                          "The title field is required.",
     *                          "The title must be at least 5 characters.",
     *                          "The title must be a string.",
     *                      },
     *                  ),
     *               ),
     *               @OA\Property(
     *                  property="author_ids",
     *                  type="array",
     *                  collectionFormat="multi",
     *                  @OA\Items(
     *                     type="string",
     *                     example={
     *                           "The author ids must be an array.",
     *                           "The selected author_ids.0 is invalid.",
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
     * @param BookStoreRequest $request
     * @return BookResource
     */
    public function store(BookStoreRequest $request)
    {
        $book = Book::create($request->validated());
        $book->authors()->sync($request->input('author_ids'));
        return new BookResource($book);
    }
}

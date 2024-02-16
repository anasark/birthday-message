<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class UserController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     * 
     * @return JsonResponse
     * 
     * @OA\Get(
     *      path="/api/user",
     *      description="User",
     *      operationId="user",
     *      tags={"User"},
     *      @OA\Response(
     *          response="200",
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="int", example="200"),
     *              @OA\Property(property="success", type="bool", example="true"),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(type="object",
     *                      @OA\Property(property="id", type="integer", example=1),
     *                      @OA\Property(property="first_name", type="string", example="John"),
     *                      @OA\Property(property="last_name", type="string", example="Doe"),
     *                      @OA\Property(property="address", type="string", example="bourke street"),
     *                      @OA\Property(property="city", type="string", example="melbourne"),
     *                      @OA\Property(property="country", type="string", example="australia"),
     *                      @OA\Property(property="birth_date", type="string", example="2024-01-24T17:00:00.000000Z"),
     *                      @OA\Property(property="timezone", type="string", example="Australia/Melbourne"),
     *                      @OA\Property(property="email", type="string", example="john.doe@mail.com"),
     *                      @OA\Property(property="updated_at", type="string", example="2024-01-25T04:41:09.000000Z"),
     *                      @OA\Property(property="created_at", type="string", example="2024-01-25T04:41:09.000000Z")
     *                  )
     *              )
     *          ),
     *      )
     *  )
     */
    public function index()
    {
        return $this->success(User::all());
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  UserStoreRequest $request
     *
     * @return JsonResponse
     * 
     * @OA\Post(
     *      path="/api/user",
     *      description="User Store",
     *      operationId="userStore",
     *      tags={"User"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"first_name", "last_name", "email", "address", "city", "country", "birth_date"},
     *              @OA\Property(property="first_name", type="string", example="John"),
     *              @OA\Property(property="last_name", type="string", example="Doe"),
     *              @OA\Property(property="address", type="string", example="bourke street"),
     *              @OA\Property(property="city", type="string", example="melbourne"),
     *              @OA\Property(property="country", type="string", example="australia"),
     *              @OA\Property(property="birth_date", type="string", example="2024-01-24"),
     *              @OA\Property(property="timezone", type="string", example="Australia/Melbourne"),
     *              @OA\Property(property="email", type="string", example="john.doe@mail.com"),
     *          )
     *      ),
     *      @OA\Response(
     *          response="201",
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="int", example="201"),
     *              @OA\Property(property="success", type="bool", example="true"),
     *              @OA\Property(property="data", type="object", 
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="first_name", type="string", example="John"),
     *                  @OA\Property(property="last_name", type="string", example="Doe"),
     *                  @OA\Property(property="address", type="string", example="bourke street"),
     *                  @OA\Property(property="city", type="string", example="melbourne"),
     *                  @OA\Property(property="country", type="string", example="australia"),
     *                  @OA\Property(property="birth_date", type="string", example="2024-01-24T17:00:00.000000Z"),
     *                  @OA\Property(property="timezone", type="string", example="Australia/Melbourne"),
     *                  @OA\Property(property="email", type="string", example="john.doe@mail.com"),
     *                  @OA\Property(property="updated_at", type="string", example="2024-01-25T04:41:09.000000Z"),
     *                  @OA\Property(property="created_at", type="string", example="2024-01-25T04:41:09.000000Z"),
     *              )
     *          ),
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="The given data was invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example=422),
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="error", type="object",
     *                  @OA\Property(property="code", type="integer", example=2002),
     *                  @OA\Property(property="message", type="string", example="The last name field is required."),
     *                  @OA\Property(property="error", type="array",
     *                      @OA\Items(type="string", example="The last name field is required."),
     *                  )
     *              )
     *          )
     *      )
     *  )
     */
    public function store(UserStoreRequest $request)
    {
        return $this->success(User::create($request->validated()), null, 201);
    }

    /**
     * Display the specified resource.
     * 
     * @param  String $id
     *
     * @return JsonResponse
     * 
     * @OA\Get(
     *      path="/api/user/{user_id}",
     *      description="User Get",
     *      operationId="userGet",
     *      tags={"User"},
     *      @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string"),
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="int", example="200"),
     *              @OA\Property(property="success", type="bool", example="true"),
     *              @OA\Property(property="data", type="object", 
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="first_name", type="string", example="John"),
     *                  @OA\Property(property="last_name", type="string", example="Doe"),
     *                  @OA\Property(property="address", type="string", example="bourke street"),
     *                  @OA\Property(property="city", type="string", example="melbourne"),
     *                  @OA\Property(property="country", type="string", example="australia"),
     *                  @OA\Property(property="birth_date", type="string", example="2024-01-24T17:00:00.000000Z"),
     *                  @OA\Property(property="timezone", type="string", example="Australia/Melbourne"),
     *                  @OA\Property(property="email", type="string", example="john.doe@mail.com"),
     *                  @OA\Property(property="updated_at", type="string", example="2024-01-25T04:41:09.000000Z"),
     *                  @OA\Property(property="created_at", type="string", example="2024-01-25T04:41:09.000000Z"),
     *              )
     *          ),
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Data Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example=404),
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="error", type="object",
     *                  @OA\Property(property="code", type="integer", example=2001),
     *                  @OA\Property(property="message", type="string", example="Not found")
     *              )
     *          )
     *      )
     *  )
     */
    public function show(string $id)
    {
        return $this->success(User::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  UserUpdateRequest $request
     * @param  string            $id
     *
     * @return JsonResponse
     * 
     * @OA\Put(
     *      path="/api/user/{user_id}",
     *      description="User Update",
     *      operationId="userUpdate",
     *      tags={"User"},
     *      @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string"),
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="address", type="string", example="Level 24/570 Bourke St")
     *          )
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="int", example="200"),
     *              @OA\Property(property="success", type="bool", example="true"),
     *              @OA\Property(property="data", type="string", example="null")
     *          ),
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Data Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example=404),
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="error", type="object",
     *                  @OA\Property(property="code", type="integer", example=2001),
     *                  @OA\Property(property="message", type="string", example="Not found")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="The given data was invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example=422),
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="error", type="object",
     *                  @OA\Property(property="code", type="integer", example=2002),
     *                  @OA\Property(property="message", type="string", example="The address field must be a string."),
     *                  @OA\Property(property="error", type="array",
     *                      @OA\Items(type="string", example="The address field must be a string."),
     *                  )
     *              )
     *          )
     *      )
     *  )
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        User::findOrFail($id)->update($request->validated());

        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  string $id
     *
     * @return JsonResponse
     * 
     * @OA\Delete(
     *      path="/api/user/{user_id}",
     *      description="User Delete",
     *      operationId="userDelete",
     *      tags={"User"},
     *      @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="string"),
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="int", example="200"),
     *              @OA\Property(property="success", type="bool", example="true"),
     *              @OA\Property(property="data", type="string", example="null")
     *          ),
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Data Not found",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example=404),
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="error", type="object",
     *                  @OA\Property(property="code", type="integer", example=2001),
     *                  @OA\Property(property="message", type="string", example="Not found")
     *              )
     *          )
     *      )
     *  )
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        return $this->success();
    }

    /**
     * Generate 25 resources.
     * 
     * @return JsonResponse
     * 
     * @OA\Get(
     *      path="/api/user/generate",
     *      description="User Generate",
     *      operationId="userGenerate",
     *      tags={"User"},
     *      @OA\Response(
     *          response="200",
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="int", example="200"),
     *              @OA\Property(property="success", type="bool", example="true"),
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="message", type="string", example="25 users successfully generated")
     *              )
     *          )
     *      )
     *  )
     */
    public function generate()
    {
        Artisan::call('db:seed');

        return $this->success(['message' => '25 users successfully generated.']);
    }
}

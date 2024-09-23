<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseAPIController;
use App\Models\CoreUsers;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\RoomMeet;
use App\Utils\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Validator;

class HomeController extends BaseAPIController
{


    /**
     * @OA\Get(
     *     path="/home/index",
     *     tags={"Home"},
     *     summary="Get home data",
     *     description="",
     *     operationId="getHomeData",
     *     @OA\Parameter(name="company_id", description="COMPANY ID", required=true, in="query",
     *         @OA\Schema(type="string",)
     *     ),
     *     @OA\Parameter(name="api_key", description="API Key", required=true, in="query",
     *         @OA\Schema(type="string",)
     *     ),
     *     @OA\Parameter(name="token", description="token from api login", required=false, in="query",
     *         @OA\Schema(type="string",)
     *     ),
     *     @OA\Parameter( name="id_branch", description="id chi nhanh ", required=false, in="query",
     *         @OA\Schema( type="integer", )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Missing/Invalid params"),
     *     @OA\Response(response="500", description="Server error"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="403", description="Account is banned"),
     *     @OA\Response(response="404", description="Account not exits"),
     *     @OA\Response(response="405", description="Account has not been activated yet"),
     * )
     */
    public function index(Request $request)
    {
        if (!$request->get('company_id') || !$request->get('api_key'))
            return $this->throwError(400, 'Vui lòng nhập Company ID & API_Key!');

        $this->checkCompany($request->get('company_id'), $request->get('api_key'));

        $product_type = ProductType::get_by_where(['assign_key' => true,], ['id', 'name', 'parent_id']);

        $id_branch = 0;
        if(!empty($request->get('id_branch'))){
            $id_branch = $request->get('id_branch');
        }
        foreach ($product_type as $k => $v) {

            if ($v['parent_id']) continue;

            $all_child = [];
            $all_child = Category::get_all_child_categories($product_type, $k);

            $all_child = array_merge($all_child, [$k]);
            $products_by_category[] = ['category' => $v, 'rows' => Product::get_by_where([
                'status'          => 1,
                'product_type_id' => $all_child,
                'limit'           => 12,
                'id_branchs'           => $id_branch,
                'sort'            => 'newest',
                'pagin'           => false,
            ])];
        }
//        $user = $this->getAuthenticatedUser();

        return $this->returnResult($products_by_category);
    }


    /**
     * @OA\Get  (
     *     path="/quickom/oauth2/verify",
     *     tags={"Home"},
     *     summary="Verify user token",
     *     description="Verifies the provided token and returns user details if valid.",
     *     operationId="verify",
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="token for authorization",
     *         @OA\Schema(
     *             type="string",
     *             example="Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="response_code", type="string", example="00"),
     *             @OA\Property(property="user_id", type="string", example="hashed_user_id"),
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="phone_number", type="string", example="123456789"),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="host", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(response="400", description="Missing/Invalid params"),
     *     @OA\Response(response="500", description="Server error"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="403", description="Account is banned"),
     *     @OA\Response(response="404", description="Account not exists"),
     *     @OA\Response(response="405", description="Account has not been activated yet"),
     * )
     */



    public function oauth2(Request $request) {

        $token = $request->header('Authorization');

        $token = str_replace('Bearer ', '', $token);


        if (empty($token)) {
            return response()->json([
                "response_code" => '01'
            ], 401);
        }



        try {
            $user = CoreUsers::where('token_api', $token)->first();// chuyen gia

            if (empty($user)) {
                return response()->json([
                    "response_code" => '01'
                ], 401);
            }
            $room = RoomMeet::where('expert_id', $user->id)->first();

            $host = false;
           if ( !empty($room)) { // nieu la chuyen gia
               $host = true;
           }


            return response()->json([
                "response_code" => "00",
                "user_id" => (String)$user->id,
                "email" => $user->email,
                "phone_number" => null,
                "name" => $user->fullname,
                "host" => $host
            ], 200);
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json([
                "response_code" => "01"
            ], 401);
        }

    }

}

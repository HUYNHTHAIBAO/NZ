<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseAPIController;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends BaseAPIController
{
    /**
     * @OA\Get(
     *   path="/branch/getAll",
     *   tags={"Branch"},
     *   summary="Get all Branch",
     *   description="",
     *   operationId="BranchGetAll",
     *     @OA\Parameter( name="company_id", description="Company ID", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="api_key", description="API Key", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *   @OA\Response(response="200", description="Success operation"),
     *   @OA\Response(response="500", description="Server error")
     * )
     */
    public function getAll(Request $request)
    {
        if (!$request->get('company_id') || !$request->get('api_key'))
            return $this->throwError(400, 'Vui lòng nhập Company ID & API_Key!');

        $this->checkCompany($request->get('company_id'), $request->get('api_key'));

        $return = Branch::get();

       // $return = $return->limit(30)->get();
        return $this->returnResult($return);
    }


    /**
     * @OA\Get(
     *   path="/branch/getTableByIdBranch",
     *   tags={"Branch"},
     *   summary="Get all Table By Id Branch",
     *   description="",
     *   operationId="GetTableByIdBranch",
     *     @OA\Parameter( name="company_id", description="Company ID", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="api_key", description="API Key", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="idbranch", description="idbranch", required=true, in="query",
     *         @OA\Schema( type="integer", )
     *     ),
     *   @OA\Response(response="200", description="Success operation"),
     *   @OA\Response(response="500", description="Server error")
     * )
     */
    public function getTableByIdBranch(Request $request)
    {
        if (!$request->get('company_id') || !$request->get('api_key'))
            return $this->throwError(400, 'Vui lòng nhập Company ID & API_Key!');

        $this->checkCompany($request->get('company_id'), $request->get('api_key'));

        $return = Branch::Join('lck_warehouse', 'lck_branch.id', '=', 'lck_warehouse.branch_id')
            ->where('lck_branch.id',$request->get('idbranch'))
            ->get();

        // $return = $return->limit(30)->get();
        return $this->returnResult($return);
    }
}

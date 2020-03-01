<?php
namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\UserFollow;
use App\Models\User;
use Lang;

class UserFollowController extends ApiController {

    /**
     * @SWG\Post(
     *     path="/api/v1/user/{id}/follow",
     *     operationId="follow",
     *     description="Follow user",
     *     produces={"application/json"},
     *     tags={"Follow"},
     *     summary="Follow user",
     *  @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="user id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public"
     *     )
     * )
     */
    public function follow($id, Request $req) {
        $user = $req->user();
        $has = User::where('use_id', $id)->count() > 0;
        if (!$has) {
            return response([
                'msg' => Lang::get('response.user_not_found')
            ], 404);
        }
        $follow = UserFollow::where([
            'user_id' => $id,
            'follower' => $user->use_id, 
        ])->first();

        if ($follow) {
            $follow->hasFollow = !$follow->hasFollow;
        } else {
            $follow = new UserFollow([
                'user_id' => $id,
                'follower' => $user->use_id,
                'hasFollow' => true
            ]);
        }

        $follow->save();
        return response([
            'msg' => Lang::get('response.success'),
            'hasFollow' => $follow->hasFollow
        ]);
    }
}
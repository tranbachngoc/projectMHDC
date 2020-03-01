<?php
namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Content;
use App\Models\ContentComment;
use Lang;
use App\Models\SelectNews;
use App\Models\UserFollow;
use App\Models\User;
use DB;

class NewsController extends ApiController {

	/**
     * @SWG\Get(
     *     path="/api/v1/news",
     *     operationId="news",
     *     description="Danh sach news",
     *     produces={"application/json"},
     *     tags={"News"},
     *     summary="Danh sach news",
     *     @SWG\Parameter(
     *         name="filterBy",
     *         in="query",
     *         description="filterBy: follow,promotion: theo khuyến mãi ,new, hot: Tin  hot ,category : Lọc theo danh mục, group",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="filter",
     *         in="query",
     *         description="Nếu filter By = category truyền id cateogy vào đây",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page ",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="orderBy",
     *         in="query",
     *         description="orderBy",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    public function index(Request $req) {
        $condition = [
            'not_status' => 1,
            'id_category'=>16,
          //  'cat_type' => 1,
            'not_publish' => 1       // TODO
        ];
        if ($req->test) {
            $condition = [
                'not_status' => 1,
                'id_category' => 16,
//            'cat_type' => 1,
                'not_publish' => 1       // TODO
            ];
        }
        $user = $req->user();
        $query = Content::where($condition)
        ->leftJoin('tbtt_user', 'use_id', 'not_user')
        ->select('tbtt_content.*', 'tbtt_user.use_fullname');
        $query->where('tbtt_user.use_status','>',0);
        if ($req->orderFilter == 'ghim') {
            $query->orderBy('not_ghim', 'DESC')->orderBy('not_view','DESC');
        } else {
            $query->orderBy('not_begindate', 'DESC');
        }

        if ($req->filterBy == Content::FILTER_PROMOTION) {
            $query->where('not_news_sale', 1);
        } else if ($req->filterBy == Content::FILTER_HOT) {
            $query->where('not_news_hot', 1);
        } else if ($req->filterBy == Content::FILTER_CATEGORY) {
            $query->where('not_pro_cat_id', $req->filter);
        } else if ($req->filterBy == Content::FILTER_FOLLOW) {
            $user_follow_table = UserFollow::tableName();
            $content_table = Content::tableName();

            $query->leftJoin($user_follow_table.' as f', function($join) use ($user, $user_follow_table, $content_table) {
                $join->on('f.user_id', '=', $content_table . '.not_user');
                $join->where([
                    'follower' => $user ? $user->use_id : -1,
                    'hasFollow' => true,
                ]);
            })
            ->havingRaw('count(f.id) > 0')
            ->groupBy($content_table . '.not_id');
        }

        Content::filter($query, $user);

        if ($req->search) {
            $query->where(function($q) use ($req) {
                $q->orWhere('not_title', 'LIKE', '%' . $req->search . '%');
                $q->orWhere('not_detail', 'LIKE', '%' . $req->search . '%');
                $q->orWhere('use_fullname', 'LIKE', '%' . $req->search . '%');
            });
        }

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $paginate = $query->paginate($limit, ['*'], 'page', $page);

        //populate user
        $arraysData = [];
        foreach ($paginate->items() as $value) {
            $value->populate($user);
            $data = $value->toArray();
            $data['user'] = $value->user->publicProfile();
            $data['user']['shop'] = $value->user->shop;
            $arraysData[] = $data;
            //$value->user->shop;
        }
        $results = $paginate->toArray();
        $results['data'] = $arraysData;
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/news/{id}",
     *     operationId="newsDetail",
     *     description="get list logs online offline of driver",
     *     produces={"application/json"},
     *     tags={"News"},
     *     summary="Lấy detail của bài viết",
     *  @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="new id",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    public function detail($id, Request $req) {
    	$query = Content::where(['not_id'=>$id]);
        $userLogin = $req->user();
        if(!empty($userLogin)){
           Content::filter($query,$userLogin);
        }else{
            $query->where('not_permission',Content::PERRMISSION_ALL);
        }
        $content = $query->first();
    	if (!$content) {
            return response([
                'msg' => Lang::get('response.news_not_found')
                ], 404);
        }

        //populate user
        $content->user;
        $content->populate($req->user());
        $content->increment('not_view');

    	return response([
            'msg' => Lang::get('response.success'),
            'data' => $content
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/news/{id}/comments",
     *     operationId="newsComments",
     *     description="get list logs online offline of driver",
     *     produces={"application/json"},
     *     tags={"News"},
     *     summary="Lấy danh sách bình luận",
     *  @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="new id",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page ",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    public function comments($id, Request $req) {
        $user = $req->user();

        $query = ContentComment::where([
            'noc_content' => $id,
            'noc_reply' => 0
        ])->orderBy('noc_date', 'ASC');

        $isOnwer = Content::where(['not_user' => $user->use_id, 'not_id' => $id])->count() > 0;

        if (!$isOnwer) {
            $query->where('noc_user', $user->use_id);
        }
        
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $results = $query->paginate($limit, ['*'], 'page', $page);
        //populate user
        foreach ($results as $value) {
            $value->replies;
        }

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
    }


    /**
     * @SWG\Get(
     *     path="/api/v1/news/{id}/comments/{commentId}/comments",
     *     operationId="newsComments",
     *     description="get list logs online offline of driver",
     *     produces={"application/json"},
     *     tags={"News"},
     *     summary="Lấy danh sách bình luận",
     *  @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="new id",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="commentId",
     *         in="path",
     *         description="commentId",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page ",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    public function subComments($id, $commentId, Request $req) {
        $query = ContentComment::where([
            'noc_content' => $id,
            'noc_reply' => $commentId
        ])->orderBy('noc_date', 'ASC');
        
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $results = $query->paginate($limit, ['*'], 'page', $page);

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
    }


    /**
     * @SWG\Post(
     *     path="/api/v1/news/{id}/comments",
     *     operationId="createNewsComments",
     *     description="get list logs online offline of driver",
     *     produces={"application/json"},
     *     tags={"News"},
     *     summary="Tạo mới bình luận",
     *  @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="new id",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="noc_comment",
     *         in="body",
     *         description="noc_comment",
     *         required=true,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="noc_reply",
     *         in="body",
     *         description="noc_reply, default 0",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    public function createComments($id, Request $req) {
        $validator = Validator::make($req->all(), [
            'noc_comment' => 'required|string',
            'noc_reply' => 'integer',
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $hasNews = Content::where('not_id', $id)->count() > 0;
        if (!$hasNews) {
            return response([
                'msg' => Lang::get('response.news_not_found')
            ], 404);
        }

        $user = $req->user();

        $comment = new ContentComment([
            'noc_comment' => $req->noc_comment,
            'noc_name' => $user->use_username,
            'noc_email' => $user->use_email,
            'noc_phone' => $user->use_phone,
            'noc_user' => $user->use_id,
            'noc_date' => date('Y-m-d H:i:s'),
            'noc_content' => $id,
            'noc_avatar' => $user->avatar,
            'noc_reply' => $req->noc_reply ? $req->noc_reply : 0 
        ]);

        try {
            $comment->save();
            return response([
                'msg' => Lang::get('response.success'),
                'data' => $comment
            ]);
        } catch (Exception $ex) {
            return response(['msg' => Lang::get('response.server_error')], 500);
        }
    }


    /**
     * @SWG\Get(
     *     path="/api/v1/news/{id}/related",
     *     operationId="newsRelated",
     *     description="Danh sách tin tức liên quan",
     *     produces={"application/json"},
     *     tags={"News"},
     *     summary="Lấy danh sách tin liên quan",
     *  @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="new id",
     *         required=true,
     *         type="integer",
     *     ),
     *  @SWG\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page ",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    public function related($id, Request $req) {
        $content = Content::find($id);
        if (!$content) {
            return response([
                'msg' => Lang::get('response.news_not_found')
            ], 404);
        }
        $query = Content::where([
            'not_status' => 1,
            'cat_type' => 1,
            'not_publish' => 1,
            'not_pro_cat_id' => $content->not_pro_cat_id
        ])->orderBy('not_begindate', 'DESC');
        
        if ($req->search) {
            $query->where(function($q) use ($req) {
                $q->orWhere('not_title', 'LIKE', '%' . $req->search . '%');
                $q->orWhere('not_detail', 'LIKE', '%' . $req->search . '%');
            });
        }


        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $paginate = $query->paginate($limit, ['*'], 'page', $page);



        $arraysData = [];
        foreach ($paginate->items() as $value) {
            $value->populateSlug();
            $value->populate($req->user());
            $data = $value->toArray();
            $data['user'] = $value->user->publicProfile();
            $data['user']['shop'] = $value->user->shop;
            $arraysData[] = $data;
            //$value->user->shop;
        }
        $results = $paginate->toArray();
        $results['data'] = $arraysData;
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
    }

    /**
     * @SWG\Post(
     *     path="/api/v1/news",
     *     operationId="createNews",
     *     description="Tạo bài viết mới",
     *     produces={"application/json"},
     *     summary="Tạo bài viết mới",
     *     tags={"News"},
     *     @SWG\Parameter(
     *         name="not_description",
     *         in="body",
     *         description="Mô tả ngắn",
     *         required=false,
     *         type="string",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *      @SWG\Parameter(
     *         name="not_keywords",
     *         in="body",
     *         description="Từ khóa bài viết cách nhau dấu ,",
     *         required=false,
     *         type="string",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_image",
     *         in="body",
     *         description="image of news",
     *         required=true,
     *         type="float",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     * 
     *     @SWG\Parameter(
     *         name="not_image1",
     *         in="body",
     *         description="not_image1 of news Đánh số từ 1-8",
     *         required=false,
     *         type="float",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ), 
     *     @SWG\Parameter(
     *         name="imgcaption1",
     *         in="body",
     *         description="image catption Đánh số từ 1-8",
     *         required=false,
     *         type="float",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="imglink1",
     *         in="body",
     *         description="imglink1 of news Đánh số từ 1 -> 8",
     *         required=false,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="linkdetail1",
     *         in="body",
     *         description="imglink1 of news Đánh số từ 1 tới 8",
     *         required=false,
     *         type="string",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_dir_image",
     *         in="body",
     *         description="dir_image of news",
     *         required=true,
     *         type="float",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_title",
     *         in="body",
     *         description="title",
     *         required=true,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_detail",
     *         in="body",
     *         description="detail, format html",
     *         required=true,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_pro_cat_id",
     *         in="body",
     *         description="pro_cat_id",
     *         required=true,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_news_hot",
     *         in="body",
     *         description="not_news_hot 0, 1",
     *         required=true,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_status",
     *         in="body",
     *         description="content active 0, 1",
     *         required=true,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_news_sale",
     *         in="body",
     *         description="not_news_sale, 0, 1",
     *         required=true,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_video_url1",
     *         in="body",
     *         description="not_video_url1",
     *         required=true,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="success"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Not found",
     *     )
     * )
     */
    public function create(Request $req) {
        $validator = Validator::make($req->all(), [
            'not_image' => 'string',
            'not_dir_image' => 'required|string',
            //'not_title' => 'string',
            'not_detail' => 'required|string',
            'not_pro_cat_id'=> 'integer',         //Danh mục sản phẩm
            'not_news_hot'=> 'required|in:0,1',           //Tin tức HOT
            //'not_status'=> 'required|in:0,1',             //Kích hoạt: 0 không, 1 có
            'not_news_sale'=> 'required|in:0,1'           //Tin khuyến mãi
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $req->user();

        $content = new Content([
            'not_title' => $req->not_title ? trim($req->not_title) : '',
            'not_description'=>isset($req->not_description)?trim($req->not_description):'',
            'not_keywords'=>isset($req->not_keywords)?trim($req->not_keywords):'',
            'not_group' => $user->use_group,
            'not_user' => $user->use_id,
            'id_category' => 16,
            'not_degree' => 1,
            'not_detail' => trim($req->not_detail),
            'not_begindate' => time(),
            'not_enddate' => 0,
            'cat_type' => 1,
            'not_image' => $req->not_image ? $req->not_image : '',
            'not_image1' => $req->not_image1 ? $req->not_image1 : '',
            'not_image2' => $req->not_image2 ? $req->not_image2 : '',
            'not_image3' => $req->not_image3 ? $req->not_image3 : '',
            'not_image4' => $req->not_image4 ? $req->not_image4 : '',
            'not_image5' => $req->not_image5 ? $req->not_image5 : '',
            'not_image6' => $req->not_image6 ? $req->not_image6 : '',
            'not_image7' => $req->not_image7 ? $req->not_image7 : '',
            'not_image8' => $req->not_image8 ? $req->not_image8 : '',
            'imglink1'=>$req->imglink1 ? $req->imglink1:null,
            'imglink2'=>$req->imglink2 ? $req->imglink2:null,
            'imglink3'=>$req->imglink3 ? $req->imglink3:null,
            'imglink4'=>$req->imglink4 ? $req->imglink4:null,
            'imglink5'=>$req->imglink5 ? $req->imglink5:null,
            'imglink5'=>$req->imglink5 ? $req->imglink5:null,
            'imglink6'=>$req->imglink6 ? $req->imglink6:null,
            'imglink7'=>$req->imglink7 ? $req->imglink7:null,
            'imglink8'=>$req->imglink8 ? $req->imglink8:null,
            'linkdetail1' => $req->linkdetail1 ? $req->linkdetail1 : '#',
            'linkdetail2' => $req->linkdetail2 ? $req->linkdetail2 : '#',
            'linkdetail3' => $req->linkdetail3 ? $req->linkdetail3 : '#',
            'linkdetail4' => $req->linkdetail4 ? $req->linkdetail4 : '#',
            'linkdetail5' => $req->linkdetail5 ? $req->linkdetail5 : '#',
            'linkdetail6' => $req->linkdetail6 ? $req->linkdetail6 : '#',
            'linkdetail7' => $req->linkdetail7 ? $req->linkdetail7 : '#',
            'linkdetail8' => $req->linkdetail8 ? $req->linkdetail8 : '#',
            'not_dir_image' => $req->not_dir_image,
            'not_video_url' => $req->not_video_url ? $req->not_video_url : '',
            'not_video_url1' => $req->not_video_url1 ? $req->not_video_url1 : '',
            'not_status' => 1,
            'not_pro_cat_id' => $req->not_pro_cat_id ? $req->not_pro_cat_id : 0,
            'not_news_hot' => $req->not_news_hot,
            'not_news_sale' => $req->not_news_sale
        ]);
        for ($i = 1; $i < 9; $i++) {
            $content->{'imgcaption' . $i} = $req->{'imgcaption' . $i} ? $req->{'imgcaption' . $i} :"";
        }

        $content->not_publish = 1;
        try {
            $content->save();

            return response([
                'msg' => Lang::get('response.success'),
                'data' => $content
            ]);
        } catch (Exception $ex) {
            return response(['msg' => Lang::get('response.server_error')], 500);
        }
    }


    /**
     * @SWG\Put(
     *     path="/api/v1/news/{id}",
     *     operationId="updateNews",
     *     description="Cập nhật bài viết mới",
     *     produces={"application/json"},
     *     summary="Cập nhật bài viết mới",
     *     tags={"News"},
   @SWG\Parameter(
     *         name="not_description",
     *         in="body",
     *         description="Mô tả ngắn",
     *         required=true,
     *         type="string",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *      @SWG\Parameter(
     *         name="not_keywords",
     *         in="body",
     *         description="Từ khóa bài viết cách nhau dấu ,",
     *         required=false,
     *         type="string",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_image",
     *         in="body",
     *         description="image of news",
     *         required=true,
     *         type="float",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_image1",
     *         in="body",
     *         description="not_image1 of news",
     *         required=false,
     *         type="float",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_image2",
     *         in="body",
     *         description="not_image2 of news",
     *         required=false,
     *         type="float",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_image3",
     *         in="body",
     *         description="not_image3 of news",
     *         required=false,
     *         type="float",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_image4",
     *         in="body",
     *         description="not_image4 of news",
     *         required=false,
     *         type="float",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_image5",
     *         in="body",
     *         description="not_image5 of news",
     *         required=false,
     *         type="float",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="imglink1",
     *         in="body",
     *         description="imglink1 of news Đánh số từ 1 -> 6",
     *         required=false,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="linkdetail1",
     *         in="body",
     *         description="imglink1 of news Đánh số từ 1 tới 6",
     *         required=false,
     *         type="string",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_dir_image",
     *         in="body",
     *         description="dir_image of news",
     *         required=true,
     *         type="float",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_title",
     *         in="body",
     *         description="title",
     *         required=true,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_detail",
     *         in="body",
     *         description="detail, format html",
     *         required=true,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_pro_cat_id",
     *         in="body",
     *         description="pro_cat_id",
     *         required=true,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_news_hot",
     *         in="body",
     *         description="not_news_hot 0, 1",
     *         required=true,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_status",
     *         in="body",
     *         description="content active 0, 1",
     *         required=true,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_news_sale",
     *         in="body",
     *         description="not_news_sale, 0, 1",
     *         required=true,
     *         type="integer",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Parameter(
     *         name="not_video_url1",
     *         in="body",
     *         description="not_video_url1",
     *         required=false,
     *         type="string",
     *         @SWG\Schema(ref="#/definitions/News")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="success"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Not found",
     *     )
     * )
     */
    public function update($id, Request $req) {
        $content = Content::find($id);
        if (!$content) {
            return response([
                'msg' => Lang::get('response.news_not_found')
            ], 404);
        }
        $user = $req->user();

        if (!$content->checkOwner($user->use_id)) {
            return response([
                'msg' => Lang::get('response.permission_denied')
            ], 403);
        }

        $validator = Validator::make($req->all(), [
            'not_image' => 'string',
            'not_dir_image' => 'required|string',
            //'not_title' => 'required|string',
            'not_detail' => 'required|string',
            'not_pro_cat_id'=> 'integer',                 //Danh mục sản phẩm
            'not_news_hot'=> 'required|in:0,1',           //Tin tức HOT
          //  'not_status'=> 'required|in:0,1',             //Kích hoạt: 0 không, 1 có
            'not_news_sale'=> 'required|in:0,1'           //Tin khuyến mãi
        ]);

        if ($validator->fails()) {
            return response([
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $content->fill([
            'not_title' => $req->not_title ? trim($req->not_title) : '',
            'not_description'=>isset($req->not_description)?trim($req->not_description):'',
            'not_keywords'=>isset($req->not_keywords)?trim($req->not_keywords):'',
            'not_group' => $user->use_group,
            'not_user' => $user->use_id,
            'id_category' => 16,
            'not_degree' => 1,
            'not_detail' => trim($req->not_detail),
            'not_enddate' => 0,
            'cat_type' => 1,
            'not_status' => 1,
            'not_pro_cat_id' => $req->not_pro_cat_id ? $req->not_pro_cat_id : 0,
            'not_news_hot' => $req->not_news_hot,
            'not_news_sale' => $req->not_news_sale,
            'not_video_url' => $req->not_video_url ? $req->not_video_url : '',
            'not_video_url1' => $req->not_video_url1 ? $req->not_video_url1 : '',
        ]);
        if(isset($req->not_video_url)){
            $content->not_video_url = $req->not_video_url;
        }
        if (isset($req->not_image)) {
            $content->not_image = $req->not_image;
        }
        if (isset($req->not_dir_image)) {
            $content->not_dir_image = $req->not_dir_image;
        }
        for ($i = 1; $i < 9; $i++) {
            $not_image = 'not_image'.$i;
            $imgLink = 'imglink'.$i;
            $linkDetail = 'linkdetail'.$i;
            $imgcaption = 'imgcaption'.$i;
            if (isset($req->{$not_image})) {
                $content->{$not_image} = $req->{$not_image};
            }
            if (isset($req->{$imgLink})) {
                $content->{$imgLink} = $req->{$imgLink};
            }
            if (isset($req->{$linkDetail})) {
                $content->{$linkDetail} = $req->{$linkDetail};
            }
            if (isset($req->{$imgcaption})) {
                $content->{$imgcaption} = $req->{$imgcaption};
            }
        }

        try {
            $content->save();

            return response([
                'msg' => Lang::get('response.success'),
                'data' => $content
            ]);
        } catch (Exception $ex) {
            return response(['msg' => Lang::get('response.server_error')], 500);
        }
    }

    /**
     * @SWG\Delete(
     *     path="/api/v1/news/{id}",
     *     operationId="activeTrip",
     *     summary="Xóa bài viết",
     *     tags={"News"},
     *     description="Xóa bài viết",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="success"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="news not found",
     *     )
     * )
     */
    public function destroy($id, Request $req) {
        $content = Content::find($id);
        if (!$content) {
            return response([
                'msg' => Lang::get('response.news_not_found')
            ], 404);
        }

        $user = $req->user();

        if (!$content->checkOwner($user->use_id)) {
            return response([
                'msg' => Lang::get('response.permission_denied')
            ], 403);
        }

        try {
            $content->delete();

            return response([
                'msg' => Lang::get('response.success')
            ]);
        } catch (Exception $ex) {
            return response(['msg' => Lang::get('response.server_error')], 500);
        }

    }
     /**
     * @SWG\Post(
     *     path="/api/v1/news/{id}/selects",
     *     operationId="selectNews",
     *     summary="Chọn tin này",
     *     tags={"News"},
     *     description="",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="success"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="selected news not found",
     *     )
     * )
     */
    public function select($id, Request $req) {
        $data = [
            'sho_user' => $req->user()->use_id,
            'not_id' => $id
        ];
        $hasSelected = SelectNews::where($data)->count();
        if ($hasSelected > 0) {
            return response([
                'msg' => Lang::get('response.selected_news_exits')
                ], 402);
        }
        $select = new SelectNews($data);
        try {
            $select->save();
            return response([
                'msg' => Lang::get('response.success'),
                'data' => $select
            ]);
        } catch (Exception $ex) {
            return response(['msg' => Lang::get('response.server_error')], 500);
        }
    }
     /**
     * @SWG\Delete(
     *     path="/api/v1/news/{id}/selects",
     *     operationId="selectNews",
     *     summary="Xóa chọn tin này",
     *     tags={"News"},
     *     description="",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="success"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="selected news not found",
     *     )
     * )
     */
    public function unSelected($id,Request $req){
        $data = [
            'sho_user' => $req->user()->use_id,
            'not_id' => $id
        ];
        $select = SelectNews::where($data)->first();
        if (empty($select)) {
            return response([
                'msg' => Lang::get('response.selected_news_not_found')
                ], 404);
        }
        try {
            $selected = SelectNews::where('id',$select->id)->delete();
            return response([
                'msg' => Lang::get('response.success'),
                'data'=>$selected
            ]);
        } catch (Exception $ex) {
            return response(['msg' => Lang::get('response.server_error')], 500);
        }
        
    }
    /**
     * @SWG\Get(
     *     path="/api/v1/me/news",
     *     operationId="news",
     *     description="Danh sach tin đã đăng",
     *     produces={"application/json"},
     *     tags={"News"},
     *     summary="Danh sach tin đã đăng",
     *     @SWG\Parameter(
     *         name="filterBy",
     *         in="query",
     *         description="filterBy: follow, new, category, group",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="filter",
     *         in="query",
     *         description="filter",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="search",
     *         in="query",
     *         description="search",
     *         required=false,
     *         type="string",
     *     ),
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page ",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="orderBy",
     *         in="query",
     *         description="orderBy",
     *         required=false,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    public function me(Request $req){
        $query = Content::where([
                /*'not_status' => 1,*/
                'id_category' => 16,
                'not_user' => $req->user()->use_id
//            'cat_type' => 1,
               // 'not_publish' => 1       // TODO
            ])
            ->leftJoin('tbtt_user', 'use_id', 'not_user')
            ->select('tbtt_content.*', 'tbtt_user.use_fullname')
            ->orderBy('not_begindate', 'DESC');

        if ($req->filterBy == Content::FILTER_PROMOTION) {
            $query->where('not_news_sale', 1);
        } else if ($req->filterBy == Content::FILTER_HOT) {
            $query->where('not_news_hot', 1);
        } else if ($req->filterBy == Content::FILTER_CATEGORY) {
            $query->where('not_pro_cat_id', $req->filter);
        }

        if ($req->search) {
            $query->where(function($q) use ($req) {
                $q->orWhere('not_title', 'LIKE', '%' . $req->search . '%');
                $q->orWhere('not_detail', 'LIKE', '%' . $req->search . '%');
                $q->orWhere('use_fullname', 'LIKE', '%' . $req->search . '%');
            });
        }

        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

         $paginate = $query->paginate($limit, ['*'], 'page', $page);

        //populate user
        $arraysData = [];
        foreach ($paginate->items() as $value) {
            $value->populate($req->user());
            $data = $value->toArray();
            $data['user'] = $value->user->publicProfile();
            $data['user']['shop'] = $value->user->shop;
            $arraysData[] = $data;
            //$value->user->shop;
        }
        $results = $paginate->toArray();
        $results['data'] = $arraysData;
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
    }
        /**
     * @SWG\Get(
     *     path="/api/v1/news/{id}/userSelected",
     *     operationId="news",
     *     description="Danh sách người chọn tin",
     *     produces={"application/json"},
     *     tags={"News"},
     *     summary="Danh sách người chọn tin",
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page ",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    public function userSelected($id, Request $req) {
        $selecdb = (new SelectNews)->getTable();
        $userdb = (new User)->getTable();
        $query = User::where([])->join($selecdb, $selecdb . '.sho_user', $userdb . '.use_id')
            ->where($selecdb . '.not_id', $id);
        $query->orderBy($userdb . '.use_fullname', 'ASC');
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $paginate = $query->paginate($limit, ['*'], 'page', $page);
        $data = [];
        foreach ($paginate->items() as $value) {
            $data[] = $value->publicProfile();
        }
        $results = $paginate->toArray();
        $results['data'] = $data;
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $results
        ]);
    }
    
    
        /**
     * @SWG\Get(
     *     path="/api/v1/me/news-comments",
     *     operationId="news",
     *     description="Danh sách tin nhắn từ tin tức của tôi",
     *     produces={"application/json"},
     *     tags={"News"},
     *     summary="NHẬN XÉT CỦA KHÁCH HÀNG",
     *  @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="page ",
     *         required=false,
     *         type="integer",
     *     ),
     *    @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="limit ",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="public "
     *     )
     * )
     */
    
    public function listComment(Request $req) {
        $user = $req->user();
        $query = Content::where(['not_user' => $user->use_id])->rightJoin('tbtt_content_comment', 'tbtt_content_comment.noc_content', 'tbtt_content.not_id');
        $query->select('tbtt_content_comment.*', DB::raw('DATE_FORMAT(tbtt_content_comment.noc_date,"%d-%m-%Y") AS noc_date, tbtt_content.not_title, tbtt_content.not_id'));
        $query->orderBy('tbtt_content_comment.noc_date', 'desc');
        $limit = $req->limit ? (int) $req->limit : 10;
        $page = $req->page ? (int) $req->page : 0;

        $paginate = $query->paginate($limit, ['*'], 'page', $page);

        return response([
            'msg' => Lang::get('response.success'),
            'data' => $paginate
        ]);
    }
       /**
     * @SWG\Delete(
     *     path="/api/v1/me/news-comments/{id}",
     *     operationId="news",
     *     description="Xóa comment",
     *     produces={"application/json"},
     *     tags={"News"},
     *     summary="Xóa comment"
     * )
     */
    public function deleteComment($id, Request $req) {
        $user = $req->user();
        $comment = ContentComment::where('noc_id', $id)->first();
        if (empty($comment)) {
            return response([
                'msg' => Lang::get('response.not_found')
                ], 500);
        }

        $query = Content::where(['not_user' => $user->use_id, 'noc_id' => $id])->rightJoin('tbtt_content_comment', 'tbtt_content_comment.noc_content', 'tbtt_content.not_id');
        $news = $query->first();
        if (empty($news)) {
            return response([
                'msg' => Lang::get('response.not_found')
                ], 500);
        }
        $comment->delete();
        return response([
            'msg' => Lang::get('response.success'),
            'data' => $comment
        ]);
    }

    /**
     * @SWG\Put(
     *     path="/api/v1/news/{not_id}/ghim",
     *     operationId="update-permission",
     *     description="Ghim bài viết",
     *     produces={"application/json"},
     *     tags={"News"},
     *     summary="Ghim bài viết",
     *     @SWG\Parameter(
     *         name="not_id",
     *         in="path",
     *         description="Id của news",
     *         required=true,
     *         type="integer",
     *     ),
     *     @SWG\Parameter(
     *         name="not_ghim",
     *         in="body",
     *         description="0: unghim, 1: ghim",
     *         required=false,
     *         type="integer",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Danh sách quyền"
     *     )
     * )
     */
    public function ghimNew($not_id, Request $req) {
        $new = Content::find($not_id);
        if (!$new) {
            return response([
                'msg' => Lang::get('response.news_not_found')
            ], 404);
        }

        if (!$new->hasPermission($req->user(), true)) {
            return response([
                'msg' => Lang::get('response.permission_denied')
            ], 400);
        }

        $new->not_ghim = $req->not_ghim;

        $new->save();
        return response([
            'msg' => Lang::get('response.success')
        ]);
    }
}
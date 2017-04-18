<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiArticleController extends Controller
{
    public $articleLimit = 15;
//    public $commentLimit = 20;

    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return [
            'id' => $article->id,
            'original_id' => $article->original_id,
            'original_user'=> $article->original->user,
            'user' => $article->user,
//            'original_user_id' => $article->original->user->id,
//            'original_user_name' => $article->original->user->name,
//            'original_user_avatar' => $article->original->user->avatar,
//            'user_id' => $article->updated_by,
//            'user_name' => $article->user->name,
//            'user_avatar' => $article->user->avatar,
//            'user_airport' => $article->user->profile->airport,
            'content' => $article->content,
            'update_at' => $article->updated_at,
            'total_comments' => count($article->comments),
            'forwarded' => count($article->forwarded),
            'favorited' => count($article->favorited),
            'resources' => $article->mediaResources->take(4),
                'comments' => $this->loadComments($article->id, 1, 0, 2),
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function followingActivities(Request $request) {
        $lastid = $request['lastid'];
        $from = ($request['page'] -1) * $this->articleLimit;
        $articles = Article::join('user_relations', 'user_relations.relation_id', '=', 'articles.created_by')
//            ->leftJoin('users', 'users.id', '=', 'articles.updated_by')
//            ->leftJoin('users', 'users.id', '=', 'articles.original_id')
            ->select('articles.*')
            ->where('user_relations.user_id', $request['userid'])
            ->orWhere('articles.created_by', $request['userid'])
            ->where('status', '1');
        if($lastid && $lastid > 0)
            $articles = $articles->where('articles.id', '<=', $lastid);

             $articles = $articles->orderBy('articles.updated_at', 'desc')
                ->skip($from)
                ->take($this->articleLimit)
                ->get();
        $acitivities = array();
        foreach ($articles as $article) {
            array_push($acitivities, [
                'id' => $article->id,
                'original_id' => $article->original_id,
                'user' => $article->user,
//                'original_user_id' => $article->original->user->id,
//                'original_user_name' => $article->original->user->name,
//                'original_user_avatar' => $article->original->user->avatar,
//                'user_id' => $article->updated_by,
//                'user_name' => $article->user->name,
//                'user_avatar' => $article->user->avatar,
                'content' => $article->content,
                'update_at' => $article->updated_at,
                'total_comments' => count($article->comments),
                'forwarded' => count($article->forwarded),
                'favorited' => count($article->favorited),
                'thumb' => $article->mediaResources->first()['url'],
//                'comments' => $this->loadComments($article->id, 1, 0),
            ]);
        }
        return $acitivities;
    }

    public function loadComments($id, $page, $lastid, $limit = 20) {
        $from = ($page -1) * $limit;
        $comments = Comment::where('article_id', $id)
                        ->leftJoin('users', 'users.id', '=', 'comments.updated_by')
                        ->select('comments.*', 'users.name', 'users.avatar');
        if($lastid && $lastid > 0)
            $comments = $comments->where('comments.id', '<=', $lastid);
        $comments = $comments->skip($from)->take($limit)->get();
        return $comments;
    }
}

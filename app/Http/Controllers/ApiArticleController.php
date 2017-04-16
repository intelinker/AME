<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiArticleController extends Controller
{
    public $articleLimit = 15;
    public $commentLimit = 20;

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
        return $article;
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
                'original_name' => $article->original->name,
                'user_id' => $article->updated_by,
                'user_name' => $article->user->name,
                'content' => $article->content,
                'update_at' => $article->updated_at,
                'total_comments' => count($article->comments),
                'forwarded' => count($article->forwarded),
                'favorited' => count($article->favorited),
                'avatar' => $article->user->avatar,
                'thumb' => $article->mediaResources->first()['url'],
//                'comments' => $this->loadComments($article->id, 1, 0),
            ]);
        }
        return $acitivities;
    }

    public function loadComments($id, $page, $lastid) {
        $from = ($page -1) * $this->commentLimit;
        $comments = Comment::where('article_id', $id)
                        ->leftJoin('users', 'users.id', '=', 'comments.updated_by')
                        ->select('comments.*', 'users.name', 'users.avatar');
        if($lastid && $lastid > 0)
            $comments = $comments->where('comments.id', '<=', $lastid);
        $comments = $comments->skip($from)->take($this->commentLimit)->get();
        return $comments;
    }
}

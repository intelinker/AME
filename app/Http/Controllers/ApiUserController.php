<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Setup;
use App\User;
use App\UserRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class ApiUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request);
        $email = $request['email'];
        if(count(User::where('email', $email)->first()))
            return ['result' => 'exist'];
        $user = new User();
        $user->name = $request['name'];
        $user->password = bcrypt($request['password']);
        $user->uid = $request['uid'];
//        $user->remember_token = $request['_token'];
        $user->email = $request['email'];
        $user->avatar = '/media/users/avatar.jpg';
        $user->cover = '/media/users/cover.jpg';
        $user->save();
        $profile = new Profile();
        $profile->user_id=$user->id;
        $profile->save();
        $setup = new Setup();
        $setup->user_id = $user->id;
        $setup->save();
        return ['result'=>'success', 'user'=>$user];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $result = [
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar,
            'cover' =>$user->cover,
            'is_person' => $user->is_person,
            'self_intro' => $user->profile ? $user->profile->self_intro : '',
            'title' => $user->profile && $user->profile->title ? $user->profile->title->name : '',
            'position' => $user->profile && $user->profile->position ? $user->profile->position->positon : '',
            'airport' =>$user->airport,
            'following' => count($user->relation),
            'followed' => count($user->related),
            'uid' => $user->uid,
//            'relation' => $user->relation,
        ];
//        if($user->profile && $user->profile->title) {
//            $result['user']['title'] =  $user->profile->title->name;
////                array_merge($result['user'],  ['title' => $user->profile->title->name]);
//        }
//        if($user->profile && $user->profile->position) {
//            $result['user']['position'] =  $user->profile->position-->name;
////                array_merge($result['user'],  ['title' => $user->profile->position->name]);
//        }
        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    public function mailCaptcha(Request $request) {
        $user = User::where('email', $request['email'])->get();
        if(count($user)) {
            return [
              'result'=>'exist',
            ];
        }
        $data = ['mail'=>$request['email'], 'name'=>$request['name'], 'uid'=>$request['uid'], 'captcha'=>random_int(100000, 999999)];
//        dd($data);
        Mail::send('user.activemail', $data, function($message) use($data)
        {
//            $captcha = random_int(100000, 999999);

            $message->to($data['mail'])->subject('Welcom register AME!');


        });
        return ['captcha' => $data['captcha'],
            'result' => 'success',];
    }

    public function signin(Request $request) {
//        dd($request->all());
        $email = $request['email'];
        $user = User::where('email', $email)->first();
//        dd($user->email);
//        if(count($user) && $user->password==bcrypt($request['password']))
        if(Auth::attempt([
            'email' => $email,
            'password' => $request['password'],

        ])) {
            $result = ['result'=>'success', 'user'=>[
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar,
                'cover' =>$user->cover,
                'is_person' => $user->is_person,
                'self_intro' => $user->profile->self_intro,
                'airport' =>$user->airport,
                'title' => $user->profile && $user->profile->title ? $user->profile->title->name : '',
                'position' => $user->profile && $user->profile->position ? $user->profile->position->positon : '',
                'following' => count($user->relation),
                'followed' => count($user->related),
                'uid' => $user->uid,
            ]];
//            if($user->profile && $user->profile->title) {
//                $result['user']['title'] =  $user->profile->title->name;
////                array_merge($result['user'],  ['title' => $user->profile->title->name]);
//            }
//            if($user->profile && $user->profile->position) {
//                $result['user']['position'] =  $user->profile->position-->name;
////                array_merge($result['user'],  ['title' => $user->profile->position->name]);
//            }
            return $result;
        }

        return ['result' => 'error'];
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }

    public function setavatar(Request $request) {
        $userID = $request['userid'];
        $file = $request->file('avatar');
        $destPath='media/users/'.$userID.'/avatar/';
        // Create target dir
        if (!file_exists($destPath)) {
            @mkdir($destPath );
        }
        $filename = str_replace([' ', ':'], ['', ''], $userID.'_'.time().$file->getClientOriginalName());
        $filePath = $destPath.$filename;
        $thumbPath = $destPath.'thumb_'.$filename;
        $file->move($destPath, $filename);
        $imageSize = GetImageSize($filePath);
        // resizing an uploaded file
        Image::make($filePath)->resize(80, (int)((80 * $imageSize[1]) / $imageSize[0]))->save($thumbPath);
//        Image::make($filePath)->fit(80)->save();
        $user = User::find($userID);
        $user->avatar = $filePath;
        $user->save();
        return [
            'result'=>'success',
            'avatar'=>$filePath,
        ];
    }

    public function setcover(Request $request) {
        $userID = $request['userid'];
        $file = $request->file('cover');
        $destPath='media/users/'.$userID.'/cover/';
        // Create target dir
        if (!file_exists($destPath)) {
            @mkdir($destPath );
        }

        $filename = str_replace([' ', ':'], ['', ''], $userID.'_'.time().$file->getClientOriginalName());
        $filePath = $destPath.$filename;
        $thumbPath = $destPath.'thumb_'.$filename;
        $file->move($destPath, $filename);
        $imageSize = GetImageSize($filePath);
        // resizing an uploaded file
        Image::make($filePath)->resize(320, (int)((320 * $imageSize[1]) / $imageSize[0]))->save($thumbPath);
        $user = User::find($userID);
        $user->cover = $filePath;
        $user->save();
        return [
            'result'=>'success',
            'cover'=>$filePath,
        ];
    }

    public function selfintro(Request $request) {
        $user = User::findOrFail($request['userid']);
        $user->profile->self_intro = $request['selfintro'];
        $user->profile->save();
        return ['result'=>'success'];
    }

    public function relationUser(Request $request) {
        $userid = $request['userid'];
        $relationid = $request['relationid'];
        $user = User::findOrFail($relationid);
        $relation = UserRelation::select('relation_type')
            ->where('user_id', $userid)
            ->where('relation_id', $relationid)
            ->first();
        $result = [
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar,
            'cover' =>$user->cover,
            'is_person' => $user->is_person,
            'self_intro' => $user->profile ? $user->profile->self_intro : '',
            'title' => $user->profile && $user->profile->title ? $user->profile->title->name : '',
            'position' => $user->profile && $user->profile->position ? $user->profile->position->positon : '',
            'airport' =>$user->airport,
            'following' => count($user->relation),
            'followed' => count($user->related),
            'uid' => $user->uid,
            'relation' => $relation ? $relation['relation_type'] : 1,

        ];
        return $result;
    }

    public function setRelation(Request $request) {
        $userid = $request['userid'];
        $relationid = $request['relationid'];
        $type = $request['type'];
        $relation = UserRelation::select('id', 'relation_type')
            ->where('user_id', $userid)
            ->where('relation_id', $relationid)
            ->first();
        if($relation) {
            $relation = UserRelation::where('id', $relation->id)->update([
                'relation_type' => $type,
            ]);
        } else {
            $relation = UserRelation::create([
               'user_id' => $userid,
                'relation_id' => $relationid,
                'relation_type' => $type,
            ]);
        }
        return ['result' => $relation];
    }
}

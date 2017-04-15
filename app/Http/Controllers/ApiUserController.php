<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Setup;
use App\User;
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
        return [
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar,
            'cover' =>$user->cover,
            'is_person' => $user->is_person,
            'self_intro' => $user->profile->self_intro,
            'title' => $user->profile->title,
            'position' => $user->profile->position,
            'airport' =>$user->profile->airport,
            'following' => count($user->relation),
            'followed' => count($user->related),
            'uid' => $user->uid,
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

        ]))
            return ['result'=>'success', 'user'=>[
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar,
                'cover' =>$user->cover,
                'is_person' => $user->is_person,
                'self_intro' => $user->profile->self_intro,
                'title' => $user->profile->title,
                'position' => $user->profile->position,
                'airport' =>$user->profile->airport,
                'following' => count($user->relation),
                'followed' => count($user->related),
                'uid' => $user->uid,
            ]];
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
        $filename = trim($userID.'_'.time().$file->getClientOriginalName(), ' ');
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

}

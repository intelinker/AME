<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        $user = new User();
        $user->name = $request['name'];
        $user->password = bcrypt($request['password']);
//        $user->remember_token = $request['_token'];
        $user->phone = $request['phone'];
        $user->avatar= '/images/avatar.png';
        $user->save();
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $user = User::where('mail', $request['mail'])->get();
        if(count($user)) {
            return [
              'result'=>'exist',
            ];
        }
        $data = ['mail'=>$request['mail'], 'name'=>$request['name'], 'uid'=>$request['uid'], 'captcha'=>random_int(100000, 999999)];
//        dd($data);
        Mail::send('user.activemail', $data, function($message) use($data)
        {
//            $captcha = random_int(100000, 999999);

            $message->to($data['mail'])->subject('Welcom register AME!');


        });
        return ['captcha' => $data['captcha'],
            'result' => 'success',];
    }
}

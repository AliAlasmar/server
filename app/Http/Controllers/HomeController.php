<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Events\NewNotification;
use App\Jobs\sendMails;
use App\Mail\TestMail;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = Post::with(['users','comments'])->get();
      //  return $data;


        return view('home',compact('data'));
    }

    public function comment_save(Request $request){
        //return Auth::user()->id;
        Comment::create([
            'post_id'=> $request->post_id,
             'user_id'=>Auth::user()->id ,
             'comment'=> $request->post_content,
        ]);

        $data=[
            'post_id'=> $request->post_id,
            'user_id'=>Auth::user()->id ,
            'comment'=> $request->post_content,
        ];

        event(new NewNotification($data));
        return redirect()->back()->with(['success'=>'تم اضافة تعليقك بنجاح']);
    }


public function send_mails(){
        $emails = User::chunk(50,function ($data){
           dispatch(new sendMails($data));
        });
   // $emails = User::select('email')->get();
   // return $emails;
    //foreach ($emails as $email){
      //  Mail::to($email->email)->send(new TestMail());
    //}
    return "the message is sended in backgroud";

}

}

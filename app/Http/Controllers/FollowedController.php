<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Follow;
use App\News;
use Mail;
class FollowedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $news = News::get();
            $content = "";
            foreach ($news as $new) {
                $content = $content . $new->title . '-' .url('page/news/'.$new->slug);
            }
            
            $follows = Follow::where('status',1)->get();
            $emails = [];
            foreach ($follows as $value) {
                array_push($emails, $value->email);
            }
            Mail::send('view.mail_form', array('name'=>"abc",'email'=>"email", 'content'=> $content), 
            function($message) use ($emails)
            {    
                $message->to($emails)->subject('Bài viết mới có thể bạn quan tâm');    
            });
        return $content;
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
         $request->validate([
            'email'                => 'required',
        ]);

        Follow::create([
            'email'   => $request->email,
            'status'  => 1
        ]);

        return redirect()->back()->with(['message' => 'successfully!']);
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
}

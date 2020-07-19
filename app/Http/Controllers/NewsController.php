<?php

namespace App\Http\Controllers;

use App\News;
use App\Category;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function index()
    {
        $newslist = News::with('category')->latest()->get();

        return view('backend.news.index', compact('newslist'));
    }


    public function create()
    {
        $categories = Category::latest()->select('id','name')->where('status',1)->get();

        return view('backend.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|unique:news|max:255',
            'details'       => 'required',
            'category_id'   => 'required',
            'image'         => 'required|image|mimes:jpg,png,jpeg',
            'work_address'  => 'required',
            'deadline_for_sub'  => 'required',
            'salary'  => 'required',
            'emp_total'  => 'required',

        ]);

        if(isset($request->status)){
            $status = true;
        }else{
            $status = false;
        }

        if(isset($request->featured)){
            $featured = true;
        }else{
            $featured = false;
        }

        if ($request->hasFile('image')) {
            $imageName = 'news-'.time().uniqid().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
        }

        News::create([
            'title'         => $request->title,
            'slug'          => str_slug($request->title),
            'details'       => $request->details,
            'category_id'   => $request->category_id,
            'image'         => $imageName,
            'status'        => $status,
            'featured'      => $featured
        ]);

        return redirect()->route('admin.news.index')->with(['message' => 'Tạo thành công!']);
    }


    public function show(News $news)
    {
        //
    }


    public function edit(News $news)
    {
        $categories = Category::latest()->select('id','name')->where('status',1)->get();
        $news       = News::findOrFail($news->id);

        return view('backend.news.edit', compact('categories','news'));
    }


    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'         => 'required|max:255',
            'details'       => 'required',
            'category_id'   => 'required',
            'image'         => 'image|mimes:jpg,png,jpeg',
            'work_address'  => 'required',
            'deadline_for_sub'  => 'required',
            'salary'  => 'required',
            'emp_total'  => 'required',
        ]);

        if(isset($request->status)){
            $status = true;
        }else{
            $status = false;
        }

        if(isset($request->featured)){
            $featured = true;
        }else{
            $featured = false;
        }

        $news = News::findOrFail($news->id);

        if ($request->hasFile('image')) {

            if(file_exists(public_path('images/') . $news->image)){
                unlink(public_path('images/') . $news->image);
            }

            $imageName = 'news-'.time().uniqid().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);

        }else{
            $imageName = $news->image;
        }

        $news->update([
            'title'         => $request->title,
            'slug'          => str_slug($request->title),
            'details'       => $request->details,
            'category_id'   => $request->category_id,
            'image'         => $imageName,
            'status'        => $status,
            'featured'      => $featured
        ]);

        return redirect()->route('admin.news.index')->with(['message' => 'Chỉnh sửa thành công!']);
    }


    public function destroy(News $news)
    {
        $news = News::findOrFail($news->id);

        if(file_exists(public_path('images/') . $news->image)){
            unlink(public_path('images/') . $news->image);
        }

        $news->delete();

        return back()->with(['message' => 'Xóa thành công!']);
    }
}

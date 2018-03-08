<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\user\Post;
use App\Model\user\Tag;
use App\Model\user\Category;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
    {
        $this->middleware('auth:admin');
    }
   
    public function index()
    {
        $postData = Post::get();
        return view('admin.post.show')->with('postData', $postData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::get();

        $categories = Category::get();

        return view('admin.post.post')->with(compact('tags','categories'));
       
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

            'posttitle' => 'required',
            'postsubtitle'=> 'required',
            'postslug'=> 'required',
            'image'=> 'required|mimes:jpeg,jpg,bmp,png|max:7120',
            'body'=> 'required',
            'posttag' => 'required',
            'postcategory' => 'required'
        ]);

        // $input = [

        //     'title' => $request->posttitle,
        //     'subtitle' => $request->postsubtitle,
        //     'slug' => $request->postslug,
        //     'body' => $request->body,
        //     'image' => $request->image
        // ];
        // $post->create($input);
        // $post->tags()->sync($request->posttag)->create();
        // $post->categories()->sync($request->postcategory)->create();

        if($request->hasFile('image'))
        {
            $imageName = $request->image->store('public');
        }
        $post = new Post;
        $post->image = $imageName;
        $post->title=$request->posttitle;
        $post->subtitle=$request->postsubtitle;
        $post->slug=$request->postslug;
        $post->body=$request->body;
        $post->status=$request->status;
        $post->save();
        $post->tags()->sync($request->posttag);
        $post->categories()->sync($request->postcategory);


        return redirect('admin/post');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $tags = Tag::get();
        $categories = Category::get();
        $data =  Post::with('tags','categories')->where('id', $id)->first();


        return view('admin.post.edit')->with(compact('tags','categories','data'));
       

       return view('admin.post.edit')->with('data', $allpostyData);
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


        $request->validate([

            'posttitle' => 'required',
            'postsubtitle'=> 'required',
            'postslug'=> 'required',
            'body'=> 'required',
            'posttag' => 'required',
            'postcategory' => 'required',
            'image'=> 'required|mimes:jpeg,jpg,bmp,png|max:7120',

        ]);

       /* $input = [

            'title' => $request->posttitle,
            'subtitle' => $request->postsubtitle,
            'slug' => $request->postslug,
            'body' => $request->body,
            'image' => $request->image,
            'status' =>$request->status
        ];*/
         // Post::where('id', $id)->update($input);

        if($request->hasFile('image'))
        {
            $imageName = $request->image->store('public');
        }

        $post = Post::find($id);
       
        $post->title = $request->posttitle;
        $post->subtitle = $request->postsubtitle;
        $post->slug = $request->postslug;
        $post->body = $request->body;
        $post->image = $imageName;
        $post->status = $request->status;
        $post->save();

        $post->tags()->sync($request->posttag);
        $post->categories()->sync($request->postcategory);

        // Tag::create($tags);
        // Category::create($category);

       
        return redirect('admin/post');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        post::where('id',$id)->delete();
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\user\Post;
use App\Model\user\Tag;
use App\Model\user\Category;

class HomeController extends Controller
{
   public function index()
   {
   		$posts = Post::where('status',1)->orderBy('created_at','DESC')->paginate(2);
   		return view('user.blog')->with('posts',$posts);
   }

   public function tags(Tag $tag)
   {
   	     $posts =  $tag->posts();
   		return view('user.blog')->with('posts',$posts);
   }

    public function category(Category $category)
   {
   		$posts =  $category->posts();
   		return view('user.blog')->with('posts',$posts);

   }
}

<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\user\Post;

class PostController extends Controller
{
     public function post(Post $post)
   {

   		return view('user.post')->with('posts',$post);
   }
}

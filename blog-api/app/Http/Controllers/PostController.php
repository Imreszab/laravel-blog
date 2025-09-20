<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class PostController extends Controller
{
    use HttpResponses;

    public function index() {
        return PostResource::collection(
            Post::all()
        );
    }

   public function store(StorePostRequest $request) {
       $request->validated();

       $post = Post::create([
           'user_id' => Auth::user()->id,
           'title' => $request->title,
           'content' => $request->content,
       ]);

       return new PostResource($post);
      
   }

   public function show(Post $post) {
       return new PostResource($post);
   }

   public function update(Request $request, Post $post) {
       if($this->isNotAuthorized($post)) {
         return $this->isNotAuthorized($post);
       }else {
        $post->update($request->all());
       
        return new PostResource($post);

       }
   }

   public function destroy (Post $post) {

        if($this->isNotAuthorized($post)) {
            return $this->isNotAuthorized($post);
        }else {
            $post->delete();
       
            return $this->success('', 'Successfully deleted the Post', 200);

        }
   }


   public function isNotAuthorized($post) {
        if(Auth::user()->id !== $post->user_id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }
    }
}
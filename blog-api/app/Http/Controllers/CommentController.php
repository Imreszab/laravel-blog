<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use HttpResponses;

    public function store(CommentRequest $request)
    {
        $request->validated();
        $post = Comment::create([
           'user_id' => Auth::user()->id,
           'post_id' => $request->post_id,
           'comment' => $request->comment,
       ]);

       return new CommentResource($post);
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        if($this->isOwner($comment)) {
            return $this->isOwner($comment);
        }

        $request->validated();
        $comment->update($request->all());

        return new CommentResource($comment);
    }

    public function destroy(Comment $comment)
    {
        if($this->isOwner($comment) || $this->isPostOwner($comment)) {
             return $this->error('', 'You are not authorized to make this request', 403);
        }
        
        $comment->delete();
        return $this->success('', 'Successfully deleted the Comment', 200);
    }

    public function isOwner($comment) {
        if(Auth::user()->id !== $comment->user_id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }
    }

    public function isPostOwner($comment) {
        if(Auth::user()->id !== $comment->post->user_id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }
    }
}

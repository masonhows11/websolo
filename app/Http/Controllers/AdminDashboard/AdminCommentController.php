<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Sample;
use Illuminate\Http\Request;

class AdminCommentController extends Controller
{
    //
    public function articles()
    {
        return view('dash.admin_comment.articles')
            ->with(['articles' => Article::paginate(12)]);
    }

    public function samples()
    {
        return view('dash.admin_comment.samples')
            ->with(['samples' => Sample::paginate(12)]);
    }

    public function articleComments(Article $article)
    {

        return view('dash.admin_comment.article_comments')
            ->with(['article' => $article]);
    }

    public function sampleComments(Sample $sample)
    {
        return view('dash.admin_comment.sample_comments')
            ->with(['sample' => $sample]);
    }

    public function approveArticleComment(Request $request)
    {


        try {
            $comment = Comment::findOrFail($request->id);

            if ($comment->approved == 0) {
                $comment->approved = 1;
            } elseif ($comment->approved == 1) {
                $comment->approved = 0;
            }
            $comment->save();
            return response()->json(['message' => 'وضعیت دیدگاه بروز رسانی شد.', 'publish' => $comment->approved, 'status' => 200], 200);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'دیدگاه مورد نظر وجود ندارد.', 'status' => 404], 200);
        }
    }

    public function deleteArticleComment(Request $request)
    {

        try {
            $comment = Comment::findOrFail($request->id);
            $comment->delete();
            return response()
                ->json(['message' => 'رکورد مورد نظر با موفقیت حذف شد.', 'status' => 200], 200);
        } catch (\Exception $ex) {
            return response()
                ->json(['message' => 'رکورد مورد نظر وجود ندارد.', 'status' => 404], 200);
        }
    }

    public function approveSampleComment(Request $request)
    {
        $comment = Comment::findOrFail($request->id);
        try {
            if ($comment->approved == 0) {
                $comment->approved = 1;
            } elseif ($comment->approved == 1) {
                $comment->approved = 0;
            }
            $comment->save();
            return response()->json(['message' => 'وضعیت دیدگاه بروز رسانی شد.', 'publish' => $comment->approved, 'status' => 200], 200);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'دیدگاه مورد نظر وجود ندارد.', 'status' => 404], 200);
        }
    }

    public function deleteSampleComment(Request $request)
    {
        try {
            $comment = Comment::findOrFail($request->id);
            $comment->delete();
            return response()
                ->json(['message' => 'رکورد مورد نظر با موفقیت حذف شد.', 'status' => 200], 200);
        } catch (\Exception $ex) {
            return response()
                ->json(['message' => 'رکورد مورد نظر وجود ندارد.', 'status' => 404], 200);
        }
    }
}

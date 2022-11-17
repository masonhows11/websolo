<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //
    public function index(Tag $tag)
    {


        return view('front.article.article_by_category')
            ->with(['articles'=>$tag->articles()->paginate(12),
                'categories'=>Category::tree()->get()->toTree()]);
    }
}

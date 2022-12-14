<?php

namespace App\Http\Livewire;

use App\Models\Like;
use App\Models\Sample;
use Livewire\Component;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class FrontSample extends Component
{
    public $sample;
    public $body;
    public $is_like;
    public $like_count;
    public $like_color;
    public $current_like_status;
    public $auth_id;

    public function mount(Sample $sample)
    {
        $sample->views++;
        $sample->save();
        $this->auth_id = Auth::id();
        $this->sample = $sample;
        $this->like_count = Like::where('sample_id', $this->sample->id)->count();
        $this->current_like_status = Like::where('sample_id', '=', $sample->id)
            ->where('user_id', '=', $this->auth_id)
            ->exists();
        $this->like_color = 'color:tomato';

    }

    public function addLike($id)
    {
        if (Auth::check()) {
            $this->is_like = true;
            $user_is_liked = Like::where('sample_id', '=', $id)
                ->where('user_id', '=', $this->auth_id)
                ->first();
            if ($user_is_liked) {
                $user_is_liked->delete();
                $this->like_count--;
                $this->current_like_status = false;
                $this->like_color = null;
            } else {
                $newLike = new Like();
                $newLike->user_id = $this->auth_id;
                $newLike->sample_id = $this->sample->id;
                $newLike->like = $this->is_like;
                $newLike->save();
                $this->like_count++;
                $this->current_like_status = true;
                $this->like_color = 'color:tomato';
            }
        } else {
            return redirect('/loginForm');
        }

    }

    protected $rules = [
        'body' => 'required|min:6',
    ];
    protected $messages = [
        'body.required' => 'متن دیدگاه را وارد کنید.',
        'body.min' => 'حداقل ۶ کارکتر وارد کنید.',
    ];

    public function submit()
    {
        $this->validate();
        Comment::create([
            'user_id' => $this->auth_id,
            'sample_id' => $this->sample->id,
            'body' => $this->body,
        ]);
        $this->body = null;
        session()->flash('message', 'دیدگاه شما با موفقیت ثبت شد.');
    }

    public function render()
    {
        return view('livewire.front-sample')
            ->extends('front.include.master')
            ->section('main_content')
            ->with(['sample' => $this->sample]);
    }
}

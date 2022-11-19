<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserAvatar extends Component
{
    use WithFileUploads;
    public $avatar;

    public function mount(){

    }

    public function save()
    {
        $image_name_save = 'UIMG' . date('YmdHis') . uniqid('', true) . '.jpg';
        $this->avatar->storeAs('users', $image_name_save,'public');

        // delete old image if exists
        $user = User::findOrFail(Auth::id());
        if ( $user->image_path != null) {
            if (Storage::disk('public')->exists('users/' . $user->image_path)) {
                Storage::disk('public')->delete('users/' . $user->image_path);
            }
        }
        User::where('id', Auth::id())
            ->update(['image_path' => $image_name_save]);
    }

    public function render()
    {
        return view('livewire.user-avatar');
    }
}

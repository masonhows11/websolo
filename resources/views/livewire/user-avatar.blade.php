<div>
    <div class="col-lg-6 user-avatar d-flex flex-column justify-content-center ">
        <div class="user-img">
            @php
                $user = \Illuminate\Support\Facades\Auth::user();
            @endphp
            <img src="{{ $user->image_path ?  asset('storage/users/'.$user->image_path)  : asset('images/users/no-image-icon-23494.png') }}"
                 class="rounded avatar-previewer" alt="user-avatar">
        </div>
        <div class="user-name">
            <p class="text-center">{{ $user->name }}</p>
            <p class="text-center">{{ $user->first_name }} {{ $user->last_name }} </p>
        </div>
        <div class="d-flex my-2 userAvatarFile justify-content-center">
            <form wire:submit.prevent="save">
                <label for="avatarFile">
                    آپلود عکس
                    <input type="file" class="btn btn-info" name="avatarFile" wire:model="avatar">
                </label>
            </form>

        </div>
    </div>
</div>

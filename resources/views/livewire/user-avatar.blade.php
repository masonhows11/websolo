<div>
    <div class="row user-avatar d-flex flex-column">

        <div class="user-img mt-2 d-flex justify-content-center">
            <img src="{{ $user->image_path ?  asset('storage/users/'.$user->image_path)  : asset('images/users/no-image-icon-23494.png') }}"
                 class="rounded avatar-previewer" alt="user-avatar">
        </div>

        <div class="user-name">
            <p class="text-center">{{ $user->name }}</p>
            <p class="text-center">{{ $user->first_name }} {{ $user->last_name }} </p>
        </div>

        <div class="d-flex justify-content-center my-2 userAvatarFile">
            <form wire:submit.prevent="save">
                <label for="avatarFile">
                    آپلود عکس
                    <input type="file" class="btn btn-info" name="avatarFile" wire:model="avatar">
                </label>
            </form>
        </div>

    </div>
</div>

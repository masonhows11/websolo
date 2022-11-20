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
                <div class="mx-2">
                    <label for="avatarFile">
                        انتخاب عکس
                    </label>
                    <input type="file" class="btn" name="avatarFile" wire:model="avatar">
                </div>
                <div class="mx-2">
                    <button type="submit">آپلود عکس</button>
                </div>

                @error('avatar')
                <span class="alert alert-danger">
                    {{ $message }}
                </span>
                @enderror
            </form>
        </div>

    </div>
</div>

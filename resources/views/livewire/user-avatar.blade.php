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


            <form wire:submit.prevent="save">
                <div class="d-flex  flex-column my-2 userAvatarFile">

                <div class="my-2 mx-auto" style="width: 100px">
                    <label for="avatarFile" class="text-center">
                        انتخاب عکس
                    </label>
                    <input type="file" class="" style="width: 100px;" name="avatarFile" wire:model="avatar">
                </div>

                <div class="mx-auto my-2">
                    <button type="submit">آپلود عکس</button>
                </div>

                @error('avatar')
                <span class="alert alert-danger">
                    {{ $message }}
                </span>
                @enderror
                </div>
            </form>


    </div>
</div>

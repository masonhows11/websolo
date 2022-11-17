@extends('front.include.master_auth')
@section('page_title')
    ورود
@endsection
@section('main_content')
    <div class="container login-form">
        <div class="alert-section mt-2">
            @include('front.include.alert')
        </div>
         <div class="row d-flex justify-content-center py-5">
             <div class="col-xl-5 col-lg-6 col-md-6">
                 <form action="{{ route('login') }}" method="post">
                     @csrf
                     <div class="mb-3 mt-3">
                         <label for="email" class="form-label">ایمیل</label>
                         <input type="email" class="@error('email') is-invalid @enderror form-control" id="email"  name="email">
                     </div>
                     @error('email')
                     <div class="alert alert-danger">{{ $message }}</div>
                     @enderror

                     <div class="mb-3">
                         <label for="pwd" class="form-label">رمز عبور</label>
                         <input type="password" class="@error('password') is-invalid @enderror form-control" id="pwd"  name="password">
                     </div>
                     @error('password')
                     <div class="alert alert-danger">{{ $message }}</div>
                     @enderror

                     <div class="form-check mb-3">
                         <label class="form-check-label">
                             <input class="form-check-input" type="checkbox" name="remember"> منو فراموش نکن !
                         </label>
                     </div>
                     <button type="submit" class="btn btn-login w3-flat-alizarin rounded-3">ورود</button>
                 </form>
             </div>

         </div>


    </div>
@endsection

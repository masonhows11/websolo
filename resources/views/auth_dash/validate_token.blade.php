@extends('auth_dash.master_auth')
@section('auth_admin_title')
    پنل مدیریت
@endsection
@section('main_content')
    <div class="container">

        <div class="row d-flex justify-content-center">
            <div class="col-lg-10 col-md-10 my-2 alert-dive ">
                @include('auth_dash.alert')
            </div>
        </div>

        <div class="row validate-mobile-admin-form">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
              {{--  <img alt="Logo" src="#" class="logo-login my-5"/>--}}
                <h3 class="logo-login my-5">وب سولو</h3>
                <div class="w-lg-500px bg-white rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <form action="{{ route('validateMobile') }}" method="post" class="form w-100" novalidate="novalidate" id="kt_sign_in_form">
                        @csrf

                        @if(session()->exists('admin_mobile'))
                            <input type="hidden" name="mobile" id="mobile"
                                   value="{{   session()->get('admin_mobile')  }}">
                        @endif

                        <div class="text-center mb-10">
                            <h1 class="text-dark mb-3">ورود به پنل مدیریت</h1>
                        </div>

                        <div class="fv-row mb-10">
                            <div class="d-flex flex-stack">
                                <label class="form-label fs-6 fw-bolder text-dark" for="token">کد فعال سازی</label>
                                <a href="#" id="resend_token" onclick="startTimer()" class="link-primary fs-6 fw-bolder">ارسال مجدد کد</a>
                                <a id="timer" class="timer"></a>
                            </div>

                            <input class="form-control form-control-lg form-control-solid" id="token" type="text"
                                   name="token" autocomplete="off"/>
                            @error('token')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="fv-row mb-10">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember"> من را به خاطر بسپار !
                            </label>
                        </div>

                        <div class="text-center">
                            <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                                <span class="indicator-label">ورود</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom_scripts')
    <script>
        let counter = 0;
        let remainingSeconds = 0;
        let timer = document.getElementById('timer');
        let resend = document.getElementById('resend_token');
        let timerInterval;
        function displayTime(s) {
            let min = Math.floor(s / 60);
            let sec = s % 60;
            return min.toString().padStart(2, "0") + ':' + sec.toString().padStart(2, "0");
        }
        // default timer div element display in none
        timer.style.display = 'none';
        // for display timer in timer div element
        timer.innerHTML = (displayTime(remainingSeconds - counter)).toString();
        function startTimer() {
            resend.style.display = 'none';
            timer.style.display = 'block';
            remainingSeconds = 60;
            timerInterval = setInterval(() => {
                counter++;
                timer.innerHTML = (displayTime(remainingSeconds - counter)).toString();
                if (counter === remainingSeconds) {
                    // for stop the timer if counter & timeLeft is equal
                    clearInterval(timerInterval);
                    counter = 0;
                    timer.style.display = 'none';
                    resend.style.display = 'block';
                }
            }, 1000);
        }


        $(document).on('click', '#resend_token', function (event) {
            event.preventDefault();
            let number = document.getElementById('mobile').value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: 'POST',
                url: '{{ route('adminResendToken') }}',
                data: {number: number}
            }).done(function (data) {
                if (data['status'] === 200) {
                    Toastify({
                        text:data['success'],
                        duration:3000,
                        gravity: "top",
                        position: "center",
                        stopOnFocus: true,
                        style:{
                            background:"linear-gradient(to right, #00b09b, #96c93d)",
                        }
                    }).showToast();
                }
            }).fail(function (data) {
                if (data['status'] === 500) {
                    alert(data['exception'])
                }
            });
        })
    </script>
@endpush

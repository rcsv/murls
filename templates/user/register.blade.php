@extends('layouts.app')

@section('content')

<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-lg-7 text-center text-lg-start">
            <h1 class="display-4 fw-bold lh-1 mb-3">Sign up</h1>
            <p class="col-lg-10 fs-4">
                <!-- ここは英語で
                    「あなたがよく使うウェブサイト、またはあなたがみんなに紹介したいウェブサイトを
                    　より使いやすくするために。
                    　便利な短縮コードサービスをどうぞ」
                    　と記載する。
                -->
                Introducing an Effortless Shortcut Code Service: <br>
                Enhance your experience on the websites you frequently visit, or 
                discover a new platform that you can't wait to share with others.
                Sign up now to enjoy a convenient shortcut code service that makes your
                online interactions smoother than ever before.
                Don't miss out on this opportunity to simplify your web browsing and
                amplify your productivity. Join us today!
                
            </p>
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
            <form id="user-registration" class="p-4 p-md-5 border rounded-3 bg-light" method="POST">
                <div class="form-floating mb-3">
                    <!-- email -->
                    <input name="email" value="{{ $email }}" type="email" class="form-control" id="floatingInput"
                        placeholder="name@example.com">
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <!-- password #1 -->
                    <input name="password" type="password" class="form-control" id="floatingPassword-1"
                        placeholder="Password">
                    <label for="floatingPassword-1">Password</label>
                </div>
                <div class="form-floating mb-3">
                    <!-- password #2 -->
                    <input name="password_confirmation" type="password" class="form-control" id="floatingPassword-2"
                        placeholder="SamePhrase">
                    <label for="floatingPassword-2">Confirm</label>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
                <hr class="my-4">
                <small class="text-muted">By clicking Sign up, you agree to the terms of use.</small>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('user-registration').addEventListener('submit', function(e) {
        e.preventDefault();
        var passA = document.getElementById('floatingPassword-1').value;
        var passB = document.getElementById('floatingPassword-2').value;
        if ( passA !== passB ) {
            alert('Password does not match');
        } else {
            this.submit();
        }
    });
</script>
@endsection
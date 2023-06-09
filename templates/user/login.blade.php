@extends('layouts.app')

@section('content')

<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-lg-7 text-center text-lg-start">
            <h1 class="display-4 fw-bold lh-1 mb-3">Login</h1>
            <p class="col-lg-10 fs-4">...?</p>
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
                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
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
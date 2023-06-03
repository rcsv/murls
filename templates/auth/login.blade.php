@extends('layouts.app')

@section('content')

LOGIN FORM

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
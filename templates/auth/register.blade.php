@extends('layouts.app')

@section('content')
<div class="flex justify-center">
    <form class="" method="POST">
        <!-- email -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                Email
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   id="email" type="email" placeholder="Email" name="email" value="{{ old('email') }}">
            @error('email')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <!-- password -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Password
            </label>
            <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight
                           focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************" name="password">
            @error('password')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <!-- password confirmation -->
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                Password Confirmation
            </label>
            <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight
                           focus:outline-none focus:shadow-outline" id="password_confirmation" type="password" placeholder="******************" name="password_confirmation">
            @error('password_confirmation')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <!-- submit -->
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded
                           focus:outline-none focus:shadow-outline" type="submit">
                Register
            </button>
            <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('login') }}">
                Already have an account?
            </a>
        </div>
        

    </form>
</div>
@endsection

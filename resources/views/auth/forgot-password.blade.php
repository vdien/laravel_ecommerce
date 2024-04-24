@extends('user.layouts.template')
@section('main-content')
    <div class="container">
        <x-guest-layout>
            <div class="form-group">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>
            <!-- Session Status -->
            <x-auth-session-status :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <!-- Email Address -->
                <div class="form-group">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input class="form-control form-control-sm" id="email" type="email" name="email"
                        :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="form-group">
                    <x-primary-button class=" btn btn-primary">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </x-guest-layout>
    </div>
@endsection

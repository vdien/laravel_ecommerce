@extends('user.layouts.template')
@section('main-content')
    <x-guest-layout>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="form-group">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="form-control form-control-sm" type="password" name="password" required
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="form-group">
                <x-primary-button class="btn btn-primary">
                    {{ __('Confirm') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
@endsection

<section>
    <header>
        <h3 >
            {{ __('Cập nhật mật khẩu') }}
        </h3>

        <p class="">
            {{ __('Đảm bảo tài khoản của bạn sử dụng mật khẩu dài và ngẫu nhiên để đảm bảo an toàn') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')
        <div class="form-group">
            <x-input-label for="current_password" :value="__('Mật khẩu hiện tại')" />
            <x-text-input id="current_password" name="current_password" type="password" class="form-control form-control-sm"
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>
        <div class="form-group">
            <x-input-label for="password" :value="__('Mật khẩu mới')" />
            <x-text-input id="password" name="password" type="password" class="form-control form-control-sm"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>
        <div class="form-group">
            <x-input-label for="password_confirmation" :value="__('Xác nhận mật khẩu mới')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="form-control form-control-sm"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-primary-button class="btn btn-primary btn-sm">{{ __('Lưu lại') }}</x-primary-button>
                    @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                {{ __('Lưu lại.') }}</p>
            @endif
            </div>
            </form>
</section>

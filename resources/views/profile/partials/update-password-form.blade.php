<section>
    <header>
        <h2 class="text-lg font-medium text-pink-700">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-pink-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-pink-700" />
            <x-text-input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="mt-1 block w-full border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500" 
                autocomplete="current-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-pink-600" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-pink-700" />
            <x-text-input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="mt-1 block w-full border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-pink-600" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-pink-700" />
            <x-text-input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="mt-1 block w-full border border-pink-300 rounded-lg focus:ring-pink-500 focus:border-pink-500" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-pink-600" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700">
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-pink-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<section class="bg-white p-8 rounded-2xl shadow-lg border border-pink-100">
    <header class="text-center mb-8">
        <h2 class="text-2xl font-serif text-gray-900 relative inline-block">
            {{ __('Profile Information') }}
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-pink-200 to-pink-400"></div>
        </h2>

        <p class="mt-3 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-8">
        @csrf
        @method('patch')

        <div class="group">
            <x-input-label for="name" :value="__('Name')" class="font-serif text-gray-700"/>
            <x-text-input 
                id="name" 
                name="name" 
                type="text" 
                class="mt-2 block w-full rounded-lg border-pink-200 focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50 transition duration-200"
                :value="old('name', $user->name)" 
                required 
                autofocus 
                autocomplete="name" 
            />
            <x-input-error class="mt-2 text-rose-500" :messages="$errors->get('name')" />
        </div>

        <div class="group">
            <x-input-label for="email" :value="__('Email')" class="font-serif text-gray-700"/>
            <x-text-input 
                id="email" 
                name="email" 
                type="email" 
                class="mt-2 block w-full rounded-lg border-pink-200 focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50 transition duration-200"
                :value="old('email', $user->email)" 
                required 
                autocomplete="username" 
            />
            <x-input-error class="mt-2 text-rose-500" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-pink-50 rounded-lg border border-pink-100">
                    <p class="text-sm text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button 
                            form="send-verification" 
                            class="underline text-sm text-pink-600 hover:text-pink-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition duration-200"
                        >
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-pink-400 to-pink-600 text-white rounded-lg font-medium hover:from-pink-500 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-pink-600 bg-pink-50 px-4 py-2 rounded-full"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <style>
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
        
        .group:hover input {
            border-color: #F9A8D4;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        section {
            animation: fadeIn 0.5s ease-out;
        }
    </style>

    <!-- Add Playfair Display font -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
</section>

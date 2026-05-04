<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(auth()->user()->must_change_password || session('warning'))
            <div class="bg-yellow-50 border border-yellow-400 text-yellow-800 rounded-lg px-5 py-4 flex items-start gap-3">
                <span class="text-yellow-500 text-xl leading-none mt-0.5">&#9888;</span>
                <div>
                    <p class="font-semibold">Contraseña provisional activa</p>
                    <p class="text-sm mt-1">Tu cuenta usa la contraseña provisional de empresa. Debes cambiarla antes de poder acceder al resto de la aplicación.</p>
                </div>
            </div>
            @endif
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div id="password" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

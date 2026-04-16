<x-guest-layout>
    <form method="POST" action="{{ route('register') }}"
        x-data="{ isConductor: false }">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nombre completo" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" value="Correo electrónico" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Tipo de cuenta -->
        <div class="mt-4">
            <x-input-label value="Tipo de cuenta" />
            <div class="mt-2 flex gap-4">
                <label class="flex items-center gap-2 cursor-pointer px-4 py-3 border-2 rounded-lg transition-colors flex-1 justify-center"
                    :class="!isConductor ? 'border-indigo-500 bg-indigo-50 text-indigo-700' : 'border-gray-200 text-gray-600 hover:border-gray-300'">
                    <input type="radio" name="is_conductor" value="0" class="sr-only"
                        @change="isConductor = false" :checked="!isConductor">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                    </svg>
                    <span class="text-sm font-medium">Generador de residuos</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer px-4 py-3 border-2 rounded-lg transition-colors flex-1 justify-center"
                    :class="isConductor ? 'border-green-500 bg-green-50 text-green-700' : 'border-gray-200 text-gray-600 hover:border-gray-300'">
                    <input type="radio" name="is_conductor" value="1" class="sr-only"
                        @change="isConductor = true" :checked="isConductor">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
                    </svg>
                    <span class="text-sm font-medium">Conductor</span>
                </label>
            </div>
        </div>

        <!-- Contraseña para usuario normal -->
        <div x-show="!isConductor" x-transition>
            <div class="mt-4">
                <x-input-label for="password" value="Contraseña" />
                <x-text-input id="password" class="block mt-1 w-full" type="password"
                    name="password" autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="password_confirmation" value="Confirmar contraseña" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <!-- Clave predefinida para conductor -->
        <div x-show="isConductor" x-transition>
            <div class="mt-4">
                <x-input-label for="conductor_password" value="Clave de acceso de conductor" />
                <x-text-input id="conductor_password" class="block mt-1 w-full" type="password"
                    name="conductor_key" autocomplete="off" />
                <p class="mt-1 text-xs text-gray-500">Introduce la clave proporcionada por la empresa. Si no la tienes, contacta con el administrador.</p>
                <x-input-error :messages="$errors->get('conductor_key')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                ¿Ya tienes cuenta?
            </a>
            <x-primary-button class="ms-4">
                Registrarse
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

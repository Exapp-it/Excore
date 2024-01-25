<div x-data="loginForm" x-cloak x-show="$store.modal.login.isOpen" x-transition.opacity.duration.500ms
     class="min-w-screen h-screen animated fadeIn faster fixed flex justify-center items-center inset-0">
    <div @click="$store.modal.login.close" class="absolute bg-black opacity-80 inset-0 z-0"></div>
</div>
<script src="/front/auth/login.js"></script>
<!-- <div class="w-full max-w-lg p-5 relative mx-auto my-auto rounded-xl shadow-lg bg-white">
    <div class="text-center px-5 flex-auto justify-center">
        <h2 class="text-xl font-bold py-4">{{__('Register Form')}}</h2>
        <p class="text-sm text-gray-500 pb-3 px-8">{{__('Register form text')}}</p>
        <div class="mb-4">
            <label for="l_login" class="block text-sm font-semibold text-gray-600">{{__('Username')}}</label>
            <input
                x-model="state.login"
                type="text"
                id="l_login"
                class="form-input w-full mt-1">
            <span class="text-red-600 text-sm" x-text="state.errors.login"></span>
        </div>
        <div class="mb-4">
            <label for="l_password"
                   class="block text-sm font-semibold text-gray-600">{{__('Password')}}</label>
            <input
                x-model="state.password"
                type="password"
                id="l_password"
                class="form-input w-full mt-1">
            <span class="text-red-600 text-sm" x-text="state.errors.password"></span>
        </div>
    </div>
    <div
        class="inline-block text-sm text-green-400 float-right px-5 pb-5">
        <span @click="openForgotModal"
              class="cursor-pointer hover:text-green-600 hover:underline decoration-green-600 underline-offset-2 transition-all duration-300">
            {{__('Forgot your password?')}}
        </span>
    </div>

    <div class="px-5 mt-2 text-center space-x-5 md:block">
        <button @click="loginAction"
                class="w-full bg-gradient-to-r from-green-500 to-indigo-500 text-white py-2 px-4 rounded-md hover:from-green-600 hover:to-indigo-600 focus:outline-none focus:ring focus:border-green-300">
            {{__('Login')}}
        </button>
    </div>
</div> -->
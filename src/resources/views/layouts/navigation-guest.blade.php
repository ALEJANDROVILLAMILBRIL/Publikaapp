<nav class="flex items-center justify-end gap-4">
    <a
        href="{{ url('/') }}"
        class="inline-block px-5 py-1.5 text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-sm text-sm leading-normal"
    >
        {{ __('Home') }}
    </a>
    <a
        href="{{ route('login') }}"
        class="inline-block px-5 py-1.5 text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-sm text-sm leading-normal"
    >
        {{ __('Log in') }}
    </a>
    <a
        href="{{ route('register') }}"
        class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] rounded-sm text-sm leading-normal">
        {{ __('Register') }}
    </a>
    <div class="flex justify-end items-center gap-x-4 p-4">
        <a href="{{ route('lang.switch', 'en') }}"
            class="{{ app()->getLocale() === 'en' ? 'font-bold underline' : '' }}">
            {{ __('English') }}
        </a>
        <span class="text-gray-500 dark:text-gray-400 px-2">|</span>
        <a href="{{ route('lang.switch', 'es') }}"
            class="{{ app()->getLocale() === 'es' ? 'font-bold underline' : '' }}">
            {{ __('Spanish') }}
        </a>
    </div>
</nav>

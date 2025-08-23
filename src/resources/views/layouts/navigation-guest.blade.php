<nav class="flex items-center justify-end gap-4">
    <a
        href="{{ url('/') }}"
        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
    >
        {{ __('Home') }}
    </a>
    <a
        href="{{ route('login') }}"
        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
    >
        {{ __('Log in') }}
    </a>
    <a
        href="{{ route('register') }}"
        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
        {{ __('Register') }}
    </a>
    <div class="flex justify-end items-center gap-x-4 p-4">
        <a href="{{ route('lang.switch', 'en') }}"
            class="{{ app()->getLocale() === 'en' ? 'font-bold underline' : '' }} text-gray-800 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">
            {{ __('English') }}
        </a>
        <span class="text-gray-500 dark:text-gray-400 px-2">|</span>
        <a href="{{ route('lang.switch', 'es') }}"
            class="{{ app()->getLocale() === 'es' ? 'font-bold underline' : '' }} text-gray-800 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">
            {{ __('Spanish') }}
        </a>
    </div>
</nav>

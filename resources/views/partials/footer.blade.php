@php
$is_docs_page = request()->is('docs/*');
@endphp

<footer class="max-w-screen-2xl pb-16 mt-10 mx-auto w-full {{ $is_docs_page ? 'dark:bg-dark-700 px-8' : 'px-5' }}">
    <p class="text-xs text-gray-700 {{ $is_docs_page ? 'dark:text-gray-400' : '' }}">
        Laravel is a Trademark of Laravel Holdings Inc.<br />
        Copyright &copy; 2011-{{ now()->format('Y') }} Laravel Holdings Inc.
    </p>

    <p class="mt-6 text-xs text-gray-700 {{ $is_docs_page ? 'dark:text-gray-400' : '' }}">
        Code highlighting provided by <a href="https://torchlight.dev">Torchlight</a>
    </p>
</footer>

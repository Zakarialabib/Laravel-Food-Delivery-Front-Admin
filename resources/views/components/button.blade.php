<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-red-700 hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 focus:ring-offset-slate-50 text-white font-semibold h-12 px-6 rounded-lg w-full flex items-center justify-center sm:w-auto dark:bg-red-500 dark:highlight-white/20 dark:hover:bg-red-400']) }}>
    {{ $slot }}
</button>

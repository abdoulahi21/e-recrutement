<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-md hover:shadow-lg']) }}>
    {{ $slot }}
</button>

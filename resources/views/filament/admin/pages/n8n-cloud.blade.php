<x-filament-panels::page>
    <div class="flex items-center justify-end gap-2 mb-2">
        <a
            href="{{ $url }}"
            target="_blank"
            rel="noopener noreferrer"
            class="text-sm text-primary-600 hover:underline dark:text-primary-400"
        >
            Otworz w nowej karcie &rarr;
        </a>
    </div>

    <iframe
        src="{{ $url }}"
        class="w-full border-0 rounded-md bg-white dark:bg-gray-900"
        style="height: calc(100vh - 10rem); min-height: 600px;"
        sandbox="allow-same-origin allow-scripts allow-popups allow-popups-to-escape-sandbox allow-forms allow-downloads allow-modals"
        allow="camera; microphone; clipboard-read; clipboard-write; fullscreen"
        referrerpolicy="no-referrer-when-downgrade"
    ></iframe>
</x-filament-panels::page>

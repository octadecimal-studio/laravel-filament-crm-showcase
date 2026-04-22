<x-filament-panels::page>
    <div class="flex items-center justify-between gap-2 mb-2">
        <p class="text-xs text-gray-500 dark:text-gray-400">
            Jesli iframe jest pusty &mdash; otworz raz w nowej karcie, zaloguj sie przez Cloudflare Access (OTP) i odswiez.
        </p>
        <a
            href="{{ $url }}"
            target="_blank"
            rel="noopener noreferrer"
            class="text-sm text-primary-600 hover:underline dark:text-primary-400"
        >
            Otworz w nowej karcie &rarr;
        </a>
    </div>

    <div style="width: 100%;">
        <iframe
            src="{{ $url }}"
            width="100%"
            class="border-0 rounded-md bg-white dark:bg-gray-900"
            style="display: block; width: 100%; height: calc(100vh - 10rem); min-height: 600px;"
            sandbox="allow-same-origin allow-scripts allow-popups allow-popups-to-escape-sandbox allow-forms allow-downloads allow-modals"
            allow="camera; microphone; clipboard-read; clipboard-write; fullscreen; autoplay"
            referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
    </div>
</x-filament-panels::page>

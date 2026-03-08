@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between gap-4">

            <div class="flex justify-between flex-1 sm:hidden">
                @if ($paginator->onFirstPage())
                    <span class="px-4 py-2 text-sm text-neutral-400 dark:text-zinc-600 border border-neutral-200 dark:border-zinc-700 rounded-lg cursor-default">
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    <button type="button"
                        wire:click="previousPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        wire:loading.attr="disabled"
                        class="px-4 py-2 text-sm font-medium text-neutral-900 dark:text-neutral-100 border border-neutral-200 dark:border-zinc-700 rounded-lg hover:bg-neutral-100 dark:hover:bg-zinc-800 transition-colors cursor-pointer">
                        {!! __('pagination.previous') !!}
                    </button>
                @endif

                @if ($paginator->hasMorePages())
                    <button type="button"
                        wire:click="nextPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        wire:loading.attr="disabled"
                        class="px-4 py-2 text-sm font-medium text-neutral-900 dark:text-neutral-100 border border-neutral-200 dark:border-zinc-700 rounded-lg hover:bg-neutral-100 dark:hover:bg-zinc-800 transition-colors cursor-pointer">
                        {!! __('pagination.next') !!}
                    </button>
                @else
                    <span class="px-4 py-2 text-sm text-neutral-400 dark:text-zinc-600 border border-neutral-200 dark:border-zinc-700 rounded-lg cursor-default">
                        {!! __('pagination.next') !!}
                    </span>
                @endif
            </div>

            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    Showing <span class="font-medium text-neutral-900 dark:text-neutral-100">{{ $paginator->firstItem() }}</span>
                    to <span class="font-medium text-neutral-900 dark:text-neutral-100">{{ $paginator->lastItem() }}</span>
                    of <span class="font-medium text-neutral-900 dark:text-neutral-100">{{ $paginator->total() }}</span> results
                </p>

                <div class="flex items-center gap-1">
                    @if ($paginator->onFirstPage())
                        <span class="inline-flex items-center justify-center size-9 text-neutral-400 dark:text-zinc-600 border border-neutral-200 dark:border-zinc-700 rounded-lg cursor-default">
                            <flux:icon name="chevron-left" class="size-4" />
                        </span>
                    @else
                        <button type="button"
                            wire:click="previousPage('{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            class="inline-flex items-center justify-center size-9 text-neutral-900 dark:text-neutral-100 border border-neutral-200 dark:border-zinc-700 rounded-lg hover:bg-neutral-100 dark:hover:bg-zinc-800 transition-colors cursor-pointer"
                            aria-label="{{ __('pagination.previous') }}">
                            <flux:icon name="chevron-left" class="size-4" />
                        </button>
                    @endif

                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="inline-flex items-center justify-center size-9 text-sm text-neutral-400 dark:text-zinc-500">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                <span wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                                    @if ($page == $paginator->currentPage())
                                        <span class="inline-flex items-center justify-center size-9 text-sm font-semibold text-white bg-neutral-900 dark:bg-white dark:text-neutral-900 rounded-lg cursor-default">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <button type="button"
                                            wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                            class="inline-flex items-center justify-center size-9 text-sm font-medium text-neutral-900 dark:text-neutral-100 border border-neutral-200 dark:border-zinc-700 rounded-lg hover:bg-neutral-100 dark:hover:bg-zinc-800 transition-colors cursor-pointer"
                                            aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                            {{ $page }}
                                        </button>
                                    @endif
                                </span>
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <button type="button"
                            wire:click="nextPage('{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            class="inline-flex items-center justify-center size-9 text-neutral-900 dark:text-neutral-100 border border-neutral-200 dark:border-zinc-700 rounded-lg hover:bg-neutral-100 dark:hover:bg-zinc-800 transition-colors cursor-pointer"
                            aria-label="{{ __('pagination.next') }}">
                            <flux:icon name="chevron-right" class="size-4" />
                        </button>
                    @else
                        <span class="inline-flex items-center justify-center size-9 text-neutral-400 dark:text-zinc-600 border border-neutral-200 dark:border-zinc-700 rounded-lg cursor-default">
                            <flux:icon name="chevron-right" class="size-4" />
                        </span>
                    @endif
                </div>
            </div>

        </nav>
    @endif
</div>

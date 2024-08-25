<div class="grid fixed inset-4 place-items-end text-sm sm:top-auto" x-data="{ open: false }">
    <div>
        <div
            class="w-full sm:w-[480px] mb-4 bg-white/[.85] dark:bg-black/[.85] backdrop-blur-md rounded-lg ring-1 ring-black/5 dark:ring-white/5 shadow-lg shadow-black/20 dark:shadow-none dark:text-gray-300"
            x-data="{ characters: 0 }"
            x-show="open"
            x-transition.duration.300ms
            x-trap="open"
            @click.away="open = false"
            @keyup.esc="open = false"
            @conversation.window="open = true"
        >
            @if (! empty($messages) && count($messages) > 2)
                <div class="grid gap-4 max-h-[65dvh] md:max-h-[75dvh] p-4 pb-0 overflow-y-scroll">
                    @foreach ($messages as $message)
                        @if ($loop->first || $loop->index === 1)
                            @continue
                        @endif

                        <div
                            class="scroll-mt-4"
                            x-init="$el.scrollIntoView({ behavior: 'smooth' })"
                        >
                            @if ($message['role'] === 'assistant')
                                <div class="mb-2 font-medium">Laravel</div>
                            @else
                                <div class="mb-2 font-medium">You</div>
                            @endif

                            <div
                                @class([
                                    'p-4 marker:text-white marker:font-medium rounded prose prose-sm max-w-none prose-pre:break-all prose-pre:whitespace-pre-wrap prose-pre:text-base',
                                    'bg-black/5 dark:bg-white/10 dark:text-gray-100' => $message['role'] === 'user',
                                    'bg-[#eb4432]/[.85] prose-invert text-white' => $message['role'] === 'assistant',
                                ])
                                style="word-break: break-word"
                            >
                                {!! Str::markdown($message['content']) !!}
                            </div>
                        </div>
                    @endforeach

                    @if ($replying)
                        <div
                            wire:stream="reply-{{ $this->getId() }}"
                            class="p-4 rounded border border-black/10 dark:border-white/20 scroll-mt-4"
                            x-init="$el.scrollIntoView({ behavior: 'smooth' })"
                        >
                            {{ $reply }}
                        </div>
                    @endif
                </div>
            @else
                <div class="p-8 pb-4 prose dark:prose-invert prose-sm">
                    <p>Heads up!</p>
                    <ol>
                        <li><strong>This is an experimental tool</strong></li>
                        <li><strong>It's more accurate than ChatGPT</strong></li>
                        <li><strong>It's not based on RAG</strong>, which makes it even more accurate</li>
                        <li>Until we get a bigger context window on GPT, <strong>it only knows about the current page</strong></li>
                        <li><strong>It can still hallucinate</strong>, so always double check</li>
                    </ol>
                </div>
            @endif

            <form
                @submit.prevent="characters = 0; $wire.submitMessage()"
                class="p-4"
            >
                <input type="text" wire:model="message" placeholder="Ask questions about Laravel" maxlength="256" class="pb-3 w-full bg-transparent border-b placeholder-black/20 dark:placeholder-white/30 border-black/10 dark:border-white/20 focus:outline-none" @keyup.stop="characters = $event.target.value.length" @keyup.esc="open = false" />

                @error('message')
                    <div class="mt-3 text-red-600 dark:text-red-500">{{ $message }}</div>
                @enderror
            </form>

            <div class="text-right text-sm text-black/[.5] dark:text-white/50 pb-4 px-4">
                <span x-text="characters"></span>/256
            </div>
        </div>

        <div class="text-right">
            <button
                class="rounded-full inline-grid place-items-center text-white bg-[#eb4432] w-[3.5rem] h-[3.5rem] hover:scale-110 transition-transform duration-300"
                @click="open = ! open"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-[1.5rem]"><path fill-rule="evenodd" d="M5.337 21.718a6.707 6.707 0 0 1-.533-.074.75.75 0 0 1-.44-1.223 3.73 3.73 0 0 0 .814-1.686c.023-.115-.022-.317-.254-.543C3.274 16.587 2.25 14.41 2.25 12c0-5.03 4.428-9 9.75-9s9.75 3.97 9.75 9c0 5.03-4.428 9-9.75 9-.833 0-1.643-.097-2.417-.279a6.721 6.721 0 0 1-4.246.997Z" clip-rule="evenodd" /></svg>
                <span class="sr-only">Babble with Laravel</span>
            </button>
        </div>
    </div>
</div>

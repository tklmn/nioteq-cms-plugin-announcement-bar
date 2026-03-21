<x-app-layout>
    <x-slot name="header">
        {{ __('announcement-bar::ab.settings_title') }}
    </x-slot>

    <div class="content-inner-wrap">
        <div class="mx-auto">
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow">
                <div class="p-6 text-gray-900 dark:text-white">
                    <h2 class="text-xl font-semibold mb-6">{{ __('announcement-bar::ab.heading') }}</h2>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/30 border border-green-300 dark:border-green-700 text-green-700 dark:text-green-400 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('backend.announcement-bar.settings.save') }}" method="POST" class="space-y-6">
                        @csrf

                        {{-- Enable toggle --}}
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="enabled" id="enabled" value="1" {{ $enabled === '1' ? 'checked' : '' }}
                                   class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500 dark:bg-gray-700">
                            <label for="enabled" class="font-medium">{{ __('announcement-bar::ab.enable') }}</label>
                        </div>

                        {{-- Message --}}
                        <div>
                            <label for="message" class="block text-sm font-medium mb-1">{{ __('announcement-bar::ab.message') }}</label>
                            <input type="text" name="message" id="message" value="{{ old('message', $message) }}" maxlength="500"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        {{-- Colors --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="bg_color" class="block text-sm font-medium mb-1">{{ __('announcement-bar::ab.bg_color') }}</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" name="bg_color" id="bg_color" value="{{ old('bg_color', $bg_color) }}"
                                           class="w-10 h-10 rounded border-gray-300 dark:border-gray-600 cursor-pointer">
                                    <input type="text" value="{{ old('bg_color', $bg_color) }}" readonly
                                           class="w-24 text-sm rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                           onclick="this.previousElementSibling.click()">
                                </div>
                            </div>
                            <div>
                                <label for="text_color" class="block text-sm font-medium mb-1">{{ __('announcement-bar::ab.text_color') }}</label>
                                <div class="flex items-center gap-2">
                                    <input type="color" name="text_color" id="text_color" value="{{ old('text_color', $text_color) }}"
                                           class="w-10 h-10 rounded border-gray-300 dark:border-gray-600 cursor-pointer">
                                    <input type="text" value="{{ old('text_color', $text_color) }}" readonly
                                           class="w-24 text-sm rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                           onclick="this.previousElementSibling.click()">
                                </div>
                            </div>
                        </div>

                        {{-- Preview --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">{{ __('announcement-bar::ab.preview') }}</label>
                            <div id="bar-preview" class="relative text-center text-sm py-2 px-4 rounded" style="background-color: {{ $bg_color }}; color: {{ $text_color }};">
                                <span id="preview-message">{{ $message }}</span>
                            </div>
                        </div>

                        {{-- Position --}}
                        <div>
                            <label for="position" class="block text-sm font-medium mb-1">{{ __('announcement-bar::ab.position') }}</label>
                            <select name="position" id="position"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="top" {{ $position === 'top' ? 'selected' : '' }}>{{ __('announcement-bar::ab.position_top') }}</option>
                                <option value="bottom" {{ $position === 'bottom' ? 'selected' : '' }}>{{ __('announcement-bar::ab.position_bottom') }}</option>
                            </select>
                        </div>

                        {{-- Link (optional) --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="link_text" class="block text-sm font-medium mb-1">{{ __('announcement-bar::ab.link_text') }} <span class="text-gray-400 text-xs">({{ __('announcement-bar::ab.optional') }})</span></label>
                                <input type="text" name="link_text" id="link_text" value="{{ old('link_text', $link_text) }}" maxlength="100"
                                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="link_url" class="block text-sm font-medium mb-1">{{ __('announcement-bar::ab.link_url') }} <span class="text-gray-400 text-xs">({{ __('announcement-bar::ab.optional') }})</span></label>
                                <input type="url" name="link_url" id="link_url" value="{{ old('link_url', $link_url) }}" maxlength="500" placeholder="https://"
                                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        {{-- Dismissible --}}
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="dismissible" id="dismissible" value="1" {{ $dismissible === '1' ? 'checked' : '' }}
                                   class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500 dark:bg-gray-700">
                            <label for="dismissible">{{ __('announcement-bar::ab.dismissible') }}</label>
                        </div>

                        <div class="flex justify-end">
                            <x-btn variant="primary" type="submit" icon="bi bi-check-lg">{{ __('translation.save') }}</x-btn>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var bgInput = document.getElementById('bg_color');
            var textInput = document.getElementById('text_color');
            var msgInput = document.getElementById('message');
            var preview = document.getElementById('bar-preview');
            var previewMsg = document.getElementById('preview-message');

            function updatePreview() {
                preview.style.backgroundColor = bgInput.value;
                preview.style.color = textInput.value;
                bgInput.nextElementSibling.value = bgInput.value;
                textInput.nextElementSibling.value = textInput.value;
            }
            bgInput.addEventListener('input', updatePreview);
            textInput.addEventListener('input', updatePreview);
            msgInput.addEventListener('input', function() { previewMsg.textContent = this.value; });
        });
    </script>
</x-app-layout>

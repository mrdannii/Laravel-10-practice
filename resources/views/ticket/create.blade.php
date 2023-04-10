<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Support Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 dark:text-gray-100">
                    {{ __("Create Ticket!") }}
                </div>

                <section>


                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="post" action="{{ route('profile.update') }}" class=" space-y-6">
                        @csrf
                        @method('patch')



                        <div class="ml-10 mr-10">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="" required autofocus autocomplete="T" />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div class="ml-10 mr-10">
                            <x-input-label for="Description" :value="__('Description')" />
                            <x-textarea name="description" id="description"/>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="ml-10 mr-10">
                            <x-input-label for="attachment" :value="__('Attachment (if any)')" />
                            <x-text-input id="attachment" name="attachment" type="file" class="mt-0 block w-50" value=""  autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('attachment')" />
                        </div>


                        <div class="flex items-center gap-4 justify-center p-5">
                            <x-primary-button>{{ __('Create') }}</x-primary-button>

                            @if (session('status') === 'profile-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >{{ __('Saved.') }}</p>
                            @endif
                        </div>
                    </form>
                </section>

            </div>
        </div>
    </div>

</x-app-layout>

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
                    {{ __('Update Ticket!') }}
                </div>

                <section>


                    <form method="post" action="" class=" space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="ml-10 mr-10">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                autofocus autocomplete="T" value="{{ $ticket->title }}" readonly />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div class="ml-10 mr-10">
                            <x-input-label for="Description" :value="__('Description')" />
                            <x-textarea name="description" id="description" value="{{ $ticket->description }}"
                                readonly />
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="ml-10 mr-10 mb-5">
                            @if ($ticket->attachment)
                                <a href="{{ '/storage/' . $ticket->attachment }}" class="text-white mb-5"
                                    target="_blank">See Attachment</a>
                            @endif
                            {{-- <x-input-label for="attachment" :value="__('Attachment (if any)')" />
                            <x-text-input id="attachment" name="attachment" type="file" class="mt-0 block w-50"
                                value="" autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('attachment')" /> --}}
                        </div>


                        {{-- <div class="flex items-center gap-4 justify-center p-5">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>

                            @if (session('status') === 'profile-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                            @endif
                        </div> --}}
                    </form>
                    @if (auth()->user()->isAdmin)
                            <div class="flex items-center gap-4 justify-center p-3">
                                <form class="" action="{{ route('ticket.update', $ticket->id) }}" method="post">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" name="status" value="Approved">
                                    <x-secondary-button>{{ __('Approve ✔') }}</x-secondary-button>
                                </form>
                                <form class="ml-3" action="{{ route('ticket.update', $ticket->id) }}" method="post">
                                    @csrf
                                    @method('patch')
                                    <input type="hidden" name="status" value="Rejected">
                                    <x-secondary-button>{{ __('Reject ✖') }}</x-secondary-button>
                                </form>
                            </div>
                        @else
                            <div class="flex items-center gap-4 justify-center p-3">
                                <a href="{{ route('ticket.edit', $ticket->id) }}">
                                    <x-secondary-button>{{ __('Edit') }}</x-secondary-button>
                                </a>
                                <form class="ml-3" action="{{ route('ticket.destroy', $ticket->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <x-secondary-button>{{ __('delete') }}</x-secondary-button>
                                </form>
                            </div>
                        @endif


                </section>

            </div>
        </div>
    </div>

</x-app-layout>

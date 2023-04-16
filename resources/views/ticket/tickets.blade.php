<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Support Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 dark:text-gray-100">
                    {{ __('List of Tickets ') }}

                    <x-nav-link class="ml-5" :href="route('ticket.create')">{{ __('Create New') }}</x-nav-link>

                </div>

                <section>
                    <table class="mt-5 w-full text-gray-900 dark:text-gray-100 mb-5 ">
                        <thead class="">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                {{-- <th scope="col">Description</th> --}}
                                <th scope="col">Status</th>
                                <th scope="col">Updated_at</th>
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse ($ticket as $item)
                                <tr>
                                    <th scope="row">{{ $i++ }}</th>
                                    <td><a href="{{ route('ticket.show', $item->id) }}"> {{ $item->title }} </a> </td>
                                    {{-- <td>{{ $item->description }}</td> --}}
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->updated_at->diffForHumans() }}</td>
                                   <td>
                                    @if (auth()->user()->isAdmin)
                                    <div class="inline-flex items-center justify-center">
                                        <form class="" action="{{ route('ticket.update', $item->id) }}"
                                            method="post">
                                            @csrf
                                            @method('patch')
                                            <input type="hidden" name="status" value="Approved">
                                            <x-secondary-button>{{ __('Approve ✔') }}</x-secondary-button>
                                        </form>
                                        <form class="ml-3" action="{{ route('ticket.update', $item->id) }}"
                                            method="post">
                                            @csrf
                                            @method('patch')
                                            <input type="hidden" name="status" value="Rejected">
                                            <x-secondary-button>{{ __('Reject ✖') }}</x-secondary-button>
                                        </form>
                                    </div>
                                    @else
                                    <div class="inline-flex items-center justify-center">
                                        <a href="{{ route('ticket.edit', $item->id) }}">
                                            <x-secondary-button>{{ __('Edit') }}</x-secondary-button>
                                        </a>
                                        <form class="ml-3" action="{{ route('ticket.destroy', $item->id) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <x-secondary-button>{{ __('delete') }}</x-secondary-button>
                                        </form>
                                    </div>
                                    @endif
                                </td>
                                </tr>
                            @empty
                                <p class="h1 text-white text-center">No Tickets Founds</p>
                            @endforelse



                        </tbody>
                    </table>


                    @if (session('status'))
                        <div class="flex justify-end text-center gap-4 mt-5">
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-end text-gray-600 dark:text-gray-400">
                                {{ session('status') }}
                            </p>
                        </div>
                    @endif



                </section>

            </div>
        </div>
    </div>

</x-app-layout>

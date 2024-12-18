<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Link') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Card 1: Centered form inside a full-width card -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-2xl mx-auto"> <!-- Centering the content with max-width -->
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Upload Image Data') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Upload Image data for url redirection.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('addlink.linkinsert') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                            @csrf
                            @method('post')

                            <div>
                                <x-input-label for="image_name" :value="__('Image Name')" />
                                <x-text-input id="image_name" name="image_name" type="text" class="mt-1 block w-full" required autofocus autocomplete="image_name" />
                                <x-input-error class="mt-2" :messages="$errors->get('image_name')" />
                            </div>

                            <div>
                                <x-input-label for="image_upload" :value="__('Image Upload (optional)')" />
                                <x-text-input id="image_upload" name="image" type="file" class="mt-1 block w-full"  autofocus autocomplete="image_upload" />
                                <x-input-error class="mt-2" :messages="$errors->get('image_upload')" />
                            </div>

                            <div>
                                <x-input-label for="image_url" :value="__('Image Insert Url (optional)')" />
                                <x-text-input id="image_url" name="image_url" type="text" class="mt-1 block w-full"  autofocus autocomplete="image_url" />
                                <x-input-error class="mt-2" :messages="$errors->get('image_url')" />
                            </div>

                            <div>
                                <x-input-label for="facebook_link" :value="__('Facebook Link (optional)')" />
                                <x-text-input id="facebook_link" name="facebook_link" type="text" class="mt-1 block w-full" required autofocus autocomplete="facebook_link" />
                                <x-input-error class="mt-2" :messages="$errors->get('facebook_link')" />
                            </div>

                            <div>
                                <x-input-label for="all_link" :value="__('All Other Link (optional)')" />
                                <x-text-input id="all_link" name="all_link" type="text" class="mt-1 block w-full" required autofocus autocomplete="all_link" />
                                <x-input-error class="mt-2" :messages="$errors->get('all_link')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'link-inserted')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <!-- Card 2: Another card below -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="mx-auto">
                    <!-- Content of the second card -->
                    <h3 class="text-xl font-medium text-gray-900">Link Lists</h3>
                    <!-- Responsive Table -->
                    <div class="overflow-x-auto mt-6">
                        <table class="min-w-full table-auto">
                            <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">#</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Image Name</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Facebook Url</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Other Url</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Sharable Url</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($links as $link)
                            <tr class="border-t">
                                <td class="px-4 py-2 text-sm text-gray-700"> {{$link->id}}</td>
                                <td class="px-4 py-2 text-sm text-gray-700"> {{$link->image_name}}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{$link->facebook_link}}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{$link->all_link}}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{$url = url('/')}}/share/{{$link->image_name}}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    <a class="text-blue-500 hover:text-blue-700" href="{{route('linkDelete',$link->id)}}" onclick="return confirm('Are you sure you want to delete ?');">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

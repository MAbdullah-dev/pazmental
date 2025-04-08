<div class="w-full">
    <div class="content-management">
        <div class="px-4 lg:px-6 w-full">
            <div class="flex flex-wrap">
                <div class="w-full">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="border-b border-gray-200 dark:border-gray-700 p-4">
                            <h5 class="text-lg font-semibold mb-0">@translate('Language')</h5>
                        </div>
                        <div class="p-4">
                            <form class="space-y-4" wire:submit="env_key_update">
                                <div class="flex flex-wrap items-center space-y-4 md:space-y-0">
                                    <div class="w-full md:w-1/4">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">@translate('Default Language')</label>
                                    </div>
                                    <div class="w-full md:w-1/2">
                                        <select
                                            class="form-control block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm rounded-md"
                                            wire:model="defaultlang" data-selected="en">
                                            <option value="" selected>Select Default Language</option>
                                            @foreach ($lang as $ln)
                                                <option value="{{ $ln->code }}">{{ $ln->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('defaultlang')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="w-full md:w-1/4">
                                        <button type="submit"
                                            class="ml-2 bg-blue-500 text-white py-2 px-4 rounded-md">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="border-b border-gray-200 dark:border-gray-700 p-4">
                    <h5 class="text-lg font-semibold mb-0">Language</h5>
                </div>
                <div class="p-4">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">#
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                    Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300">
                                    Code</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-300">
                                    Options</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($lang as $ln)
                                <tr>
                                    <td class="px-4 py-2">{{ $ln->id }}</td>
                                    <td class="px-4 py-2">{{ $ln->name }}</td>
                                    <td class="px-4 py-2">{{ $ln->code }}</td>
                                    <td class="px-4 py-2 text-right">
                                        <a class="bg-blue-500 text-white p-2 rounded-full inline-flex items-center justify-center"
                                            href="{{ route('admin.languages.show',$ln->id) }}" title="Translation">
                                            <i class='bx bx-globe'></i>
                                        </a>
                                        <a class="bg-blue-500 text-white p-2 rounded-full inline-flex items-center justify-center"
                                            href="{{ route('admin.editlang', $ln->id) }}" title="Edit">
                                            <i class='bx bx-edit'></i>
                                        </a>
                                        @if($defaultlang != $ln->code)
                                        <button wire:click="delete({{ $ln->id }})"
                                            class="bg-red-500 text-white p-2 rounded-full inline-flex items-center justify-center"
                                            title="Delete">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        <div class="flex justify-end">
                            <!-- Add your pagination here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script src="{{ asset('assets/js/party-welcome.js') }}"></script>
@endpush

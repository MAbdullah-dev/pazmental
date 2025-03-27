<div class="w-full">
    <div class="content-management">
        <div class="px-15px px-lg-25px">
            <div class="card">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg mx-3 flex justify-between items-center">
                    <div class="border-b border-gray-200 dark:border-gray-700 p-4">
                        <h5 class="text-lg font-semibold mb-0">{{ $lang->name }}</h5>
                    </div>
                    {{-- <div class="p-4">
                        <form wire:submit.prevent="searchlang" class="space-y-4">
                            <div class="flex flex-wrap items-center space-y-4 md:space-y-0">
                                <div class="w-full md:w-1/4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">@translate('Search Translations')</label>
                                </div>
                                <div class="w-full md:w-1/2">
                                    <input type="text" wire:model="search"
                                        class="form-control block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm rounded-md"
                                        placeholder="@translate('Type key & Enter')">
                                </div>
                                <div class="w-full md:w-1/4">
                                    <button type="submit"
                                        class="ml-2 bg-blue-500 text-white py-2 px-4 rounded-md">@translate('Search')</button>
                                </div>
                            </div>
                        </form>
                    </div> --}}
                </div>
                <form wire:submit.prevent="save" class="form-horizontal">

                    <div class="card-body">
                        <div class="form-group mb-0 text-right my-4">
                            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Save</button>
                        </div>
                        <table class="table table-striped table-bordered demo-dt-basic" id="translation-table"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="45%">@translate('Text-Keys')</th>
                                    <th width="45%">@translate('Translations')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($translations as $index => $translation)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="key">{{ $translation->lang_key }}</td>
                                        <td>
                                            <input type="text"
                                                class="form-control block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm rounded-md"
                                                wire:model="values.{{ $translation->lang_key }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

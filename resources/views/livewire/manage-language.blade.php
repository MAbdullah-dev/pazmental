<div class="w-full">
    <div class="content-management">
        <div class="px-4 lg:px-6">
            <div class="text-left mt-4 mb-6">
                <h5 class="text-lg font-semibold mb-0">@translate('Language Information')</h5>
            </div>
            <div class="flex flex-wrap justify-center">
                <div class="w-full lg:w-1/2">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="border-b border-gray-200 dark:border-gray-700 p-4">
                            <h5 class="text-lg font-semibold mb-0">@translate('Update Language Info')</h5>
                        </div>
                        <div class="p-0">
                            <form class="p-4" wire:submit="submit">
                                <input type="hidden" name="_token" value="RUwOdZmwj7jbcfPS7Yqfwmk28O4dyW3tGPWV2K2S"
                                    autocomplete="off">
                                <div class="mb-4">
                                    <div class="flex items-center">
                                        <label
                                            class="w-1/4 text-sm font-medium text-gray-700 dark:text-gray-300">@translate('Name') :</label>
                                        <div class="w-3/4">
                                            <input type="text"
                                                class="form-control block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm rounded-md"
                                                wire:model="lang" placeholder="@translate('Name')" required>
                                            @error('lang')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="flex items-center">
                                        <label
                                            class="w-1/4 text-sm font-medium text-gray-700 dark:text-gray-300">@translate('Language Code') :</label>
                                        <div class="w-3/4">
                                            <input type="text"
                                                class="form-control block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm rounded-md"
                                                wire:model="code" placeholder="@translate('Code')" required>
                                            @error('code')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit"
                                        class="bg-blue-500 text-white py-2 px-4 rounded-md">@translate('Save')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

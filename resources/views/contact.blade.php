<x-default-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contact Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">
                    <div>
                        {{-- <x-jet-application-logo class="block h-12 w-auto" /> --}}
                    </div>

                    <div class="mt-8 text-2xl">
                        Get in touch
                    </div>

                    <div class="mt-6 text-gray-500 dark:text-gray-400">
                        <p>Phasellus vitae nunc eget lectus varius luctus. Aenean sit amet magna eget est lacinia posuere. Phasellus vitae nunc eget lectus varius luctus. Aenean sit amet magna eget est lacinia posuere.</p>
                    </div>
                </div>

                <div class="p-6 sm:px-20 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">
                    <div class="mt-8 text-2xl">
                        Contact Form
                    </div>

                    <div class="mt-6 text-gray-500 dark:text-gray-400">
                        <form action="#" method="POST">
                            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                    <div class="mt-1">
                                        <input type="text" name="name" id="name" autocomplete="name" class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                    <div class="mt-1">
                                        <input id="email" name="email" type="email" autocomplete="email" class="block w-full shadow-sm sm
                                        :text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
                                    <div class="mt-1">
                                        <input type="text" name="subject" id="subject" autocomplete="subject" class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                                    <div class="mt-1">
                                        <textarea id="message" name="message" rows="4" class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md"></textarea>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                        Send
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</x-default-layout>
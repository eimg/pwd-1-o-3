@php use Illuminate\Support\Str; @endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Latest Posts
            </h2>
            @auth
                <a
                    href="{{ route('posts.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    New Post
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 p-4 rounded bg-green-100 text-green-800">
                    {{ session('status') }}
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($posts as $post)
                    <article class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden flex flex-col">
                        <img src="{{ $post->feature_image }}" alt="{{ $post->title }}" class="h-48 w-full object-cover">
                        <div class="p-6 flex flex-col flex-1">
                            <div class="text-sm text-indigo-600 dark:text-indigo-400 mb-2 uppercase tracking-wide">
                                {{ $post->category->name }}
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                {{ $post->title }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 flex-1">
                                {{ Str::limit(strip_tags($post->content), 120) }}
                            </p>
                            <div class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                                By {{ $post->author->name }} • {{ $post->created_at->format('M d, Y') }}
                            </div>
                            <a href="{{ route('posts.show', $post) }}" class="mt-4 inline-flex items-center text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">
                                Read more →
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 text-center text-gray-500 dark:text-gray-400">
                        No posts found.
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>


<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                    {{ $post->category->name }}
                </p>
                <h1 class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">{{ $post->title }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    By {{ $post->author->name }} • {{ $post->created_at->format('M d, Y') }}
                </p>
            </div>
            @can('delete', $post)
                <form method="POST" action="{{ route('posts.destroy', $post) }}">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        onclick="return confirm('Delete this post? This cannot be undone.');"
                    >
                        Delete Post
                    </button>
                </form>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-10">
            @if (session('status'))
                <div class="p-4 rounded bg-green-100 text-green-800">
                    {{ session('status') }}
                </div>
            @endif
            <article class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <img src="{{ $post->feature_image }}" alt="{{ $post->title }}" class="w-full h-80 object-cover">
                <div class="p-8">
                    <div class="prose prose-indigo max-w-none dark:prose-invert text-gray-900 dark:text-gray-100">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>
            </article>

            <section class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Comments ({{ $post->comments->count() }})
                </h2>

                <div class="mt-6 space-y-6">
                    @forelse ($post->comments as $comment)
                        <div class="border-b border-gray-100 dark:border-gray-700 pb-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $comment->author->name }} • {{ $comment->created_at->diffForHumans() }}
                            </p>
                            <p class="mt-2 text-gray-800 dark:text-gray-200">
                                {{ $comment->body }}
                            </p>
                            @can('delete', $comment)
                                <form
                                    method="POST"
                                    action="{{ route('posts.comments.destroy', [$post, $comment]) }}"
                                    class="mt-2"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="text-xs text-red-600 hover:underline"
                                        onclick="return confirm('Delete this comment?');"
                                    >
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">No comments yet. Be the first to share your thoughts!</p>
                    @endforelse
                </div>

                <div class="mt-8">
                    @auth
                        @if (session('status'))
                            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('posts.comments.store', $post) }}">
                            @csrf
                            <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Add a comment
                            </label>
                            <textarea id="body" name="body" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">{{ old('body') }}</textarea>
                            @error('body')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <button
                                type="submit"
                                class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                Post Comment
                            </button>
                        </form>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">Log in</a>
                            to add a comment.
                        </p>
                    @endauth
                </div>
            </section>
        </div>
    </div>
</x-app-layout>


<x-app-layout>
    <x-slot name="header">
        <h2 class="text-gray-800 text-xl font-semibold leading-tight">{{ $post->title }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl lg:px-8 sm:px-6">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="border-gray-200 border-b bg-white p-6">
                    <h1 class="mb-4 text-3xl font-bold">{{ $post->title }}</h1>
                    <p class="text-gray-600 mb-4">By {{ $post->user->name }} on {{ $post->published_at }}</p>
                    <div class="prose mb-6 max-w-none">{!! nl2br(e($post->content)) !!}</div>
                    <div class="mb-6 flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <span class="bg-blue-100 text-blue-800 rounded px-2.5 py-0.5 text-xs font-semibold"
                            >{{ $tag->name }}</span
                            >
                        @endforeach
                    </div>
                    @can('update', $post)
                        <a
                            href="{{ route('posts.edit', $post) }}"
                            class="bg-blue-500 hover:bg-blue-700 rounded px-4 py-2 font-bold text-white"
                        >Edit Post</a
                        >
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

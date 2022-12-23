<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Hello, ' . auth()->user()->name) }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
          <section>
            <header>
              <h2 class="text-lg font-medium text-gray-900">
                {{ __('My posts') }}
              </h2>

            </header>

            <x-secondary-button x-data="" x-on:click="window.location.href = '{{ route('posts.create') }}'">
              {{ __('Create new post') }}
            </x-secondary-button>

            @if ($posts)
            <ul class="list-disc list-inside mt-3">
              @foreach ($posts as $post)
              <li><a class="text-blue-600 visited:text-purple-600" href="{{ route('posts.view', $post->id) }}" target="_blank">{{ $post->title }}</a></li>
              @endforeach
            </ul>
            @endif

            {{ $posts->links() }}
          </section>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
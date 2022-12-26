<section>
  <header>
    <h2 class="text-lg font-medium text-gray-900">
      {{ __('Add a new post') }}
    </h2>

  </header>

  @if (session('post') === false)
  <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 6000)" class="text-sm text-red-600">{{ __('Blog post can not be created. Please try again later.') }}</p>
  @endif

  <form method="post" action="{{ route('posts.store') }}" class="mt-6 space-y-6">
    @csrf
    <div>
      <x-input-label for="title" :value="__('Title')" />
      <x-text-input value="{{ old('title') }}" id="title" name="title" type="text" class="mt-1 block w-full" autocomplete="title" />
      <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div>
      <x-input-label for="description" :value="__('Description')" />
      <x-forms.tinymce-editor name="description" value="{{ old('description') }}" />
      <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div class="mt-6 flex items-center gap-4">
      <x-primary-button>{{ __('Save') }}</x-primary-button>

      @if (session('post')->id ?? false)
      <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 6000)" class="text-sm text-green-600">{{ __('Post was created.') }}</p>
      @endif
    </div>
  </form>
</section>
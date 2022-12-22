@extends('layouts.blog')

@section('content')

@forelse($posts as $post)
<article class="flex flex-col shadow my-4">
  <!-- Article Image -->
  <a href="#" class="hover:opacity-75">
    <img src="https://source.unsplash.com/collection/1346951/1000x500?sig={{ $post->id }}">
  </a>
  <div class="bg-white flex flex-col justify-start p-6">
    <a href="#" class="text-blue-700 text-sm font-bold uppercase pb-4">Technology</a>
    <a href="#" class="text-3xl font-bold hover:text-gray-700 pb-4">{{ $post->title }}</a>
    <p href="#" class="text-sm pb-3">
      By <a href="#" class="font-semibold hover:text-gray-800">{{ $post->user->name }}</a>, Published on {{ $post->formatted_date }}
    </p>
    <a href="#" class="pb-6">{{ $post->short_description }}</a>
    <a href="#" class="uppercase text-gray-800 hover:text-black">Continue Reading <i class="fas fa-arrow-right"></i></a>
  </div>
</article>
@empty
<p>No posts found</p>
@endforelse

<!-- Pagination -->
<div class="flex items-center py-8">
  <a href="#" class="h-10 w-10 bg-blue-800 hover:bg-blue-600 font-semibold text-white text-sm flex items-center justify-center">1</a>
  <a href="#" class="h-10 w-10 font-semibold text-gray-800 hover:bg-blue-600 hover:text-white text-sm flex items-center justify-center">2</a>
  <a href="#" class="h-10 w-10 font-semibold text-gray-800 hover:text-gray-900 text-sm flex items-center justify-center ml-3">Next <i class="fas fa-arrow-right ml-2"></i></a>
</div>
@endsection
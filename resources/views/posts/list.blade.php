@extends('layouts.blog')

@section('content')

@forelse($posts as $post)
<x-posts.post-article :$post />
@empty
<p>No posts found</p>
@endforelse

{{ $posts->onEachSide(1)->links() }}

@endsection
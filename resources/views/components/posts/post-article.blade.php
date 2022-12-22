<article class="flex flex-col shadow my-4">
    <x-posts.post-image :$post />
    <div class="bg-white flex flex-col justify-start p-6">
        <x-posts.post-category />
        <x-posts.post-title :$post />
        <x-posts.post-publish-date :$post />
        <x-posts.post-short-description :$post />
        <x-posts.post-continue-reading :$post />
    </div>
</article>
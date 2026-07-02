@extends('layouts.MainLayout')
@section('content')
<div class="mb-10">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">My Blogs</h1>
            <p class="text-gray-500 mt-2">Manage all the blogs you've written.</p>
        </div>
        <a href="/post/create" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-full font-semibold transition shadow-sm hover:shadow text-sm inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Write Blog
        </a>
    </div>
</div>

@if (empty($posts))
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
        <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">No blogs found</h3>
        <p class="text-gray-500 mb-6">You haven't written any blogs yet. Start sharing your knowledge!</p>
        <a href="/post/create" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-full transition shadow-sm">Create Your First Blog</a>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($posts as $post)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full transition duration-200">
                <a href="/post/{{ $post['slug'] }}" class="block relative h-48 bg-gray-100">
                    @if (!empty($post['cover_image']))
                        <img src="{{ $post['cover_image'] }}" alt="Cover" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </a>
                <div class="p-5 flex flex-col flex-grow">
                    <a href="/post/{{ $post['slug'] }}" class="block mt-2">
                        <h3 class="text-lg font-bold text-gray-900 leading-tight mb-2 line-clamp-2 transition">{{ $post['title'] }}</h3>
                    </a>
                    
                    <div class="flex items-center gap-4 text-xs text-gray-500 mt-2 mb-4 font-medium">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                            {{ $post['like_count'] ?? 0 }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            {{ $post['comment_count'] ?? 0 }}
                        </span>
                    </div>

                    <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between">
                        <a href="/post/edit/{{ $post['id'] }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit
                        </a>
                        <button onclick="openDeleteModal({{ $post['id'] }})" class="text-sm font-semibold text-red-500 hover:text-red-700 flex items-center gap-1 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<!-- Delete Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900/50 backdrop-blur-sm transition-opacity opacity-0">
    <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6 transform scale-95 transition-transform duration-300">
        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Delete Blog</h3>
        <p class="text-sm text-gray-500 text-center mb-6">Are you sure you want to delete this blog? This action cannot be undone.</p>
        <div class="flex gap-3 justify-center">
            <button onclick="closeDeleteModal()" class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Cancel</button>
            <button id="confirm-delete-btn" class="px-5 py-2.5 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">Delete</button>
        </div>
    </div>
</div>

<script>
    let postToDelete = null;

    function openDeleteModal(id) {
        postToDelete = id;
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.children[0].classList.remove('scale-95');
        }, 10);
    }

    function closeDeleteModal() {
        postToDelete = null;
        const modal = document.getElementById('delete-modal');
        modal.classList.add('opacity-0');
        modal.children[0].classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    document.getElementById('confirm-delete-btn').addEventListener('click', async function() {
        if (!postToDelete) return;
        
        const btn = this;
        btn.disabled = true;
        btn.innerText = 'Deleting...';
        
        try {
            const res = await fetch('/post/delete/' + postToDelete, {
                method: 'POST'
            });
            const data = await res.json();
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.error || 'Failed to delete post.');
                closeDeleteModal();
                btn.disabled = false;
                btn.innerText = 'Delete';
            }
        } catch(e) {
            console.error(e);
            alert("An error occurred.");
            closeDeleteModal();
            btn.disabled = false;
            btn.innerText = 'Delete';
        }
    });
</script>

@endsection

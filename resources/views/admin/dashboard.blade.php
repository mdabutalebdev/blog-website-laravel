@extends('layouts.AdminLayout')

@section('content')
<div class="max-w-7xl mx-auto min-h-full">
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 shadow-sm" role="alert">
            <span class="block sm:inline font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 shadow-sm" role="alert">
            <span class="block sm:inline font-medium">{{ session('error') }}</span>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 shadow-sm">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Content Area -->
    <div class="w-full">
        
        <!-- Pending Blogs Section -->
        <div id="section-blogs" class="block">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                @if(empty($pendingPosts))
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">কোনো পেন্ডিং ব্লগ নেই</h3>
                        <p class="text-sm text-gray-500">বর্তমানে রিভিউ করার মতো কোনো নতুন ব্লগ নেই।</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($pendingPosts as $post)
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 flex flex-col h-full">
                            @if($post['cover_image'])
                                <img src="{{ $post['cover_image'] }}" alt="{{ $post['title'] }}" class="w-full h-40 object-cover">
                            @else
                                <div class="w-full h-40 bg-gradient-to-br from-indigo-50 to-blue-50 flex items-center justify-center">
                                    <span class="text-indigo-300 text-4xl"><i class="fas fa-image"></i></span>
                                </div>
                            @endif
                            
                            <div class="p-5 flex-grow flex flex-col">
                                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 hover:text-indigo-600 transition-colors">
                                    <a href="/post/{{ $post['slug'] }}" target="_blank">{{ $post['title'] }}</a>
                                </h3>
                                <div class="flex items-center gap-2 mb-4 text-xs text-gray-500">
                                    <span>{{ $post['author_name'] }}</span> • <span>{{ \Carbon\Carbon::parse($post['created_at'])->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-600 text-sm line-clamp-2 mb-6 flex-grow">
                                    {{ Str::limit(strip_tags(\Illuminate\Support\Str::markdown($post['content'])), 100) }}
                                </p>
                                <div class="grid grid-cols-2 gap-3 mt-auto border-t border-gray-100 pt-4">
                                    <form action="/admin/post/approve/{{ $post['id'] }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-green-50 text-green-600 hover:bg-green-100 hover:text-green-700 font-medium py-2 text-sm rounded-lg transition border border-green-200">Approve</button>
                                    </form>
                                    <form action="/admin/post/delete/{{ $post['id'] }}" method="POST" onsubmit="return confirm('Are you sure you want to reject and delete this post?');">
                                        @csrf
                                        <button type="submit" class="w-full bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 font-medium py-2 text-sm rounded-lg transition border border-red-200">Reject</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Manage Banners Section -->
        <div id="section-banners" class="hidden">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-900 hidden">Manage Banners</h2>
                <div class="ml-auto">
                    <button onclick="toggleModal('create-banner-modal')" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg shadow-sm transition">
                        <i class="fas fa-plus mr-1"></i> Create Banner
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                @if(count($banners) > 0)
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                            <th class="p-4 font-semibold w-1/4">Preview</th>
                            <th class="p-4 font-semibold w-1/2">Heading & Paragraph</th>
                            <th class="p-4 font-semibold text-right w-1/4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($banners as $banner)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="p-4 align-middle">
                                <div class="w-32 h-20 rounded overflow-hidden bg-gray-900 relative shadow-sm border border-gray-200">
                                    @if($banner->media_type === 'video')
                                        <video src="{{ $banner->media_path }}" class="w-full h-full object-cover"></video>
                                    @else
                                        <img src="{{ $banner->media_path }}" class="w-full h-full object-cover" alt="Banner">
                                    @endif
                                </div>
                            </td>
                            <td class="p-4 align-middle">
                                <div class="font-bold text-gray-900 text-sm mb-1">{{ $banner->heading ?: '(No Heading)' }}</div>
                                <div class="text-gray-500 text-xs line-clamp-2">{{ $banner->paragraph ?: '(No Paragraph)' }}</div>
                            </td>
                            <td class="p-4 align-middle text-right space-x-2">
                                <button onclick="toggleModal('edit-banner-modal-{{ $banner->id }}')" class="inline-flex items-center justify-center w-8 h-8 rounded text-blue-600 bg-blue-50 hover:bg-blue-100 transition tooltip" title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                                <form action="/admin/banner/delete/{{ $banner->id }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this banner?');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded text-red-600 bg-red-50 hover:bg-red-100 transition tooltip" title="Delete">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal for this Banner -->
                        <div id="edit-banner-modal-{{ $banner->id }}" class="fixed inset-0 z-50 flex items-center justify-center hidden">
                            <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="toggleModal('edit-banner-modal-{{ $banner->id }}')"></div>
                            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg p-6 m-4 animate-scale-up">
                                <div class="flex justify-between items-center mb-5 border-b border-gray-100 pb-3">
                                    <h3 class="text-lg font-bold text-gray-900">Edit Banner</h3>
                                    <button type="button" onclick="toggleModal('edit-banner-modal-{{ $banner->id }}')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
                                </div>
                                <form action="/admin/banner/update/{{ $banner->id }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Heading</label>
                                        <input type="text" name="heading" value="{{ $banner->heading }}" placeholder="Ex: তথ্যই শক্তি..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Paragraph</label>
                                        <textarea name="paragraph" rows="3" placeholder="Enter paragraph text..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border text-sm">{{ $banner->paragraph }}</textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Update Media (Optional)</label>
                                        <input type="file" name="banner_media" accept="image/*,video/*,.gif" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-200 rounded-lg">
                                        <p class="text-xs text-gray-400 mt-1">Leave empty to keep current media.</p>
                                    </div>
                                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 mt-6">
                                        <button type="button" onclick="toggleModal('edit-banner-modal-{{ $banner->id }}')" class="px-5 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm transition">Cancel</button>
                                        <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 shadow-sm transition">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-400 mb-4">
                        <i class="fas fa-images text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No banners created yet</h3>
                    <p class="text-gray-500 text-sm mb-4">Upload your first banner to see it on the homepage slider.</p>
                    <button onclick="toggleModal('create-banner-modal')" class="text-blue-600 font-medium hover:underline text-sm">Create your first banner</button>
                </div>
                @endif
            </div>
        </div>

        <!-- Settings Section -->
        <div id="section-settings" class="hidden">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-900 hidden">Site Settings</h2>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form action="/admin/settings/update" method="POST" class="space-y-6 max-w-2xl">
                    @csrf
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Announcement Bar</h3>
                        <div class="space-y-4 mb-8">
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="block text-sm font-semibold text-gray-800">Show Announcement Bar</label>
                                    <label class="flex items-center cursor-pointer">
                                        <div class="relative">
                                            <input type="hidden" name="announcement_active" value="0">
                                            <input type="checkbox" name="announcement_active" value="1" class="sr-only peer" {{ \App\Models\Setting::get('announcement_active', '1') == '1' ? 'checked' : '' }}>
                                            <div class="w-10 h-5 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:bg-blue-600 transition-colors"></div>
                                            <div class="absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition-transform peer-checked:translate-x-5"></div>
                                        </div>
                                        <span class="ml-2 text-xs font-medium text-gray-600 uppercase tracking-wider">Active</span>
                                    </label>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Highlight Title</label>
                                    <input type="text" name="announcement_title" value="{{ \App\Models\Setting::get('announcement_title', 'New Feature:') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Announcement Text</label>
                                    <input type="text" name="announcement_text" value="{{ \App\Models\Setting::get('announcement_text', 'Write your blogs with the brand new markdown editor! 🎉') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Social Links</h3>
                        
                        <div class="space-y-6">
                            <!-- Facebook -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="block text-sm font-semibold text-gray-800">Facebook</label>
                                    <label class="flex items-center cursor-pointer">
                                        <div class="relative">
                                            <input type="hidden" name="social_active_facebook" value="0">
                                            <input type="checkbox" name="social_active_facebook" value="1" class="sr-only peer" {{ \App\Models\Setting::get('social_active_facebook', '1') == '1' ? 'checked' : '' }}>
                                            <div class="w-10 h-5 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:bg-blue-600 transition-colors"></div>
                                            <div class="absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition-transform peer-checked:translate-x-5"></div>
                                        </div>
                                        <span class="ml-2 text-xs font-medium text-gray-600 uppercase tracking-wider">Active</span>
                                    </label>
                                </div>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fab fa-facebook-f"></i>
                                    </div>
                                    <input type="url" name="social_url_facebook" value="{{ \App\Models\Setting::get('social_url_facebook', 'https://www.facebook.com/jyotirmoy.sameer') }}" placeholder="https://facebook.com/..." class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border text-sm">
                                </div>
                            </div>
                            
                            <!-- WhatsApp -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="block text-sm font-semibold text-gray-800">WhatsApp</label>
                                    <label class="flex items-center cursor-pointer">
                                        <div class="relative">
                                            <input type="hidden" name="social_active_whatsapp" value="0">
                                            <input type="checkbox" name="social_active_whatsapp" value="1" class="sr-only peer" {{ \App\Models\Setting::get('social_active_whatsapp', '1') == '1' ? 'checked' : '' }}>
                                            <div class="w-10 h-5 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-green-300 peer-checked:bg-green-600 transition-colors"></div>
                                            <div class="absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition-transform peer-checked:translate-x-5"></div>
                                        </div>
                                        <span class="ml-2 text-xs font-medium text-gray-600 uppercase tracking-wider">Active</span>
                                    </label>
                                </div>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fab fa-whatsapp"></i>
                                    </div>
                                    <input type="url" name="social_url_whatsapp" value="{{ \App\Models\Setting::get('social_url_whatsapp', 'https://wa.me/01710845363') }}" placeholder="https://wa.me/..." class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border text-sm">
                                </div>
                            </div>

                            <!-- LinkedIn -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="block text-sm font-semibold text-gray-800">LinkedIn</label>
                                    <label class="flex items-center cursor-pointer">
                                        <div class="relative">
                                            <input type="hidden" name="social_active_linkedin" value="0">
                                            <input type="checkbox" name="social_active_linkedin" value="1" class="sr-only peer" {{ \App\Models\Setting::get('social_active_linkedin', '1') == '1' ? 'checked' : '' }}>
                                            <div class="w-10 h-5 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 peer-checked:bg-blue-600 transition-colors"></div>
                                            <div class="absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition-transform peer-checked:translate-x-5"></div>
                                        </div>
                                        <span class="ml-2 text-xs font-medium text-gray-600 uppercase tracking-wider">Active</span>
                                    </label>
                                </div>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fab fa-linkedin-in"></i>
                                    </div>
                                    <input type="url" name="social_url_linkedin" value="{{ \App\Models\Setting::get('social_url_linkedin', 'https://linkedin.com/') }}" placeholder="https://linkedin.com/..." class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border text-sm">
                                </div>
                            </div>

                            <!-- Instagram -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="block text-sm font-semibold text-gray-800">Instagram</label>
                                    <label class="flex items-center cursor-pointer">
                                        <div class="relative">
                                            <input type="hidden" name="social_active_instagram" value="0">
                                            <input type="checkbox" name="social_active_instagram" value="1" class="sr-only peer" {{ \App\Models\Setting::get('social_active_instagram', '1') == '1' ? 'checked' : '' }}>
                                            <div class="w-10 h-5 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-pink-300 peer-checked:bg-pink-600 transition-colors"></div>
                                            <div class="absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition-transform peer-checked:translate-x-5"></div>
                                        </div>
                                        <span class="ml-2 text-xs font-medium text-gray-600 uppercase tracking-wider">Active</span>
                                    </label>
                                </div>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fab fa-instagram"></i>
                                    </div>
                                    <input type="url" name="social_url_instagram" value="{{ \App\Models\Setting::get('social_url_instagram', 'https://www.instagram.com/jyotirmoysameer') }}" placeholder="https://instagram.com/..." class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border text-sm">
                                </div>
                            </div>
                            
                            <!-- YouTube -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="block text-sm font-semibold text-gray-800">YouTube</label>
                                    <label class="flex items-center cursor-pointer">
                                        <div class="relative">
                                            <input type="hidden" name="social_active_youtube" value="0">
                                            <input type="checkbox" name="social_active_youtube" value="1" class="sr-only peer" {{ \App\Models\Setting::get('social_active_youtube', '1') == '1' ? 'checked' : '' }}>
                                            <div class="w-10 h-5 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-red-300 peer-checked:bg-red-600 transition-colors"></div>
                                            <div class="absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition-transform peer-checked:translate-x-5"></div>
                                        </div>
                                        <span class="ml-2 text-xs font-medium text-gray-600 uppercase tracking-wider">Active</span>
                                    </label>
                                </div>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <i class="fab fa-youtube"></i>
                                    </div>
                                    <input type="url" name="social_url_youtube" value="{{ \App\Models\Setting::get('social_url_youtube', 'https://youtube.com/') }}" placeholder="https://youtube.com/..." class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-100">
                        <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 shadow-sm transition">
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Create Banner Modal -->
<div id="create-banner-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="toggleModal('create-banner-modal')"></div>
    <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg p-6 m-4 animate-scale-up">
        <div class="flex justify-between items-center mb-5 border-b border-gray-100 pb-3">
            <h3 class="text-lg font-bold text-gray-900">Create New Banner</h3>
            <button type="button" onclick="toggleModal('create-banner-modal')" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <form action="/admin/banner/store" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Heading</label>
                <input type="text" name="heading" placeholder="Ex: তথ্যই শক্তি, জ্ঞানই সমাধান" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Paragraph</label>
                <textarea name="paragraph" rows="3" placeholder="Enter paragraph text..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2 border text-sm"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Media File (Image/Video) *</label>
                <input type="file" name="banner_media" accept="image/*,video/*,.gif" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-200 rounded-lg" required>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 mt-6">
                <button type="button" onclick="toggleModal('create-banner-modal')" class="px-5 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 shadow-sm transition">Cancel</button>
                <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 shadow-sm transition">Upload</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function switchTab(tabName) {
        document.getElementById('section-blogs').classList.add('hidden');
        document.getElementById('section-banners').classList.add('hidden');
        document.getElementById('section-settings').classList.add('hidden');
        
        document.getElementById('section-' + tabName).classList.remove('hidden');
        
        const activeClass = ['bg-blue-50', 'text-blue-700'];
        const inactiveClass = ['text-gray-600', 'hover:bg-gray-50', 'hover:text-gray-900'];
        
        const btnBlogs = document.getElementById('nav-blogs');
        const btnBanners = document.getElementById('nav-banners');
        const btnSettings = document.getElementById('nav-settings');
        
        const title = document.getElementById('page-title');
        
        [btnBlogs, btnBanners, btnSettings].forEach(btn => {
            if(btn) {
                btn.classList.add(...inactiveClass);
                btn.classList.remove(...activeClass);
            }
        });
        
        if (tabName === 'blogs') {
            if(btnBlogs) { btnBlogs.classList.add(...activeClass); btnBlogs.classList.remove(...inactiveClass); }
            if(title) title.innerText = 'Dashboard';
        } else if (tabName === 'banners') {
            if(btnBanners) { btnBanners.classList.add(...activeClass); btnBanners.classList.remove(...inactiveClass); }
            if(title) title.innerText = 'Hero / Banners';
        } else if (tabName === 'settings') {
            if(btnSettings) { btnSettings.classList.add(...activeClass); btnSettings.classList.remove(...inactiveClass); }
            if(title) title.innerText = 'Site Settings';
        }
    }

    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.toggle('hidden');
        }
    }
</script>
<style>
    .animate-scale-up {
        animation: scaleUp 0.2s ease-out forwards;
    }
    @keyframes scaleUp {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>
@endpush

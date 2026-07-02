@extends('layouts.MainLayout')

@section('banner')
    @php
        $catLower = strtolower($currentCategory ?? '');
    @endphp

    @if($catLower === 'banking')
        <!-- Banking Banner -->
        <div class="relative bg-cover bg-center w-full" style="background-image: url('https://images.unsplash.com/photo-1601597111158-2fceff292cdc?auto=format&fit=crop&q=80&w=2000');">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-purple-600 to-orange-500 opacity-85"></div>
            <div class="relative z-10 container mx-auto px-4 lg:px-16 pt-16 pb-20 flex flex-col items-center justify-center text-center w-full">
                <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-4 drop-shadow-[0_5px_5px_rgba(0,0,0,0.8)]" style="font-family: 'Hind Siliguri', sans-serif;">ব্যাংকিং ও ফাইন্যান্স</h2>
                <p class="text-lg md:text-xl text-gray-100 max-w-3xl font-medium drop-shadow-[0_2px_2px_rgba(0,0,0,0.8)]" style="font-family: 'Hind Siliguri', sans-serif;">
                    ব্যাংকিং সেক্টরের সর্বশেষ আপডেট, টিপস এবং নির্ভরযোগ্য তথ্য।
                </p>
            </div>
        </div>
    @elseif($catLower === 'health')
        <!-- Health Banner -->
        <div class="relative bg-cover bg-center w-full" style="background-image: url('https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&q=80&w=2000');">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-purple-600 to-orange-500 opacity-85"></div>
            <div class="relative z-10 container mx-auto px-4 lg:px-16 pt-16 pb-20 flex flex-col items-center justify-center text-center w-full">
                <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-4 drop-shadow-[0_5px_5px_rgba(0,0,0,0.8)]" style="font-family: 'Hind Siliguri', sans-serif;">স্বাস্থ্য ও চিকিৎসা</h2>
                <p class="text-lg md:text-xl text-gray-100 max-w-3xl font-medium drop-shadow-[0_2px_2px_rgba(0,0,0,0.8)]" style="font-family: 'Hind Siliguri', sans-serif;">
                    সুস্থ ও সুন্দর জীবনের জন্য সঠিক স্বাস্থ্য বিষয়ক পরামর্শ।
                </p>
            </div>
        </div>
    @elseif($catLower === 'law')
        <!-- Law Banner -->
        <div class="relative bg-cover bg-center w-full" style="background-image: url('https://images.unsplash.com/photo-1505664194779-8beaceb93744?auto=format&fit=crop&q=80&w=2000');">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-purple-600 to-orange-500 opacity-85"></div>
            <div class="relative z-10 container mx-auto px-4 lg:px-16 pt-16 pb-20 flex flex-col items-center justify-center text-center w-full">
                <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-4 drop-shadow-[0_5px_5px_rgba(0,0,0,0.8)]" style="font-family: 'Hind Siliguri', sans-serif;">আইন ও বিচার</h2>
                <p class="text-lg md:text-xl text-gray-100 max-w-3xl font-medium drop-shadow-[0_2px_2px_rgba(0,0,0,0.8)]" style="font-family: 'Hind Siliguri', sans-serif;">
                    আইন কানুন, আইনি অধিকার এবং সচেতনতামূলক নির্ভরযোগ্য তথ্য।
                </p>
            </div>
        </div>
    @elseif($catLower === 'education')
        <!-- Education Banner -->
        <div class="relative bg-cover bg-center w-full" style="background-image: url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=2000');">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-purple-600 to-orange-500 opacity-85"></div>
            <div class="relative z-10 container mx-auto px-4 lg:px-16 pt-16 pb-20 flex flex-col items-center justify-center text-center w-full">
                <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-4 drop-shadow-[0_5px_5px_rgba(0,0,0,0.8)]" style="font-family: 'Hind Siliguri', sans-serif;">শিক্ষা ও ক্যারিয়ার</h2>
                <p class="text-lg md:text-xl text-gray-100 max-w-3xl font-medium drop-shadow-[0_2px_2px_rgba(0,0,0,0.8)]" style="font-family: 'Hind Siliguri', sans-serif;">
                    শিক্ষা, ক্যারিয়ার গাইডলাইন এবং সফলতার সঠিক দিকনির্দেশনা।
                </p>
            </div>
        </div>
    @else
        <!-- General Banner -->
        @if(isset($banners) && count($banners) > 0)
        <div class="swiper banner-swiper w-full relative">
            <div class="swiper-wrapper">
                @foreach($banners as $banner)
                <div class="swiper-slide">
                    <div class="relative w-full h-[300px] sm:h-[400px] md:h-[500px] lg:h-[600px] bg-gray-100 overflow-hidden">
                        @if($banner->media_type === 'video')
                            <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover">
                                <source src="{{ $banner->media_path }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <img src="{{ $banner->media_path }}" alt="Banner" class="absolute inset-0 w-full h-full object-cover object-center">
                        @endif
                        
                        @if($banner->heading || $banner->paragraph)
                        <!-- Optional Overlay Text -->
                        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent flex flex-col justify-center items-start px-8 md:px-16 lg:px-24">
                            <div class="max-w-2xl mt-8">
                                @if($banner->heading)
                                <h2 class="text-2xl md:text-4xl lg:text-5xl font-extrabold text-white drop-shadow-lg mb-4" style="font-family: 'Hind Siliguri', sans-serif; line-height: 1.2;">
                                    {!! nl2br(e($banner->heading)) !!}
                                </h2>
                                @endif
                                @if($banner->paragraph)
                                <p class="text-sm md:text-base lg:text-lg text-gray-200 drop-shadow-md" style="font-family: 'Hind Siliguri', sans-serif;">
                                    {!! nl2br(e($banner->paragraph)) !!}
                                </p>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Swiper Pagination -->
            <div class="swiper-pagination"></div>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof Swiper !== 'undefined') {
                    const swiper = new Swiper('.banner-swiper', {
                        loop: true,
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false,
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        effect: 'fade',
                        fadeEffect: {
                            crossFade: true
                        }
                    });
                }
            });
        </script>
        <style>
            .banner-swiper .swiper-pagination-bullet {
                background: #ffffff;
                opacity: 0.5;
            }
            .banner-swiper .swiper-pagination-bullet-active {
                opacity: 1;
                background: #ffffff;
            }
            .swiper-pagination {
                bottom: 20px !important;
            }
        </style>
        @else
        <!-- Fallback General Banner -->
        <div class="relative bg-gradient-to-r from-blue-600 via-purple-600 to-orange-500 w-full overflow-hidden">
            <div class="flex flex-col md:flex-row items-stretch justify-between container mx-auto w-full">
                <!-- Left Content -->
                <div class="text-left flex-1 z-10 w-full px-4 lg:px-16 pt-10 pb-10 md:pt-16 md:pb-16 lg:py-20 flex flex-col justify-center">
                    <h2 class="text-4xl md:text-5xl lg:text-7xl font-extrabold text-white mb-6 drop-shadow-md" style="font-family: 'Hind Siliguri', sans-serif; line-height: 1.2;">
                        তথ্যই শক্তি, <br>জ্ঞানই সমাধান
                    </h2>
                    <p class="text-lg md:text-xl lg:text-3xl text-white font-medium drop-shadow opacity-95 leading-relaxed mt-4" style="font-family: 'Hind Siliguri', sans-serif;">
                        ব্যাংকিং, স্বাস্থ্য, আইন এবং শিক্ষা - <br>সঠিক তথ্যের নির্ভরযোগ্য উৎস।
                    </p>
                </div>

                <!-- Right Content (Dynamic Media) -->
                <div class="flex-1 flex justify-center md:justify-end items-end relative z-10 w-full px-4 lg:px-16 pt-6 md:pt-0">
                    <img src="/uploads/covers/update.png" alt="Banner" class="w-full max-w-md md:max-w-lg lg:max-w-xl h-auto max-h-[22rem] md:max-h-[30rem] lg:max-h-[38rem] object-contain object-bottom drop-shadow-[0_20px_20px_rgba(0,0,0,0.4)]">
                </div>
            </div>
        </div>
        @endif
    @endif
@endsection

@section('content')
<div class="w-full">

    <!-- Search Bar & Filters (Matches Image 1) -->
    <div class="mb-10 max-w-full mx-auto">
        <!-- Search Input -->
        <form action="/" method="GET" class="relative mb-6">
            @if (!empty($currentCategory))
                <input type="hidden" name="category" value="{{ $currentCategory }}">
            @endif
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input type="text" name="q" value="{{ $currentSearch ?? '' }}" class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm transition" placeholder="Search by keyword, tags, or author...">
        </form>

        <!-- Dynamic Category Pills -->
        <div class="flex flex-wrap items-center gap-2.5">
            <?php $isAllActive = empty($currentCategory); ?>
            <a href="/" class="inline-flex items-center gap-1.5 px-4 py-1.5 {{ $isAllActive ? 'bg-gray-900 text-white shadow-sm hover:opacity-90' : 'bg-white text-gray-700 border border-gray-200 hover:border-blue-400 hover:text-blue-600 shadow-sm' }} rounded-lg text-sm font-semibold transition">
                All <span class="{{ $isAllActive ? 'bg-white text-gray-900' : 'bg-gray-100 text-gray-600' }} px-1.5 py-0.5 rounded text-[11px] leading-none">{{ $totalPosts }}</span>
            </a>
            @foreach ($categories as $cat)
                <?php $isActive = (!empty($currentCategory) && strtolower($currentCategory) === strtolower($cat['category'])); ?>
                <a href="/category/{{ slugify($cat['category']) }}" class="inline-flex items-center gap-1.5 px-4 py-1.5 {{ $isActive ? 'bg-gray-900 text-white shadow-sm hover:opacity-90' : 'bg-white text-gray-700 border border-gray-200 hover:border-blue-400 hover:text-blue-600 shadow-sm' }} rounded-lg text-sm font-medium transition">
                    {{ ucfirst($cat['category']) }} <span class="{{ $isActive ? 'bg-white text-gray-900' : 'bg-gray-100 text-gray-600' }} px-1.5 py-0.5 rounded text-[11px] leading-none">{{ $cat['count'] }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Top Header matches the educative image exactly -->
    <div class="flex justify-between items-end border-b border-gray-200 pb-4 mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">blogsite</h1>
        
    </div>

    @if ($posts->isEmpty())
        <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-lg">No posts published yet.</p>
        </div>
    @else
        <!-- Grid Section for All Posts -->
        <div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 800)">
            <!-- Skeleton Loader -->
            <div x-show="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @for ($i = 0; $i < 12; $i++)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full animate-pulse">
                    <div class="w-full h-48 bg-gray-200"></div>
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="h-6 w-20 bg-gray-200 rounded-md"></div>
                            <div class="h-4 w-16 bg-gray-200 rounded ml-auto"></div>
                        </div>
                        <div class="h-6 w-3/4 bg-gray-200 rounded mb-2"></div>
                        <div class="h-6 w-1/2 bg-gray-200 rounded mb-4"></div>
                        <div class="h-4 w-full bg-gray-200 rounded mb-2"></div>
                        <div class="h-4 w-full bg-gray-200 rounded mb-4"></div>
                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gray-200"></div>
                                <div class="h-4 w-24 bg-gray-200 rounded"></div>
                            </div>
                            <div class="h-4 w-8 bg-gray-200 rounded"></div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <!-- Actual Posts -->
            <div x-show="!loading" style="display: none;" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($posts as $post)
                    @include('components.GridPostCard', ['post' => $post])
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div x-show="!loading" style="display: none;" class="mt-10">
                {{ $posts->links() }}
            </div>
        </div>
    @endif

    <!-- Major Website Links Section -->
    <div class="mt-16 mb-8 border-t border-gray-200 pt-10 px-4 md:px-0">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 tracking-tight flex items-center gap-2">
            <i class="fas fa-link text-blue-600 text-xl"></i> Major Website Links
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-4">
            <a href="https://bangladesh.gov.bd" target="_blank" class="relative overflow-hidden bg-gradient-to-br from-teal-500 to-emerald-600 rounded-xl p-5 text-center shadow-md hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col items-center justify-center min-h-[120px] group border border-transparent hover:border-white/20">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                <i class="fas fa-globe-asia text-white/80 text-3xl mb-3 group-hover:scale-110 transition-transform duration-300"></i>
                <span class="text-sm font-bold text-white tracking-wide">Bangladesh.gov.bd</span>
            </a>
            
            <a href="https://bb.org.bd" target="_blank" class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-5 text-center shadow-md hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col items-center justify-center min-h-[120px] group border border-transparent hover:border-white/20">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                <i class="fas fa-building-columns text-white/80 text-3xl mb-3 group-hover:scale-110 transition-transform duration-300"></i>
                <span class="text-sm font-bold text-white tracking-wide">bb.org.bd</span>
            </a>
            
            <a href="https://bdjobs.com" target="_blank" class="relative overflow-hidden bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl p-5 text-center shadow-md hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col items-center justify-center min-h-[120px] group border border-transparent hover:border-white/20">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                <i class="fas fa-briefcase text-white/80 text-3xl mb-3 group-hover:scale-110 transition-transform duration-300"></i>
                <span class="text-sm font-bold text-white tracking-wide">bdjobs.com</span>
            </a>
            
            <a href="https://canva.com" target="_blank" class="relative overflow-hidden bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl p-5 text-center shadow-md hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col items-center justify-center min-h-[120px] group border border-transparent hover:border-white/20">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                <i class="fas fa-palette text-white/80 text-3xl mb-3 group-hover:scale-110 transition-transform duration-300"></i>
                <span class="text-sm font-bold text-white tracking-wide">canva.com</span>
            </a>
            
            <a href="https://gemini.google.com" target="_blank" class="relative overflow-hidden bg-gradient-to-br from-orange-400 to-rose-500 rounded-xl p-5 text-center shadow-md hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col items-center justify-center min-h-[120px] group border border-transparent hover:border-white/20">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                <i class="fas fa-wand-magic-sparkles text-white/80 text-3xl mb-3 group-hover:scale-110 transition-transform duration-300"></i>
                <span class="text-sm font-bold text-white tracking-wide">gemini.google.com</span>
            </a>
            
            <a href="https://github.com" target="_blank" class="relative overflow-hidden bg-gradient-to-br from-gray-700 to-gray-900 rounded-xl p-5 text-center shadow-md hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col items-center justify-center min-h-[120px] group border border-transparent hover:border-white/20">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                <i class="fab fa-github text-white/80 text-3xl mb-3 group-hover:scale-110 transition-transform duration-300"></i>
                <span class="text-sm font-bold text-white tracking-wide">github.com</span>
            </a>
            
            <a href="https://www.agranibank.org/" target="_blank" class="relative overflow-hidden bg-gradient-to-br from-emerald-500 to-teal-700 rounded-xl p-5 text-center shadow-md hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col items-center justify-center min-h-[120px] group border border-transparent hover:border-white/20">
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                <i class="fas fa-piggy-bank text-white/80 text-3xl mb-3 group-hover:scale-110 transition-transform duration-300"></i>
                <span class="text-sm font-bold text-white tracking-wide">agranibank.org</span>
            </a>
        </div>
    </div>
</div>

<style>
/* Custom scrollbar for trending section */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

@endsection

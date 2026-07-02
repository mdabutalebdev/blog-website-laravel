<footer class="bg-gray-900 border-t border-gray-800 mt-auto pt-16 pb-8 relative overflow-hidden text-white">
    <!-- Optional Background Graphic (Soft Gradient Blob) -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-gradient-to-br from-blue-900 to-indigo-900 opacity-20 blur-3xl z-0"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-gradient-to-tr from-purple-900 to-blue-900 opacity-20 blur-3xl z-0"></div>

    <div class="container mx-auto px-4 lg:px-16 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
            
            <!-- Column 1: Brand Info -->
            <div class="space-y-4">
                <a href="/" class="inline-block">
                    <img src="/uploads/avatars/logo.jpeg" alt="Logo" class="h-16 w-auto object-contain rounded-lg shadow-sm border border-gray-700">
                </a>
                <p class="text-gray-400 text-sm leading-relaxed pr-4">
                    A trusted platform for reliable information. We are committed to keeping you informed with accurate and timely updates on education, health, banking, and law.
                </p>
                <div class="flex gap-4 pt-2">
                    @if(\App\Models\Setting::get('social_active_facebook', '1') == '1')
                    <a href="{{ \App\Models\Setting::get('social_url_facebook', 'https://www.facebook.com/jyotirmoy.sameer') }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-800 text-gray-300 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors shadow-sm" title="Facebook">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    @endif
                    
                    @if(\App\Models\Setting::get('social_active_whatsapp', '1') == '1')
                    <a href="{{ \App\Models\Setting::get('social_url_whatsapp', 'https://wa.me/01710845363') }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-800 text-gray-300 flex items-center justify-center hover:bg-green-600 hover:text-white transition-colors shadow-sm" title="WhatsApp">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12.031 0C5.393 0 0 5.392 0 12.029c0 2.128.555 4.195 1.611 6.012L.26 24l6.113-1.603a11.967 11.967 0 005.658 1.423c6.638 0 12.03-5.392 12.03-12.029C24 5.392 18.669 0 12.031 0zm0 21.84c-1.787 0-3.535-.48-5.076-1.39l-.364-.216-3.771.99.998-3.676-.238-.378A9.972 9.972 0 011.97 12.03C1.97 6.496 6.48 1.97 12.031 1.97c5.534 0 10.061 4.526 10.061 10.06 0 5.535-4.527 10.06-10.061 10.06zm5.516-7.53c-.302-.15-1.785-.882-2.062-.983-.277-.101-.48-.15-.681.15-.202.301-.782.983-.958 1.183-.176.202-.353.227-.655.076a8.214 8.214 0 01-2.42-1.493c-.636-.554-1.066-1.238-1.192-1.44-.126-.201-.014-.31.137-.46.136-.135.302-.353.453-.529.15-.176.201-.302.302-.503.1-.202.05-.378-.025-.529-.076-.15-.681-1.644-.933-2.253-.245-.59-.495-.51-.68-.52-.176-.01-.378-.01-.58-.01a1.116 1.116 0 00-.806.378c-.277.302-1.057 1.034-1.057 2.52 0 1.487 1.083 2.925 1.234 3.126.151.202 2.13 3.254 5.157 4.56.721.31 1.282.496 1.722.635.723.23 1.381.197 1.901.12.583-.086 1.785-.73 2.036-1.436.252-.705.252-1.31.176-1.436-.075-.126-.277-.202-.579-.353z"/></svg>
                    </a>
                    @endif
                    
                    @if(\App\Models\Setting::get('social_active_linkedin', '1') == '1')
                    <a href="{{ \App\Models\Setting::get('social_url_linkedin', 'https://linkedin.com/') }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-800 text-gray-300 flex items-center justify-center hover:bg-blue-700 hover:text-white transition-colors shadow-sm" title="LinkedIn">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    @endif
                    
                    @if(\App\Models\Setting::get('social_active_instagram', '1') == '1')
                    <a href="{{ \App\Models\Setting::get('social_url_instagram', 'https://www.instagram.com/jyotirmoysameer') }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-800 text-gray-300 flex items-center justify-center hover:bg-pink-600 hover:text-white transition-colors shadow-sm" title="Instagram">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    @endif

                    @if(\App\Models\Setting::get('social_active_youtube', '1') == '1')
                    <a href="{{ \App\Models\Setting::get('social_url_youtube', 'https://youtube.com/') }}" target="_blank" class="w-10 h-10 rounded-full bg-gray-800 text-gray-300 flex items-center justify-center hover:bg-red-600 hover:text-white transition-colors shadow-sm" title="YouTube">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.377.55a3.016 3.016 0 0 0-2.122 2.136C0 8.07 0 12 0 12s0 3.93.501 5.814a3.016 3.016 0 0 0 2.122 2.136c1.872.55 9.377.55 9.377.55s7.505 0 9.377-.55a3.016 3.016 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div>
                <h3 class="text-white font-bold mb-4 uppercase text-sm tracking-wider">Quick Links</h3>
                <ul class="space-y-3">
                    <li><a href="/" class="text-gray-400 hover:text-blue-400 hover:translate-x-1 inline-block transition-transform text-sm font-medium">Home</a></li>
                    <li><a href="/books" class="text-gray-400 hover:text-blue-400 hover:translate-x-1 inline-block transition-transform text-sm font-medium">Books</a></li>
                    <li><a href="/login" class="text-gray-400 hover:text-blue-400 hover:translate-x-1 inline-block transition-transform text-sm font-medium">Log In</a></li>
                    <li><a href="/register" class="text-gray-400 hover:text-blue-400 hover:translate-x-1 inline-block transition-transform text-sm font-medium">Sign Up</a></li>
                </ul>
            </div>

            <!-- Column 3: Categories -->
            <div>
                <h3 class="text-white font-bold mb-4 uppercase text-sm tracking-wider">Categories</h3>
                <ul class="space-y-3">
                    <li><a href="/category/banking" class="text-gray-400 hover:text-purple-400 hover:translate-x-1 inline-block transition-transform text-sm font-medium">Banking</a></li>
                    <li><a href="/category/law" class="text-gray-400 hover:text-purple-400 hover:translate-x-1 inline-block transition-transform text-sm font-medium">Law</a></li>
                    <li><a href="/category/education" class="text-gray-400 hover:text-purple-400 hover:translate-x-1 inline-block transition-transform text-sm font-medium">Education</a></li>
                    <li><a href="/category/health" class="text-gray-400 hover:text-purple-400 hover:translate-x-1 inline-block transition-transform text-sm font-medium">Health</a></li>
                </ul>
            </div>

            <!-- Column 4: Contact Us instead of Subscribe -->
            <div>
                <h3 class="text-white font-bold mb-4 uppercase text-sm tracking-wider">Contact Us</h3>
                <p class="text-gray-400 text-sm mb-4">
                    Have any questions or suggestions? We'd love to hear from you.
                </p>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <div class="flex flex-col gap-1">
                            <a href="mailto:jyotirmoysarker2026@gmail.com" class="hover:text-blue-400 transition-colors">jyotirmoysarker2026@gmail.com</a>
                            <a href="mailto:sameersarker@ymail.com" class="hover:text-blue-400 transition-colors">sameersarker@ymail.com</a>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span>WhatsApp: 01710845363</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8 mt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-400 text-sm text-center md:text-left">
                &copy; {{ date('Y') }} BlogSite Blog Platform. All rights reserved.
            </p>
            <div class="flex gap-4 text-sm text-gray-400 font-medium">
                <span>Created by <a href="https://www.extrainweb.com/" target="_blank" class="text-blue-400 hover:text-blue-300 transition-colors">Extrain Web</a></span>
            </div>
        </div>
    </div>
</footer>

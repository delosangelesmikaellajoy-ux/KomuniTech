<footer class="bg-neutral-900 text-neutral-200 border-t border-neutral-800 mt-12 py-8">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Brand -->
            <div>
                <h3 class="text-white font-bold text-lg mb-2">KomuniTech</h3>
                <p class="text-sm text-neutral-400">Streamlining barangay document services for everyone.</p>
            </div>

            <!-- Links -->
            <div>
                <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-primary-400 transition">Dashboard</a></li>
                    <li><a href="#" class="hover:text-primary-400 transition">About Us</a></li>
                    <li><a href="#" class="hover:text-primary-400 transition">Contact</a></li>
                </ul>
            </div>

            <!-- Info -->
            <div>
                <h4 class="text-white font-semibold mb-4">Info</h4>
                <p class="text-sm text-neutral-400">© {{ now()->year }} KomuniTech. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

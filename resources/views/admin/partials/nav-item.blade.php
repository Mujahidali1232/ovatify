<a href="{{ route($route) }}"
   class="admin-sidebar-item flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-150 hover:bg-white/5 {{ Request::routeIs($route) || Request::routeIs($route.'.*') ? 'active' : 'text-gray-400' }}">
    <i class="fa-solid {{ $icon }} w-5 text-center"></i>
    <span class="font-medium text-sm">{{ $label }}</span>
</a>

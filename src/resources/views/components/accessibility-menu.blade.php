<!-- Panel de Accesibilidad -->
<div class="fixed top-1/2 right-0 transform -translate-y-1/2 z-[9999]">
    <!-- Botón toggle para móvil -->
    <div class="md:hidden bg-blue-600 rounded-l-xl p-2 shadow-2xl">
        <button onclick="toggleAccessibilityMenu()"
                class="w-8 h-8 bg-white text-blue-600 text-sm font-bold rounded-md shadow border border-gray-200 flex items-center justify-center"
                title="Menú de Accesibilidad">
            <i class="fa-solid fa-universal-access"></i>
        </button>
    </div>

    <!-- Panel de accesibilidad -->
    <div id="accessibilityPanel" class="hidden md:flex bg-blue-600 rounded-l-xl p-2 flex-col gap-2 shadow-2xl max-h-[80vh] overflow-y-auto">
        <button onclick="adjustFontSize(1)" title="Aumentar tamaño"
            class="w-8 h-8 bg-white text-blue-600 font-bold rounded-md shadow border border-gray-200 text-xs">A+</button>
        <button onclick="adjustFontSize(-1)" title="Disminuir tamaño"
            class="w-8 h-8 bg-white text-blue-600 font-bold rounded-md shadow border border-gray-200 text-xs">A-</button>
        <button onclick="toggleContrast()" title="Alto contraste"
            class="w-8 h-8 bg-white text-blue-600 text-sm font-bold rounded-md shadow border border-gray-200"><i class="fa-solid fa-adjust"></i></button>
        <button onclick="toggleDarkMode()" title="Cambiar modo"
            class="w-8 h-8 bg-white text-blue-600 text-sm font-bold rounded-md shadow border border-gray-200"><i class="fa-solid fa-sun"></i></button>
        <button onclick="resetAccessibility()" title="Reiniciar accesibilidad"
            class="w-8 h-8 bg-white text-blue-600 text-sm font-bold rounded-md shadow border border-gray-200"><i class="fa-solid fa-rotate"></i></button>
        <a href="https://centroderelevo.gov.co/632/w3-channel.html" target="_blank" title="Centro de Relevo"
            class="w-8 h-8 bg-white text-blue-600 font-bold rounded-md shadow border border-gray-200 text-xs flex justify-center items-center">
            <span><i class="fa-solid fa-hands-clapping"></i></span>
        </a>
    </div>
</div>

<script>
    let fontSize = parseInt(sessionStorage.getItem('fontSize')) || 100;
    const contrastEnabled = sessionStorage.getItem('contrast') === 'true';
    const darkModeEnabled = sessionStorage.getItem('darkMode') === 'true';

    // Inicializar configuraciones
    document.documentElement.style.fontSize = fontSize + '%';
    if (contrastEnabled) document.documentElement.style.filter = 'invert(1) contrast(1.5) brightness(0.9)';
    if (darkModeEnabled) document.documentElement.style.filter = 'invert(1) hue-rotate(180deg)';

    function toggleAccessibilityMenu() {
        const panel = document.getElementById('accessibilityPanel');
        panel.classList.toggle('hidden');
        panel.classList.toggle('flex');
    }

    // Cerrar el menú cuando se hace clic fuera de él en móvil
    document.addEventListener('click', function(event) {
        const panel = document.getElementById('accessibilityPanel');
        const toggleButton = event.target.closest('button[onclick="toggleAccessibilityMenu()"]');
        const isInsidePanel = event.target.closest('#accessibilityPanel');

        if (!toggleButton && !isInsidePanel && window.innerWidth < 768) {
            panel.classList.add('hidden');
            panel.classList.remove('flex');
        }
    });

    function adjustFontSize(change) {
        fontSize = Math.min(150, Math.max(80, fontSize + change * 10));
        document.documentElement.style.fontSize = fontSize + '%';
        sessionStorage.setItem('fontSize', fontSize);
    }

    function toggleContrast() {
        const currentFilter = document.documentElement.style.filter;
        if (currentFilter.includes('invert(1) contrast(1.5)')) {
            document.documentElement.style.filter = '';
            sessionStorage.setItem('contrast', 'false');
        } else {
            document.documentElement.style.filter = 'invert(1) contrast(1.5) brightness(0.9)';
            sessionStorage.setItem('contrast', 'true');
        }
    }

    function toggleDarkMode() {
        const currentFilter = document.documentElement.style.filter;
        if (currentFilter.includes('hue-rotate(180deg)')) {
            document.documentElement.style.filter = '';
            sessionStorage.setItem('darkMode', 'false');
        } else {
            document.documentElement.style.filter = 'invert(1) hue-rotate(180deg)';
            sessionStorage.setItem('darkMode', 'true');
        }
    }

    function resetAccessibility() {
        fontSize = 100;
        document.documentElement.style.fontSize = '100%';
        document.documentElement.style.filter = '';
        sessionStorage.removeItem('fontSize');
        sessionStorage.removeItem('contrast');
        sessionStorage.removeItem('darkMode');
    }
</script>

<style>
    html {
        transition: filter 0.3s ease;
    }
</style>

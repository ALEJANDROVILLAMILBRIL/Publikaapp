<div class="fixed top-1/2 right-0 transform -translate-y-1/2 z-[9999]">
    <div class="bg-blue-600 rounded-l-xl p-2 flex flex-col gap-2 shadow-2xl max-h-[80vh] overflow-y-auto">
        <button onclick="adjustFontSize(1)" title="Aumentar tamaño"
            class="w-8 h-8 bg-white text-blue-600 font-bold rounded-md shadow border border-gray-200 text-xs">A+</button>
        <button onclick="adjustFontSize(-1)" title="Disminuir tamaño"
            class="w-8 h-8 bg-white text-blue-600 font-bold rounded-md shadow border border-gray-200 text-xs">A-</button>
        <button onclick="toggleContrast()" title="Alto contraste"
            class="w-8 h-8 bg-white text-blue-600 text-sm font-bold rounded-md shadow border border-gray-200">☀</button>
        <button onclick="toggleDarkMode()" title="Cambiar modo"
            class="w-8 h-8 bg-white text-blue-600 text-sm font-bold rounded-md shadow border border-gray-200">🌙</button>
        <button onclick="resetAccessibility()" title="Reiniciar accesibilidad"
            class="w-8 h-8 bg-white text-blue-600 text-sm font-bold rounded-md shadow border border-gray-200">↺</button>
    </div>
</div>

<script>
    let fontSize = parseInt(localStorage.getItem('fontSize')) || 100;
    const contrastEnabled = localStorage.getItem('contrast') === 'true';
    const darkModeEnabled = localStorage.getItem('darkMode') === 'true';
    console.log('Dark Mode:', darkModeEnabled);


    document.documentElement.style.fontSize = fontSize + '%';
    if (contrastEnabled) document.body.classList.add('contrast');
    if (darkModeEnabled) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    function adjustFontSize(change) {
        fontSize = Math.min(150, Math.max(80, fontSize + change * 10));
        document.documentElement.style.fontSize = fontSize + '%';
        localStorage.setItem('fontSize', fontSize);

        if (fontSize >= 120) {
            document.body.style.overflowY = 'auto';
        } else {
            document.body.style.overflowY = 'hidden';
        }
    }

    function toggleContrast() {
        document.body.classList.toggle('contrast');
        localStorage.setItem('contrast', document.body.classList.contains('contrast'));
    }

    function toggleDarkMode() {
        document.documentElement.classList.toggle('dark');
        const darkModeState = document.documentElement.classList.contains('dark');
        localStorage.setItem('darkMode', darkModeState);
    }

    function resetAccessibility() {
        fontSize = 100;
        document.documentElement.style.fontSize = '100%';
        document.body.classList.remove('contrast');
        document.documentElement.classList.remove('dark');
        document.body.style.overflowY = 'hidden';
        localStorage.removeItem('fontSize');
        localStorage.removeItem('contrast');
        localStorage.removeItem('darkMode');
    }
</script>

<style>
    .contrast {
        background-color: #000 !important;
        color: #ff0 !important;
    }

    .contrast a {
        color: #0ff !important;
    }

    .fixed {
        position: fixed;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        z-index: 9999;
    }

    .max-h-[80vh] {
        max-height: 80vh;
    }
</style>
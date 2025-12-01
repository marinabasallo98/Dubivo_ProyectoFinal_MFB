import './bootstrap';

// Importar todos los componentes de forma dinámica
const loadComponents = async () => {
    try {
        // ActorFilters se auto-inicializa, solo necesitamos cargarlo
        const actorModule = await import('./components/ActorFilters.js');
        
        // Cargar otros componentes si existen
        const modules = {};
        
        if (document.getElementById('schoolsContainer') || document.querySelector('.school-filters')) {
            const schoolModule = await import('./components/SchoolFilters.js');
            modules.SchoolFilters = schoolModule.SchoolFilters;
        }
        
        if (document.getElementById('worksContainer') || document.querySelector('.work-filters')) {
            const workModule = await import('./components/WorkFilters.js');
            modules.WorkFilters = workModule.WorkFilters;
        }
        
        // Guardar en window para acceso global (si es necesario)
        window.ActorFilters = actorModule.ActorFilters;
        if (modules.SchoolFilters) window.SchoolFilters = modules.SchoolFilters;
        if (modules.WorkFilters) window.WorkFilters = modules.WorkFilters;
        
        // Inicializar SchoolFilters y WorkFilters si existen
        initializeOtherComponents(modules);
        
    } catch (error) {
        console.warn('Algunos componentes no se pudieron cargar:', error);
        // Continuar aunque falle la carga de algún componente
    }
};

function initializeOtherComponents(modules) {
    // SchoolFilters (si necesita inicialización explícita)
    if (modules.SchoolFilters && document.getElementById('schoolsContainer')) {
        try {
            new modules.SchoolFilters();
        } catch (e) {
            console.warn('Error inicializando SchoolFilters:', e);
        }
    }
    
    // WorkFilters (si necesita inicialización explícita)
    if (modules.WorkFilters && document.getElementById('worksContainer')) {
        try {
            new modules.WorkFilters();
        } catch (e) {
            console.warn('Error inicializando WorkFilters:', e);
        }
    }
}

// Inicializar cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadComponents);
} else {
    loadComponents();
}

// Exportar para uso en módulos (si es necesario)
export { loadComponents };
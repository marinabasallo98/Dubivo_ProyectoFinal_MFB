export class ActorFilters {
    constructor() {
        console.log('ActorFilters inicializado');
        this.initForCurrentPage();
    }

    initForCurrentPage() {
        // Página de índice de actores
        if (document.querySelector('.actor-card')) {
            this.initActorIndex();
        }
        
        // Página de edición/creación de actor
        if (document.querySelector('form[action*="actors"]')) {
            this.initActorForm();
        }
    }

    initActorIndex() {
        console.log('Inicializando para índice de actores');
        // Solo el código esencial para filtros
        this.setupBasicFilters();
    }

    initActorForm() {
        console.log('Inicializando para formulario de actor');
        // Solo mejoras visuales básicas, NO toggle
        this.enhanceFormVisuals();
    }

    setupBasicFilters() {
        const searchInput = document.getElementById('searchActor');
        if (searchInput) {
            let timeout;
            searchInput.addEventListener('input', () => {
                clearTimeout(timeout);
                timeout = setTimeout(() => this.filterActors(), 300);
            });
        }
        
        // Filtros básicos
        document.querySelectorAll('#filter-form input').forEach(input => {
            input.addEventListener('change', () => this.filterActors());
        });
    }

    filterActors() {
        const searchTerm = document.getElementById('searchActor')?.value.toLowerCase() || '';
        const actorCards = document.querySelectorAll('.actor-card');
        
        actorCards.forEach(card => {
            const actorName = card.getAttribute('data-name').toLowerCase();
            card.style.display = actorName.includes(searchTerm) ? 'flex' : 'none';
        });
    }

    enhanceFormVisuals() {
        // Mejorar visualmente los radio buttons de disponibilidad
        document.querySelectorAll('input[name="is_available"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Actualizar estilos de los labels
                document.querySelectorAll('input[name="is_available"]').forEach(r => {
                    const label = r.closest('label');
                    if (r.checked) {
                        label.classList.add('border-2', 'bg-opacity-10');
                        label.classList.remove('border-gray-300');
                    } else {
                        label.classList.remove('border-2', 'bg-opacity-10');
                        label.classList.add('border-gray-300');
                    }
                });
            });
        });
        
        // Previsualización de imagen
        const photoInput = document.getElementById('photo');
        if (photoInput) {
            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        let preview = document.getElementById('photoPreview');
                        if (!preview) {
                            preview = document.createElement('img');
                            preview.id = 'photoPreview';
                            preview.className = 'w-16 h-16 object-cover rounded-lg mt-2';
                            photoInput.parentNode.appendChild(preview);
                        }
                        preview.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    }
}

// Auto-inicialización
if (typeof window !== 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        // Solo crear instancia si es necesario
        if (document.querySelector('.actor-card') || document.querySelector('form[action*="actors"]')) {
            window.actorFilters = new ActorFilters();
        }
    });
}
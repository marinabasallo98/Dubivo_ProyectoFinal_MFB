//Manejamos los filtros de actores
export class ActorFilters {
    constructor() {
        console.log('🎭 Filtros de actores listos');
        this.iniciar();
    }

    iniciar() {
        //Página de lista de actores
        if (document.querySelector('.actor-card')) {
            this.filtrarPorBusqueda();
        }
        
        //Página de formulario de actor
        if (document.querySelector('form[action*="actors"]')) {
            this.mejorarFormulario();
        }
    }

    //Filtramos actores por búsqueda
    filtrarPorBusqueda() {
        const buscador = document.getElementById('searchActor');
        if (!buscador) return;

        let tiempoEspera;
        
        buscador.addEventListener('input', () => {
            clearTimeout(tiempoEspera);
            tiempoEspera = setTimeout(() => {
                const texto = buscador.value.toLowerCase();
                const tarjetas = document.querySelectorAll('.actor-card');
                
                tarjetas.forEach(tarjeta => {
                    const nombre = tarjeta.getAttribute('data-name').toLowerCase();
                    tarjeta.style.display = nombre.includes(texto) ? 'flex' : 'none';
                });
            }, 300);
        });
    }

    //Mejoramos la experiencia del formulario
    mejorarFormulario() {
        //Previsualizamos la foto cuando se selecciona
        const inputFoto = document.getElementById('photo');
        if (inputFoto) {
            inputFoto.addEventListener('change', function(e) {
                const archivo = e.target.files[0];
                if (archivo && archivo.type.startsWith('image/')) {
                    const lector = new FileReader();
                    lector.onload = function(evento) {
                        //Mostramos miniatura de la foto
                        let vistaPrevia = document.getElementById('photoPreview');
                        if (!vistaPrevia) {
                            vistaPrevia = document.createElement('img');
                            vistaPrevia.id = 'photoPreview';
                            vistaPrevia.className = 'w-16 h-16 object-cover rounded-lg mt-2';
                            inputFoto.parentNode.appendChild(vistaPrevia);
                        }
                        vistaPrevia.src = evento.target.result;
                    };
                    lector.readAsDataURL(archivo);
                }
            });
        }
    }
}

//Inicializamos automáticamente si estamos en página de actores
if (typeof window !== 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        if (document.querySelector('.actor-card') || document.querySelector('form[action*="actors"]')) {
            window.filtrosActor = new ActorFilters();
        }
    });
}
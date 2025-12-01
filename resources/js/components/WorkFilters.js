//Los filtros de obras permiten buscar y filtrar el catálogo
export class WorkFilters {
    constructor() {
        console.log('🎬 Filtros de obras listos');
        this.tiempoEspera = null;
        this.iniciar();
    }

    //Inicializamos todos los componentes del filtro
    iniciar() {
        this.mostrarOcultarFiltros();
        this.configurarFiltros();
        this.aplicarFiltros();
    }

    //Controlamos el botón que muestra u oculta la columna de filtros
    mostrarOcultarFiltros() {
        const boton = document.getElementById('filterToggle');
        const columna = document.getElementById('filterColumn');
        
        if (boton && columna) {
            boton.addEventListener('click', () => {
                columna.classList.toggle('hidden');
                const icono = columna.classList.contains('hidden') ? 'filter' : 'times';
                boton.innerHTML = `<i class="fas fa-${icono} mr-2"></i>${columna.classList.contains('hidden') ? 'Mostrar' : 'Ocultar'} Filtros`;
            });
        }
    }

    //Configuramos los diferentes controles de filtrado
    configurarFiltros() {
        const buscador = document.getElementById('searchWork');
        if (buscador) {
            buscador.addEventListener('input', () => this.aplicarFiltros());
        }

        const botonLimpiar = document.getElementById('clearFilters');
        if (botonLimpiar) {
            botonLimpiar.addEventListener('click', () => {
                document.querySelectorAll('input[type="text"], input[type="number"], input[type="checkbox"]')
                    .forEach(input => {
                        if (input.type === 'checkbox') input.checked = false;
                        else input.value = '';
                    });
                this.aplicarFiltros();
            });
        }
    }

    //Aplicamos los filtros con un pequeño retardo para mejor rendimiento
    aplicarFiltros() {
        clearTimeout(this.tiempoEspera);
        this.tiempoEspera = setTimeout(() => this.filtrarObras(), 300);
    }

    //Filtramos las obras según los criterios seleccionados
    filtrarObras() {
        const texto = document.getElementById('searchWork')?.value.toLowerCase() || '';
        const tipos = Array.from(document.querySelectorAll('.type-filter:checked'))
            .map(cb => cb.value);
        
        const tarjetas = document.querySelectorAll('.work-card');
        let visibles = 0;

        tarjetas.forEach(tarjeta => {
            const titulo = tarjeta.getAttribute('data-title');
            const tipo = tarjeta.getAttribute('data-type');
            
            //Verificamos si pasa cada filtro
            const coincideTexto = !texto || titulo.includes(texto);
            const coincideTipo = tipos.length === 0 || tipos.includes(tipo);
            
            //Mostramos u ocultamos según los filtros
            const mostrar = coincideTexto && coincideTipo;
            tarjetas.style.display = mostrar ? 'flex' : 'none';
            if (mostrar) visibles++;
        });

        //Actualizamos el contador de resultados
        const contador = document.getElementById('resultsCount');
        if (contador) contador.textContent = visibles;
    }
}

//Auto-inicializamos si estamos en una página con obras
if (typeof window !== 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        if (document.querySelector('.work-card')) {
            window.filtrosObra = new WorkFilters();
        }
    });
}
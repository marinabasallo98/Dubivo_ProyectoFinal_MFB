//Manejamos los filtros de escuelas
export class SchoolFilters {
    constructor() {
        console.log('🏫 Filtros de escuelas listos');
        this.tiempoEspera = null;
        this.iniciar();
    }

    iniciar() {
        this.mostrarOcultarFiltros();
        this.configurarFiltros();
        this.aplicarFiltros();
    }

    //Mostramos u ocultamos la columna de filtros
    mostrarOcultarFiltros() {
        const boton = document.getElementById('filterToggle');
        const columna = document.getElementById('filterColumn');
        
        if (boton && columna) {
            boton.addEventListener('click', () => {
                columna.classList.toggle('hidden');
                //Cambiamos el texto del botón
                const icono = columna.classList.contains('hidden') ? 'filter' : 'times';
                boton.innerHTML = `<i class="fas fa-${icono} mr-2"></i>${columna.classList.contains('hidden') ? 'Mostrar' : 'Ocultar'} Filtros`;
            });
        }
    }

    //Configuramos los filtros disponibles
    configurarFiltros() {
        //Búsqueda por texto
        const buscador = document.getElementById('searchSchool');
        if (buscador) {
            buscador.addEventListener('input', () => this.aplicarFiltros());
        }

        //Botón para limpiar filtros
        const botonLimpiar = document.getElementById('clearFilters');
        if (botonLimpiar) {
            botonLimpiar.addEventListener('click', () => {
                //Reseteamos todos los filtros
                document.querySelectorAll('input[type="text"], input[type="number"], input[type="checkbox"]')
                    .forEach(input => {
                        if (input.type === 'checkbox') input.checked = false;
                        else input.value = '';
                    });
                this.aplicarFiltros();
            });
        }
    }

    //Aplicamos los filtros con un pequeño retardo
    aplicarFiltros() {
        clearTimeout(this.tiempoEspera);
        this.tiempoEspera = setTimeout(() => this.filtrarEscuelas(), 300);
    }

    //Filtramos las escuelas según criterios
    filtrarEscuelas() {
        const texto = document.getElementById('searchSchool')?.value.toLowerCase() || '';
        const ciudades = Array.from(document.querySelectorAll('.city-filter:checked'))
            .map(cb => cb.value.toLowerCase());
        
        const tarjetas = document.querySelectorAll('.school-card');
        let visibles = 0;

        tarjetas.forEach(tarjeta => {
            const nombre = tarjeta.getAttribute('data-name');
            const ciudad = tarjeta.getAttribute('data-city').toLowerCase();
            
            const coincideTexto = !texto || nombre.includes(texto);
            const coincideCiudad = ciudades.length === 0 || ciudades.includes(ciudad);
            
            const mostrar = coincideTexto && coincideCiudad;
            tarjeta.style.display = mostrar ? 'flex' : 'none';
            if (mostrar) visibles++;
        });

        //Actualizamos contador
        const contador = document.getElementById('resultsCount');
        if (contador) contador.textContent = visibles;
    }
}
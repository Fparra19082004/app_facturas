// Inicialización de gráficos y funcionalidades
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
    initializeEventListeners();
});

// Función para inicializar los gráficos
function initializeCharts() {
    initializeCobranzasChart();
    initializeTendenciasChart();
}

// Gráfico de Estado de Cobranzas
function initializeCobranzasChart() {
    const cobranzasCtx = document.getElementById('cobranzasChart').getContext('2d');
    new Chart(cobranzasCtx, {
        type: 'pie',
        data: {
            labels: ['Cobrado', 'Pendiente', 'Vencido'],
            datasets: [{
                data: [28350, 33250, 12430],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.7)',
                    'rgba(255, 193, 7, 0.7)',
                    'rgba(220, 53, 69, 0.7)'
                ]
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Estado de Cobranzas'
                }
            }
        }
    });
}

// Gráfico de Tendencias
function initializeTendenciasChart() {
    const tendenciasCtx = document.getElementById('tendenciasChart').getContext('2d');
    new Chart(tendenciasCtx, {
        type: 'line',
        data: {
            labels: ['Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov'],
            datasets: [{
                label: 'Cobros Realizados',
                data: [25000, 28000, 32000, 30000, 28350, 31000],
                borderColor: 'rgba(40, 167, 69, 1)',
                tension: 0.1
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Tendencia de Cobros'
                }
            }
        }
    });
}

// Inicialización de event listeners
function initializeEventListeners() {
    // Event listener para el formulario de pago
    const pagoForm = document.getElementById('pagoForm');
    if (pagoForm) {
        pagoForm.addEventListener('submit', handlePagoSubmit);
    }

    // Event listeners para botones de cobro
    const cobrarButtons = document.querySelectorAll('.btn-cobrar');
    cobrarButtons.forEach(button => {
        button.addEventListener('click', handleCobrarClick);
    });
}

// Manejador de envío del formulario de pago
function handlePagoSubmit(event) {
    event.preventDefault();
    // Aquí iría la lógica para procesar el pago
    console.log('Procesando pago...');
}

// Manejador para botones de cobro
function handleCobrarClick(event) {
    const facturaId = event.target.dataset.facturaId;
    // Aquí iría la lógica para abrir el modal de cobro
    console.log(`Iniciando cobro para factura ${facturaId}`);
}

// Funciones auxiliares para cálculos
function calcularTotales() {
    // Lógica para calcular totales
    return {
        porCobrar: 45680,
        cobradoMes: 28350,
        vencidos: 12430
    };
}

// Función para actualizar el dashboard
function actualizarDashboard() {
    const totales = calcularTotales();
    // Actualizar elementos del DOM con los nuevos totales
    document.querySelector('.total-por-cobrar').textContent = `$${totales.porCobrar}`;
    document.querySelector('.cobrado-mes').textContent = `$${totales.cobradoMes}`;
    document.querySelector('.total-vencidos').textContent = `$${totales.vencidos}`;
}

// Función para filtrar cobros
function filtrarCobros(filtro) {
    // Lógica para filtrar la tabla de cobros
    console.log(`Aplicando filtro: ${filtro}`);
}

// Exportar funciones si se necesita usar en otros archivos
export {
    initializeCharts,
    actualizarDashboard,
    filtrarCobros
};


// Add to cobros.js
function formatPostgreSQLDate(date) {
    return date.toISOString().split('T')[0];
}

function showPaymentModal(facturaId) {
    document.getElementById('factura_id').value = facturaId;
    document.querySelector('input[name="fecha_pago"]').value =
        formatPostgreSQLDate(new Date());
    $('#pagoModal').modal('show');
}
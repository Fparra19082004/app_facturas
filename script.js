// Manejo de facturas
class FacturaManager {
    constructor() {
        this.productos = [];
        this.total = 0;
    }
    
    agregarProducto(producto) {
        this.productos.push(producto);
        this.calcularTotal();
    }

    calcularTotal() {
        this.total = this.productos.reduce((sum, prod) =>
            sum + (prod.precio * prod.cantidad), 0);
    }

    generarFactura() {
        return {
            id: Date.now(),
            productos: this.productos,
            total: this.total,
            fecha: new Date()
        };
    }
}

// Inicialización de gráficos
document.addEventListener('DOMContentLoaded', () => {
    // Gráfico de ventas
    const ventasCtx = document.getElementById('ventasChart').getContext('2d');
    new Chart(ventasCtx, {
        type: 'line',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            datasets: [{
                label: 'Ventas Mensuales',
                data: [12000, 19000, 15000, 21000, 18000, 25000],
                borderColor: 'rgb(75, 192, 192)'
            }]
        }
    });

    // Gráfico de regiones
    const regionesCtx = document.getElementById('regionesChart').getContext('2d');
    new Chart(regionesCtx, {
        type: 'pie',
        data: {
            labels: ['Norte', 'Sur', 'Este', 'Oeste'],
            datasets: [{
                data: [30, 20, 25, 25],
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0'
                ]
            }]
        }
    });
});

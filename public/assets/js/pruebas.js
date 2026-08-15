document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formCargue');
    const inputArchivo = document.getElementById('archivoCargue');
    const archivoSeleccionado = document.getElementById('archivoSeleccionado');
    const estado = document.getElementById('estadoCargue');
    const boton = document.getElementById('btnCargue');

    console.log(form);

    if (!form || !inputArchivo || !archivoSeleccionado || !estado || !boton) {
        return;
    }

    function mostrarEstado(mensaje, tipo) {
        estado.textContent = mensaje;
        estado.className = 'alert mt-4 mb-0 alert-' + tipo;
    }

    inputArchivo.addEventListener('change', function () {
        const archivo = inputArchivo.files[0];

        archivoSeleccionado.textContent = archivo
            ? 'Archivo seleccionado: ' + archivo.name
            : 'Aún no ha seleccionado un archivo.';

        estado.className = 'alert d-none mt-4 mb-0';
    });

    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        if (!inputArchivo.files.length) {
            mostrarEstado('Seleccione un archivo antes de continuar.', 'warning');
            inputArchivo.focus();
            return;
        }

        boton.disabled = true;
        boton.textContent = 'Cargando...';
        estado.className = 'alert d-none mt-4 mb-0';

        try {
            const respuesta = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            });
            const contenido = await respuesta.json();

            if (!respuesta.ok || !contenido.success) {
                throw new Error(contenido.message || 'No fue posible cargar el archivo.');
            }

            mostrarEstado(contenido.message || 'Archivo cargado correctamente.', 'success');
            form.reset();
            archivoSeleccionado.textContent = 'Aún no ha seleccionado un archivo.';
        } catch (error) {
            mostrarEstado(error.message || 'Ocurrió un error al cargar el archivo.', 'danger');
        } finally {
            boton.disabled = false;
            boton.textContent = 'Cargar archivo';
        }
    });
});

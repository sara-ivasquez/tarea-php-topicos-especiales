<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - PHP</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
    <div class="contenedor-principal">
        <!-- Encabezado -->
        <header class="encabezado">
            <h1>Sistema de Gestión de Usuarios</h1>
            <p class="subtitulo">Aplicación web en PHP sin frameworks</p>
        </header>

        <!-- Sección del formulario -->
        <section class="seccion-formulario">
            <h2>Registrar Nuevo Usuario</h2>
            
            <form id="formulario-usuario" class="formulario">
                <div class="grupo-input">
                    <label for="nombre">Nombre completo:</label>
                    <input 
                        type="text" 
                        id="nombre" 
                        name="nombre" 
                        placeholder="Ingresa tu nombre completo"
                        required
                        maxlength="100"
                        autocomplete="off"
                    >
                </div>
                
                <button type="submit" class="boton-primario">
                    Guardar Usuario
                </button>
            </form>

            <!-- Mensaje de respuesta -->
            <div id="mensaje-respuesta" class="mensaje oculto"></div>
        </section>
    </div>

    <script>
        /**
         * Objeto principal para manejar el registro de usuarios
         */
        const GestionUsuarios = {
            
            /**
             * Inicializa la aplicación configurando eventos
             */
            inicializar() {
                this.configurarEventoFormulario();
            },

            /**
             * Configura el evento submit del formulario
             */
            configurarEventoFormulario() {
                const formulario = document.getElementById('formulario-usuario');
                
                formulario.addEventListener('submit', (evento) => {
                    evento.preventDefault();
                    this.procesarRegistro();
                });
            },

            /**
             * Procesa el registro del usuario enviando datos al servidor
             */
            procesarRegistro() {
                const inputNombre = document.getElementById('nombre');
                const nombreUsuario = inputNombre.value.trim();

                // Validar que el nombre no esté vacío
                if (nombreUsuario === '') {
                    this.mostrarMensaje('Por favor ingresa un nombre', 'error');
                    return;
                }

                // Preparar datos del formulario
                const datosFormulario = new FormData();
                datosFormulario.append('nombre', nombreUsuario);

                // Enviar petición al servidor
                this.enviarDatos(datosFormulario);
            },

            /**
             * Envía los datos al servidor mediante fetch API
             * @param {FormData} datosFormulario - Datos del formulario a enviar
             */
            enviarDatos(datosFormulario) {
                fetch('src/guardar.php', {
                    method: 'POST',
                    body: datosFormulario
                })
                .then(respuesta => respuesta.json())
                .then(datos => this.manejarRespuesta(datos))
                .catch(error => this.manejarError(error));
            },

            /**
             * Maneja la respuesta exitosa del servidor
             * @param {Object} datos - Objeto con la respuesta del servidor
             */
            manejarRespuesta(datos) {
                if (datos.exito) {
                    this.mostrarMensaje(datos.mensaje, 'exito');
                    this.limpiarFormulario();
                } else {
                    this.mostrarMensaje(datos.mensaje, 'error');
                }
            },

            /**
             * Maneja errores de conexión o procesamiento
             * @param {Error} error - Objeto de error
             */
            manejarError(error) {
                console.error('Error en la petición:', error);
                this.mostrarMensaje('Error al procesar la solicitud', 'error');
            },

            /**
             * Muestra un mensaje de feedback al usuario
             * @param {string} textoMensaje - Texto del mensaje a mostrar
             * @param {string} tipoMensaje - Tipo de mensaje: 'exito' o 'error'
             */
            mostrarMensaje(textoMensaje, tipoMensaje) {
                const elementoMensaje = document.getElementById('mensaje-respuesta');
                
                elementoMensaje.textContent = textoMensaje;
                elementoMensaje.className = `mensaje ${tipoMensaje}`;
                elementoMensaje.classList.remove('oculto');

                // Ocultar mensaje automáticamente después de 5 segundos
                setTimeout(() => {
                    elementoMensaje.classList.add('oculto');
                }, 5000);
            },

            /**
             * Limpia todos los campos del formulario
             */
            limpiarFormulario() {
                const formulario = document.getElementById('formulario-usuario');
                formulario.reset();
            }
        };

        // Inicializar la aplicación cuando el DOM esté completamente cargado
        document.addEventListener('DOMContentLoaded', () => {
            GestionUsuarios.inicializar();
        });
    </script>
</body>
</html>
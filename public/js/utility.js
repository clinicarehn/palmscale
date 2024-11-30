$(() => {
    // Inicialización o configuraciones si es necesario
});

/**
 * Deshabilita el campo <select> original y su instancia de Tom Select.
 *
 * @param {string} id - El ID del campo <select> (sin el símbolo '#' al inicio) que se desea deshabilitar.
 * @returns {void}
 */
function disableSelect(id) {
    // Deshabilitar el campo <select> original
    $('#' + id).prop('disabled', true);

    // Deshabilitar Tom Select usando su método específico
    const tomSelectInstance = $('#' + id)[0].tomselect;
    if (tomSelectInstance) {
        tomSelectInstance.disable(); // Método interno de Tom Select para deshabilitarlo
    }

    // Añadir la clase 'disabled' para bloquear visualmente Tom Select
    $('#' + id).closest('.ts-wrapper').addClass('locked disabled');

    // Deshabilitar el dropdown de Tom Select y ocultarlo
    $('#' + id + '-ts-dropdown').css('display', 'none'); // Ocultar el menú desplegable

    // Evitar que cualquier clic o evento en el contenedor de Tom Select responda
    $('#' + id + '-ts-control').css('pointer-events', 'none');
}

/**
 * Habilita el campo <select> original y su instancia de Tom Select.
 *
 * @param {string} id - El ID del campo <select> (sin el símbolo '#' al inicio) que se desea habilitar.
 * @returns {void}
 */
function enableSelect(id) {
    // Habilitar el campo <select> original
    $('#' + id).prop('disabled', false);

    // Habilitar Tom Select usando su método específico
    const tomSelectInstance = $('#' + id)[0].tomselect;
    if (tomSelectInstance) {
        tomSelectInstance.enable(); // Método interno de Tom Select para habilitarlo
    }

    // Quitar las clases que bloquean la funcionalidad visual
    $('#' + id).closest('.ts-wrapper').removeClass('locked disabled');

    // Mostrar el dropdown de Tom Select nuevamente
    $('#' + id + '-ts-dropdown').css('display', 'block');

    // Habilitar clics y eventos en el contenedor de Tom Select nuevamente
    $('#' + id + '-ts-control').css('pointer-events', 'auto');
}

/**
 * Habilita todos los campos <select> originales y sus instancias de Tom Select en el formulario.
 *
 * @returns {void}
 */
function enableAllSelects() {
    $('select').each(function() {
        const id = $(this).attr('id'); // Obtiene el ID del campo <select>

        // Habilitar el campo <select> original
        $(this).prop('disabled', false);

        // Habilitar Tom Select usando su método específico
        const tomSelectInstance = this.tomselect; // Accede a la instancia de Tom Select
        if (tomSelectInstance) {
            tomSelectInstance.enable(); // Habilita Tom Select
        }

        // Quitar las clases que bloquean la funcionalidad visual
        $(this).closest('.ts-wrapper').removeClass('locked disabled');

        // Mostrar el dropdown de Tom Select nuevamente
        $('#' + id + '-ts-dropdown').css('display', 'block');

        // Habilitar clics y eventos en el contenedor de Tom Select nuevamente
        $('#' + id + '-ts-control').css('pointer-events', 'auto');
    });
}

/**
 * Deshabilita todos los campos <select> originales y sus instancias de Tom Select en el formulario,
 * excepto los que se especifiquen en el array de excepciones.
 *
 * @param {Array<string>} [exceptions] - Un array opcional de IDs de campos <select> (sin el símbolo '#') que no se deben deshabilitar.
 * @returns {void}
 */
function disableAllSelects(exceptions = []) {
    $('select').each(function() {
        const id = $(this).attr('id'); // Obtiene el ID del campo <select>

        // Verifica si el ID está en el array de excepciones
        if (exceptions.includes(id)) {
            return; // Salir de la función si el ID está en excepciones
        }

        // Deshabilitar el campo <select> original
        $(this).prop('disabled', true);

        // Deshabilitar Tom Select usando su método específico
        const tomSelectInstance = this.tomselect; // Accede a la instancia de Tom Select
        if (tomSelectInstance) {
            tomSelectInstance.disable(); // Deshabilita Tom Select
        }

        // Añadir la clase 'disabled' para bloquear visualmente Tom Select
        $(this).closest('.ts-wrapper').addClass('locked disabled');

        // Ocultar el dropdown de Tom Select
        $('#' + id + '-ts-dropdown').css('display', 'none');

        // Evitar que cualquier clic o evento en el contenedor de Tom Select responda
        $('#' + id + '-ts-control').css('pointer-events', 'none');
    });
}

/**
 * Limpia el valor de todos los campos de relación y su visualización en la interfaz de usuario,
 * excepto los que se especifiquen en el array de excepciones.
 *
 * @param {Array<string>} [exceptions] - Un array opcional de IDs de campos <select> (sin el símbolo '#') que no se deben limpiar.
 * @returns {void}
 */
function clearAllRelationSelectFields(exceptions = []) {
    $('select').each(function() {
        const fieldId = $(this).attr('id'); // Obtiene el ID del campo <select>

        // Verifica si el ID está en el array de excepciones
        if (exceptions.includes(fieldId)) {
            return; // Salir de la función si el ID está en excepciones
        }

        // Obtener la instancia de Tom Select
        const tomSelectInstance = this.tomselect; // Accede a la instancia de Tom Select
        if (tomSelectInstance) {
            tomSelectInstance.clear(); // Usar el método clear de Tom Select para limpiar
        }

        // Limpiar el valor visual que muestra la selección (si es que aplica)
        $('#' + fieldId + '-ts-control').html(''); // Elimina la selección visual
        $('#' + fieldId + '-ts-control').removeClass('is-active'); // Remueve la clase activa si existe
    });
}

/**
 * Limpia el valor del campo de relación y su visualización en la interfaz de usuario.
 *
 * @param {string} fieldId - El ID del campo de relación (sin el símbolo '#' al inicio) que se desea limpiar.
 * @returns {void}
 */
function clearRelationSelectField(fieldId) {
    // Obtener la instancia de Tom Select
    const tomSelectInstance = $('#' + fieldId)[0].tomselect;
    if (tomSelectInstance) {
        tomSelectInstance.clear(); // Usar el método clear de Tom Select para limpiar
    }

    // Limpiar el valor visual que muestra la selección
    $('#' + fieldId + '-ts-control').html(''); // Elimina la selección visual

    // Eliminar la clase "is-active" para limpiar el estado activo
    $('#' + fieldId + '-ts-control').removeClass('is-active');
}

/**
 * Limpia el valor de todos los campos de entrada (input) y su visualización en la interfaz de usuario,
 * excepto los que se especifiquen en el array de excepciones.
 *
 * @param {Array<string>} [exceptions] - Un array opcional de IDs de campos <input> (sin el símbolo '#') que no se deben limpiar.
 * @returns {void}
 */
function clearAllInputFields(exceptions = []) {
    $('input').each(function() {
        const fieldId = $(this).attr('id'); // Obtiene el ID del campo <input>

        // Verifica si el ID está en el array de excepciones
        if (exceptions.includes(fieldId)) {
            return; // Salir de la función si el ID está en excepciones
        }

        // Limpiar el valor del input
        $(this).val(''); // Limpia el valor del campo input

        // Si el input es de tipo checkbox o radio, deseleccionarlo
        if ($(this).attr('type') === 'checkbox' || $(this).attr('type') === 'radio') {
            $(this).prop('checked', false); // Deseleccionar
        }

        // Si el input tiene una visualización adicional (ej. un campo custom), limpiar también su visualización
        $('#' + fieldId + '-custom-control').html(''); // Limpia cualquier visualización extra (si existe)

        // Eliminar clases activas relacionadas con visualización
        $('#' + fieldId).removeClass('is-active');
    });
}

/**
 * Deshabilita todos los campos de entrada (<input>) en el formulario,
 * excepto los que se especifiquen en el array de excepciones.
 *
 * @param {Array<string>} [exceptions] - Un array opcional de IDs de campos <input> (sin el símbolo '#') que no se deben deshabilitar.
 * @returns {void}
 */
function disableAllInputs(exceptions = []) {
    $('input').each(function() {
        const inputId = $(this).attr('id'); // Obtiene el ID del campo <input>

        // Verifica si el ID está en el array de excepciones
        if (exceptions.includes(inputId)) {
            return; // Salir de la función si el ID está en excepciones
        }

        // Establece el atributo readonly a true
        $(this).prop('readonly', true);
    });
}

/**
 * Habilita todos los campos de entrada (<input>) en el formulario,
 * excepto los que se especifiquen en el array de excepciones.
 *
 * @param {Array<string>} [exceptions] - Un array opcional de IDs de campos <input> (sin el símbolo '#') que no se deben habilitar.
 * @returns {void}
 */
function enableAllInputs(exceptions = []) {
    $('input').each(function() {
        const inputId = $(this).attr('id'); // Obtiene el ID del campo <input>

        // Verifica si el ID está en el array de excepciones
        if (exceptions.includes(inputId)) {
            return; // Salir de la función si el ID está en excepciones
        }

        // Establece el atributo readonly a false
        $(this).prop('readonly', false);
    });
}
$ = jQuery.noConflict();

function fixEncoding(str) {
    try {
        return decodeURIComponent(escape(str));
    } catch (e) {
        return str;
    }
}

function aplicarCorreccionARespuesta(respuesta) {
    // Recorremos cada propiedad de la respuesta
    for (let key in respuesta) {
        if (typeof respuesta[key] === 'string') {
            // Corregimos los caracteres especiales en las cadenas
            respuesta[key] = fixEncoding(respuesta[key]);
        } else if (typeof respuesta[key] === 'object') {
            // Si la propiedad es un objeto o array, hacemos la corrección de manera recursiva
            aplicarCorreccionARespuesta(respuesta[key]);
        }
    }
}

function armarPeticionAjax(formData, resolve, reject) {
    $.ajax({
        url: miAjax.ajaxurl, // WordPress AJAX handler URL
        type: 'POST',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        success: function (response) {
            aplicarCorreccionARespuesta(response);
            if (response.success) {
                // Aplicamos corrección de caracteres a la respuesta antes de resolver
                resolve(response.data.respuesta);
            } else {
                reject(response.data.errores);
            }
        },
        error: function (xhr, status, error) {
            reject([`Error desconocido`]);
        }
    });
}

function crearFormularioAjax(action, data = {}){
    try {
        //Obtengo datos del form
        let formData = new FormData();
        //seteo accion de wordpress
        formData.append("action", action);

        for (let key in data) {
            if (data.hasOwnProperty(key)) {
                formData.append(key, data[key]);
            }
        }
        return formData;
    } catch  {
        return null;
    }
}



//Función que muestra u oculata el botçon de descargar proyecto
function MostrarresumenMobile(currentStepValue){
    // Manejar el botón de descarga
    if (currentStepValue) {
        $('.price-mobile-bottom').removeClass('d-none').css('display', 'block');
    } else {
        $('.price-mobile-bottom').addClass('d-none').css('display', 'none');
    }
}



function SACAIG_guardar_transient(datos) {
    return new Promise((resolve, reject) => {
        let formData = crearFormularioAjax('SACAIG_save_transient', datos);
        armarPeticionAjax(formData, resolve, reject);
    });
}


// Verificar si es un dispositivo móvil con tamaño de pantalla menor a 1024 px
function esDispositivoMovil() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && window.innerWidth < 1024;
}



function collectFormData() {
    try {
        let poliza = sessionStorage.getItem('selectedProductId');
        const form = document.getElementById('form-contratacion-aig');
       
        const data = {
            poliza
        };

        // Recorremos todos los elementos del formulario
        for (let element of form.elements) {
            if (element instanceof Node) {

                // Para inputs de tipo radio, solo recogemos el seleccionado
                if (element.type === 'radio' && !element.checked) {
                    continue;
                }

                if (element.type === 'checkbox') {
                    data[element.name] = element.checked;
                    continue;
                }         

                // Añadimos el valor al objeto de datos
                data[element.name] = element.value;
            }
        }

        return data;

    } catch (error) {
        console.log(error);
        return null;
    }
}




// Función para el funcionamiento de las pantalls en el formulario
function updateClassesOnStep(steps) {
    
    var currentStep = $('div[id^="step-form-anim-"]:visible').attr('id');
    var currentStepNumber = parseInt(currentStep.replace('step-form-anim-', ''));

    if (steps.includes(currentStepNumber)) {
        $('.bloque-sin-left').addClass('principal-left');
        $('.box-aside-multistp').addClass('d-block');
        $('.box-aside-multistp').removeClass('d-none');
    } else {
        $('.bloque-sin-left').removeClass('principal-left');
        $('.box-aside-multistp').addClass('d-none');
        $('.box-aside-multistp').removeClass('d-block');
    }
}



//Contador para que la verificación de firma no funcione indefinidamente
let contadorVerificacionesFirma = 0;

// FUNCIÓN PARA VERIFICAR EL ESTADO DE LA FIRMA DIGITAL DEL DOCUMENTO CON LLEIDA NET
function SACAIG_verificarEstadoTransaccion(request_id, signature_id, signatory_id, email_asegurado, link_poliza_firmada, name_asegurado) {

    if (contadorVerificacionesFirma < 90) {
        contadorVerificacionesFirma++;

        let formData = new FormData();

        formData.append("action", "SACAIG_verifica_status_proc_firma");
        formData.append("request_id", request_id);
        formData.append("signature_id", signature_id);
        formData.append("signatory_id", signatory_id);
        formData.append("name_asegurado", name_asegurado);

        $.ajax({
            url: miAjax.ajaxurl,
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response) {
                const { data } = response;

                if (response.success) {

                
                const {status} = data;


                    if(!status){
                        setTimeout(()=>{
                            SACAIG_verificarEstadoTransaccion(request_id, signature_id, signatory_id, email_asegurado, link_poliza_firmada, name_asegurado);
                        }, 2000); 
                    } else {
                        let codigoint = parseInt(status);

                        if (codigoint >= 101 && codigoint != 900) {
                            contadorVerificacionesFirma = 0;
                            Swal.fire({
                                title: 'Error!',
                                text: 'Se generó un error 1 desconocido para terminar de contratar tu seguro.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            const policy_data_sacaig = sessionStorage.getItem('policy_data_sacaig');
                            insu_registrar_contract(policy_data_sacaig,signature_id);
                            // Enviar el correo antes de redirigir
                            $('#enviarCorreoBtn').prop('disabled', true); // Deshabilitar el botón mientras se procesa
                           
                            window.location.href = '/agradecimiento-seguro-sagcaig/';


                        }
                    }
                } else {
                    contadorVerificacionesFirma = 0;
                    Swal.fire({
                        title: 'Error!',
                        text: 'Se generó un error 2 desconocido para terminar de contratar tu seguro.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function (xhr, status, error) {
                contadorVerificacionesFirma = 0 ;
                Swal.fire({
                    title: 'Error!',
                    text: 'Se generó un error 3 desconocido para terminar de contratar tu seguro.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }else{
        contadorVerificacionesFirma = 0;
        Swal.fire({
            title: 'Error!',
            text: 'Has agotado el tiempo de espera para la firma del documento.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
}






/************** VALIDACIÓN DE FORMULARIOS *************/
// Función para validar todos los campos
function validarCamposEnDiv(div) {

    // Configuración global de jQuery Validate
    $.extend($.validator.messages, {
        required: "Este campo es obligatorio",
        email: "Introduce un correo electrónico válido",
        number: "Introduce un número válido",
        maxlength: $.validator.format("No más de {0} caracteres"),
        minlength: $.validator.format("Introduce al menos {0} caracteres"),
        rangelength: $.validator.format("Introduce un valor entre {0} y {1} caracteres"),
        range: $.validator.format("Introduce un valor entre {0} y {1}"),
        max: $.validator.format("Introduce un valor menor o igual a {0}"),
        min: $.validator.format("Introduce un valor mayor o igual a {0}")
    });

    // Obtener el formulario que contiene el div
    var form = $(div).closest("form");
    
    // Inicializar jQuery Validate sobre el formulario
    form.validate({
        rules: {
            razon_social: {
                required: true,
                maxlength: 125
            },
            name: {
                required: true,
                maxlength: 100
            },
            apellidos: {
                required: true,
                maxlength: 150
            },
            codigo_postal: {
                required: true,
                validCodigoPostal: true
            },
            provincia: {
                selectRequired: true
            },
            direccion: {
                required: true,
                maxlength: 200
            },
            poblacion: {
                required: true,
                maxlength: 100
            },
            identificador: {
                required: true,
                validIdentificador: true
            },
            email: {
                required: true,
                email: true
            },
            telefono: {
                required: true,
                validTelefono: true
            },
            profesion: {
                required: true
            },
            enf_grave_desctip: {
                required: true
            },
            iban: {
                required: true,
                validIBAN: true
            },
            password: {
                required: true
            },
            numeroAsegurados: {
                required: true,
                min: 1,
                max: 10
            },
            fecha_nacimiento: {
                required: true
            },
            sector_empresa: {
                selectRequired: true
            }
        },
        messages: {
            razon_social: {
                required: "Completa este campo",
                maxlength: "No más de 125 caracteres"
            },
            name: {
                required: "Completa este campo",
                maxlength: "No más de 100 caracteres"
            },
            apellidos: {
                required: "Completa este campo",
                maxlength: "No más de 150 caracteres"
            },
            codigo_postal: {
                required: "Completa este campo",
                validCodigoPostal: "Introduce un Código Postal válido"
            },
            provincia: {
                selectRequired: "Selecciona una opción"
            },
            sector_empresa: {
                selectRequired: "Selecciona una opción"
            },
            direccion: {
                required: "Completa este campo",
                maxlength: "No más de 200 caracteres"
            },
            poblacion: {
                required: "Completa este campo",
                maxlength: "No más de 100 caracteres"
            },
            identificador: {
                required: "Completa este campo",
                validIdentificador: "Introduce un DNI, NIE o CIF válido"
            },
            email: {
                required: "Completa este campo",
                email: "Introduce un email válido"
            },
            telefono: {
                required: "Completa este campo",
                validTelefono: "Introduce un número de teléfono móvil válido"
            },
            profesion: {
                required: "Completa este campo"
            },
            enf_grave_desctip: {
                required: "Completa este campo"
            },
            iban: {
                required: "Completa este campo",
                validIBAN: "Introduce un IBAN válido"
            },
            password: {
                required: "Completa este campo"
            },
            numeroAsegurados: {
                required: "Completa este campo",
                min: "Mínimo 1 asegurado",
                max: "Máximo 10 asegurados"
            },
            fecha_nacimiento: {
                required: "Completa este campo"
            }               
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2-hidden-accessible')) {
                error.insertAfter(element.next('.select2-container'));
            } else if (element.is(":radio") || element.is(":checkbox")) {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    // Validar solo los campos dentro del div
    var campos = $(div).find("input, textarea, select");
    var esValido = true;

    campos.each(function() {
        if (!$(this).valid()) {
            esValido = false;
        }
    });

    return esValido;
}




$(document).ready(function() {
    
    function scrollToTop() {
        $('html, body').animate({ scrollTop: 0 }, 'fast');
    }

    //Ocultamos el loader
    $('#loader-simple').attr('style', 'display: none !important;');

    //Subir arriba la página
    scrollToTop()


    // Si estamos en la página que se realiza la firma de la plantilla
    let path = window.location.pathname;
    let page = path.replaceAll('/', '');
    let url_producto = miAjax.url_producto;

    




    //Si existe pantallad de un solo precio la definimos aquí
    let  pantallaPrecio = "";

    if (pantallaPrecio) {
        const stepFormAnim = $('#step-form-anim-' + pantallaPrecio);

        if (stepFormAnim.length > 0 && stepFormAnim.css('display') !== 'none') {
            $('body').addClass('fondo-body-verde');
        } else {
            $('body').removeClass('fondo-body-verde');
        }
    }


    //Registramos el lead en insuguru
    $('#btn-paso-8').click(async function(event) {
        await insu_registrar_lead();

        let IDprecioSeguro = sessionStorage.getItem('selectedProductId')
        let precioSeguro = SACAIG_poliza_selected(IDprecioSeguro)

        insu_registrar_rate(precioSeguro.precio)
    });


    function isValidIban(iban) {
        // Elimina los espacios en blanco
        iban = iban.replace(/\s+/g, '');

        // Expresión regular básica para validar el formato del IBAN
        const ibanPattern = /^[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}$/;

        if (!ibanPattern.test(iban)) {
            return false; // Formato inválido
        }

        return true; // El IBAN es válido
    }


    //FUNCIONALIDAD DEL PASO FINAL DEL FORMULARIO
    // Cache de selectores
    const $sgPasoAct          = $('#sg-paso-14');
    const $sgPasoPresu         = $('#sg-paso-13');

    const $suscripcionCond    = $('#suscripcion_cond');
    const $declaracionDatos   = $('#declaracion_datos');
    const $iban               = $('#iban');
    const $loaderSimple       = $('#loader-simple');

    /**
     * Función para verificar si el IBAN es inválido o está vacío.
     */
    function hasInvalidFields() {
        const ibanVal = $iban.val().trim();
        return (ibanVal === '' || !isValidIban(ibanVal));
    }

    /**
     * Función que comprueba si ambos checkboxes están activados.
     */
    function allChecksAreValid() {
        return $suscripcionCond.is(':checked') && $declaracionDatos.is(':checked');
    }

    /**
     * Habilita o deshabilita el botón del paso final en función de la validez de los campos.
     */
    function toggleButtonFinalStep() {
        if (allChecksAreValid() && !hasInvalidFields()) {
            $sgPasoAct
                .addClass('btn-next-form btn-next-paso-asg')
                .removeClass('disabled');
        } else {
            $sgPasoAct
                .removeClass('btn-next-form btn-next-paso-asg')
                .addClass('disabled');
        }
    }

    $sgPasoPresu.on('click', function() {
  
        // Obtiene datos del formulario
        const dataForm = collectFormData();

        // Muestra el loader
        $loaderSimple.show();

        // Realiza la llamada AJAX al backend de WordPress para generar el proyecto
        $.ajax({
            url: miAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'SACAIG_generar_proyecto',
                ...dataForm
            },
            success: async function(response) {
                if (response.success) {
                    // Data url proyecto
                    $('#descargar-presupuesto-SACAIG')
                    .attr('href', response.data.respuesta.url_proyecto)
                    .attr('download', 'Presupuesto_seguro_accidentes');
                    // Registrar proyecto según tu lógica actual
                    await  insu_registrar_proyecto(response.data.respuesta.url_proyecto);
                    $('#descargar-presupuesto-SACAIG').removeClass('d-none').css('display', 'block');
                } else {
                    console.log(response);
                    console.log('Ha fallado el proceso en el servidor.');
                }
                $loaderSimple.attr('style', 'display: none !important;');
            },
            error: function(err) {
                console.log(err);
                console.log('Error en la llamada AJAX.');
                $loaderSimple.attr('style', 'display: none !important;');
            }
        });
    });
    /**
     * Manejo de clic en el botón final.
     * - Si está deshabilitado o hay campos inválidos, muestra SweetAlert y no continúa.
     * - En caso contrario, ejecuta la llamada AJAX y maneja el flujo.
     */
    $sgPasoAct.on('click', function(e) {
        toggleButtonFinalStep()
        
        if ($sgPasoAct.hasClass('disabled') || hasInvalidFields()) {
            e.preventDefault();
            Swal.fire({
                title: '',
                text: hasInvalidFields()
                    ? 'Por favor, complete todos los campos correctamente.'
                    : 'Por favor, acepta los términos y condiciones junto con la conformidad de la información para continuar.',
                icon: 'warning',
                confirmButtonText: 'Aceptar'
            });
            return;
        }
        
        // Obtiene datos del formulario
        const dataForm = collectFormData();
        // Llamada previa a patch lead (según tu lógica actual)
        insu_patch_lead(dataForm.suscripcion_pub);

        // Muestra el loader
        $loaderSimple.show();

        // Realiza la llamada AJAX al backend de WordPress
        $.ajax({
            url: miAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'SACAIG_procesar_poliza',
                ...dataForm
            },
            success: async function(response) {
                if (response.success) {
                    const respuestaFirma = response.data.respuesta.respuesta_firma;
                    const responsedataUsr = response.data.datos_user;
                    let INSU_WP_ARISE_RATE = sessionStorage.getItem('INSU_WP_ARISE_RATE');
                    let INSU_WP_ARISE_LEAD = sessionStorage.getItem('INSU_WP_ARISE_LEAD');

                     await SACAIG_guardar_transient({
                        ...dataForm,
                        INSU_WP_ARISE_RATE,
                        INSU_WP_ARISE_LEAD,
                        email_to_asegurar : responsedataUsr.email,
                        name_to_asegurar : responsedataUsr.nombre_completo,
                        request_id: respuestaFirma.request_id,
                        signature_id: respuestaFirma.signature_id,
                        signatory_id: respuestaFirma.signatory_id,
                        url_redirect: respuestaFirma.url_redirect
                    });


                    // Redirige a la ruta de tu preferencia
                    window.location.href = respuestaFirma.url_redirect;
                } else {
                    console.log(response);
                    console.log('Ha fallado el proceso en el servidor.');
                }
            },
            error: function(err) {
                console.log(err);
                console.log('Error en la llamada AJAX.');
            },
            complete: function() {
                // Oculta el loader cuando finaliza la petición
                $loaderSimple.hide();
            }
        });
    });

    /**
     * Vincular eventos de cambio en checkboxes y campo IBAN
     * para habilitar/deshabilitar el botón automáticamente.
     */
    $suscripcionCond.on('change', toggleButtonFinalStep);
    $declaracionDatos.on('change', toggleButtonFinalStep);
    $iban.on('input change', toggleButtonFinalStep);





    /********* FUNCIONAMIENTO DE LAS PANTALLAS DEL FORMULARIO  *****/
    //Definimos las pantallas con aside
    let pantallasConAside = [1,2,3,4,5,6,7,8,9,10,11,12,13,14];


    // Inicialmente, mostrar solo el primer paso y ocultar los botones de volver si estamos en el primer paso
    $('div[id^="step-form-anim-"]').hide();
    $('#step-form-anim-1').show();
    $('.link-paso-atras').hide();


    // Inicialmente, mostrar solo el primer paso y ocultar los botones de volver si estamos en el primer paso
    $('div[id^="step-form-anim-"]').hide();
    $('#step-form-anim-1').show();
    $('.link-paso-atras').hide();


    // Función para determinar el siguiente paso basado en las respuestas
    function getNextStep(currentStep) {
        let nextStep = currentStep.next('div[id^="step-form-anim-"]');

        /******** AQUÍ SE INTRODUCEN LAS CONDICIONES BAJO LAS CUALES SE SALTAN PANTALLAS ***********/
        if (currentStep.is('#step-form-anim-2') && $('input[name="actividad_maual"]:checked').val() == 'no') {
            $('#descr_trabajo_manual').val("")
            return $('#step-form-anim-4');          
        }else if(currentStep.is('#step-form-anim-2') && $('input[name="actividad_maual"]:checked').val() == 'si'){
            agregarNuevoStep()
        }


        if (currentStep.is('#step-form-anim-4') && $('input[name="enf_cardiaca"]:checked').val() == 'no') {
            $('#enf_cardiaca_descript').val("")
            return $('#step-form-anim-6');   
        }else if(currentStep.is('#step-form-anim-4') && $('input[name="enf_cardiaca"]:checked').val() == 'si'){
            agregarNuevoStep()
        }


        if (currentStep.is('#step-form-anim-6') && $('input[name="enf_grave"]:checked').val() == 'no') {
            $('#enf_grave_desctip').val("")
            return $('#step-form-anim-8');
        }else if(currentStep.is('#step-form-anim-6') && $('input[name="enf_grave"]:checked').val() == 'si'){
            agregarNuevoStep()
        }


        if (currentStep.is('#step-form-anim-9') && $('input[name="tomador_diferente"]:checked').val() == 'no') {
            $('#step-form-anim-10 input').val('');
            return $('#step-form-anim-11');          
        }else if(currentStep.is('#step-form-anim-9') && $('input[name="tomador_diferente"]:checked').val() == 'si'){
            agregarNuevoStep()
        }


        if (currentStep.is('#step-form-anim-11') && $('input[name="establece_herederos"]:checked').val() == 'no') {
            $('#step-form-anim-12 input').val('');
            return $('#step-form-anim-13');      
        }else if(currentStep.is('#step-form-anim-11') && $('input[name="establece_herederos"]:checked').val() == 'si'){
            agregarNuevoStep()
        }

        // Actualiza los pasos visuales
        let currentIndex = parseInt(currentStep.attr('id').replace('step-form-anim-', ''));
        let nextIndex = parseInt(nextStep.attr('id').replace('step-form-anim-', ''));
        
        // Desactiva los puntos que se están saltando
        for (let i = currentIndex + 1; i < nextIndex; i++) {
            $('.steps_asegura_forms').eq(i - 1).removeClass('active');
        }

        return nextStep;
    }

    // Función para determinar el paso anterior basado en el historial
    function getPreviousStep() {
        return $('#' + stepHistory.pop());
    }

    // Variable para guardar el historial de pasos
    let stepHistory = [];

    //Función que muestra u oculata el resumen de  mobile
    function MostrarBotonDescargaProyecto(currentStepValue){
        // Manejar el botón de descarga
        if (currentStepValue > 14) {
            $('#descargar-presupuesto-SACAIG').removeClass('d-none').css('display', 'block');
        } else {
            $('#descargar-presupuesto-SACAIG').addClass('d-none').css('display', 'none');
        }
    }

    // Manejar el botón de siguiente
    $('.btn-next-form').click(async function (event) {
        event.preventDefault();

        var currentStep = $(this).closest('div[id^="step-form-anim-"]');
        var isvalidaPantalla = validarCamposEnDiv(currentStep);
        var nextStep = await getNextStep(currentStep);

        var currentPasoLinea = $('.steps_asegura_forms.active');
        var nextStepPasoLinea = currentPasoLinea.next('.steps_asegura_forms');

        if (nextStep.length && isvalidaPantalla) {
            stepHistory.push(currentStep.attr('id')); // Guardar el paso actual en el historial

            currentStep.fadeOut(250, function () {
                nextStep.fadeIn(250);

                currentPasoLinea.removeClass('active');
                nextStepPasoLinea.addClass('active');

                updateClassesOnStep(pantallasConAside);
            });

            $('.link-paso-atras').show();

            scrollToTop();
        }
        // Obtener el valor actual del paso a partir del ID
        var currentStepId = currentStep.attr('id'); 
        var currentStepValue = parseInt(currentStepId.split('-').pop(), 10);


        MostrarBotonDescargaProyecto(currentStepValue)
        MostrarresumenMobile(currentStepValue)
    });

    // Manejar el botón de atrás
    $('.link-paso-atras').click(function (event) {
        event.preventDefault();

        var currentStep = $('div[id^="step-form-anim-"]:visible');
        var prevStep = $('#' + stepHistory.pop()); // Obtener el paso anterior del historial

        var actualPasoLinea = $('.steps_asegura_forms.active');
        var anteriorStepPasoLinea = actualPasoLinea.prev('.steps_asegura_forms');

        if (prevStep.length) {
            currentStep.fadeOut(250, function () {
                prevStep.fadeIn(250, function () {
                    // Obtener el valor actual del paso a partir del nuevo paso visible
                    var currentStepId = prevStep.attr('id'); 
                    var currentStepValue = parseInt(currentStepId.split('-').pop(), 10);

                    MostrarBotonDescargaProyecto(currentStepValue);
                    MostrarresumenMobile(currentStepValue)
                });

                actualPasoLinea.removeClass('active');
                anteriorStepPasoLinea.addClass('active');

                updateClassesOnStep(pantallasConAside);
            });

            if (stepHistory.length === 0) {
                $('.link-paso-atras').hide();
            }
        }

        //Borramos la seleccion de tipo de ataque sufrido
        $('#tipo-ataque-sufrido').val(null).trigger('change');

        //si hay que quitar puntos, actualizamos (definida en asegura-core)
        gestionarStepsaEliminar()
    });



    // Llamar la función inicialmente si estamos en la url del formulario
    if (page == "contratacion-seguro-do-SACAIG") {
        updateClassesOnStep(pantallasConAside);
    }



    //En el paso donde se asignan los herederos, verificamos que no se repitan identificadores y que el total de porcentajes sume 100%
    // Validación al avanzar al paso 8
    $('#sg-paso-8').click(function (event) {
        let suma = 0;
        let nifs = new Set();
        let duplicado = false;

        // Verificamos porcentajes
        $('[id^="porc_benf_"]').each(function () {
            const val = parseFloat($(this).val()) || 0;
            suma += val;
        });

        // Verificamos duplicidad de NIFs
        $('[id^="nif_benf_"]').each(function () {
            const val = $(this).val().trim();

            if (nifs.has(val)) {
                duplicado = true;
            } else {
                nifs.add(val);
            }
        });

        if (duplicado) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'DNI/NIE duplicado',
                text: 'No puedes repetir el mismo DNI/NIE para más de un beneficiario.',
                confirmButtonText: 'OK'
            }).then(() => {
                document.getElementById('step-form-anim-12').style.display = '';
                document.getElementById('step-form-anim-13').style.display = 'none';
            });
            return;
        }

        if (suma !== 100) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error en los porcentajes',
                text: `La suma total de los porcentajes debe ser exactamente 100%. Actualmente suma ${suma}%.`,
                confirmButtonText: 'OK'
            }).then(() => {
                document.getElementById('step-form-anim-12').style.display = '';
                document.getElementById('step-form-anim-13').style.display = 'none';
            });
            return;
        }

        // Si todo está correcto, el flujo continúa
    });





    //Código para mostrar el aside en móvil para mostrar el desplegable con el precio y demás info:
    let isRotated = false;

    // Aseguramos que el documento esté cargado completamente antes de buscar los elementos
    // Creamos una función para ejecutar cuando se hace clic en el elemento con la clase 'show-dt'
    $('.show-dt').on('click', function () {
        // Verificamos si ya se ha realizado la rotación
        if (isRotated) {
            // Si ya está rotado, volvemos a la posición inicial
            $(this).css('transform', '');
            // Utilizamos la función animate de jQuery para crear una transición suave
            $('.aside-resumen').animate({
                'opacity': 0,
                'top': '100vh'
            }, 500, function () {
                $(this).css('display', 'none');
            });
            isRotated = false;
        } else {
            // Si no está rotado, lo rotamos 180 grados
            $(this).css('transform', 'rotate(360deg)');
            // Ajustamos la posición inicial antes de mostrar el elemento
            $('.aside-resumen').css({
                'display': 'block',
                'position': 'fixed',
                'top': '100vh',
                'left': '0',
                'opacity': 1
            });
            // Utilizamos la función animate de jQuery para crear una transición suave
            $('.aside-resumen').animate({
                'opacity': 1,
                'top': '0'
            }, 500);
            isRotated = true;
        }
    });



    // Ejecutar solo en dispositivos móviles con tamaño de pantalla menor a 1024 px
    if (esDispositivoMovil()) {
        // Funcionamiento tabs movil comparativa polizass
        $('#tabItem1-tab').addClass('active');
    }


    // Verificar si la clave 'selectedProductId' está en sessionStorage
    if (!sessionStorage.getItem('selectedProductId')) {
        // Si no existe, redirige a la URL específica
        window.location.href = '/seguros-de-accidentes/';
    }





    //Función que determina el precio del seguro contratado y su nombre en función del id
    function SACAIG_poliza_selected(id_poliza) {
        var data = {};

        switch (id_poliza) {
            case '1':
                data = { 'nombre': 'Classic', 'precio': 92, 'limite': '150.000 €' };
                break;

            case '2':
                data = { 'nombre': 'Plus', 'precio': 173, 'limite': '250.000 €' };
                break;

            case '3':
                data = { 'nombre': 'Premier', 'precio': 265, 'limite': '350.000 €' };
                break;
        }

        return data;
    }


    //Cargamos el precio en el aside
    if (sessionStorage.getItem('selectedProductId')) {
        let IDprecioSeguro = sessionStorage.getItem('selectedProductId')
        let precioSeguro = SACAIG_poliza_selected(IDprecioSeguro)

        $('#precio_SACAIG_seguro_aside, .prc-seguro-spdmb').html(precioSeguro.precio)

        $('#resp-incid-1,#resp-incid-2').html(precioSeguro.limite )
    }



    //Si solicita incluir más beneficarios
    var beneficiarioCount = 1;

    // Añadir beneficiario
    $(".anadir-beneficiario").click(function() {
        if (beneficiarioCount < 4) {
            beneficiarioCount++;
            var nuevoBeneficiarioHtml = '<div class="beneficiarios-inputs row g-3 align-items-center" id="beneficiario_' + beneficiarioCount + '">' +
                    '<div class="col-5">' +
                        '<label for="nombre_benf_' + beneficiarioCount + '" class="form-label">Nombre y apellidos</label>' +
                        '<input type="text" class="form-control" name="nombre_benf_' + beneficiarioCount + '" id="nombre_benf_' + beneficiarioCount + '">' +
                    '</div>' +
                    '<div class="col-4">' +
                        '<label for="nif_benf_' + beneficiarioCount + '" class="form-label">DNI/NIE</label>' +
                        '<input type="text" class="form-control" name="nif_benf_' + beneficiarioCount + '" id="nif_benf_' + beneficiarioCount + '">' +
                    '</div>' +
                    '<div class="col-2">' +
                        '<label for="porc_benf_' + beneficiarioCount + '" class="form-label">%</label>' +
                        '<input type="text" class="form-control text-center" name="porc_benf_' + beneficiarioCount + '" id="porc_benf_' + beneficiarioCount + '">' +
                    '</div>' +
                    '<div class="col-1">' +
                        '<a class="plus-beneficiario btn quitar-benef" data-beneficiario="' + beneficiarioCount + '"><img src="/wp-content/plugins/seguro-accidentes-aig/img/delete.svg"></a>' +
                    '</div>' +
                '</div>';

            $(this).before(nuevoBeneficiarioHtml);
        }
        if (beneficiarioCount == 4) {
            $('.anadir-beneficiario').hide()
        }
    });

    // Quitar beneficiario
    $(document).on('click', '.quitar-benef', function() {
        var beneficiarioId = $(this).data('beneficiario');
        $('#beneficiario_' + beneficiarioId).remove();

        // Actualizar el contador de beneficiarios
        actualizarContadorBeneficiarios();

        if (beneficiarioCount < 4) {
            $('.anadir-beneficiario').show()
        }
    });

    function actualizarContadorBeneficiarios() {
        var beneficiariosExistentes = $('.beneficiarios-inputs').length;
        beneficiarioCount = beneficiariosExistentes;
    }


    //Comprobamos si la profesión está cubierta, de lo contratario mostramos un mensaje     
    $('#profesion').on('select2:select', function (e) {
        let profesionSeleccionada = $(this).val();

        $.ajax({
            url: miAjax.ajaxurl,
            type: 'GET',
            data: {
                action: 'verificar_profesion',
                id: profesionSeleccionada
            },
            success: function(response) {
                let info = JSON.parse(response);

                if (info && info.riesgo === 'SC') {

                    Swal.fire({
                        title: 'Atención',
                        text: 'La protección aplicará únicamente fuera de las horas de trabajo para la profesión seleccionada (cobertura extraprofesional).',
                        icon: 'warning'
                    });
                }
            }
        });
    });


    //Fecha de inicio de cobertura con airdatepicker
    const today = new Date();

    const localeEs = {
        days: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        daysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
        daysMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Dic'],
        today: 'Hoy',
        clear: 'Cancelar',
        dateFormat: 'dd-MM-yyyy',  // Cambiar el formato de fecha aquí
        timeFormat: 'hh:ii',
        firstDay: 1
    };


    // Calcula la fecha máxima seleccionable inicio cobertura (2 meses posteriores al día actual)
    const maxDate = new Date();
    maxDate.setMonth(today.getMonth() + 2);

    // Inicializar el datepicker con la fecha de mañana
    new AirDatepicker('#fecha_efecto_solicitada', {
        dateFormat: 'dd-MM-yyyy', // Asegúrate de que este formato coincida con el formateo deseado
        isMobile: true,
        autoClose: true,
        locale: localeEs,
        startDate: today,
        minDate: today, // Establecer la fecha mínima a hoy,
        maxDate: maxDate // Fecha máxima seleccionable (2 meses posteriores)
    });

    new AirDatepicker('#fecha_nacimiento_tomador', {
        dateFormat: 'dd-MM-yyyy',
        isMobile: true,
        autoClose: true,
        locale: localeEs,
        startDate: new Date(1985, 1, 1),
        view: 'years',
        minView: 'days',
        onChangeView(view) {
            // Cambiar la vista al seleccionar años o meses
            const instance = this; // 'this' se refiere a la instancia del datepicker
            setTimeout(() => {
                if (view === 'years' && instance.setView) {
                    instance.setView('months');
                } else if (view === 'months' && instance.setView) {
                    instance.setView('days');
                }
            }, 0);
        },
        onSelect: function({datepicker}) {
            $(`#fecha_nacimiento_asegurado_${contadorAseguradosAdic}`).valid();
            verificarEdadYOcultarCampos(datepicker.$el);

        }
    });

    /********* EN EL TOMADOR MOSTRAMOS UNOS U OTROS CAMPOS SEGÚN SEA EL TIPO DE FIGURA DE TOMADOR *************/
    // Function to toggle fields based on selection
    function toggleFields(tipo) {
        if (tipo === 'juridica') {
            // Para el campo "identificador_tomador": cambiamos el label a "CIF" y la clase a "cif-vrf"
            $('label[for="identificador_tomador"]').text('CIF');
            $('#identificador_tomador').removeClass('identificador-vrf').addClass('cif-vrf');

            // Ocultamos el campo "apellidos_tomador"
            $('#apellidos_tomador').closest('.col-12.col-md-6').hide();

            // Para el campo "nombre_tomador": cambiamos el label a "Razón Social" y la clase a "insulead-razon-social"
            $('label[for="nombre_tomador"]').text('Razón Social');
            $('#nombre_tomador').removeClass('name-vrf').addClass('insulead-razon-social');

            //Ocultamos la fecha de nacimiento
            $('.nac-tomador-div').hide()
        } else {
            // Revertimos los cambios para el campo "identificador_tomador": label vuelve a "NIF/NIE" y clase a "identificador-vrf"
            $('label[for="identificador_tomador"]').text('NIF/NIE');
            $('#identificador_tomador').removeClass('cif-vrf').addClass('identificador-vrf');

            // Mostramos de nuevo el campo "apellidos_tomador"
            $('#apellidos_tomador').closest('.col-12.col-md-6').show();

            // Revertimos los cambios para el campo "nombre_tomador": label vuelve a "Nombre" y clase a "name-vrf"
            $('label[for="nombre_tomador"]').text('Nombre');
            $('#nombre_tomador').removeClass('insulead-razon-social').addClass('name-vrf');

            //Mostramos la fecha de nacimiento
            $('.nac-tomador-div').show()
        }
    }

    // Configuración inicial basada en el valor por defecto
    toggleFields($('#tipo_tomador').val());

    // Escuchamos los cambios en el elemento select
    $('#tipo_tomador').on('change', function() {
        toggleFields($(this).val());
    });

    
    

    /**************** VERIFICAMOS QUE NO SE REPITAN DNIS ***********/
    $(document).on('input', '.identificador-vrf', function () {
        const enteredValue = $(this).val().trim();
        const currentInput = $(this);

        // Check if the entered value exists in other inputs with the same class
        let duplicateFound = false;

        $('.identificador-vrf').each(function () {
            if ($(this).val().trim() === enteredValue && !$(this).is(currentInput)) {
                duplicateFound = true;
                return false; // Exit loop
            }
        });

        if (duplicateFound) {
            // Show SweetAlert message
            Swal.fire({
                icon: 'error',
                title: 'DNI/NIE duplicado',
                text: 'Este DNI/NIE ya ha sido registrado.',
            });

            // Clear the current input
            currentInput.val('');
        }
    });


    // Crear una nueva instancia de Date para obtener la fecha actual
    var todayS = new Date();

    // Obtener el día, mes y año, ajustando el formato para que siempre tenga dos dígitos
    var day = ("0" + todayS.getDate()).slice(-2);
    var month = ("0" + (todayS.getMonth() + 1)).slice(-2); // Los meses en JavaScript empiezan desde 0, por eso se suma 1
    var year = todayS.getFullYear();

    // Formatear la fecha en el formato dd-mm-yyyy
    var todayFormattedS = day + "-" + month + "-" + year;

    // Setear el valor del input a la fecha de mañana
    $('#fecha_efecto_solicitada').val(todayFormattedS);

});



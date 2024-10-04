$ = jQuery.noConflict();


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

                console.log(response)

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
// Función para validar DNI, NIE o CIF de España
function esIdentificadorValido(identificador) {
    let regexDni = /^\d{8}[A-Z]$/i;
    let regexNie = /^[XYZ]\d{7}[A-Z]$/i;
    let regexCif = /^[A-HJNPQS]\d{7}[A-J0-9]$/i;
    return regexDni.test(identificador) || regexNie.test(identificador) || regexCif.test(identificador);
}

// Función para validar el IBAN
function esIbanValido(iban) {
    const ibanSinEspacios = iban.replace(/\s+/g, '');
    const regexIban = /^[A-Z]{2}[0-9]{22}$/;
    return regexIban.test(ibanSinEspacios);
}

// Función para validar el número de teléfono
function esTelefonoValido(numero) {
    const numeroSinEspacios = numero.replace(/\s+/g, '');
    const regexTelefono = /^[67][0-9]{8}$/;
    return regexTelefono.test(numeroSinEspacios);
}

// Función para validar el código postal
function esCodigoPostalValido(codigoPostal) {
    var regex = /^[0-9]{5}$/;
    return regex.test(codigoPostal);
}


// Función para validar todos los campos
function validarCamposEnDiv(div) {
    // Método personalizado para validar NIF/NIE/CIF
    $.validator.addMethod("validIdentificador", function(value, element) {
        return this.optional(element) || esIdentificadorValido(value);
    }, "Introduce un DNI, NIE o CIF válido.");

    // Método personalizado para validar IBAN
    $.validator.addMethod("validIBAN", function(value, element) {
        return this.optional(element) || esIbanValido(value);
    }, "Introduce un IBAN válido.");

    // Método personalizado para validar el teléfono
    $.validator.addMethod("validTelefono", function(value, element) {
        return this.optional(element) || esTelefonoValido(value);
    }, "Introduce un número de teléfono móvil válido.");

    // Método personalizado para validar el código postal
    $.validator.addMethod("validCodigoPostal", function(value, element) {
        return this.optional(element) || esCodigoPostalValido(value);
    }, "Introduce un Código Postal válido.");

    // Método personalizado para validar selects requeridos
    $.validator.addMethod("selectRequired", function(value, element) {
        return value !== null;
    }, "Selecciona una opción.");


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

    if (page === 'firma-seguro-accidentes') {
        let request_id = sessionStorage.getItem('request_id');
        let signature_id = sessionStorage.getItem('signature_id');
        let signatory_id = sessionStorage.getItem('signatory_id');
        let email_asegurado = sessionStorage.getItem('email_to_asegurar');
        let link_poliza_firmada = sessionStorage.getItem('url_poliza');
        let name_asegurado = sessionStorage.getItem('name_to_asegurar');


        if (!request_id || !signature_id || !signatory_id) {
            Swal.fire({
                title: 'Información faltante',
                text: 'Por favor, vuelve a completar tu solicitud, o si lo prefieres, contacta con nosotros vía telefónica, a través del correo electrónico o directamente a través de nuestro formulario de contacto.',
                icon: 'warning',
                confirmButtonText: 'De acuerdo'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url_producto;
                }
            });
        } else {
                SACAIG_verificarEstadoTransaccion(request_id, signature_id, signatory_id, email_asegurado, link_poliza_firmada, name_asegurado);
                
        }
    }

    if (page === 'agradecimiento-seguro-sagcaig') {
        let email_asegurado = sessionStorage.getItem('email_to_asegurar');
        let link_poliza_firmada = sessionStorage.getItem('link_poliza_firmada');
        let request_id = sessionStorage.getItem('request_id');
        let signature_id = sessionStorage.getItem('signature_id');
        let signatory_id = sessionStorage.getItem('signatory_id');
        let name_asegurado = sessionStorage.getItem('name_to_asegurar');


        $.ajax({
            url: miAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'SACAIG_enviar_correo_poliza',
                email_asegurado,
                link_poliza: link_poliza_firmada,
                request_id,
                signature_id,
                signatory_id,
                name_asegurado
            },
            timeout: 15000, // 15 segundos de espera antes de timeout
            success: function (mailResponse) {
                if (!mailResponse.success) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'No se pudo enviar el correo. Por favor, inténtalo de nuevo.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Error en la solicitud para enviar el correo.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            },
            complete: function () {
                $('#enviarCorreoBtn').prop('disabled', false); // Rehabilitar el botón
            }
        });
    }


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

        insu_registrar_rate(precioSeguro.precio,2)
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
    const sgPasoAct = $('#sg-paso-14');

    function toggleButtonFinalStep() {
        var isCondChecked = $('#suscripcion_cond').is(':checked');
        var isDatosChecked = $('#declaracion_datos').is(':checked');
        var iban = $('#iban').val();
        var hasInvalidFields = iban === '' || !isValidIban(iban);

        if (isCondChecked && isDatosChecked && !hasInvalidFields) {
            sgPasoAct.addClass('btn-next-form btn-next-paso-asg').removeClass('disabled');
        } else {
            sgPasoAct.removeClass('btn-next-form btn-next-paso-asg').addClass('disabled');
        }
    }

    // Añadir el evento click para mostrar SweetAlert si el botón está deshabilitado
    sgPasoAct.on('click', function(e) {
        var isDisabled = sgPasoAct.hasClass('disabled');
        var iban = $('#iban').val();
        var hasInvalidFields = iban === '' || !isValidIban(iban);

        if (isDisabled || hasInvalidFields) {
            e.preventDefault(); // Prevenir la acción por defecto del botón si está deshabilitado
            Swal.fire({
                title: '',
                text: hasInvalidFields ? 'Por favor, complete todos los campos correctamente.' : 'Por favor, acepta los términos y condiciones junto con la conformidad de la información para continuar.',
                icon: 'warning',
                confirmButtonText: 'Aceptar'
            });
        } else {
            let dataForm = collectFormData();
            console.log(dataForm);
            insu_patch_lead(dataForm.suscripcion_pub);

            // Muestra el loader
            $('#loader-simple').css('display', 'block');

            // Ejecuta el AJAX
            $.ajax({
                url: miAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'SACAIG_procesar_poliza',
                    ...dataForm
                },
                success: function(response) {
                    if (response.success) {
                        console.log(response);

                        // Guardar información de respuesta_firma en sessionStorage
                        const respuestaFirma = response.data.respuesta.respuesta_firma;
                        const responsedataUsr = response.data.datos_user;

                        sessionStorage.setItem('request_id', respuestaFirma.request_id);
                        sessionStorage.setItem('signature_id', respuestaFirma.signature_id);
                        sessionStorage.setItem('signatory_id', respuestaFirma.signatory_id);

                        sessionStorage.setItem('url_poliza', response.data.url_proyecto);

                        // Data usuario
                        sessionStorage.setItem('name_to_asegurar', responsedataUsr.nombre_completo);
                        sessionStorage.setItem('email_to_asegurar', responsedataUsr.email);

                        insu_registrar_proyecto(response.data.respuesta.url_proyecto);

                        sessionStorage.setItem('policy_data_sacaig', JSON.stringify(dataForm));

                        // Redirigir a otra página
                        window.location.href = '/firma-seguro-accidentes/';
                    } else {
                        // Mostrar sweet alert
                        console.log(response);
                        console.log('Ha fallado');
                    }
                },
                error: function(err) {
                    console.log(err);
                    console.log('Ha fallado');
                },
                complete: function() {
                    // Oculta el loader cuando la solicitud AJAX ha terminado
                    $('#loader-simple').css('display', 'none');
                }
            });         
        }
    });

    // Vincular el cambio del checkbox y validación de campos a la función de toggle
    $('#suscripcion_cond, #declaracion_datos').on('change', toggleButtonFinalStep);
    $('#iban').on('input change', toggleButtonFinalStep);





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
        }

        if (currentStep.is('#step-form-anim-4') && $('input[name="enf_cardiaca"]:checked').val() == 'no') {
            $('#enf_cardiaca_descript').val("")
            return $('#step-form-anim-6');
            
        }

        if (currentStep.is('#step-form-anim-6') && $('input[name="enf_grave"]:checked').val() == 'no') {
            $('#enf_grave_desctip').val("")
            return $('#step-form-anim-8');
            
        }

        if (currentStep.is('#step-form-anim-9') && $('input[name="tomador_diferente"]:checked').val() == 'no') {
            $('#step-form-anim-10 input').val('');
            return $('#step-form-anim-11');
            
        }

        if (currentStep.is('#step-form-anim-11') && $('input[name="establece_herederos"]:checked').val() == 'no') {
            $('#step-form-anim-12 input').val('');
            return $('#step-form-anim-13');      
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
                prevStep.fadeIn(250);

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
    });



    // Llamar la función inicialmente si estamos en la url del formulario
    if (page == "contratacion-seguro-do-SACAIG") {
        updateClassesOnStep(pantallasConAside);
    }



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
        // Si no existe, redirige a la URL anterior
        window.history.back();
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

        $('#precio_SACAIG_seguro_aside').html(precioSeguro.precio)

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

                    $('#profesion').val(null).trigger('change');

                    Swal.fire({
                        title: 'Atención',
                        text: 'Esta profesión no está cubierta en esta póliza. Sin embargo, puedes completar la solicitud de manera que podamos ofrecerte igualmente una solicitud personalizada a tus requerimientos.',
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


    // Inicializar el datepicker con la fecha de mañana
    new AirDatepicker('#fecha_efecto_solicitada', {
        dateFormat: 'dd-MM-yyyy', // Asegúrate de que este formato coincida con el formateo deseado
        isMobile: true,
        autoClose: true,
        locale: localeEs,
        startDate: today,
        minDate: today // Establecer la fecha mínima a hoy
    });


});



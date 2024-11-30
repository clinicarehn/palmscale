$(() => {
    var _tipo = '';
    var _vehiculoId = '';
    var _vehiculo = '';
    var _nombreCorto = '';
    var _modeloVehiculo = '';
    var _yearId = '';
    var _year;
    var _positionId = '';
    var _position = '';
    var _identidad = '';
    var _materialId = '';
    var _material = '';
    var _longitId = '';
    var _longit = '';
    var _materialCombinado = '';
    var _materialGrapa = ''

    $("#CódigoInput").css({
        'color': 'black', 
        'opacity': '1' 
    });  
    
    $("#descriptionInput").css({
        'color': 'black', 
        'opacity': '1' 
    });  

    const handleTypeChange = () => {
        const typeValue = $('#typeidInput').val();
           
        if (typeValue === '0') {
            $('#CódigoInput').val('');
            $('#descriptionInput').val('');
            enableSelect('vehiculoidInput');

            // Limpia el campo select de modelos completamente (vaciar dropdown y opciones)
            clearRelationSelectField('modelidInput');
        } else if (typeValue === '1') {
            enableSelect('positionidInput');
            disableSelect('vehiculoidInput');
            $('#CódigoInput').val('');
            $('#descriptionInput').val('Tramo--TrT');

            // Limpia el campo select de modelos completamente (vaciar dropdown y opciones)
            clearRelationSelectField('vehiculoidInput');
        } else if (typeValue === '2') {
            $('#longitInput').prop('readonly', false);
            $('#cortecmInput').prop('readonly', false);
            $('#lccmInput').prop('readonly', false);
            $('#abrazlongcmInput').prop('readonly', false);

            disableSelect('vehiculoidInput');
            enableSelect('materialidInput');
            enableSelect('porcendespunteInput');
            disableSelect('positionidInput');
            $('#CódigoInput').val('');
            $('#descriptionInput').val('TrR-');

            // Limpia el campo select de modelos completamente (vaciar dropdown y opciones)
            clearRelationSelectField('vehiculoidInput');
        } else if (typeValue === '3') {
            $('#longitInput').prop('readonly', false);
            enableSelect('materialgrapaidInput');
            disableSelect('vehiculoidInput');
            $('#CódigoInput').val('');
            $('#descriptionInput').val('');

            // Limpia el campo select de modelos completamente (vaciar dropdown y opciones)
            clearRelationSelectField('vehiculoidInput');
        }
    };
    
    const handleVehiculoChange = () => {   
        enableSelect('modelidInput');
    };   

    const handleModelChange = () => {   
        $('#apodoInput').prop('readonly', false);
        enableSelect('yearidInput');
    };   
    
    const handleYearChange = () => {     
        enableSelect('positionidInput');
    }; 

    //SELECT PARA POSICION
    const handlePositionChange = () => {
        if($('#typeidInput').val() === '0') {
            $('#identidadInput').prop('readonly', false);
            $('#distcccmInput').prop('readonly', false);           
            enableSelect('materialidInput');
            enableSelect('tipohojaidInput');
            enableSelect('diatcidInput');
            enableSelect('tiposbujesidInput');
            enableSelect('bujelcidInput');
            enableSelect('bujellidInput');
            enableSelect('brioidInput');
            enableSelect('brioidInput');
        }

        if($('#typeidInput').val() === '1') {
            $('#identidadInput').prop('readonly', false);
            $('#distcccmInput').prop('readonly', false);           
            enableSelect('materialidInput');
            enableSelect('tipohojaidInput');
            enableSelect('roleolcidInput');
            enableSelect('roleollidInput');
            enableSelect('abraztipoidInput');
            enableSelect('abrazmasteridInput');
            enableSelect('diatcidInput');
            enableSelect('bujelcidInput');
            enableSelect('bujellidInput');
        }
    }

    const handleTramoRectoChange = () => {

    }

    $('#typeidInput').on('change', () => {
        $('#modelidInput').off('change', handleVehiculoChange);
        $('#modelidInput').off('change', handleModelChange);
        //$('#yearidInput').off('change', handleYearChange);
        $('#positionidInput').off('change', handlePositionChange);
        $('#positionidInput').off('change', handleTramoRectoChange);

        handleTypeChange();
        
        $('#modelidInput').on('change', handleModelChange);
        //$('#yearidInput').on('change', handleYearChange);
        $('#positionidInput').on('change', handlePositionChange);
    });

    $('#vehiculoidInput').on('change', handleVehiculoChange);
    $('#modelidInput').on('change', handleModelChange);
    $('#yearidInput').on('change', handleYearChange);
    $('#positionidInput').on('change', handlePositionChange);

    $.get('/admin/obtener-csrf-token', function(responseToken) {
        //INICIO DEL TOKEN csrfToken, TODO EL CODIGO QUE CONSULTE DIRECTAMENTE A LARAVEL DEBE ESTAR, ESTO PERMITE QUE SU CONSULTA TENGA EXITO
        const csrfToken = responseToken.csrfToken;

        $('#typeidInput').on('change', function() {
            var selectedValue = $(this).val();
            $('#CódigoInput').val('');

            if (selectedValue === '' || selectedValue === '0' || selectedValue === '3') {
                return;
            }

            $.ajax({
                url: `/admin/obtener-codigo-tipo-vehiculo/${selectedValue}`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {                  
                    _tipo = response.numero;
                    $('#CódigoInput').val(_tipo + '-');
        
                    if (selectedValue === '2') {
                        $('#CódigoInput').val(_tipo + '-R');
                    }
                },                
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        console.error(xhr.responseJSON.error); 
                    } else {
                        console.error('Error en la solicitud AJAX:', xhr.statusText); 
                    }
                }
            });
        });

        $('#modelidInput').on('change', function() {
            var selectedValue = $(this).val();
            $('#CódigoInput').val('');

            if (selectedValue === '' || selectedValue === '0' || selectedValue === '3') {
                return;
            }

            $.ajax({
                url: `/admin/obtener-nombre-corto-vehiculo/${selectedValue}`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {                  
                    _nombreCorto = response.nombrecorto;
                    _modeloVehiculo = response.modelo_detalle;

                    $('#descriptionInput').val(_nombreCorto + ' ' + _modeloVehiculo + ' a');
                },                
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        console.error(xhr.responseJSON.error); 
                    } else {
                        console.error('Error en la solicitud AJAX:', xhr.statusText); 
                    }
                }
            });
        });       

        $('#modelidInput').on('change', function() {   
            var selectedValue = $('#typeidInput').val();

            _vehiculoId = $(this).val();
            var codigo = '';
    
            codigo = _tipo + _vehiculoId + '-';
            $('#CódigoInput').val(codigo.trim());

            if (selectedValue === '0') {
                codigo = _vehiculoId + '-';
                $('#CódigoInput').val(codigo.trim());
            }
        });

        $('#yearidInput').on('change', function() {
            var selectedValue = $('#typeidInput').val();

            _yearId = $(this).val();
            _year = $('#yearidInput option:selected').text();

            if(selectedValue === '0'){
                $('#descriptionInput').val(_nombreCorto + ' ' + _modeloVehiculo + ' a' + _year.slice(-2));
            }            
        });
    
        $('#positionidInput').on('change', function() {
            _positionId = $(this).val();
            _position = $('#positionidInput option:selected').text();
    
            var selectedValue = $('#typeidInput').val();        

            _vehiculoId = $(this).val();
            var codigo = '';
    
            codigo = _tipo + _vehiculoId + _position + '-';
            $('#CódigoInput').val(codigo.trim());
        
            if (selectedValue === '0') {
                codigo = _vehiculoId + _position + '-';
                $('#CódigoInput').val(codigo.trim());

                $('#descriptionInput').val(_nombreCorto + ' ' + _modeloVehiculo + ' ' + _position.slice(-1) + ' a' + _year.slice(-2));
            }

            if (selectedValue === '1') {
                codigo = _tipo + _position + '-';
                $('#CódigoInput').val(codigo.trim());

                $('#descriptionInput').val('Tramo--TrT ' + _position);
            }        
        });

        $('#materialidInput').on('change', function() {
            _materialId = $(this).val();
            _material = $('#materialidInput option:selected').text();
    
            var selectedValue = $('#typeidInput').val();           

            if (selectedValue === '1') {
                 $('#descriptionInput').val('Tramo--Trt ' + _position);
            }    

            if (selectedValue === '2') {
                codigo = _tipo + _materialId + '-R';
                $('#CódigoInput').val(codigo.trim());
            }            
        });        

        $('#longitInput').on('input', function() {
            _longitId = $(this).val();
    
            var selectedValue = $('#typeidInput').val();           

            if (selectedValue === '2') {
                codigo = _tipo + _materialId + '-R' + _longitId;
                $('#CódigoInput').val(codigo.trim());
                $('#descriptionInput').val('TramoRecto--TrR ' + _materialCombinado + _longitId);
            }     

            if (selectedValue === '3') {
                $('#descriptionInput').val('Grapa ' + _materialGrapa + ' ' + _longitId + 'cm');
            }
        });  

        $('#identidadInput').on('input', function() {

            var selectedValue = $('#typeidInput').val();

            _identidad = $(this).val();
            var codigo = '';
    
            codigo = _tipo + _vehiculoId + _position + '-' + _identidad;
            $('#CódigoInput').val(codigo.trim());
        
            if (selectedValue === '0') {
                codigo = _vehiculoId + _position + '-' + _identidad;
                $('#CódigoInput').val(codigo.trim());

                // Obtener el valor del campo de entrada
                let noIdent = $('#identidadInput').val();

                // Convertir el valor a número
                let noIdentNum = parseInt(noIdent, 10);

                // Verificar si el número es impar o par y asignar el valor correspondiente
                let dltTrs;
                if (noIdentNum % 2 === 1) { // Impar
                    dltTrs = "T";
                } else if (noIdentNum % 2 === 0) { // Par
                    dltTrs = "D";
                } else {
                    dltTrs = "";
                }

                $('#descriptionInput').val(_nombreCorto + ' ' + _modeloVehiculo + ' ' + dltTrs + _position.slice(-1) + ' a' + _year.slice(-2));
            }

            if (selectedValue === '1') {
                codigo = _tipo + _position + '-' + _identidad;
                $('#CódigoInput').val(codigo.trim());

                $('#descriptionInput').val('TrT tt1 D a');
            }                       
        });    

        $('#materialidInput').on('change', function() {
            var selectedValue = $(this).val();

            $.ajax({
                url: `/admin/obtener-material-combinado-material/${selectedValue}`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    _materialCombinado = response.material_combinado
                    $('#descriptionInput').val('TramoRecto--TrR ' + _materialCombinado);
                },                
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        console.error(xhr.responseJSON.error); 
                    } else {
                        console.error('Error en la solicitud AJAX:', xhr.statusText); 
                    }
                }
            });
        });

        $('#materialgrapaidInput').on('change', function() {
            var selectedValue = $(this).val();

            $.ajax({
                url: `/admin/obtener-inches-material-grapa/${selectedValue}`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    _materialGrapa = response.inches
                    $('#descriptionInput').val('Grapa ' + _materialGrapa);
                },                
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        console.error(xhr.responseJSON.error); 
                    } else {
                        console.error('Error en la solicitud AJAX:', xhr.statusText); 
                    }
                }
            });
        });        

        $('#tipohojaidInput').on('change', function() {
            var selectedValue = $(this).val();

            $.ajax({
                url: `/admin/obtener-imagen-tipo-hoja/${selectedValue}`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    $('#imagePreviewTipoHoja').attr('src', response.imageUrl);
                },
                error: function(xhr) {
                    console.error("Error al cargar la imagen");
                }
            });
        });

        $('#bujelcidInput').on('change', function() {
            var selectedValue = $(this).val();

            $.ajax({
                url: `/admin/obtener-imagen-buje-lc/${selectedValue}`,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken 
                },
                success: function(response) {
                    $('#imagePreviewBujeLC').attr('src', response.imageUrl);
                },
                error: function(xhr) {
                    console.error("Error al cargar la imagen");
                }
            });
        });

        $('#bujellidInput').on('change', function() {
            var selectedValue = $(this).val();

            $.ajax({
                url: `/admin/obtener-imagen-buje-ll/${selectedValue}`, 
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken 
                },
                success: function(response) {
                    $('#imagePreviewBujeLL').attr('src', response.imageUrl); 
                },
                error: function(xhr) {
                    console.error("Error al cargar la imagen");
                }
            });
        });

        // Selecciona el input donde se llenarán los modelos
        const modeloSelect = $('#modelidInput');

        // Evento para detectar cambios en el select de vehículos
        $('#vehiculoidInput').on('change', () => {
            const vehiculosId = $('#vehiculoidInput').val();
            console.log('ID del vehículo seleccionado:', vehiculosId);
        
            // Limpia el campo select de modelos completamente (vaciar dropdown y opciones)
            clearRelationSelectField('modelidInput');
        
            if (vehiculosId) {
                $.ajax({
                    url: `/admin/obtener-vehiculos/${vehiculosId}`,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    dataType: 'json',
                    success: (data) => {
                        console.log('Respuesta de la solicitud AJAX:', data);
        
                        const tomSelectInstance = $('#modelidInput')[0].tomselect;
        
                        // Asegúrate de que la instancia esté cargada
                        if (tomSelectInstance) {
                            // Limpia las opciones previas
                            tomSelectInstance.clearOptions(); // Limpiar todas las opciones previas
                            tomSelectInstance.addOption({ value: '', text: 'Seleccione una opción' }); // Agregar la opción predeterminada
        
                            // Agregar nuevas opciones obtenidas de AJAX
                            data.forEach((modelo) => {
                                tomSelectInstance.addOption({ value: modelo.id, text: modelo.modelo_detalle });
                            });
        
                            // Habilitar el select si no está habilitado
                            tomSelectInstance.enable();
                        }
                    },
                    error: (xhr, status, error) => {
                        console.error('Error en la solicitud AJAX:', status, error);
                        alert('Hubo un error al intentar obtener los modelos. Por favor, inténtelo nuevamente.');
                    },
                });
            }
        });
          
          
        //FIN DEL TOKEN csrfToken, TODO EL CODIGO QUE CONSULTE DIRECTAMENTE A LARAVEL DEBE ESTAR, ESTO PERMITE QUE SU CONSULTA TENGA EXITO
    });         
});

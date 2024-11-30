$(() => {  
    $("#pkg_Weight").css({
        'color': 'black', 
        'opacity': '1' 
    });  

    function round(value, decimals) {
        return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
    }       

    $('#pkg_Lenght').on('input', () => {
        var longitud = parseFloat($('#pkg_Lenght').val()) || 0;  // Si el valor es null o vacío, se asigna 0
        console.log(longitud);
        var diametro = 0.01429;
        var pesoEspecifico = 7850;
        var area = parseFloat(diametro) * parseFloat(diametro) * 0.7854;
        var volumen = area * longitud;
        var Peso = volumen * pesoEspecifico; 
        
        $("#pkg_Weight").val(round(Peso,2));
    });
});
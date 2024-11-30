$(() => {
    $("#pulgadasInput").attr("readonly", true);

    // Agregar estilo al elemento pulgadasInput
    $("#pulgadasInput").css({
        'color': 'black',  // Fondo blanco
        'opacity': '1'  // No opaco
    });    

    // Convertir mm a pulgadas
    $("#milimetrosInput").on("input", () => {
        var mmInput = $("#milimetrosInput").val();
        var mmValue = parseFloat(mmInput);

        if (!isNaN(mmValue)) {
            const inchesValue = mmValue / 25.4; // 1 pulgada = 25.4 mm
            $("#pulgadasInput").val(inchesValue.toFixed(2));
        } else {
            $("#pulgadasInput").val("");
        }
    });
});

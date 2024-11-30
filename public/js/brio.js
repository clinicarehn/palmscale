$(() => {
    $("#inchesInput").attr("readonly", true);

    $("#inchesInput").css({
        'color': 'black', 
        'opacity': '1' 
    });    

    $("#cmInput").on("input", () => {
        var cmInput = $("#cmInput").val();
        var cmValue = parseFloat(cmInput);

        if (!isNaN(cmValue)) {
            const inchesValue = cmValue / 2.54;
            $("#inchesInput").val(inchesValue.toFixed(2));
        } else {
            $("#inchesInput").val("");
        }
    });
});
function sendSolicitud(variable){
    let tag = $(".solicitudGrupo"+variable);
    let op_prod_url = $(tag).data('url');
    $.ajax({
        type: 'POST',
        url: op_prod_url,
        dataType: 'json',
        success: function(res){
            if(res.success == true){
                $.sweetModal(res.msg);
                $(".request" + variable).html("<button class=\"cancelRequest cancelarGrupo"+variable+"\" onclick=\"cancelarSolicitud("+variable+")\" data-url=\"/solicitudremove/"+variable+"\" >Cancelar</button>");
            }

        }
    })
}
function cancelarSolicitud(variable){
    let tagcancel = $(".cancelarGrupo"+variable);
    let op_url = $(tagcancel).data('url');
    $.ajax({
        type: 'POST',
        url: op_url,
        dataType: 'json',
        success: function(rescancel){
            if(rescancel.success == true){
                $.sweetModal(rescancel.msg);
                $(".request" + variable).html("<button class=\"sendRequest solicitarGrupo"+variable+"\" onclick=\"sendSolicitud("+variable+")\" data-url=\"/solicitud/"+variable+"\" >Enviar solicitud</button>");
            }

        }
    })
}
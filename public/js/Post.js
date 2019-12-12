function heartSystem(variable){
    let tag = $(".heart-base"+variable).children(0);
    let op_prod_id = $(tag).data('id');
    let op_prod_url = $(tag).data('url');
    $.ajax({
        type: 'POST',
        url: op_prod_url,
        dataType: 'json',
        success: function(response) {
            if(response.message == "like"){
                $(".hearCounterResponse" + op_prod_id).html(response.counter);
                $(".heart-base" + op_prod_id).html("<img onclick=\"heartSystem("+op_prod_id+")\" class=\"heart-class\" data-id='" +op_prod_id+ "' data-url='"+op_prod_url+"' src=\"img/corazonpicked.png\" height=\"20\" alt=\"\">");
            }else if(response.message == "unlike"){
                $(".hearCounterResponse" + op_prod_id).html(response.counter);
                $(".heart-base" + op_prod_id).html("<img onclick=\"heartSystem("+op_prod_id+")\" class=\"heart-class\" data-id='" +op_prod_id+ "' data-url='"+op_prod_url+"' src=\"img/corazon.png\" height=\"20\" alt=\"\">");
            }
        },
    });
}
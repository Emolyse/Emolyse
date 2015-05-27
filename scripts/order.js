$(function() {
    // Tri des produits jQuery UI
    $( "#sortable").sortable({
        update : function(event, ui){
            var pos = 0;
            $(".liste-objets li").each(function(index,element){
                $(this).attr("data-order",++pos);

                var id = $(this).attr("data-id");
                var order = $(this).attr("data-order");

                texte = file('http://'+window.location.host+'/Emolyse/includes/traitement.php?id='+escape(id)
                    +'&order='+escape(order)
                    +'&updateOrderList="updateOrderList"'
                )

            });
        }
    });
});

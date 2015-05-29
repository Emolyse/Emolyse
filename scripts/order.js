$(function() {
    // Tri des produits jQuery UI
    $( ".sortable").sortable({
        tolerance: 'pointer',
        dropOnEmpty: true,
        connectWith: 'ul.sortable',
        update : function(event, ui){
            if(this.id == 'delete') {
                var dataid = ui.item.attr("data-id");
                $(ui.item).remove();

                var idExperience = $('#idExperience').val();

                texte = file('http://'+window.location.host+'/Emolyse/includes/traitement.php?id='+escape(dataid)
                    +'&idExperience='+escape(idExperience)
                    +'&deleteProduitListe="deleteProduitListe"'
                )

            }
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

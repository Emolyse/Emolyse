(function($){
    // upload Manuel d'un produit
    var o = {
        message : 'Ajout manuel',
        script : 'includes/upload.php'
    }

    $.fn.uploadFile = function(oo){
        if(oo) $.extend(o, oo);
        this.each(function(){
            $('<span>').addClass('instruction').append(o.message).appendTo('#manualAdd');
            $( "#manualAdd" ).click(function() {
                $("#lienPhoto").click();
            });

            $("input[name*='lienPhoto']").on('change', function(e){
                var files = e.target.files;
                upload(files,0);
            });
        });
        function upload(files, index){
            var file = files[index];
            var xhr = new XMLHttpRequest();

            xhr.addEventListener('load', function(e){
                var json = jQuery.parseJSON(e.target.responseText);
                if(index < files.length-1){
                    upload(files, index+1);
                }
                if(json.error){
                    alert(json.error);
                    return false;
                }
                $('.liste-objets').append(json.content);
            });

            var idExperience = $('#idExperience').val();

            xhr.open('post', o.script, true);
            xhr.setRequestHeader('content-type', 'multipart/form-data');
            xhr.setRequestHeader('x-file-type', file.type);
            xhr.setRequestHeader('x-file-size', file.size);
            xhr.setRequestHeader('x-file-name', file.name);
            xhr.setRequestHeader('idExperience', idExperience);
            xhr.send(file);
        }
    }
})(jQuery);
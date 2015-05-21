(function($){
    // Upload d'un produit via drag & drop
    var o = {
        script : 'includes/upload.php'
    }

    $.fn.dropfile = function(oo){
        if(oo) $.extend(o, oo);
        this.each(function(){
            $(this).bind({
                dragenter : function(e){
                    e.preventDefault();
                },
                dragover : function(e){
                    e.preventDefault();
                    $(this).addClass('hover');
                },
                dragleave : function(e){
                    e.preventDefault();
                    $(this).removeClass('hover');
                }
            });
            this.addEventListener('drop', function(e){
                e.preventDefault();
                var files = e.dataTransfer.files;
                upload(files,$(this),0);
            }, false);

        });
        function upload(files, area, index){
            var file = files[index];
            var xhr = new XMLHttpRequest();

            xhr.addEventListener('load', function(e){
                var json = jQuery.parseJSON(e.target.responseText);
                area.removeClass('hover');
                if(index < files.length-1){
                    upload(files, area, index+1);
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
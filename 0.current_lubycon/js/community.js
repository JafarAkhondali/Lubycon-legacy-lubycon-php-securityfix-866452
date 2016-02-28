function eventHandler(event, selector) {//
    event.stopPropagation();
    event.preventDefault();
    if (event.type === 'touchend'){
        selector.off('click');
    }
};

/*--------------------------------community write button start-----------------------------*/
$(function(){
    if($("#write_bt").length != 0){
        if("length true");
        $("#write_bt").on("click touchend", function(event){
            eventHandler(event,$(this));
            var url = "./index.php?1=community&2=community_write";    
            $(location).attr('href',url);
            return;
        });
    }else{
        return;
    }
});
/*--------------------------------community write button end-------------------------------*/

/*--------------------------------community editor start-------------------------------*/
$(function(){
    $('#file_import_bt').on("click touchend",function(event) {
        eventHandler(event,$(this));
        $('#file_import_com').click();
    });
    $('#file_import_com').change(function () {
        $('#file_text_com').val($(this).val());
    });
});

$(document).ready(function(){
    if($("#main_work_space").length != 0){
        $('#summernote').summernote({
            height: 250,
            minHeight: null,
            maxHeight: null,
            focus: true,
            placeholder: '...make your preview image on here...',
            toolbar: [
                // [groupName, [list of button]]
                ['style',['style']],
                ['fontsize', ['fontsize']],
                ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],              
                ['color', ['color']],
                ['para', ['paragraph']],
                ['insert', ['picture', 'video', 'link', 'table', 'hr']],
                ['misc', ['help']]
            ],
            callbacks:{
                onImageUpload: function (files, editor, welEditable){
                    for ( var i = files.length - 1 ; i >= 0 ; i-- ){
                        sendFile(files[i], this);
                        console.log(files[i]);
                    }
                }
            }
        });

        function sendFile(file, el)
        {
            var form_data = new FormData();
            form_data.append('file', file);
            $.ajax({
                data: form_data,
                type: "POST",
                dataType: 'json',
                url: './php/editor/imageUpload.php',
                cache: false,
                contentType: false,
                processData: false,
                success: function (url)
                {
                    $(el).summernote('editor.insertImage', url["file_path"]);
                    $("form").append("<input type='hidden' name='contents_image[]' value='" + url["file_name"] + "'>");
                }
            });
        }
        //summernote end
        var postForm = function ()
        { // summernote submit event
            var content = $('textarea[name="content"]').html($('#summernote').code());
        }
        return true;
    }else{
        return false;
    }
    
});
/*--------------------------------community editor end-------------------------------*/
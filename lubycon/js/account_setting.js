﻿
$(function (){ //account setting script
    $('#change_pass').click(function (){ //change pass remove attr
        if($('#now_pass_id').attr('disabled')){
            $('#now_pass_id , #pass_id ,#re_pass_id').removeAttr('disabled');
            $('#change_pass').text('Cancel');
        }else{
            $('#now_pass_id , #pass_id ,#re_pass_id').attr('disabled', 'disabled');
            $('#change_pass').text('change Password');
            $('#now_pass_id , #pass_id ,#re_pass_id').val('').next().removeClass();
            $('#pass_check, #now_pass_check').text('').show();
        }
    });

    
    $(document).ready(function (){
        $("#lang_minus_id").hide();
        $(".privacyFilter").lubySelector({
            width: 100,
            theme: "white",
            icon: "fa fa-lock",
            float: "none"
        })
        $(".jobFilter").lubySelector({
            width: 300,
            theme: "white",
            "float": "none",
            "icon": "fa fa-suitcase"
        });
        $(".locationFilter").lubySelector({
            width: 300,
            theme: "white",
            "float": "none",
            searchBar: true,
            "icon": "fa fa-globe"
        });
        $(".langFilter0").lubySelector({
            width: 150,
            theme: "white",
            "float":"none"
        });
    });
    var i = 1;
    $(document).on("click touchend", "#lang_plus", function (event){
        eventHandler(event, $(this));
        if (i < 4) {
            var lang_div = '<div class="langWrap"><div class="lang_section" id="lang_clone' + i + '"><input id="lang_input_' + i + '" class="language_text" name="language[]" type="text"><div id="lang_option_' + i + '" class="lang_option"><select class="langFilter' + i + '" name="lang_ability[]"><option value="Beginer">Beginer</option><option value="Advanced">Advanced</option><option value="Fluent">Fluent</option></select></div></div></div>';
            $("#clone_div").append(lang_div);
            $(".langFilter"+i).lubySelector({
                theme:"white",
                "float":"none"
            });
            $("#lang_minus").show();
            i++; //int plus

            if (i == 4) {
                $("#lang_plus").hide();
            }
        }
    });

    $(document).on("click touchend", "#lang_minus", function (event) {
        eventHandler(event, $(this));
        $("#lang_plus").show();
        $("#clone_div > div:last-child").remove();
        i--; //int minus
        if( i == 1 ){
            $("#lang_minus").hide();
        }
        // clone div remove
    });

});

var history_stack = 1;
$(document).ready(function (){
    $(".accountFilter").lubySelector({
        maxHeight:200,
        float: "none",
        theme: "white"
    });
    $("#history_minus").hide();
})
$(document).on("click touchend", "#history_plus", function (event) {//clone language div and change id
    eventHandler(event, $(this));
    $(".history_cell .history_data:first-child").clone(true).appendTo(".history_cell");
    $(".history_cell .history_data:last-child").children('.history_text').val("");
    $("#history_minus").show();
    history_stack++;
});
$(document).on("click touchend", "#history_minus", function (event) { //clone language div and change id
    eventHandler(event, $(this));
    if (history_stack == 2){
        $(".history_cell .history_data:last-child").remove();
        $("#history_minus").hide();
    } else if (history_stack > 1) {
        $(".history_cell .history_data:last-child").remove();
    }
    history_stack--;
});
$(document).on("click touchend", ".refresh", function (event) {
    eventHandler(event,$(this));
    var history_array = [];
    $('.history_cell .history_data').each(function (index) {
        history_array.push({
            'index':  index,
            'year': $(this).find('.accountFilter:eq(0)').val(),
            'month': $(this).find('.accountFilter:eq(1)').val(),
            'kind': $(this).find('.accountFilter:eq(2)').val(),
            'text': $(this).find('.history_text').val()
        });
        console.log(history_array[index]);
    });
    aftersort = history_array.sort(CompareForSort);
    function CompareForSort(first, second) {
        if (first.year == second.year) // sort by year
            if (first.month < second.month) { // if same value year, sort by month
                return -1; //bigger than second month
            } else{
                return 1; //bigger than first month
            }
        if (first.year < second.year) 
            return -1; // bigger than second year
        else {
            return 1; // bigger than first year
        }
    }
    $('.history_cell .history_data').each(function (index) {
        $(this).find('.accountFilter:eq(0)').val(aftersort[index].year); //hidden selecter value change
        $(this).find('.ls_Label:eq(0)').text(aftersort[index].year); //luby ui lubySelector_selected.span text change

        $(this).find('.accountFilter:eq(1)').val(aftersort[index].month);
        $(this).find('.ls_Label:eq(1)').text(aftersort[index].month);

        $(this).find('.accountFilter:eq(2)').val(aftersort[index].kind);
        $(this).find('.ls_Label:eq(2)').text(aftersort[index].kind);

        $(this).children('.history_text').val(aftersort[index].text);


        console.log(aftersort[index].year);
    });
})
function eventHandler(event, selector) {//
    event.stopPropagation();
    event.preventDefault();
    if (event.type === 'touchend'){
        selector.off('click');
    }
};
function luby_selcetor_val_change(selector_name , origin_selcet)
{
    console.log(selector_name);
    console.log(origin_selcet);
    $(selector_name).find('select:eq(0)').val(origin_selcet);
    $(selector_name).find('.ls_Label:eq(0)').text(origin_selcet);
}


$(document).ready(function () {
    $("#profile-upload-bt").click(function () {
        $("#profile_uploader").click();
    });

    $(document).on("change","#profile_uploader",function () {
        showImage(this);
        $(this).val(null);
    });

    $(document).on("click", "#crop-bt", function () {
        var $object = $("#cropper_img").cropper("getCroppedCanvas", { width: 100, height: 100 });

        $("#croped").html('');
        $("#croped").append($object);
        $("#cropper-preview").hide();
        $("#cropper-wrapper").hide();
        $(".cropper-container").remove();

        dataURL = $object.toDataURL("image/jpeg");
        var dataArray = new Array;
        dataArray[0] = { 'type': 'profile', 'data64': dataURL  , 'index':''};

        $.ajax({
            type: "POST",
            url: "../ajax/account_setting_profile_upload.php", //path
            data:
            {
                'ajax_data': dataArray
            },
            cache: false,
            success: function (data) {
                console.log(data);
            }
        })



    })

});

function showImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#cropper_img').attr('src', e.target.result);

            $(".cropper-container").remove();
            $("#cropper_img").cropper({
                minCanvasWidth: 150,
                minCanvasHeight: 150,
                minContainerWidth: 200,
                minContainerHeight: 200,
                aspectRatio: 1 / 1,
                autoCropArea: 0.6,
                viewMode: 3,
                responsive: true,
                moveable: true,
                preview: "#cropper-preview",
                dragMode: "crop"
            }).show();
            $("#cropper-preview").show().css("display","inline-block");
            $("#cropper-window-wrapper > i").show().css("display","inline-block");
            $("#cropper-wrapper").show();
            $("#cropper_img").cropper("replace", e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}


    ////////////////////////////delete button interaction end
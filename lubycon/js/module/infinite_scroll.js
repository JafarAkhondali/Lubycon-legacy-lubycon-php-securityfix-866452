function up_call_contents(pageNumber) {
    //var top_bound = ($("#main_header").height() + $("#nav_guide").height() + $("#lnb_nav > ul:nth-child(1)").height());
    var remember_scroll = $('#contents_box > ul:nth-child(2) > li:nth-child(1) > div');
    var remember_scroll_value = remember_scroll.offset().top;

    $.ajax
    ({
        type: "POST",
        url: "../ajax/infinite_scroll_ajax.php", //������������ �ߺ�üũ�� �Ѵ�
        data: 'cate_param=' + CATE_PARAM + '&page_param=' + pageNumber,
        cache: false,
        success: function (data)
        {
            $('#contents_box > ul:nth-child(2) > li:nth-child(1)').before(data);
            $(document).scrollTop(remember_scroll.offset().top - remember_scroll_value);
            //console.log(remember_scroll.offset().top);
            ajax_eventing = false;
           
        }
    })
};
function down_call_contents(pageNumber) {
    $.ajax
    ({
        type: "POST",
        url: "../ajax/infinite_scroll_ajax.php", //������������ �ߺ�üũ�� �Ѵ�
        data: 'cate_param=' + CATE_PARAM + '&page_param=' + pageNumber,//test.asp�� id ���� ������
        cache: false,
        success: function (data) {
            $("#contents_box > ul:nth-child(2)").append(data);
            if ($("#contents_box > ul > .finish_contents").hasClass('finish_contents'))
            {
                return false;
            } else {
                //replaceUrlParameter('page', pageNumber);
            }
            ajax_eventing = false;
        }
    })
};

function page_checker(now_page)
{
    var up_count_page = now_page + 1;
    var down_count_page = now_page - 1;
    var scrolltop = ($(document).scrollTop());
    //var page_top = $('.page_top_' + now_page).offset().top;
    var page_bottom = $('.page_bottom_' + now_page).offset().top;
    if (scrolltop > page_bottom)
    {
        replaceUrlParameter('page', up_count_page);
        console.log('page checker up');
    }
}


var ajax_eventing = false;

$(document).scroll(function () {
    var window_position = $(document).height() - $(document).scrollTop();
    var ajax_call_boundary = 150;
    var now_page = parseInt(getUrlParameter('page'));
    var pageCountUp = now_page + 1;
    var pageCountDown = now_page - 1;

    if (window_position <= ($(window).height() + ajax_call_boundary) && ajax_eventing == false) {
        console.log('down ajax call');
        ajax_eventing = true;
        down_call_contents(pageCountUp);

    } else if ($(document).scrollTop() == 0 && pageCountDown >= 1) {
        console.log(pageCountDown);
        console.log('up ajax call');
        ajax_eventing = true;
        up_call_contents(pageCountDown);

    }
    page_checker(now_page);
});


$(document).on('change','#contents_pager', function ()
{
    $("#contents_box > ul:nth-child(2)").html('');
    down_call_contents($(this).val());
    replaceUrlParameter('page', $(this).val());
});
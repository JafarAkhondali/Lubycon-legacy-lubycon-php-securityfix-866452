﻿// TITLE : core.js
// File for global functions or classes or variables


///////////////////////////////////
// GLOBAL FUNCTION AND VARIABLES //
///////////////////////////////////

var CATE_PARAM = getUrlParameter('cate'); // GLOBAL
var MID_CATE_PARAM = getUrlParameter('mid_cate'); // GLOBAL
var CONNUM_PARAM = getUrlParameter('conno'); // GLOBAL
var BNO_PARAM = getUrlParameter('bno'); //GLOBAL
var PAGE_PARAM = getUrlParameter('page'); //GLOBAL

function getUrlParameter(sParam){
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++){
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam){
            return sParameterName[1];
        }
    }
}

function replaceUrlParameter(sParam,value){
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++){
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            history.pushState(null, "", location.pathname + '?' + sPageURL.replace(sParameterName[0] + '=' + sParameterName[1], sParameterName[0] + '=' + value));
        }
    }
}

//This function will be canceled the click event when users touch in mobile devices
//So if you want use any function in mobile, This eventHandler must be called to your function//
function eventHandler(event, selector) {
    event.stopPropagation();
    event.preventDefault();
    if (event.type === 'touchend'){
        selector.off('click');
    }
};

function InputExpander(selector) {
    this.start = function () {
        var object = $(selector);
        object.keydown(function(event) {
            this.style.height = 0;
            var newHeight = this.scrollHeight + 5;
            
            if( this.scrollHeight >= this.clientHeight ){
                newHeight += 5;
                this.style.height= newHeight + 'px';
            }
        });
    }
}

var toggle = {
    group: function(){
        var $this = $(this),
        radioType = $this.hasClass("radioType"),
        $btns = $this.siblings(".btn");

        if($this.hasClass("selected")){
            if(!radioType) $this.removeClass("selected");
        } 
        else {
            $btns.removeClass("selected");
            $this.addClass("selected");
        }
    },
    single: function(){
        var $this = $(this);
        if($this.hasClass("selected")) $this.removeClass("selected");
        else $this.addClass("selected");
    }
}

//////////////////////////
// javaScript Prototype //
//////////////////////////


Array.prototype.clean = function(deleteValue) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] == deleteValue) {         
            this.splice(i, 1);
            i--;
        }
    }
    return this;
};

Date.prototype.get12HourTime = function(iso8601){ //iso8601 = boolean
    var result = {
        "ampm" : null,
        "hour" : null,
        "minute" : null,
        "second" : null
    };

    var h = this.getHours();
    var m = this.getMinutes();
    var s = this.getSeconds();

    if(h <= 12){
        result.ampm = "am";
    }
    else if(h > 12){
        h -= 12;
        result.ampm = "pm";
    }
    else console.log("Time error in get12HourTime");

    if(iso8601){
        h = getISO8601(h);
        m = getISO8601(m);
        s = getISO8601(s);
    }
    else{
        h = h; m = m; s = s;
    }

    function getISO8601(num){
        if(num < 10) num = "0" + num;
        else num = num.toString();
        return num;
    }

    result.hour = h;
    result.minute = m;
    result.second = s;

    return result;
}

String.prototype.isEmail = function(){
    //if It is email => true Or false
    var reg = /^[0-9a-zA-Z]([\-.\w]*[0-9a-zA-Z\-_+])*@([0-9a-zA-Z][\-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9}$/;
    return reg.test(this);
}
String.prototype.isPassword = function(){
    // <Error Code>
    //
    // Empty or Null                      //error code : 1
    // length < 10                        //error code : 2
    // Hasn't Alphabet                    //error code : 3
    // Has specialchar                    //error code : 4
    // Repeat 3 word                      //error code : 5
    // used "Null" string                 //error code : 6
    //
    //
    // True                               // return 0
    var lengthTest = this.length < 10;
    var notUseAlphabet = this.match(/[^0-9]/g) === null;
    var useSpecialChar = this.isSpecialChar();
    var emptyWord = this.isNullString();
    var nullString = this.match(/ null /gi);
    var repeat3Word = this.isRepeatWord(3);

    if(emptyWord) return 1;
    else if(lengthTest) return 2;
    else if(notUseAlphabet) return 3;
    else if(useSpecialChar) return 4;  
    else if(repeat3Word) return 5;
    else if(nullString) return 6;
    else return 0;
}
String.prototype.isNullString = function(){
    //Null => true Or false
    return this.valueOf() === "" || this.valueOf() === null || this.valueOf() === undefined || this.valueOf() === " ";
}
String.prototype.isAbuseWord = function(){
    //if It is abuse word => true Or false
    var abuseWords = [
        "sex", "fuck", "bitch",
        "cunt", "dick", "fucker", "null"
    ];
    return abuseWords.indexOf(this.valueOf()) !== -1;
}
String.prototype.isRepeatWord = function(limit){
    //limit = int
    var ch = '';
    var cnt = 0;
    for (var i = 0 ; i < this.length; i++){
        if(ch === this.charAt(i)){
            cnt++;
            if (cnt >= limit){
                return true;
            }
        }
        else{
            ch = this.charAt(i);
            cnt = 1;
        }
    };

    return false;
}
String.prototype.isSpecialChar = function(){
    //if Is is specialChar => true Or false
    var reg = /[\,\.`;/\?~!@\#$%<>^&*\()<>\-=\+_\’\"\']/gi;

    return reg.test(this);
}
String.prototype.isAlphabetNumber = function(){
    var reg = /^[A-Za-z0-9+]*$/;
    return reg.test(this);
}

String.prototype.inputErrorCheck = function(){
    // 1. isSpecialChar()
    // 2. isAbuseWord()
    // 0. TRUE
    if(this.isSpecialChar()) return 1;
    else if(this.isAbuseWord() || this.match(/ null /gi)) return 2;
    else return 0;
}

String.prototype.getByteLength = function(b,i,c){
    for(b = i = 0; c = this.charCodeAt(i++); b += c >> 11 ? 3 :c >> 7 ? 2 : 1);
    return b;
}

//////////////////////
// jQuery Prototype //
//////////////////////

$.fn.tooltip = function(option){ //parent obejct must has "data-tip" attribute!!!!
    var defaults = { top: 0, left: null, right: null, appendTo: null },
    d = $.extend({}, defaults, option);

    this.each(function(){
        var $this = $(this),
        data = $this.data("tip");

        var tooltipBody = $("<div/>",{"class" : "tooltip tip-body"}),
        tooltipWrap = $("<div/>",{"class" : "tooltip tip-wrapper"}).appendTo(tooltipBody),
        tooltipContent = $("<p/>",{"class" : "tooltip tip-content","html" : data}).appendTo(tooltipWrap);
        
        tooltipBody.css("top",d.top);
        d.left !== null ? tooltipBody.css("left",d.left) : "";
        d.right !== null ? tooltipBody.css("right",d.right) : "";

        if(d.left == null && d.right == null) alert("Tooltip Error(ui.js) : Please insert value about X coordinate(left or right)");

        $this.on("mouseenter",showTooltip).on("mouseleave",hideTooltip);

        function showTooltip(){
            var $this = $(this);
            if(d.appendTo === null ) tooltipBody.appendTo($this).stop().fadeIn(300);
            else tooltipBody.appendTo(d.appendTo).stop().fadeIn(300);
        }
        function hideTooltip(){
            var $this = $(this);
            tooltipBody.hide().remove();
        }
    });
    return this;
}

$.fn.hideAnywhere = function(){
    this.each(function(){
        var $menu = $(this),
        $button = $menu.parents(".selected").length === 0 ? $menu.siblings(".selected") : $menu.parents(".selected");

        $("html").off("click").on("click",hideMenu);

        function hideMenu(event){
            event.stopPropagation();
            var $this = $(event.target),
            checkElement = !$this.is($menu) && !$this.is($button) && $button.has($this).length === 0;

            console.log(checkElement);
            if(checkElement) {
                $menu.fadeOut(200);
                $button.removeClass("selected");
            }
        }
    });
    return this;
};












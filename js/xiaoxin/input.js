/**
 *
 * write by yue
 * time 2013.11.04
 * 增加 密码输入框显示提示文字 功能
 * time 2014.04.16
 * 完善 密码输入框显示提示文字 功能
 *
 */
$(function () {

    ShowTips(); 

    $(":input").not(":input[type=submit],:input[type=button]").focus(function () {
        if ($(this).val() == this.defaultValue||$(this).val()=="") {
            $(this).val("");
        }
    }).blur(function () {
        if ($(this).val() == '') {
            $(this).val(this.defaultValue);
        }
    });

    /* 注:提示文字不能用input,防止使用tab键时出错 */
    $(".valueSpan").click(function () {
        $(this).css({ "color": "#d4d4d4" }).parent().find(".textInput").focus();
    });
    $(".textInput").focus(function () {
        //$(this).css({ "border": "2px solid #4fb1f4", "margin": 0 });
        $(this).parent().find(".valueSpan").css({ "color": "#d4d4d4" });
    });
    /* 判断input失去焦点时值是否为空 */
    $(".textInput").blur(function () {
        //$(this).css({ "border": "1px solid #A6A6A6", "margin": "1px" });
        //        if ($(this).val() == "") {
        //            $(this).parent().find(".valueSpan").show().css({ "color": "#999" });
        //        };
        ShowTips();
    });
    $(".textInput").keyup(function () {
        ShowTips();
    });
 
    $(document).mousemove(function () {
        ShowTips();
    });
    /* 判断键入的是否是tab键 */
    $(".textInput").keydown(function (event) {
        if (event.keyCode != 9) {
            $(this).parent().find(".valueSpan").hide();
        }
        if (event.keyCode == 13) {
            var txt = $(".textInput");
            var haveNoError = true;
            txt.each(function (i, item) {
                if ($(item).val() == "") { 
                    haveNoError = false;
                }
            }); 
        }
    });
    //    /*判断文本框是否幼稚*/
    //    if ($(".textInput").val() != "") {
    //        $(".valueSpan").hide();
    //    }
});

function ShowTips() {
    var textInputs = $(".textInput");
    textInputs.each(function (i, item) {
         
        if ($(item).val() == "") {
            $(item).parent().find(".valueSpan").show().css({ "color": "#999" });
        } else {
            $(item).parent().find(".valueSpan").hide();
        }
    });
}

/**
 *
 * @authors H君 (262281610@qq.com)
 * @date    2014-12-17 15:04:56
 * @version $Id$
 */
;
(function() {
    var activity = function() {
        var view = function() {
            var score = $('#score'),
                awards = $('#awards'),
                loading = $('#loading'),
                promptC = $('#prompt-c'),
                promptBox = $('#promptBox'),
                getAddUrl = $('#getAddUrl').val(),
                firstLoginVal = $('#firstView').val();

            var firstLogin = function() {
                if (firstLoginVal == 0) {
                    promptC.hide();
                    $('.mask').show();
                    $('#firstAwards').show();
                    promptBox.addClass('promptBoxHigh');
                } else {
                    $('#firstAwards').remove();
                }
            }();
            awards.on('click', '.awards-box', function(e) {
                var _thisImgUrl = $(this).find('img').attr('src'),
                    _newUrl = promptC.find('.awards-img img');
                _newUrl.attr('src', _thisImgUrl);
                $('.mask').show();
                promptBox.addClass('promptBoxHigh');
                e.stopPropagation();
            })
            promptBox.on('click', 'a', function(e) {
                var action = $(this).data('action');
                if (action === 'close') {
                    $('.mask').hide();
                    promptBox.removeClass('promptBoxHigh');
                    $('#prompt-c').show();
                    $('#zf').html('').hide();
                    $('#getAwards').html('').hide();
                    $('#firstAwards').hide();
                    $('#getOpen').data('isclick', true);
                } else if (action === 'open') {
                    var _left = $(this),
                        url = _left.data('href'),
                        isclick = _left.data('isclick');
                    loading.show();
                    if (isclick) {
                        _left.data('isclick', false)
                        $.ajax({
                            url: url,
                            type: 'POST',
                            dataType: 'JSON',
                            success: function(data) {
                                if (data != '') {
                                    var data = eval('(' + data + ')'),
                                        _html = '';
                                    if (data.state != 0) {

                                        if (data.state < 5) {
                                            getAddUrl += '&Mogrid=' + data.mogrid;
                                            if (data.state == 1) {
                                                _html = '<p>恭喜您获得<span class="red">10元充值卡</span>一张! 话费将于三个工作日之内充至您手机&nbsp;<span class="red">' + data.phone + '</span></p>' + '<p class="img center"><img src="/image/api/activity/award2.png" alt="" ></p>' + '<p class="center"><a href="javascript:;" data-action="close" class="confirm">确定</a></p>';
                                            } else if (data.state == 2) {
                                                _html = '<p>恭喜您获得<span class="red">电影通兑券</span>一张! 奖品兑换码在三个工作日之内发送至您手机&nbsp;<span class="red">' + data.phone + '</span></p>' + '<p class="img center"><img src="/image/api/activity/award4.png" alt=""  style="width:33%;"></p>' + '<p class="center"><a href="javascript:;" data-action="close" class="confirm" style="margin-top:0;">确定</a></p>';
                                            } else if (data.state == 3) {
                                                _html = '<p>恭喜您获得<span class="red">移动电源</span>一台!奖品将于活动结束后7个工作日内送出</p>' + '<p class="img center"><img src="/image/api/activity/award3.png" alt="" ></p>' + '<p class="center"><a href="' + getAddUrl + '" data-action="close" class="confirm">填写收货地址</a></p>';
                                            } else if (data.state == 4) {
                                                _html = '<p>恭喜您获得<span class="red">IPhone6手机</span>一台!奖品将于活动结束后7个工作日内送出</p>' + '<p class="img center"><img src="/image/api/activity/award1.png" alt="" ></p>' + '<p class="center"><a href="' + getAddUrl + '" data-action="close" class="confirm">填写收货地址</a></p>';
                                            }
                                            $('#prompt-c').hide();
                                            $('#getAwards').html(_html).show();
                                        } else {
                                            _html = '<p class="p1 tit red">' + data.msg + '</p>' + data.text + '<p class="center"><a href="javascript:;" data-action="close" class="confirm">确定</a></p>';
                                            $('#prompt-c').hide();
                                            $('#zf').html(_html).show();

                                        }
                                        var num = parseInt(score.text()) - 50;
                                        score.text(num);
                                    } else {
                                        _html = '<p class="p1 tit red">' + data.msg + '</p><p class="center" style="margin-top:8%"><a href="javascript:;" data-action="close" class="confirm">确定</a></p>'
                                        $('#prompt-c').hide();
                                        $('#zf').html(_html).show();
                                    };
                                    loading.hide();
                                };
                            },
                            error: function() {
                                loading.hide();
                                alert('服务端出现错误');

                            }
                        })
                    }

                }
            })
            $('.mask').not($('.promptBox')).on('click', function(e) {
                $('.mask').hide();
                promptBox.removeClass('promptBoxHigh');
                $('#prompt-c').show();
                $('#zf').html('').hide();
                $('#getAwards').html('').hide();
                $('#getOpen').data('isclick', true);
                $('#firstAwards').hide();
            })
        };
        var addressCheck = function() {
            var sub = $('#submitBtn'),
                inputList = $('.input-list').find('input'),
                inputTextarea = $('.input-list').find('textarea');
            sub.on('click', function() {
                var inputName = $('.input-name').val(),
                    inputAdd = $('.input-add').val(),
                    inputYb = $('.input-yb').val(),
                    inputTel = $('.input-tel').val(),
                    text, status = true;
                if (inputName == '') {
                    text = '请输入姓名';
                    $('#form-error').text(text);
                    status = false;
                } else if (inputAdd == '') {
                    text = '请输入地址';
                    $('#form-error').text(text);
                    status = false;
                } else if (inputTel == '') {
                    text = '请输入电话';
                    $('#form-error').text(text);
                    status = false;
                }
                if (status) {
                    $('#form').submit();
                }

            })
        };
        var price = function() {
            var priceBox = $('#priceBody');
            priceBox.on('click', 'a', function(e) {
                var type = $(this).data('type');
                if (type === 1) {
                    var tip = $(this).data('tip');
                    var _html = '<p class="p1 tit" >' + tip + '</p>';
                    $('#price-c').html(_html).show();
                    $('.mask').show();
                    $('#priceBox').addClass('promptBoxHigh');
                } else if (type === 4) {
                    var phone = $(this).data('phone');
                    var _html = '<p>话费将于三个工作日之内充至您手机&nbsp;<span class="red">' + phone + '</span></p>';
                    $('#price-c').html(_html).show();
                    $('.mask').show();
                    $('#priceBox').addClass('promptBoxHigh');
                }

            })
            $('#priceBox').on('click', 'a', function(e) {
                var action = $(this).data('action');
                if (action === 'close') {
                    $('.mask').hide();
                    $('#priceBox').removeClass('promptBoxHigh');
                }

            })
            $('.mask').not($('.promptBox')).on('click', function(e) {
                $('.mask').hide();
                $('#priceBox').removeClass('promptBoxHigh');
            })


        };
        return {
            awardV: view,
            msg: addressCheck,
            myPrive: price
        }
    }
    window.activity = activity();
})()
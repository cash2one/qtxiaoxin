/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */ 
var placeholders={ 
    int:function(strings,flag){
        var oForm = document.getElementById(strings);
        var oFormInputs = oForm.getElementsByTagName('input');
        for(var i=0;i<oFormInputs.length;i++){
            placeholders.placeHolder(oFormInputs[i],flag);
        }
        var oFormTextarea = oForm.getElementsByTagName('textarea')[0];
        if(oFormTextarea){
            placeholders.placeHolder(oFormTextarea,flag);
        } 
    }, 
    placeHolder:function(obj, span) {
     /**
     * @name placeHolder
     * @class 跨浏览器placeHolder,对于不支持原生placeHolder的浏览器，通过value或插入span元素两种方案模拟
     * @param {Object} obj 要应用placeHolder的表单元素对象
     * @param {Boolean} span 是否采用悬浮的span元素方式来模拟placeHolder，默认值false,默认使用value方式模拟
     */ 
        if(window.attachEvent){  
            if (!(obj.getAttribute('placeholder'))){ return;}
        } 
        var imitateMode = span===true?true:false;
        var supportPlaceholder = 'placeholder' in document.createElement('input');
        if (!supportPlaceholder) {
            var defaultValue = obj.getAttribute('placeholder');
            if (!imitateMode) {
                obj.onfocus = function () {
                    (obj.value == defaultValue) && (obj.value = '');
                    obj.style.color = ''; 
                }
                obj.onblur = function () {
                    if (obj.value == defaultValue) {
                        obj.style.color = '';
                    } else if (obj.value == '') {
                        obj.value = defaultValue;
                        obj.style.color = '#ACA899';
                    }
                }
                obj.onblur();
            } else {
                var placeHolderCont = document.createTextNode(defaultValue);
                var oWrapper = document.createElement('span');
                oWrapper.style.cssText = 'position:absolute; color:#ACA899; display:inline-block; overflow:hidden;';
                oWrapper.className = 'wrap-placeholder';
                oWrapper.style.fontFamily = getStyle(obj, 'fontFamily');
                oWrapper.style.fontSize = getStyle(obj, 'fontSize');
                oWrapper.style.marginLeft = parseInt(getStyle(obj, 'marginLeft')) ? parseInt(getStyle(obj, 'marginLeft')) + 3 + 'px' : 3 + 'px';
                oWrapper.style.marginTop = parseInt(getStyle(obj, 'marginTop')) ? getStyle(obj, 'marginTop'): 1 + 'px';
                oWrapper.style.paddingLeft = getStyle(obj, 'paddingLeft');
                oWrapper.style.width = obj.offsetWidth - parseInt(getStyle(obj, 'marginLeft')) + 'px';
                oWrapper.style.height = obj.offsetHeight  + 'px';
                oWrapper.style.lineHeight = obj.nodeName.toLowerCase()=='textarea'? '':obj.offsetHeight + 'px';
                oWrapper.appendChild(placeHolderCont);
                obj.parentNode.insertBefore(oWrapper, obj);
                oWrapper.onclick = function () {
                    obj.focus();
                }
                //绑定input或onpropertychange事件
                if (typeof(obj.oninput)=='object') {
                    obj.addEventListener("input", changeHandler, false);
                } else {
                    obj.onpropertychange = changeHandler;
                }
                function changeHandler() {
                    oWrapper.style.display = obj.value != '' ? 'none' : 'inline-block';
                }
                /**
                 * @name getStyle
                 * @class 获取样式
                 * @param {Object} obj 要获取样式的对象
                 * @param {String} styleName 要获取的样式名
                 */
                function getStyle(obj, styleName) {
                    var oStyle = null;
                    if (obj.currentStyle)
                        oStyle = obj.currentStyle[styleName];
                    else if (window.getComputedStyle)
                        oStyle = window.getComputedStyle(obj, null)[styleName];
                    return oStyle;
                }
            }
        }
    }
}

//    
//    
//    var oForm1 = document.getElementById('form1');
//    var oForm1Inputs = oForm1.getElementsByTagName('input');
//    for(var i=0;i<oForm1Inputs.length;i++){
//        placeHolder(oForm1Inputs[i],true);
//    } 
//    var oForm1Textarea = oForm1.getElementsByTagName('textarea')[0];
//    placeHolder(oForm1Textarea,true);
//
//    var oForm2 = document.getElementById('form2');
//    var oForm2Inputs = oForm2.getElementsByTagName('input');
//    for(var i=0;i<oForm2Inputs.length;i++){
//        placeHolder(oForm2Inputs[i]);
//    }
//    var oForm2Textarea = oForm2.getElementsByTagName('textarea')[0];
//    placeHolder(oForm2Textarea);

    
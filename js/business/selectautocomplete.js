/*!
 * 自动补全搜索         
 *
 * Copyright 201405-201409, 何挺
 */ 

/*
* 搜索自动补全
* @param {字符串} idStr  输入框的id
* @param {字符串} projects 数据数组 
*/
 function  searchAutocomplete(idStr,projects) {
    $( "#"  +idStr ).autocomplete({ 
        minLength: 0,
        source: projects,
        autoFocus: true,
        messages:{
            noResults:'',
            results:function(){}
        }
    });
 }
 
 /*
* 搜索自动补全 首字母
* @param {字符串} idStr  输入框的id
* @param {字符串} projects json数据
*/
function  selectAutoComp(idStr,projects) {
    $( "#"+idStr ).autocomplete({
      minLength: 0,
      source: projects, 
      focus: function( event, ui ) { 
        $( "#"+idStr ).val( ui.item.value ); 
        return false;
      },
      select: function( event, ui ) {
        $( "#"+idStr ).val( ui.item.value );  
        return false;
      }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" ).append( "<a>" + item.label+"</a>" ).appendTo( ul );
    }; 
 }
 
/*
* 搜索自动补全增强版
* @param {字符串} idStr  输入框的id
* @param {字符串} projects 数据数组 
* @param {字符串} strs 数据输入框的id 
*/
 function  selectAutoCompLete(idStr,projects,strs,val) {
    $( "#"+idStr ).autocomplete({
      minLength: 0,
      source: projects,
      autoFocus: true, 
      focus: function( event, ui ) { 
        $( "#"+idStr ).val( ui.item.label );
        $( "#"+strs ).val( ui.item.value );
        return false;
      },
      select: function( event, ui ) {
        $( "#"+idStr ).val( ui.item.label ); 
        $( "#"+strs ).val( ui.item.value );
        //jaxapost($( "#"+strs ).attr('url'),ui.item.value,$( "#"+strs ).attr('selectid'));
        return false;
      }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" ).append( "<a>" + item.label+"</a>" ).appendTo( ul );
    }; 
 }
 
/*
* 搜索自动补全请求
* @param {字符串} url  请求url
* @param {字符串} datas 请求参数 
* @param {字符串} selectid 数据输入框的id 
*/
function jaxapost(url,datas,selectid) { 
//    if (datas) {  
//        $.getJSON(url,{sid:datas},function(mydata) { 
//            var option ='<option value="">全部</option>'; 
//            $.each(mydata,function(i,v){ 
//                option=option+'<option value="'+i+'">'+v+'</option>';
//            });
//            $("#"+selectid).html(option);
//        }); 
//    }    
}



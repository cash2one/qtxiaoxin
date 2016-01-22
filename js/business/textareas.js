 /*!
 * tinyMCE文本编辑器插件初始化  
 *  
 * Copyright 201405-201406, 何挺 
 */
tinyMCE.init({  
    // General options  
    mode : "textareas",
    theme : "advanced",  
    language : "zh-cn",
    //elements : "MallGoods_remark", 
    plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist,autosave",  
    
    relative_urls: false,
    remove_script_host : false,
    convert_urls : true,

    // Theme options  
    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,fullscreen,code",  
    theme_advanced_buttons2 : "cut,copy,paste,pastetext,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,|,insertdate,inserttime,preview,|,forecolor,backcolor",  
    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl",  
   
    theme_advanced_toolbar_location : "top",  
    theme_advanced_toolbar_align : "left",  
    theme_advanced_statusbar_location : "bottom",  
    theme_advanced_resizing : true,
    theme_advanced_resize_horizontal : false, 
    theme_advanced_fonts : "雅黑=雅黑;宋体=宋体;楷体=楷体",

    // Example content CSS (should be your site CSS)  
    //content_css : "/js/tinymce/examples/css/style.css",  
   
    template_external_list_url : "/js/business/tinymce/examples/template_list.js",  
    external_link_list_url : "/js/business/tinymce/examples/lists/link_list.js",  
    external_image_list_url : "/js/business/tinymce/examples/lists/image_list.js",  
    media_external_list_url : "/js/business/tinymce/examples/lists/media_list.js",  
   
    // Style formats  
    style_formats : [  
        {title : 'Bold text', inline : 'strong'},  
        {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},  
        {title : 'Help', inline : 'strong', classes : 'help'},  
        {title : 'Table styles'},  
        {title : 'Table row 1', selector : 'tr', classes : 'tablerow'}  
    ], 
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    width: '100%',  
    height: '450'  
   
});  

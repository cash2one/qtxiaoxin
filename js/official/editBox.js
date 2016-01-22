/**
 * 
 * @authors H君 (26228161@qq.com)
 * @date    2014-12-03 11:12:38
 * @version $Id$
 */
js = {lang:{}};

js.lang.String = function(){

    this.REGX_HTML_ENCODE = /"|&|'|<|>|[\x00-\x20]|[\x7F-\xFF]|[\u0100-\u2700]/g;

    this.REGX_HTML_DECODE = /&\w+;|&#(\d+);/g;

    this.REGX_TRIM = /(^\s*)|(\s*$)/g;

    this.HTML_DECODE = {
        "&lt;" : "<", 
        "&gt;" : ">", 
        "&amp;" : "&", 
        "&nbsp;": " ", 
        "&quot;": "\"", 
        "&copy;": ""

        // Add more
    };

    this.encodeHtml = function(s){
        s = (s != undefined) ? s : this.toString();
        return (typeof s != "string") ? s :
            s.replace(this.REGX_HTML_ENCODE, 
                      function($0){
                          var c = $0.charCodeAt(0), r = ["&#"];
                          c = (c == 0x20) ? 0xA0 : c;
                          r.push(c); r.push(";");
                          return r.join("");
                      });
    };

    this.decodeHtml = function(s){
        var HTML_DECODE = this.HTML_DECODE;

        s = (s != undefined) ? s : this.toString();
        return (typeof s != "string") ? s :
            s.replace(this.REGX_HTML_DECODE,
                      function($0, $1){
                          var c = HTML_DECODE[$0];
                          if(c == undefined){
                              // Maybe is Entity Number
                              if(!isNaN($1)){
                                  c = String.fromCharCode(($1 == 160) ? 32:$1);
                              }else{
                                  c = $0;
                              }
                          }
                          return c;
                      });
    };

    this.trim = function(s){
        s = (s != undefined) ? s : this.toString();
        return (typeof s != "string") ? s :
            s.replace(this.REGX_TRIM, "");
    };


    this.hashCode = function(){
        var hash = this.__hash__, _char;
        if(hash == undefined || hash == 0){
            hash = 0;
            for (var i = 0, len=this.length; i < len; i++) {
                _char = this.charCodeAt(i);
                hash = 31*hash + _char;
                hash = hash & hash; // Convert to 32bit integer
            }
            hash = hash & 0x7fffffff;
        }
        this.__hash__ = hash;

        return this.__hash__; 
    };

};

js.lang.String.call(js.lang.String);
 
 
function myCustomSaveContent(element_id, html, body) {
	html = js.lang.String.decodeHtml(html);
	return html;
}
var	tinyMceFun=function(type,val){
	
		tinyMCE.init({  
		    // General options  
		     mode : "exact",
		    theme : "advanced",  
		    language : "zh-cn",
		    elements : "elm1",
            convert_urls :false,
            paste_preprocess : function(pl, o) {
            	var reg = /<img(.*)>/g;

            	if ($.trim(o.content).match(reg)) {
            		o.content = $.trim(o.content).replace(/<img[^<>]*>/ig, "");
            		//o.content = ""; //如果复制的是图片，设置o.content = "" 来阻止图片复制。
            	}
            },
            save_callback : "myCustomSaveContent",
            entity_encoding : "raw",
            valid_elements : "p,img[class|src|border=0|alt|hspace|vspace|width|height|align]",
		       plugins : "pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist", 
		    init_instance_callback : function(editor) {
		    	if (type == 'edit') {
		    		 tinyMCE.get('elm1').setContent(val);
		    	};
			}

		});  
}

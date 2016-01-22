/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 //表单验证控件
 var Validform ={
     int:function(str){
        var getInfoObj=function(){
             return   $(this).parents("td").find(".info");
         } 
        $("[datatype]").focusin(function(){
                if(this.timeout){clearTimeout(this.timeout);}
                var infoObj=getInfoObj.call(this);
                if(infoObj.siblings(".Validform_right").length!=0){
                        return;	
                } 
                infoObj.css('display','inline').siblings('.Validform_checktip"').hide(); 
        }).focusout(function(){
                var infoObj=getInfoObj.call(this);
                this.timeout=setTimeout(function(){
                        infoObj.hide().siblings(".Validform_checktip ,.Validform_wrong,.Validform_loading").css('display','inline');
                },0); 
        });
        $(str).Validform({
            tiptype:2,
            showAllError:true,
            postonce:true,
            datatype:{//传入自定义datatype类型 ; 
               "tel-3" : /^(\d{3,4}-)?\d{7,8}$/, 
               "nZ"    : /^(0|[1-9][0-9]{1}|100)$/,
               "nF"    :/^(?:0\.\d+|[01](?:\.0)?)$/,
               "nS"    : /^(([1-9]\d{0,1})|100)$/ ,
               'phone':/^((1)+\d{10})$/,
               "pwd6-16":/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i,
               "need2":function(gets,obj,curform,regxp){
                    var need=1,
                        numselected=curform.find("input[name='"+obj.attr("name")+"']:checked").length;
                     
                    return  numselected >= need ? true : "请至少选择"+need+"项！";
                } 
           },
            usePlugin:{
                passwordstrength:{
                    minLen:6,
                    maxLen:18,
                    trigger:function(obj,error){
                        if(error){
                            obj.parent().next().find(".passwordStrength").hide().siblings(".info").css('display','inline');
                        }else{
                            obj.removeClass("Validform_error").parent().next().find(".passwordStrength").css('display','inline').siblings().hide();	
                        }
                    }
                }
            }
        });
    }
};
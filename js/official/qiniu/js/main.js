/*global Qiniu */
/*global plupload */
/*global FileProgress */
/*global hljs */


var updataLoadImg=function(type){

    var uploader = Qiniu.uploader({
        runtimes: 'html5,flash,html4',
        browse_button: 'pickfiles',
        container: 'container',
        drop_element: 'container',
        max_file_size: '2mb',
        flash_swf_url: '/js/official/qiniu/js/plupload/Moxie.swf',
        dragdrop: true,
        chunk_size: '4mb',
        uptoken_url: $('#uptoken_url').val(),
        domain: $('#domain').val(),
        // rename:true,
        filters : [ {title : "图片", extensions : "jpg,png,bmp,jpeg"} ], //文件过滤
        // downtoken_url: '/downtoken',
        unique_names: true,
        // save_key: true,  
        // x_vars: {
        //     'id': '1234',
        //     'time': function(up, file) {
        //         var time = (new Date()).getTime();
        //         // do something with 'time'
        //         return time;
        //     },
        // },
        auto_start: true,
        init: {
            'FilesAdded': function(up, files) {

                $('table').show();
                $('#success').hide();
                plupload.each(files, function(file) {
                    var progress = new FileProgress(file, 'fsUploadProgress');
                    progress.setStatus("等待...");
                });
            },
            'BeforeUpload': function(up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                if (up.runtime === 'html5' && chunk_size) {
                    progress.setChunkProgess(chunk_size);
                }
            },
            'UploadProgress': function(up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                progress.setProgress(file.percent + "%", up.total.bytesPerSec, chunk_size);
            },
            'UploadComplete': function() {
                $('#success').show();
            },
            'FileUploaded': function(up, file, info) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                progress.setComplete(up, info);
                var url=$.parseJSON(info);
                var domain = up.getOption('domain');
                var res=domain+url.key;

                if(type=='center'){
                    $('#uploadImg').attr({'src': res+'?imageView2/1/w/60/h/60'});
                     $('#file_upload_tmp').val(res).attr({
                        'data-val': '1'
                    });
                }else{
                    // $('#uploadImg').attr({'src': res+'?imageView2/1/w/225/h/125'}); 
                    // $('#uploadImg').attr({'src': res+'?imageMogr2/crop/x'+parseInt(url.width/1.8)+'|imageView2/3/w/504'}); 
                    $('#uploadImg').attr({'src': res+'?imageView2/3/w/558|imageMogr2/crop/x310'}); 
                    $('#file_upload_tmp').val(res).attr({
                        'data-val': '1'
                    });
                    // $('#file_upload_tmp').val(res+'?imageMogr2/crop/x'+parseInt(url.width/1.8)).attr({
                    //     'data-val': '1'
                    // });
                }
                $('#mce-tip').text('').hide();
            },
            'Error': function(up, err, errTip) {
                    var size=err.file.size / 1000 ;
                    if (size > 2000) {
                        $('#mce-tip').text('图片上传失败，请上传小于2M的图片。').show();
                    };
                    $('table').show();
                    var progress = new FileProgress(err.file, 'fsUploadProgress');
                    progress.setError();
                    progress.setStatus(errTip);
                }
            // ,
            // 'Key': function(up, file) {
            //     var key = "56979801.jpg";
            //     // do something with key
            //     return key
            // }
        }
    });

} 

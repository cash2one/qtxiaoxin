<form enctype="multipart/form-data">
    <input name="batchfile" type="file" />
    <input type="button" value="Upload" />
</form>
<div id="result">
</div>
<script>
    
    $(':file').change(function(){
        var file = this.files[0];
        var name = file.name;
        var size = file.size;
        var type = file.type;
        //Your validation
    });
    
    $(':button').click(function(){
        var formData = new FormData($('form')[0]);
        var ajaxurl = '<?php echo Yii::app()->createUrl('gcard/upload');?>';
        $.ajax({
            url: ajaxurl,  //Server script to process data
            type: 'POST',
            xhr: function() {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){ // Check if upload property exists
                    //myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
                }
                return myXhr;
            },
            //Ajax events
            beforeSend: beforeSendHandler,
            success: completeHandler,
            error: errorHandler,
            // Form data
            data: formData,
            //Options to tell jQuery not to process data or worry about content-type.
            cache: false,
            contentType: false,
            processData: false
        });
    });
    
    function beforeSendHandler(args) {
        alert('beforeSendHandler');
    }
    
    function completeHandler(args) {
        $("#result").empty();
        $("#result").append(args);
    }
    
    function errorHandler(args) {
        console.log(args);
    }
</script>
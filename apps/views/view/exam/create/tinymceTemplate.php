
<script type="text/javascript">
tinymce.init({
    selector: "textarea#tinymceText",
    language :"zh_TW",  
    font_size_classes : "fontSize1, fontSize2, fontSize3, fontSize4, fontSize5, fontSize6",//i used this line for font sizes 
    //content_css: "css/content.css", 
    plugins: [
        "textcolor advlist autolink lists link image charmap preview",
        "searchreplace visualblocks",
        "insertdatetime media table contextmenu "
    ],     
    toolbar: "undo redo | styleselect forecolor | fontsizeselect | bold underline italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | <?php if($type=="stuff"): ?>stuffbox2<?php endif;?>",
    setup:function(ed)
    {
    	ed.addButton('stuffbox2',{
    		 title: '新增填空區塊',    			
	         image: 'img/stuffbox.png',
	         onclick: function() {
            	ed.insertContent('/*___*/');
            	//ed.insertContent('<span class="stuffbox"></span>');
         }
    	});
    },
    file_browser_callback :function(field_name, url, type, win)
{
  window.SetUrl=function(url,width,height,caption){
   win.document.forms[0].elements[field_name].value = url;
   if(caption){
    win.document.forms[0].elements["alt"].value=caption;
    win.document.forms[0].elements["title"].value=caption;
   }
  }
  window.open('./kfm/index.php?mode=selector&type='+type,'kfm','modal,width=800,height=600');
}
});


</script>
<body>
	
<textarea id="tinymceText"><?php echo $content;?></textarea>
	
</body>

<script type="text/javascript">
tinymce.init({
    selector: "textarea#tinymceText",
    language :"zh_TW",  
    font_size_classes : "fontSize1, fontSize2, fontSize3, fontSize4, fontSize5, fontSize6",//i used this line for font sizes 
    content_css: "css/content.css", 
    plugins: [
        "textcolor advlist autolink lists link image charmap preview",
        "searchreplace visualblocks",
        "insertdatetime media table contextmenu "
    ],     
    toolbar: "undo redo | styleselect forecolor | fontsizeselect | bold underline italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media"
});
</script>
<body>
	
<textarea id="tinymceText"><?php echo $content;?></textarea>
	
</body>
IpixJson.options.tinyMce = {
    menubar: false,
    theme: 'silver',
    skin: 'oxide',
    skin_url: '/css/tinymce/skins/ui/oxide',
    content_css: [
        '/css/tinymce/skins/content/default/content.min.css',
        '/css/web/font.css' // Compiled CSS from your font.scss
    ],
    font_formats: 'Lexend Bold=Lexend-Bold; Lexend Medium=Lexend-Medium; Lexend Regular=Lexend-Regular; Lexend Light=Lexend-Light; Lexend SemiBold=Lexend-SemiBold; Raleway Thin=Raleway-Thin; Raleway Regular=Raleway-Regular; Raleway Bold=Raleway-Bold; Raleway ExtraBold=Raleway-ExtraBold; Raleway Medium=Raleway-Medium; Raleway SemiBold=Raleway-SemiBold; Arial=arial,helvetica,sans-serif; Times New Roman=times new roman,times',
    fontsize_formats: '8pt 10pt 12pt 14pt 16pt 18pt 20pt 24pt 36pt',
    content_style: 'body { font-family: "Lexend-Regular"; }',
    toolbar: [
        "styleselect fontselect fontsizeselect",
        "undo redo | cut copy | bold italic | forecolor backcolor | link image | alignleft aligncenter alignright alignjustify",
        "bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | preview | code"
    ],
    plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount'
};

$("div.wrapper").hover(function () {
    if(('div.successMsg').length){
        $(".successMsg").fadeOut(2000, function(){ $(this).remove();});
    };

});
$("input.upload").click(function () {
   $('input[type="file"]').click();
});


$('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $("input.upload").val(fileName);

});
// execute click event from the anchor tag
// to click the hidden form which will trigger post
// filename
$("a.fileName").click(function () {
    let fileName = $(this).text();
    $("input.fileName").val(fileName);
    console.log($("input.fileName"));
    $("input.gotoPrev").click();
 });





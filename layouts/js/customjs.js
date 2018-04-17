$("input").on('focus',function () {
    $place = $(this).attr("placeholder");
   $(this).attr("placeholder","");
  }).on("blur",function () {
    $(this).attr("placeholder",$place);
  });

/* start employees page */

//Search Box
$(document).ready(function(){
    $("#searchbox").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tablebody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

//Select Box
$(document).ready(function(){
    // Activate tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // Select/Deselect checkboxes
    var checkbox = $('#tablebody input[type="checkbox"]');
    $("#selectAll").click(function(){
        if(this.checked){
            checkbox.each(function(){
                this.checked = true;
            });
        } else{
            checkbox.each(function(){
                this.checked = false;
            });
        }
    });
    checkbox.click(function(){
        if(!this.checked){
            $("#selectAll").prop("checked", false);
        }
    });
});
/* end employees page */
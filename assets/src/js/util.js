

$(".form-control").focusin(function() {
     $(this).next().addClass("active");
});
$(".form-control").focusout(function(){
     if ($(this).val().length===0) {
         $(this).next().removeClass("active");
    }
    else {
         $(this).next().addClass("active");
    }
});
$(".close").click(function(){
  $(".toast").removeClass("show");
  $(".toast").addClass("hide")
});

function validate(){
     var check = $("form")[0].checkValidity();
};

$(":input[required]").keyup(function(){
     validate();
});

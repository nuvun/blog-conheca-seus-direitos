window.onload = function () {
    setTimeout(function() {
        $('#popUpForm').fadeIn(1000);
    }, 5000);
};

$("#close").click(function() {
    $( "#popUpForm" ).css("display", "none");
});

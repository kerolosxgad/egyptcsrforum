doSubmit = false;

function handleregFormSubmit(event) {
    //Stop the default action.
    event.preventDefault();

    const data = new FormData(event.target);

    const newData = Object.fromEntries(data.entries());

    var gResponse = grecaptcha.getResponse();

    if (gResponse.length == 0){
        doSubmit = false;
    }
    else{
        doSubmit = true;
    }

    if (doSubmit) {
        $.ajax({
            url: "attendee.php",
            type: "POST",
            data: newData,
            success: function () {
                grecaptcha.reset();
                $(".regForm").trigger("reset");
                document.querySelector('.g-recaptcha').style.display = 'none';
                document.querySelector('.regHide').style.display = 'none';
                document.querySelector('.regAlert').style.display = 'block';
                document.querySelector('.regBtn').style.display = 'none';
                document.querySelector('.done').style.display = 'inline';
            }
        });
    } 
    else {
        alert("Please check the reCAPTCHA box and try again.");
    }
}

const form = document.querySelector('.regForm');
form.addEventListener('submit', handleregFormSubmit);
doSubmit = false;

function handleconFormSubmit(event) {
    //Stop the default action.
    event.preventDefault();

    const data = new FormData(event.target);

    const newData = Object.fromEntries(data.entries());

    var gResponse = grecaptcha.getResponse();

    if (gResponse.length == 0) {
        doSubmit = false;
    }
    else {
        doSubmit = true;
    }

    if(doSubmit){
        $.ajax({
            url: "contact.php",
            type: "POST",
            data: newData,
            success: function () {
                grecaptcha.reset();
                $(".conForm").trigger("reset");
                document.querySelector('.conAlert').style.display = 'block';
                setTimeout(function () { document.querySelector('.conAlert').style.display = 'none'; }, 5000);
            }
        });
    }
    else{
        alert("Please check the reCAPTCHA box and try again.");
    }
}

const form = document.querySelector('.conForm');
form.addEventListener('submit', handleconFormSubmit);
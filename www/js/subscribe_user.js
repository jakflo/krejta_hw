// zaregistruje email k zasilani newslatteru a posle uvitaci email
$(() => {
    const formDom = $('#newsletter-form');
    const emailFieldDom = $('#email');
    const formSubmitButtonDom = $('#newsletter-form button.submit-button');
    const formErrorFieldDom = $('#email-error');
    const successMessageDom = $('div.newsletter-message');
    
    const translateErrorMessage = (message) => {
        const dict = {
            "invalid email": "Neplatný formát emailu", 
            "email allready subscribed": "Email je již registrován", 
            "Email sending failed": "Selhalo odeslání emailu", 
            "Database Error": "Chyba databáze"
        };
        
        if (dict[message] !== undefined) {
            return dict[message];
        } else {
            return `Chyba: ${message}`;
        }
    };
    
    $(formDom).on("submit", (event) => {        
        event.preventDefault();
        $(formErrorFieldDom).addClass('hidden');
        $(formSubmitButtonDom).prop("disabled", true); //nachvilku vypneme odesilaci tlacitko, aby nervni klikani neodeslalo form vicekrat
        
        fetch("/subscribe_newsletter.php", {
          method: "post",
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },          
          body: JSON.stringify({
            email: $(emailFieldDom).val()
          })
            })
            .then((responseRaw) => {
                return responseRaw.json();
            })
            .then((response) => {
                $(formSubmitButtonDom).prop("disabled", false);
                const status = response.status;
                if (status === 'ok') {
                    $(formDom).addClass('hidden');
                    $(successMessageDom).removeClass('hidden');
                } else if (status === 'error') {
                    $(formErrorFieldDom).removeClass('hidden');
                    $(formErrorFieldDom).text(translateErrorMessage(response.message));
                } else {
                    throw new Error('neznamy status');
                }        
            })
            .catch((error) => {
                console.log(error.message);
            })
            ;
    });
});
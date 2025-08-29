// nahraje cenu z mexc API do elementu #price_text; delalo to cors problemy, tak je pouzita php jako proxy
$(() => {
    const priceDom = $('#price_text');
    
    fetch('/mexc_proxy.php')
            .then((response) => {
                return response.json();
            })
            .then((responseJson) => {
                if (responseJson.error !== undefined) {
                    throw new Error(responseJson.error);
                }
                
                //cenu preformatujem dle ceskych zvyku
                const formatedPrice = new Intl.NumberFormat('cs-CZ', {
                    minimumFractionDigits: 2    
                }).format(responseJson.price);
                
                $(priceDom).text(formatedPrice);
            })
            .catch((error) => {
                console.log(`nepovedlo se nacist ceny z mexc: ${error.message}`);
            })
            ;
});
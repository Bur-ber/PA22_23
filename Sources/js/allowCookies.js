document.getElementById('allow_cookies').addEventListener('click', function() {

    fetch('core/allowCookies.php')
    .then(response => {

        if (!response.ok) {

            throw new Error('La réponse du réseau n\'était pas correcte');

        }

        document.getElementById('cookie-use-alert').style.display = 'none';

    })

    .catch(error => {

        console.error('Il y a eu un problème avec votre opération de récupération:', error);

    });

});

document.getElementById('decline_cookies').addEventListener('click', function() {

    window.location.href = "http://www.google.fr";

});
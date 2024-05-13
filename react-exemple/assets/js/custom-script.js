var options = {
    beforeSend: function(xhr) {
        xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);

        if (beforeSend) {
            return beforeSend.apply(this, arguments);
        }
    }
};
fetch('http://localhost/wp-json/wp/v2/users/me', {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': wpApiSettings.nonce
    }
})
.then(response => {
    if (!response.ok) {
        throw new Error('La requête a échoué');
    }
    return response.json();
})
.then(data => {
    console.log(data);
    const userData = data;
    console.log(wpApiSettings);
    $.ajax({
        url: '/wp-admin/admin-ajax.php',
        data: {
            action: 'php_tutorial',
            'php_test': userData
        },
        success: function(data) {
            // Gérer la réponse en cas de succès
            console.log('Succès:', data);
        },
        error: function(xhr, status, error) {
            // Gérer les erreurs
            console.error('Erreur:', error);
        }
    });

})
.catch(error => {
    console.error('Erreur lors de la récupération des données :', error);
});

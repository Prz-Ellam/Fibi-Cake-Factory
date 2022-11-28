$('#sign-up-form').validate({
    rules: {
        'profile-picture': {
            required: true,
            filesize: 8
        },
        'email': {
            required: true,
            email: false,
            email5322: true,
            remote: {
                type: 'POST',
                url: 'Cake-Factory/isEmailAvailable',
                data: {
                    'email': function() { return $('#email').val() }
                },
                dataType: 'json'
            }
        },
        'username': {
            required: true,
            remote: {
                type: 'POST',
                url: 'Cake-Factory/isUsernameAvailable',
                data: {
                    'username': function() { return $('#username').val() }
                },
                dataType: 'json'
            }
        },
        'first-name': {
            required: true
        },
        'last-name': {
            required: true
        },
        'gender': {
            required: true
        },
        'birth-date': {
            required: true,
            date: true,
            dateRange: ['1900-01-01', dateFormat]
        },
        'password': {
            required: true
        },
        'confirm-password': {
            required: true,
            equalTo: '#password' // Igual que la contraseña
        }
    },
    messages: {
        'profile-picture': {
            required: 'La foto de perfil no puede estar vacía.',
            filesize: 'El archivo es demasiado pesado (máximo de 8MB)'
        },
        'email': {
            required: 'El correo electrónico no puede estar vacío.',
            email5322: 'El correo electrónico que ingresó no es válido.',
            remote: 'El correo electrónico está siendo usado por alguien más.'
        },
        'username': {
            required: 'El nombre de usuario no puede estar vacío.',
            remote: 'El nombre de usuario está siendo usado por alguien más.'
        },
        'first-name': {
            required: 'El nombre no puede estar vacío.'
        },
        'last-name': {
            required: 'El apellido no puede estar vacío.'
        },
        'birth-date': {
            required: 'La fecha de nacimiento no puede estar vacía.',
            date: 'La fecha de nacimiento debe tener formato de fecha.',
            dateRange: 'La fecha de nacimiento no puede ser antes de la fecha actual'
        },
        'gender': {
            required: 'El género no puede estar vacío.'
        },
        'password': {
            required: 'La contraseña no puede estar vacía.'
        },
        'confirm-password': {
            required: 'Confirmar contraseña no puede estar vacío.',
            equalTo: 'Confirmar contraseña no coincide con contraseña'
        }
    },
    errorElement: 'small',
    errorPlacement: function(error, element) {
        error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
    }
});
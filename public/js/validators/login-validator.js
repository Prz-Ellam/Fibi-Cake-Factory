export function userValidator(id) {
    // '#login-form'
    $(id).validate({
        rules: {
            'loginOrEmail': {
                required: true,
                email: false
            },
            'password': {
                required: true
            }
        },
        messages: {
            'loginOrEmail': {
                required: 'El usuario o correo electrónico no puede estar vacío.'
            },
            'password': {
                required: 'La contraseña no puede estar vacía.'
            }
        },
        errorElement: 'small',
        errorPlacement: function (error, element) {
            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        }
    });
}
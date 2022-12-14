export function profileValidator() {

    var date = new Date();
    var dateFormat = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0') + '-' + String(date.getDate()).padStart(2, '0')
    
    // RFC
    $.validator.addMethod('email5322', function (value, element) {
        return this.optional(element) || /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/.test(value);
    }, 'Please enter a valid email');

    // Date Range
    $.validator.addMethod("dateRange", function (value, element, parameter) {
        return this.optional(element) ||
            !(Date.parse(value) > Date.parse(parameter[1]) || Date.parse(value) < Date.parse(parameter[0]));
    }, 'Please enter a valid date');

    $.validator.addMethod("username", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]([._-](?![._-])|[a-zA-Z0-9]){3,18}$/.test(value);
    }, 'Please enter a valid username');

    // Data size (no puede pesar mas de 8MB)
    $.validator.addMethod('filesize', function (value, element, parameter) {

        let result;
        if (element.files[0] === undefined) {
            return this.optional(element) || result;
        }

        const size = (element.files[0].size / 1024 / 1024).toFixed(2);
        result = (parseFloat(size) > parameter) ? false : true;

        return this.optional(element) || result;
    }, 'Please enter a valid file');

    // Regex
    $.validator.addMethod('lower', function (value, element) {
        var regexp = new RegExp(/[a-z]/g);
        return this.optional(element) || regexp.test(value);
    }, 'Please enter a valid input');

    $.validator.addMethod('upper', function (value, element) {
        var regexp = new RegExp(/[A-Z]/g);
        return this.optional(element) || regexp.test(value);
    }, 'Please enter a valid input');

    $.validator.addMethod('numbers', function (value, element) {
        var regexp = new RegExp(/[0-9]/g);
        return this.optional(element) || regexp.test(value);
    }, 'Please enter a valid input');

    $.validator.addMethod('regex', function (value, element, parameter) {
        var regexp = new RegExp(parameter);
        return this.optional(element) || regexp.test(value);
    }, 'Please enter a valid input');

    $('#profile-form').validate({
        rules: {
            'profilePicture': {
                required: true,
                filesize: 8
            },
            'email': {
                required: true,
                email: false,
                email5322: true,
                remote: {
                    type: 'POST',
                    url: 'api/v1/users/email/available',
                    data: {
                        'email': function () { return $('#email').val() }
                    },
                    dataType: 'json'
                }
            },
            'username': {
                required: true,
                username: true,
                minlength: 3,
                remote: {
                    type: 'POST',
                    url: 'api/v1/users/username/available',
                    data: {
                        'username': function () { return $('#username').val() }
                    },
                    dataType: 'json'
                }
            },
            'firstName': {
                required: true
            },
            'lastName': {
                required: true
            },
            'gender': {
                required: true
            },
            'birthDate': {
                required: true,
                date: true,
                dateRange: ['1900-01-01', dateFormat]
            }
        },
        messages: {
            'profilePicture': {
                required: 'La foto de perfil no puede estar vac??a.',
                filesize: 'El archivo es demasiado pesado (m??ximo de 8MB)'
            },
            'email': {
                required: 'El correo electr??nico no puede estar vac??o.',
                email5322: 'El correo electr??nico que ingres?? no es v??lido.',
                remote: 'El correo electr??nico est?? siendo usado por alguien m??s.'
            },
            'username': {
                required: 'El nombre de usuario no puede estar vac??o.',
                username: 'El nombre de usuario debe contener m??s de 3 caracteres',
                minlength: 'El nombre de usuario debe contener m??s de 3 caracteres',
                remote: 'El nombre de usuario est?? siendo usado por alguien m??s.'
            },
            'firstName': {
                required: 'El nombre no puede estar vac??o.'
            },
            'lastName': {
                required: 'El apellido no puede estar vac??o.'
            },
            'birthDate': {
                required: 'La fecha de nacimiento no puede estar vac??a.',
                date: 'La fecha de nacimiento debe tener formato de fecha.',
                dateRange: 'La fecha de nacimiento no puede ser antes de la fecha actual'
            },
            'gender': {
                required: 'El g??nero no puede estar vac??o.'
            }
        },
        errorElement: 'small',
        errorPlacement: function (error, element) {

            if ($(element)[0].name === 'gender') {
                error.insertAfter(element.parent().parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
                return;
            }

            if ($(element)[0].name === 'profilePicture') {
                error.insertAfter(element).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
                return;
            }

            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        }
    });

    $('#password-form').validate({
        rules: {
            'oldPassword': {
                required: true
            },
            'newPassword': {
                required: true,
                minlength: 8,
                lower: true,
                upper: true,
                numbers: true,
                regex: /[?????"#$%&;/=????!??:;,.\-_+*{}\[\]]/g
            },
            'confirmNewPassword': {
                required: true,
                equalTo: '#new-password'
            }
        },
        messages: {
            'oldPassword': {
                required: 'La contrase??a no puede estar vac??a.'
            },
            'newPassword': {
                required: 'La nueva contrase??a no puede estar vac??a.',
                minlength: 'Faltan requerimentos de la nueva contrase??a',
                lower: 'Faltan requerimentos de la nueva contrase??a',
                upper: 'Faltan requerimentos de la nueva contrase??a',
                numbers: 'Faltan requerimentos de la nueva contrase??a',
                regex: 'Faltan requerimentos de la nueva contrase??a'
            },
            'confirmNewPassword': {
                required: 'Confirmar nueva contrase??a no puede estar vac??o.',
                equalTo: 'Confirmar nueva contrase??a no coincide con nueva contrase??a'
            }
        },
        errorElement: 'small',
        errorPlacement: function (error, element) {
            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        }
    });


}
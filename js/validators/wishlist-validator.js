export function wishlistValidator(id) {

    $.validator.addMethod('maxfiles', function(value, element, parameter) {
        return (element.files.length <= Number(parameter));
    }, 'Too many files');

    $.validator.addMethod('filesize', function(value, element, parameter) {

        let result;
        if (element.files[0] === undefined) {
            return this.optional(element) || result; 
        }

        const size = (element.files[0].size / 1024 / 1024).toFixed(2);
        result = (parseFloat(size) > parameter) ? false : true;

        return this.optional(element) || result;
        
    }, 'Please enter a valid file');

    $(id).validate({
        rules: {
            'images[]': {
                maxfiles: 3
            },
            'name': {
                required: true,
                maxlength: 50
            },
            'description': {
                required: true,
                maxlength: 200
            },
            'visible': {
                required: true
            }
        },
        messages: {
            'images[]': {
                maxfiles: 'Solo se pueden añadir 3 imagenes por lista'
            },
            'name': {
                required: 'El nombre de la lista de deseos no puede estar vacío.',
                maxlength: 'El nombre de la lista es demasiado largo'
            },
            'description': {
                required: 'La descripción de la lista de deseos no puede estar vacía.',
                maxlength: 'La descripción de la lista es demasiado larga'
            },
            'visible': {
                required: 'La visibilidad no puede estar vacía.'
            }
        },
        errorElement: 'small',
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        }
    });

}
export function createProductValidator(id) {

    $.validator.addMethod('fileCount', function(value, element, parameter) {
        return (element.files.length >= Number(parameter));
    }, 'Please complete the input file');

    $.validator.addMethod('maxfiles', function(value, element, parameter) {
        return (element.files.length <= Number(parameter));
    }, 'Too many files');

    $.validator.addMethod('filesize', function (value, element, parameter) {

        let result;
        if (element.files[0] === undefined) {
            return this.optional(element) || result;
        }

        const size = parseFloat((element.files[0].size / 1024.0 / 1024.0).toFixed(2));
        result = (size > parameter) ? false : true;

        return this.optional(element) || result;
    }, 'Please enter a valid file');

    $(id).validate({
        rules: {
            'name': {
                required: true
            },
            'description': {
                required: true
            },
            'price': {
                required: true,
                min: 0.01
            },
            'stock': {
                required: true,
                number: true,
                min: 1
            },
            'images[]': {
                fileCount: 3,
                maxfiles: 3
            },
            'video': {
                required: true,
                filesize: 8
            },
            'categories[]': {
                required: true
            }
        },
        messages: {
            'name': {
                required: 'El nombre del producto no puede estar vacío.'
            },
            'description': {
                required: 'La descripción del producto no puede estar vacía.'
            },
            'price': {
                required: 'Si el producto es para vender, el precio no puede estar vacío',
                min: 'El precio del producto no puede ser $0.00 M.N'
            },
            'stock': {
                required: 'La cantidad de producto no puede estar vacía',
                number: 'La cantidad debe ser un número',
                min: 'Debe haber al menos un producto en existencia'
            },
            'images[]': {
                fileCount: 'La cantidad de imágenes debe ser mínimo 3'
            },
            'video': {
                required: 'El video no puede estar vacío.',
                filesize: 'El archivo es demasiado pesado (máximo de 8MB)'
            },
            'categories[]': {
                required: 'Las categorías no pueden estar vacías'
            }
        },
        errorElement: 'small',
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        }
    });

}
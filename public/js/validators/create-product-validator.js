export function createProductValidator(id) {

    $.validator.addMethod('fileCount', function(value, element, parameter) {
        return (element.files.length >= Number(parameter));
    }, 'Please complete the input file');

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
            'images': {
                fileCount: 3
            },
            'videos': {
                fileCount: 1
            },
            'categories': {
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
            'images': {
                fileCount: 'La cantidad de imágenes debe ser mínimo 3'
            },
            'videos': {
                fileCount: 'La cantidad de videos debe ser mínimo 1'
            },
            'categories': {
                required: 'Las categorías no pueden estar vacías'
            }
        },
        errorElement: 'small',
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent()).addClass('text-danger').addClass('form-text').attr('id', element[0].id + '-error-label');
        }
    });

}
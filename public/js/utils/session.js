export function getSession() {
    var value = null;
    $.ajax({
        url: 'api/v1/session',
        method: 'GET',
        async: false,
        timeout: 0,
        success: function(response) {
            value = response.id;
        }
    });
    return value;
};
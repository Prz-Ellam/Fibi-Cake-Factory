import { getSession } from './utils/session.js';
const userId = getSession();

$.ajax({
    url: `api/v1/users/${userId}`,
    method: "GET",
    async: false,
    success: function (response) {
        const url = `api/v1/images/${response.profilePicture}`;
        $('.nav-link img').attr('src', url);
    }
});

$(document).ready(() => {


    fetch(`/api/v1/quotes/pending?userId=${userId}`)
    .then(response => response.json())
    .then(response => {

        console.log(response);

    })


})
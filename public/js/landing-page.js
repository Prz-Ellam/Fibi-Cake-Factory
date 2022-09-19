/*
const router = (event) => {
    event = event || window.event;
    event.preventDefault();
    window.history.pushState({}, '', event.target.href);
}

const handleLocation = async () => {
    const path = window.location.pathname;
    const routes = {
        '/': 'A',
    };
    console.log(routes);
    const route = routes[path];
    const html = await fetch(route).then((data) => data.text());
    const body = document.createElement('div');
    body.innerHTML = html;
    document.body.appendChild(body);
}

window.onpopstate = handleLocation;
window.route = router;

handleLocation();
*/


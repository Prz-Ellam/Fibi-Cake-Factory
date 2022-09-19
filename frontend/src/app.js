$ = require('jquery');

import LandingPage from './views/landing-page.html';
import Login from './views/login.html';
import Signup from './views/signup.html';
import Home from './views/home.html';
import Product from './views/product.html';
import Products from './views/products.html';
import Wishlist from './views/wishlist.html';
import Wishlists from './views/wishlists.html';
import Chat from './views/chat.html';
import Checkout from './views/checkout.html';
import ShoppingCart from './views/shopping-cart.html';
import Search from './views/search.html';
import CreateProduct from './views/create-product.html';
import UpdateProduct from './views/update-product.html';
import SalesReport from './views/sales-report.html';
import OrdersReport from './views/orders-report.html';

const route = (event) => {
    event = event || window.event;
    event.preventDefault();
    window.history.pushState({}, "", event.target.href);
    handleLocation();
}

const routes = {
    '/': LandingPage,
    '/login': Login,
    '/signup': Signup,
    '/home': Home,
    '/product': Product,
    '/products': Products,
    '/wishlist': Wishlist,
    '/wishlists': Wishlists,
    '/chat': Chat,
    '/checkout': Checkout,
    '/shopping-cart': ShoppingCart,
    '/create-product': CreateProduct,
    '/update-product': UpdateProduct,
    '/sales-report': SalesReport,
    '/orders-report': OrdersReport
}

const handleLocation = async () => {
    const path = window.location.pathname;
    const route = routes[path] || '';

    const mainContainer = document.getElementById('main-container');
    mainContainer.innerHTML = route;

    switch (path)
    {
        case '/':           require('./controllers/landing-page-controller.js');
        case '/login':      require('./controllers/login-controller.js');
        case '/signup':     require('./controllers/signup-controller.js');
        case '/home':       require('./controllers/home-controller.js');
        case '/product':    require('./controllers/product-controller.js');
        case '/products':   require('./controllers/products-controller.js');
        case '/wishlist':   require('./controllers/wishlist-controller.js');
        case '/wishlists':  require('./controllers/wishlists-controller.js');
        case '/chat':       require('./controllers/chat-controller.js');
        case '/checkout':   require('./controllers/checkout-controller.js');
        case '/shopping-cart':  require('./controllers/shopping-cart-controller.js');
        case '/create-product': require('./controllers/create-product-controller.js');
        case '/update-product': require('./controllers/update-product-controller.js');
        case '/sales-report':   require('./controllers/sales-report-controller.js');
        case '/orders-report':  require('./controllers/orders-report-controller.js');
    }

}

window.onpopstate = handleLocation;
window.route = route;

handleLocation();

/*
$('a').click(function(event) {
    event.preventDefault();
    delete require.cache[require.resolve('./controllers/login-controller.js')];
    route();
})
*/

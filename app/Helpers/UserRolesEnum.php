<?php

namespace CakeFactory\Helpers;

enum UserRolesEnum : string
{
    case SUPERADMIN = "Super Administrador";
    case ADMIN = "Administrador";
    case SELLER = "Vendedor";
    case CLIENT = "Comprador";
}

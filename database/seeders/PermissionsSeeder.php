<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list affiliatecommissions']);
        Permission::create(['name' => 'view affiliatecommissions']);
        Permission::create(['name' => 'create affiliatecommissions']);
        Permission::create(['name' => 'update affiliatecommissions']);
        Permission::create(['name' => 'delete affiliatecommissions']);

        Permission::create(['name' => 'list affiliateprograms']);
        Permission::create(['name' => 'view affiliateprograms']);
        Permission::create(['name' => 'create affiliateprograms']);
        Permission::create(['name' => 'update affiliateprograms']);
        Permission::create(['name' => 'delete affiliateprograms']);

        Permission::create(['name' => 'list banners']);
        Permission::create(['name' => 'view banners']);
        Permission::create(['name' => 'create banners']);
        Permission::create(['name' => 'update banners']);
        Permission::create(['name' => 'delete banners']);

        Permission::create(['name' => 'list carts']);
        Permission::create(['name' => 'view carts']);
        Permission::create(['name' => 'create carts']);
        Permission::create(['name' => 'update carts']);
        Permission::create(['name' => 'delete carts']);

        Permission::create(['name' => 'list cartitems']);
        Permission::create(['name' => 'view cartitems']);
        Permission::create(['name' => 'create cartitems']);
        Permission::create(['name' => 'update cartitems']);
        Permission::create(['name' => 'delete cartitems']);

        Permission::create(['name' => 'list categories']);
        Permission::create(['name' => 'view categories']);
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'update categories']);
        Permission::create(['name' => 'delete categories']);

        Permission::create(['name' => 'list customers']);
        Permission::create(['name' => 'view customers']);
        Permission::create(['name' => 'create customers']);
        Permission::create(['name' => 'update customers']);
        Permission::create(['name' => 'delete customers']);

        Permission::create(['name' => 'list customerwishlists']);
        Permission::create(['name' => 'view customerwishlists']);
        Permission::create(['name' => 'create customerwishlists']);
        Permission::create(['name' => 'update customerwishlists']);
        Permission::create(['name' => 'delete customerwishlists']);

        Permission::create(['name' => 'list discounts']);
        Permission::create(['name' => 'view discounts']);
        Permission::create(['name' => 'create discounts']);
        Permission::create(['name' => 'update discounts']);
        Permission::create(['name' => 'delete discounts']);

        Permission::create(['name' => 'list emailtemplates']);
        Permission::create(['name' => 'view emailtemplates']);
        Permission::create(['name' => 'create emailtemplates']);
        Permission::create(['name' => 'update emailtemplates']);
        Permission::create(['name' => 'delete emailtemplates']);

        Permission::create(['name' => 'list externalintegrations']);
        Permission::create(['name' => 'view externalintegrations']);
        Permission::create(['name' => 'create externalintegrations']);
        Permission::create(['name' => 'update externalintegrations']);
        Permission::create(['name' => 'delete externalintegrations']);

        Permission::create(['name' => 'list inventories']);
        Permission::create(['name' => 'view inventories']);
        Permission::create(['name' => 'create inventories']);
        Permission::create(['name' => 'update inventories']);
        Permission::create(['name' => 'delete inventories']);

        Permission::create(['name' => 'list notifications']);
        Permission::create(['name' => 'view notifications']);
        Permission::create(['name' => 'create notifications']);
        Permission::create(['name' => 'update notifications']);
        Permission::create(['name' => 'delete notifications']);

        Permission::create(['name' => 'list orders']);
        Permission::create(['name' => 'view orders']);
        Permission::create(['name' => 'create orders']);
        Permission::create(['name' => 'update orders']);
        Permission::create(['name' => 'delete orders']);

        Permission::create(['name' => 'list orderitems']);
        Permission::create(['name' => 'view orderitems']);
        Permission::create(['name' => 'create orderitems']);
        Permission::create(['name' => 'update orderitems']);
        Permission::create(['name' => 'delete orderitems']);

        Permission::create(['name' => 'list pages']);
        Permission::create(['name' => 'view pages']);
        Permission::create(['name' => 'create pages']);
        Permission::create(['name' => 'update pages']);
        Permission::create(['name' => 'delete pages']);

        Permission::create(['name' => 'list payments']);
        Permission::create(['name' => 'view payments']);
        Permission::create(['name' => 'create payments']);
        Permission::create(['name' => 'update payments']);
        Permission::create(['name' => 'delete payments']);

        Permission::create(['name' => 'list paymentmethods']);
        Permission::create(['name' => 'view paymentmethods']);
        Permission::create(['name' => 'create paymentmethods']);
        Permission::create(['name' => 'update paymentmethods']);
        Permission::create(['name' => 'delete paymentmethods']);

        Permission::create(['name' => 'list products']);
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'create products']);
        Permission::create(['name' => 'update products']);
        Permission::create(['name' => 'delete products']);

        Permission::create(['name' => 'list productattributes']);
        Permission::create(['name' => 'view productattributes']);
        Permission::create(['name' => 'create productattributes']);
        Permission::create(['name' => 'update productattributes']);
        Permission::create(['name' => 'delete productattributes']);

        Permission::create(['name' => 'list productimages']);
        Permission::create(['name' => 'view productimages']);
        Permission::create(['name' => 'create productimages']);
        Permission::create(['name' => 'update productimages']);
        Permission::create(['name' => 'delete productimages']);

        Permission::create(['name' => 'list productreviews']);
        Permission::create(['name' => 'view productreviews']);
        Permission::create(['name' => 'create productreviews']);
        Permission::create(['name' => 'update productreviews']);
        Permission::create(['name' => 'delete productreviews']);

        Permission::create(['name' => 'list producttags']);
        Permission::create(['name' => 'view producttags']);
        Permission::create(['name' => 'create producttags']);
        Permission::create(['name' => 'update producttags']);
        Permission::create(['name' => 'delete producttags']);

        Permission::create(['name' => 'list productvariants']);
        Permission::create(['name' => 'view productvariants']);
        Permission::create(['name' => 'create productvariants']);
        Permission::create(['name' => 'update productvariants']);
        Permission::create(['name' => 'delete productvariants']);

        Permission::create(['name' => 'list refunds']);
        Permission::create(['name' => 'view refunds']);
        Permission::create(['name' => 'create refunds']);
        Permission::create(['name' => 'update refunds']);
        Permission::create(['name' => 'delete refunds']);

        Permission::create(['name' => 'list returnprodcts']);
        Permission::create(['name' => 'view returnprodcts']);
        Permission::create(['name' => 'create returnprodcts']);
        Permission::create(['name' => 'update returnprodcts']);
        Permission::create(['name' => 'delete returnprodcts']);

        Permission::create(['name' => 'list seometas']);
        Permission::create(['name' => 'view seometas']);
        Permission::create(['name' => 'create seometas']);
        Permission::create(['name' => 'update seometas']);
        Permission::create(['name' => 'delete seometas']);

        Permission::create(['name' => 'list seosettings']);
        Permission::create(['name' => 'view seosettings']);
        Permission::create(['name' => 'create seosettings']);
        Permission::create(['name' => 'update seosettings']);
        Permission::create(['name' => 'delete seosettings']);

        Permission::create(['name' => 'list settings']);
        Permission::create(['name' => 'view settings']);
        Permission::create(['name' => 'create settings']);
        Permission::create(['name' => 'update settings']);
        Permission::create(['name' => 'delete settings']);

        Permission::create(['name' => 'list shipments']);
        Permission::create(['name' => 'view shipments']);
        Permission::create(['name' => 'create shipments']);
        Permission::create(['name' => 'update shipments']);
        Permission::create(['name' => 'delete shipments']);

        Permission::create(['name' => 'list shippingmethods']);
        Permission::create(['name' => 'view shippingmethods']);
        Permission::create(['name' => 'create shippingmethods']);
        Permission::create(['name' => 'update shippingmethods']);
        Permission::create(['name' => 'delete shippingmethods']);

        Permission::create(['name' => 'list socialmedialinks']);
        Permission::create(['name' => 'view socialmedialinks']);
        Permission::create(['name' => 'create socialmedialinks']);
        Permission::create(['name' => 'update socialmedialinks']);
        Permission::create(['name' => 'delete socialmedialinks']);

        Permission::create(['name' => 'list taxes']);
        Permission::create(['name' => 'view taxes']);
        Permission::create(['name' => 'create taxes']);
        Permission::create(['name' => 'update taxes']);
        Permission::create(['name' => 'delete taxes']);

        Permission::create(['name' => 'list useractivities']);
        Permission::create(['name' => 'view useractivities']);
        Permission::create(['name' => 'create useractivities']);
        Permission::create(['name' => 'update useractivities']);
        Permission::create(['name' => 'delete useractivities']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}

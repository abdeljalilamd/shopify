<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

        $this->call(AffiliateCommissionSeeder::class);
        $this->call(AffiliateProgramSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(CartSeeder::class);
        $this->call(CartItemSeeder::class);
        $this->call(CategorieSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(CustomerWishlistSeeder::class);
        $this->call(DiscountSeeder::class);
        $this->call(EmailTemplateSeeder::class);
        $this->call(ExternalIntegrationSeeder::class);
        $this->call(InventorySeeder::class);
        $this->call(NotificationSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(OrderItemSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductAttributeSeeder::class);
        $this->call(ProductImageSeeder::class);
        $this->call(ProductReviewSeeder::class);
        $this->call(ProductTagSeeder::class);
        $this->call(ProductVariantSeeder::class);
        $this->call(RefundSeeder::class);
        $this->call(ReturnProdctSeeder::class);
        $this->call(SeoMetaSeeder::class);
        $this->call(SeoSettingSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(ShipmentSeeder::class);
        $this->call(ShippingMethodSeeder::class);
        $this->call(SocialMediaLinkSeeder::class);
        $this->call(TaxeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserActivitieSeeder::class);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminUserTableSeeder::class,
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            ConditionsTableSeeder::class,
            DeliveryMethodsTableSeeder::class,
            OrderStatusesTableSeeder::class,
            ProductsTableSeeder::class,
            ReviewsTableSeeder::class,
            CartsTableSeeder::class,
            TagsTableSeeder::class,
            ImagesTableSeeder::class,
            MessagesTableSeeder::class,
            CouponsTableSeeder::class,
            FavoritesTableSeeder::class,
            OrdersTableSeeder::class,
            OrderItemsTableSeeder::class,
            NotificationsTableSeeder::class,
            ReportsTableSeeder::class,
        ]);
    }
}

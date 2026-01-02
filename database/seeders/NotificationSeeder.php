<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;
use App\Models\Order;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $orders = Order::all();

        if ($users->isEmpty()) {
            $this->command->error('Please run UserSeeder first!');
            return;
        }

        $notificationTypes = [
            Notification::TYPE_ORDER_NEW,
            Notification::TYPE_ORDER_ACCEPTED,
            Notification::TYPE_ORDER_COMPLETED,
            Notification::TYPE_MESSAGE_NEW,
            Notification::TYPE_GIG_APPLICATION,
        ];

        $titles = [
            Notification::TYPE_ORDER_NEW => 'New Order Received',
            Notification::TYPE_ORDER_ACCEPTED => 'Order Accepted',
            Notification::TYPE_ORDER_COMPLETED => 'Order Completed',
            Notification::TYPE_MESSAGE_NEW => 'New Message',
            Notification::TYPE_GIG_APPLICATION => 'New Gig Application',
        ];

        $messages = [
            Notification::TYPE_ORDER_NEW => 'You have received a new order request.',
            Notification::TYPE_ORDER_ACCEPTED => 'Your order has been accepted by the handyman.',
            Notification::TYPE_ORDER_COMPLETED => 'Your order has been marked as completed.',
            Notification::TYPE_MESSAGE_NEW => 'You have a new message in your conversation.',
            Notification::TYPE_GIG_APPLICATION => 'Someone applied to your gig.',
        ];

        // Create 5-10 notifications per user
        foreach ($users as $user) {
            $notificationCount = rand(5, 10);

            for ($i = 0; $i < $notificationCount; $i++) {
                $type = $notificationTypes[array_rand($notificationTypes)];
                $createdAt = now()->subDays(rand(0, 30));
                
                // 40% chance notification is read
                $isRead = rand(1, 100) <= 40;

                $notification = Notification::create([
                    'user_id' => $user->id,
                    'type' => $type,
                    'title' => $titles[$type],
                    'message' => $messages[$type],
                    'data' => [
                        'order_id' => $orders->isNotEmpty() ? $orders->random()->order_id : null,
                        'timestamp' => $createdAt->toISOString(),
                    ],
                    'created_at' => $createdAt,
                    'read_at' => $isRead ? $createdAt->copy()->addHours(rand(1, 48)) : null,
                ]);
            }
        }

        $this->command->info('Additional notifications seeded successfully!');
    }
}

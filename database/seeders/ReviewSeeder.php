<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Order;
use App\Models\Notification;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all completed orders
        $completedOrders = Order::where('status', 'completed')->get();

        if ($completedOrders->isEmpty()) {
            $this->command->error('No completed orders found! Run OrderSeeder first.');
            return;
        }

        $positiveComments = [
            'Excellent work! Very professional and on time.',
            'Highly recommend! Did an amazing job.',
            'Great service! Will definitely hire again.',
            'Very satisfied with the quality of work.',
            'Professional, courteous, and skilled. Thank you!',
            'Completed the job perfectly. Very happy!',
            'Fast response and great quality work.',
            'Exceeded my expectations. Top notch service!',
            'Very reliable and trustworthy. Highly recommend!',
            'Outstanding service! Best handyman I\'ve worked with.',
            'Clean work and great attention to detail.',
            'Exactly what I needed. Perfect results!',
            'Very professional and reasonably priced.',
            'Arrived on time and finished ahead of schedule.',
            'Excellent communication throughout the project.',
        ];

        $goodComments = [
            'Good work overall. Happy with the results.',
            'Satisfied with the service. Would recommend.',
            'Did a good job. Minor delays but worth it.',
            'Quality work at a fair price.',
            'Professional service. Met my expectations.',
            'Good experience. Will consider for future work.',
            'Solid work. No complaints.',
            'Reliable and skilled. Good value.',
            'Happy with the outcome. Professional approach.',
            'Good service. Completed as discussed.',
        ];

        $averageComments = [
            'Average service. Got the job done.',
            'Okay work. Nothing special but acceptable.',
            'Decent service. Room for improvement.',
            'Fair work. Met basic requirements.',
            'Average experience. Expected more attention to detail.',
            'Acceptable work. Could be better.',
            'Job done but not exceptional.',
            'Satisfactory. Would look for alternatives next time.',
        ];

        $poorComments = [
            'Not satisfied. Had to fix some issues myself.',
            'Below expectations. Several mistakes made.',
            'Disappointed with the quality of work.',
            'Poor communication and delayed completion.',
            'Not happy. Would not recommend.',
            'Careless work. Had to call another professional.',
        ];

        $handymanResponses = [
            'Thank you so much for your kind words! It was a pleasure working with you.',
            'We appreciate your feedback! Looking forward to serving you again.',
            'Thank you for choosing our service! Your satisfaction is our priority.',
            'Thanks for the great review! Happy to help anytime.',
            'We\'re glad you\'re satisfied with our work! Thank you!',
            'Thank you for your trust! We always strive for excellence.',
            'Appreciate your positive feedback! We\'re here whenever you need us.',
            'Thank you! It was a pleasure to work on your project.',
            'We apologize for any inconvenience. We\'ll improve our service.',
            'Thank you for your honest feedback. We take this seriously.',
        ];

        // Review ~70% of completed orders
        $ordersToReview = $completedOrders->random(min((int)($completedOrders->count() * 0.7), $completedOrders->count()));

        foreach ($ordersToReview as $order) {
            // Generate rating (weighted towards positive)
            $rating = $this->weightedRandomRating();
            
            // Select comment based on rating
            if ($rating === 5) {
                $comment = $positiveComments[array_rand($positiveComments)];
            } elseif ($rating === 4) {
                $comment = rand(0, 1) ? $positiveComments[array_rand($positiveComments)] : $goodComments[array_rand($goodComments)];
            } elseif ($rating === 3) {
                $comment = $averageComments[array_rand($averageComments)];
            } else {
                $comment = $poorComments[array_rand($poorComments)];
            }

            $createdAt = $order->created_at->copy()->addHours(rand(1, 72));

            $review = Review::create([
                'order_id' => $order->order_id,
                'client_id' => $order->id_client,
                'handyman_id' => $order->id_handyman,
                'rating' => $rating,
                'comment' => $comment,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // Update order rating
            $order->update(['rating' => $rating]);

            // 60% chance handyman responds to review
            if ($rating >= 4 && rand(1, 100) <= 60) {
                $responseAt = $createdAt->copy()->addHours(rand(1, 24));
                $review->update([
                    'response' => $handymanResponses[array_rand($handymanResponses)],
                    'response_at' => $responseAt,
                ]);
            } elseif ($rating <= 3 && rand(1, 100) <= 40) {
                // Lower ratings get fewer responses but some do respond
                $responseAt = $createdAt->copy()->addHours(rand(1, 48));
                $review->update([
                    'response' => $handymanResponses[array_rand(array_slice($handymanResponses, -2))],
                    'response_at' => $responseAt,
                ]);
            }

            // Create notification for client (review confirmation)
            Notification::create([
                'user_id' => $order->id_client,
                'type' => Notification::TYPE_REVIEW_NEW,
                'title' => 'Review Posted',
                'message' => 'Your review has been posted successfully.',
                'data' => ['review_id' => $review->review_id, 'order_id' => $order->order_id],
                'created_at' => $createdAt,
            ]);

            // Create notification for handyman about the review
            Notification::create([
                'user_id' => $order->id_handyman,
                'type' => Notification::TYPE_REVIEW_NEW,
                'title' => 'New Review Received',
                'message' => "You received a {$rating}-star review from a client.",
                'data' => ['review_id' => $review->review_id, 'order_id' => $order->order_id, 'rating' => $rating],
                'created_at' => $createdAt,
                'read_at' => rand(0, 1) ? $createdAt->copy()->addHours(rand(1, 12)) : null,
            ]);

            // If handyman responded, notify client
            if ($review->response) {
                Notification::create([
                    'user_id' => $order->id_client,
                    'type' => Notification::TYPE_REVIEW_RESPONSE,
                    'title' => 'Handyman Responded to Your Review',
                    'message' => 'The handyman has responded to your review.',
                    'data' => ['review_id' => $review->review_id, 'order_id' => $order->order_id],
                    'created_at' => $review->response_at,
                    'read_at' => rand(0, 1) ? $review->response_at->copy()->addHours(rand(1, 24)) : null,
                ]);
            }
        }

        $this->command->info('Reviews seeded successfully with ' . $ordersToReview->count() . ' reviews!');
    }

    /**
     * Generate weighted random rating (mostly positive)
     */
    private function weightedRandomRating(): int
    {
        $rand = rand(1, 100);
        
        if ($rand <= 50) return 5; // 50% - 5 stars
        if ($rand <= 80) return 4; // 30% - 4 stars
        if ($rand <= 90) return 3; // 10% - 3 stars
        if ($rand <= 96) return 2; // 6% - 2 stars
        return 1;                   // 4% - 1 star
    }
}

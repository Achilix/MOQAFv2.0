<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Models\Client;
use App\Models\Handyman;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::with('user')->get();
        $handymen = Handyman::with('user')->get();

        if ($clients->isEmpty() || $handymen->isEmpty()) {
            $this->command->warn('No clients or handymen found. Skipping conversation seeding.');
            return;
        }

        // Create 10-15 conversations between clients and handymen
        $conversationsCreated = 0;
        $messagesCreated = 0;

        foreach ($clients->take(10) as $client) {
            // Each client has conversations with 1-2 handymen
            $handymenForClient = $handymen->random(min(2, $handymen->count()));

            foreach ($handymenForClient as $handyman) {
                // Check if conversation already exists
                $existingConversation = Conversation::where(function ($query) use ($client, $handyman) {
                    $query->where('user1_id', $client->user->id)
                          ->where('user2_id', $handyman->user->id);
                })->orWhere(function ($query) use ($client, $handyman) {
                    $query->where('user1_id', $handyman->user->id)
                          ->where('user2_id', $client->user->id);
                })->first();

                if ($existingConversation) {
                    continue;
                }

                // Create conversation
                $conversation = Conversation::create([
                    'user1_id' => $client->user->id,
                    'user2_id' => $handyman->user->id,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subHours(rand(1, 72)),
                ]);

                $conversationsCreated++;

                // Create 3-10 messages for each conversation
                $messageCount = rand(3, 10);
                $messageTemplates = [
                    // Client messages
                    [
                        'sender' => 'client',
                        'messages' => [
                            'مرحبا، هل أنت متاح لإصلاح مشكلة في السباكة؟',
                            'كم تكلفة الخدمة تقريباً؟',
                            'هل يمكنك القدوم غداً؟',
                            'شكراً، في انتظار ردك',
                            'هل لديك خبرة في هذا النوع من الأعمال؟',
                            'ما هي ساعات العمل المتاحة لديك؟',
                            'هل تقدم ضمان على العمل؟',
                        ]
                    ],
                    // Handyman messages
                    [
                        'sender' => 'handyman',
                        'messages' => [
                            'مرحبا! نعم أنا متاح. ما هي التفاصيل؟',
                            'السعر يعتمد على حجم العمل. يمكنني القدوم لمعاينة المكان.',
                            'نعم، يمكنني القدوم غداً صباحاً',
                            'بالطبع، لدي خبرة 5 سنوات في هذا المجال',
                            'أنا متاح من الساعة 8 صباحاً حتى 6 مساءً',
                            'نعم، أقدم ضمان 6 أشهر على جميع الأعمال',
                            'يمكنك الاطلاع على تقييمات عملائي السابقين',
                        ]
                    ],
                ];

                for ($i = 0; $i < $messageCount; $i++) {
                    // Alternate between client and handyman messages
                    $senderType = $i % 2 === 0 ? 'client' : 'handyman';
                    $senderId = $senderType === 'client' ? $client->user->id : $handyman->user->id;
                    
                    $templates = collect($messageTemplates)->firstWhere('sender', $senderType)['messages'];
                    $messageBody = $templates[array_rand($templates)];

                    Message::create([
                        'conversation_id' => $conversation->id,
                        'sender_id' => $senderId,
                        'body' => $messageBody,
                        'created_at' => now()->subDays(rand(1, 30))->subHours(rand(0, 23)),
                        'updated_at' => now()->subDays(rand(1, 30))->subHours(rand(0, 23)),
                    ]);

                    $messagesCreated++;
                }

                // Update conversation's updated_at to match last message
                $lastMessage = $conversation->messages()->latest()->first();
                if ($lastMessage) {
                    $conversation->update(['updated_at' => $lastMessage->created_at]);
                }
            }
        }

        $this->command->info("Created {$conversationsCreated} conversations with {$messagesCreated} messages");
    }
}

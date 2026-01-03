@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-950 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-gray-900 rounded-lg shadow-lg p-8 border border-gray-800">
            <h1 class="text-4xl font-bold text-white mb-8">Terms and Conditions</h1>
            
            <div class="prose prose-invert max-w-none text-gray-300 space-y-6">
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4">1. Platform Liability Disclaimer</h2>
                    <p>MOQAF is a marketplace platform that connects clients with handymen. The platform is not responsible for any work, services, or jobs that were not officially created as orders through our system. All work must be initiated through an official order before the platform assumes any responsibility or liability.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-white mb-4">2. Order Requirement</h2>
                    <p>All services must be requested and confirmed through the official MOQAF order system. Work performed without an official order is at the sole risk and responsibility of both the client and the handyman. The platform disclaims all responsibility for:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Services rendered without an official order</li>
                        <li>Disputes arising from unofficial arrangements</li>
                        <li>Payment issues for non-order work</li>
                        <li>Quality concerns for services not tracked in our system</li>
                        <li>Injuries or damages resulting from unauthorized work</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-white mb-4">3. User Responsibilities</h2>
                    <p>Users of MOQAF agree to:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Only conduct business through official orders</li>
                        <li>Provide accurate information in their profiles</li>
                        <li>Respect the platform's terms and policies</li>
                        <li>Report any disputes or issues promptly</li>
                        <li>Comply with all local laws and regulations</li>
                        <li>Not use the platform for illegal or unethical purposes</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-white mb-4">4. Payment and Pricing</h2>
                    <p>All pricing must be agreed upon through the official order system. Handymen may offer multiple service tiers (Basic, Medium, Premium) with varying prices, delivery times, and features. Payment disputes are only valid for official orders processed through the platform.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-white mb-4">5. Service Quality and Ratings</h2>
                    <p>Reviews and ratings are only accepted for completed orders through the MOQAF system. Clients must create an official order to rate a handyman's work. Handymen agree to maintain professional standards and complete work as described in their gigs and service tiers.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-white mb-4">6. Dispute Resolution</h2>
                    <p>MOQAF will only mediate disputes related to official orders. For any claims or disputes, both parties agree to provide evidence of the official order and communications through the platform. The platform reserves the right to suspend or terminate accounts involved in repeated disputes.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-white mb-4">7. No Personal Liability for Unauthorized Work</h2>
                    <p>The platform and its administrators are not liable for any consequences, damages, injuries, or losses resulting from:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>Work performed outside the official order system</li>
                        <li>Private arrangements between users</li>
                        <li>Handymen or clients acting without platform authorization</li>
                        <li>Accidents or injuries during non-official work</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-white mb-4">8. Compliance with Laws</h2>
                    <p>Users must comply with all applicable local, state, and federal laws. Handymen must maintain necessary licenses and insurance where required by law. The platform is not responsible for users' legal compliance.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-white mb-4">9. Account Suspension and Termination</h2>
                    <p>MOQAF reserves the right to suspend or terminate accounts that violate these terms, engage in fraudulent activity, or conduct business outside the official order system.</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-white mb-4">10. Acknowledgment</h2>
                    <p>By clicking "I Agree" during registration, you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions. You further acknowledge that:</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>You will only conduct business through official MOQAF orders</li>
                        <li>You understand the platform's liability limitations</li>
                        <li>You accept full responsibility for unauthorized work</li>
                        <li>You will resolve disputes through the platform's process</li>
                    </ul>
                </section>

                <div class="bg-yellow-900/20 border border-yellow-800 rounded-lg p-4 mt-8">
                    <p class="text-yellow-200"><strong>Important:</strong> Failure to create an official order before receiving or providing services may result in loss of platform protections, refund eligibility, and account suspension.</p>
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <a href="javascript:history.back()" class="flex-1 px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg text-center font-semibold">Back</a>
                <button onclick="window.print()" class="flex-1 px-4 py-2 bg-indigo-500 hover:bg-indigo-400 text-white rounded-lg font-semibold">Print</button>
            </div>
        </div>
    </div>
</div>
@endsection

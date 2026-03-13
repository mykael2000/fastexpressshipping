<?php
namespace Database\Seeders;

use App\Models\StaticPage;
use Illuminate\Database\Seeder;

class StaticPageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => '<h2>About Fast Express Shipping</h2><p>Fast Express Shipping was founded in 2018 with a simple mission: to connect businesses and individuals with fast, reliable, and affordable shipping solutions worldwide. Today, we operate in over 150 countries with a network of trusted carriers and last-mile delivery partners.</p><h3>Our Mission</h3><p>To deliver excellence at every step of the shipping journey, from pickup to final delivery. We believe every package, no matter how small, represents a promise to our customers.</p><h3>Our Values</h3><ul><li><strong>Reliability:</strong> We deliver on our commitments, every time.</li><li><strong>Transparency:</strong> Real-time tracking means you are always informed.</li><li><strong>Security:</strong> Your shipments are protected with industry-leading practices.</li><li><strong>Customer Focus:</strong> Our team is dedicated to your satisfaction.</li></ul>',
                'show_in_nav' => true,
                'nav_order' => 1,
                'is_published' => true,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h2>Privacy Policy</h2><p>Last updated: January 1, 2024</p><p>Fast Express Shipping ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our services.</p><h3>Information We Collect</h3><p>We collect information you provide directly to us, such as when you create an account, submit a shipment request, or contact us for support. This includes your name, email address, phone number, and shipping addresses.</p><h3>How We Use Your Information</h3><p>We use the information we collect to process your shipments, send tracking updates, communicate with you about our services, and improve our platform. We do not sell your personal information to third parties.</p><h3>Data Security</h3><p>We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p><h3>Contact Us</h3><p>If you have any questions about this Privacy Policy, please contact us at privacy@fastexpressshipping.com.</p>',
                'show_in_nav' => false,
                'nav_order' => 10,
                'is_published' => true,
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'content' => '<h2>Terms of Service</h2><p>Last updated: January 1, 2024</p><p>By using Fast Express Shipping services, you agree to these Terms of Service. Please read them carefully.</p><h3>Service Agreement</h3><p>Fast Express Shipping provides shipping brokerage and logistics coordination services. By submitting a shipment request, you agree that all information provided is accurate and that the contents of your shipment comply with applicable laws and our prohibited items policy.</p><h3>Prohibited Items</h3><p>You may not ship dangerous goods, illegal substances, weapons, counterfeit items, or any goods that are prohibited by law. A full list of prohibited and restricted items is available upon request.</p><h3>Liability</h3><p>Our liability for loss or damage to shipments is limited to the declared value of the goods, not to exceed USD $500 unless additional insurance is purchased. We are not liable for delays caused by customs, weather, or other circumstances beyond our control.</p><h3>Payment Terms</h3><p>All fees are due before shipment unless credit terms have been established. We accept cryptocurrency payments as specified on our payment page.</p>',
                'show_in_nav' => false,
                'nav_order' => 11,
                'is_published' => true,
            ],
            [
                'title' => 'Services',
                'slug' => 'services-overview',
                'content' => '<h2>Our Services</h2><p>Fast Express Shipping offers a comprehensive range of logistics solutions tailored to meet the needs of businesses and individuals worldwide.</p><h3>Standard Shipping</h3><p>Our Standard shipping service offers reliable delivery within 5-10 business days for most international destinations. Ideal for non-urgent shipments that need tracking and basic insurance coverage.</p><h3>Express Shipping</h3><p>Faster delivery with a 2-4 business day window to most destinations. Includes priority handling, enhanced tracking, and higher insurance coverage.</p><h3>Overnight Shipping</h3><p>When time is critical, our Overnight service delivers to major cities the next business day. Includes real-time GPS tracking, signature confirmation, and full insurance.</p><h3>Freight Services</h3><p>For large commercial shipments, we offer LTL and FTL freight solutions with competitive rates and dedicated account management.</p>',
                'show_in_nav' => true,
                'nav_order' => 2,
                'is_published' => true,
            ],
            [
                'title' => 'FAQ',
                'slug' => 'faq-overview',
                'content' => '<h2>Frequently Asked Questions</h2><p>Find answers to the most common questions about our shipping services.</p><h3>How do I track my shipment?</h3><p>Enter your tracking number on our homepage or go to fastexpressshipping.com/track. Tracking updates are available in real time as your shipment moves through our network.</p><h3>What payment methods do you accept?</h3><p>We accept cryptocurrency payments including Bitcoin (BTC), Ethereum (ETH), and USDT (TRC20). Crypto wallets are provided during checkout.</p><h3>What is the maximum weight for a single package?</h3><p>Individual packages can weigh up to 70 kg (154 lbs). For heavier items, please use our freight service.</p><h3>Do you ship to all countries?</h3><p>We ship to over 150 countries worldwide. Some restricted destinations may require additional documentation. Contact us for specific country requirements.</p>',
                'show_in_nav' => true,
                'nav_order' => 3,
                'is_published' => true,
            ],
        ];

        foreach ($pages as $page) {
            StaticPage::firstOrCreate(['slug' => $page['slug']], $page);
        }
    }
}

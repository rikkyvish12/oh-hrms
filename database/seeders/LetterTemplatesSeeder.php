<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LetterTemplate;

class LetterTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Order Confirmation Template (Numbered Placeholders)
        LetterTemplate::create([
            'name' => 'Order Confirmation Letter',
            'template_content' => "Hi {1},\n\n✅ Your order #{2} has been successfully placed.\n\n📦 Product: {3}\n💰 Amount: ₹{4}\n\nWe will notify you once your order is shipped.\nThank you for shopping with us!",
            'placeholders' => [1, 2, 3, 4],
            'is_active' => true,
        ]);

        // Appointment Letter Template (Numbered Placeholders)
        LetterTemplate::create([
            'name' => 'Standard Appointment Letter',
            'template_content' => "APPOINTMENT LETTER\n\nDate: {current_date}\n\nTo: {employee_name}\nEmployee ID: {employee_id}\nEmail: {employee_email}\n\nDear {employee_name},\n\nWe are pleased to offer you the position of {role_name} at {company_name}.\n\nYour appointment is effective from {joining_date}. You will be reporting to your department head on this date.\n\nDuring your tenure with us, you will be expected to perform duties and responsibilities that are consistent with your position and that contribute to the achievement of our organizational objectives.\n\nPlease sign and return the duplicate copy of this letter as confirmation of your acceptance of this appointment.\n\nWe look forward to a long and mutually beneficial association.\n\nSincerely,\n\nHuman Resources Department\n{company_name}",
            'placeholders' => [], // Uses named variables, not numbered
            'is_active' => true,
        ]);

        // Joining Letter Template (Numbered Placeholders)
        LetterTemplate::create([
            'name' => 'Standard Joining Letter',
            'template_content' => "JOINING LETTER\n\nDate: {current_date}\n\nTo: {employee_name}\nEmployee ID: {employee_id}\n\nDear {employee_name},\n\nWe welcome you to {company_name} as {role_name}.\n\nYour date of joining is confirmed as {joining_date}. Please report to the HR department at 9:00 AM on your joining date with all the required documents.\n\nYou will be working in the {department} department and will report to your designated supervisor.\n\nWe have enclosed a copy of our company policies and procedures for your reference. Please go through them carefully.\n\nWe look forward to working with you and wish you a successful career with {company_name}.\n\nWelcome aboard!\n\nSincerely,\n\nHuman Resources Department\n{company_name}",
            'placeholders' => [], // Uses named variables, not numbered
            'is_active' => true,
        ]);

        // Experience Letter Template (Numbered Placeholders)
        LetterTemplate::create([
            'name' => 'Standard Experience Letter',
            'template_content' => "EXPERIENCE LETTER\n\nDate: {current_date}\n\nTo Whom It May Concern\n\nThis is to certify that {employee_name} (Employee ID: {employee_id}) has worked with {company_name} as {role_name} in the {department} department.\n\n{employee_name} joined our organization on {joining_date} and has been employed with us until the present date.\n\nDuring their tenure with us, {employee_name} has shown dedication, professionalism, and commitment to their work. They have demonstrated excellent skills and have been a valuable member of our team.\n\nTheir conduct and performance during their employment have been satisfactory, and they have discharged their duties with diligence and integrity.\n\nWe wish {employee_name} all the best in their future endeavors.\n\nFor any further information or verification, please feel free to contact our HR department.\n\nSincerely,\n\nHuman Resources Department\n{company_name}\nEmail: hr@company.com",
            'placeholders' => [], // Uses named variables, not numbered
            'is_active' => true,
        ]);

        // General Letter Template (Numbered Placeholders)
        LetterTemplate::create([
            'name' => 'General Purpose Letter',
            'template_content' => "GENERAL LETTER\n\nDate: {current_date}\n\nTo: {employee_name}\nEmployee ID: {employee_id}\nDepartment: {department}\n\nDear {employee_name},\n\nSubject: Official Communication\n\nThis letter is regarding your employment with {company_name}.\n\nPlease find the details below:\n\nEmployee Name: {employee_name}\nEmployee ID: {employee_id}\nPosition: {role_name}\nDepartment: {department}\nJoining Date: {joining_date}\n\nShould you have any questions or require further clarification, please do not hesitate to contact the HR department.\n\nThank you for your attention to this matter.\n\nSincerely,\n\nHuman Resources Department\n{company_name}",
            'placeholders' => [], // Uses named variables, not numbered
            'is_active' => true,
        ]);
    }
}

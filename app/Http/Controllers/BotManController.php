<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BotManController extends Controller
{
    public function handle()
    {
        $botman = app('botman');
  
        $botman->hears('{message}', function($botman, $message) {
  
            if ($message == 'a') {
                $botman->reply("Please email to us at mentalite@gmail.com.");
            }else if ($message == 'b'){
                $botman->reply("Please click this link -> www.mentalit-e.com/consultations");

            }else if ($message == 'c'){
                $botman->reply("FOR CLINIC ADMINS AND EMPLOYEES <br> 
                (How I pay for Subscription?) <br> 
                1. Fill up and complete registration to Mentalit-E. <br>
                2. Choose your preferred subscription and Fill-up all the requirements to avail subscription. <br>
                3. Send your proof of payment then wait for account approval. <br><br>
                
                (How I Manage Clinic Employees?) <br>
                1. Make sure that your clinic employee/s had registered to Mentalit-E <br>
                2. Navigate to your clinic profile and select manage employees. <br>
                3. If the clinic employee recently registered, approve the employee profile to join your clinic. <br><br>
                
                (How do I manage Appointments?) <br>
                1. Click consultion in your profile <br>
                2. Manage your appoinments through the list to edit, update, or cancel an appointment. <br>
                3. There is also a calendar located inside your profile that will display all of your appointments. <br><br>
                
                FOR USERS/PATIENTS <br>
                (How do I book for an appointment?) <br>
                1. Navigate to quick booking and pick any available schedules from the clinic of your choosing. <br>
                2. After the appointment is booked and paid, send a proof of payment to the clinic to confirm the appointment. <br><br>
                
                (How do I make a journal entry?) <br>
                - You can create your own personal journal entries through Mentalit-e, just click on your profile then navigate to personal journal. <br><br>
                
                (Where can I take the EMA test?/What is an EMA test?) <br>
                - The Ecological Momentary test can help you determine your current mental state before consulting a professional, it is located at Mentalit-E's hompepage. <br>
                (Disclaimer: The test should not be used as a diagnosis, please consult a mental health professional to get a proper diagnosis) <br><br>
                
                FOR ALL USERS <br>
                (Where can I resolve issues regarding the system/ other problems?) <br>
                - Just click on your profile then navigate to the Ticket form, you can track the ticket progress through your profile.	     
                ");



            }else if ($message == 'm'){
                $botman->reply("Mentalit-E is a platform that helps connect common individuals to mental health instutions, professionals, and experts in the Philippines. Mentalit-E  
                advocates mental health awareness through the use of forums along with features such as an ecological momentary assessment test and a journal
                that can help improve and maintain your mental well-being. ");

            }else if ($message == 'w'){
                $botman->reply("If you have any inquiries or concerns, type and enter 'a'. If you want to schedule a consultation, 
                press 'b'. If you want to see the FAQs, press 'c'. If you wish to know what Mentalit-E is about, press'm'.");

         


            }else{
                $botman->reply("Please see the list of commands above to answer your questions/concerns. If you wish to 
                see the list of commands, press 'w'. Please also ensure that your letter input is in LOWERCASE.");
            }

           
            
  
        });
  
        $botman->listen();
    }
  
    /**
     * Place your BotMan logic here.
     */
    public function askName($botman)
    {
        $botman->ask('Hello! What is your Name?', function(Answer $answer) {
  
            $name = $answer->getText();
  
            $this->say('Nice to meet you '.$name);
        });
    }
}

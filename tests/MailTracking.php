<?php
/**
 * Created by PhpStorm.
 * User: josephnguyen
 * Date: 2019-10-01
 * Time: 12:45
 */

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

trait MailTracking
{
    protected $emails = [];


//    /** @before */
    public function setUp()
    {
        parent::setUp();
        Mail::getSwiftMailer()
            ->registerPlugin(new TestingMailEventListener($this));
    }

    public function seeEmailWasSent()
    {
        $this->assertNotEmpty($this->emails, "No emails have been sent.");
        return $this;
    }

    public function seeEmailsSent($count)
    {
        $emailsSent = count($this->emails);

        $this->assertCount($count, $this->emails, "Expected $count emails to have been sent, but $emailsSent were.");

        return $this;
    }

    public function addEmail(Swift_Message $message)
    {
        $this->emails[] = $message;
    }

    protected function seeEmailTo($recipient, Swift_Message $message = null)
    {
        $email = $message ?: end($this->emails);

//        dd($email->getTo());
        $this->assertArrayHasKey($recipient, $email->getTo(), "No email was sent to $recipient");
    }

    protected function seeEmailEquals($body, Swift_Message $message = null)
    {
        $this->assertEquals(
            $body, $this->getMessage($message)->getBody(),
            "No email with the provided body was sent."
        );
        return $this;
    }

    protected function seeEmailContains($excerpt, Swift_Message $message = null)
    {
        $this->assertContains(
            $excerpt, $this->getMessage($message)->getBody(),
            "No email containing the provided body was found."
        );
        return $this;
    }

    protected function getMessage(Swift_Message $message = null)
    {
        return $message ?: end($this->emails);
    }
}


class TestingMailEventListener implements Swift_Events_EventListener
{

    protected $test;

    public function __construct($test)
    {
        $this->test = $test;
    }

    public function beforeSendPerformed($event)
    {
        $message = $event->getMessage();

        $this->test->addEmail($message);

//        dd($message);
//        dd(get_class_methods($message));
//        dd($message->getTo());

    }
}
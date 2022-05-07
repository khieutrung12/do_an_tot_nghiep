<?php

namespace Tests\Unit\Mail;

use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class NotificationMailTest extends TestCase
{
    protected $mail;
    protected $data;

    public function setUp(): void
    {
        parent::setUp();
        $this->mail = new NotificationMail($this->data);
    }

    public function tearDown(): void
    {
        unset($this->mail);
        parent::tearDown();
    }

    public function testBuildSendMailMarkdown()
    {
        Mail::fake();
        Mail::send($this->mail);
        Mail::assertSent(NotificationMail::class, function ($mail) {
            $mail->build();
            $this->assertEquals($mail->subject, 'Week sales report');
            $this->assertEquals($mail->markdown, 'emails.report_email');

            return true;
        });
    }
}

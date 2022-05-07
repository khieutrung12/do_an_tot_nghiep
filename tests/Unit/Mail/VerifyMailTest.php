<?php

namespace Tests\Unit\Mail;

use App\Mail\VerifyMail;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class VerifyMailTest extends TestCase
{
    protected $mail;

    public function setUp(): void
    {
        parent::setUp();
        $this->mail = new VerifyMail();
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
        Mail::assertSent(VerifyMail::class, function ($mail) {
            $mail->build();
            $this->assertEquals($mail->subject, 'Technology world - Verify Email');
            $this->assertEquals($mail->markdown, 'emails.verify_email');

            return true;
        });
    }
}

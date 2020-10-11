<?php


namespace App\Notification;


use App\Entity\Comment;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Notification\EmailNotificationInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\Recipient;

class CommentReviewCompletedNotification extends Notification implements EmailNotificationInterface
{
    private $comment;

    public function __construct(string $subject, Comment $comment)
    {
        $this->comment = $comment;

        parent::__construct($subject);
    }

    public function asEmailMessage(Recipient $recipient, string $transport = null): ?EmailMessage
    {
        $template = $this->comment->getState() === 'ready' ? 'published' : 'rejected';
        $message = EmailMessage::fromNotification($this, $recipient);
        $message->getMessage()
            ->htmlTemplate('emails/comment_'.$template.'.html.twig')
            ->context(['comment' => $this->comment]);

        return $message;
    }
}
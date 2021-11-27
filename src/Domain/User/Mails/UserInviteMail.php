<?php

    namespace Domain\User\Mails;

    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    class UserInviteMail extends Mailable
    {
        use Queueable, SerializesModels;

        /**
         * UserInviteMail constructor.
         *
         * @param string $url
         * @param string $name
         * @param string $subject
         */
        public function __construct(
            private string $url,
            private string $name,
            string $subject,
        ) {
            $this->subject = $subject;
        }

        /**
         * Build the message.
         *
         * @return UserInviteMail
         */
        public function build(): UserInviteMail
        {
            return $this->markdown('admin::mails.invite-user', [
                    'url' => $this->url,
                    'name' => $this->name
                ]
            );
        }
    }

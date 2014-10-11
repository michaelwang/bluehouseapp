<?php


namespace Blackhouseapp\Bundle\BluehouseappBundle\Service;


class MailService {
    protected $mailer;
    protected $template;

    public function __construct($mailer,$template)
    {
        $this->mailer = $mailer;
        $this->template = $template;
    }

} 
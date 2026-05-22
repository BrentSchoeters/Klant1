<?php

namespace App\Livewire\Forms;

use App\Models\MailTemplate;
use Livewire\Attributes\Validate;
use Livewire\Form;

class MailsBeherenForm extends Form
{
    public $id = null;
    #[Validate('required', as: 'subject item')]
    public $subject = null;
    public $template = null;


    public function read($mailtemplate)
    {
        $this->id = $mailtemplate->id;
        $this->subject = $mailtemplate->subject;
        $this->template = $mailtemplate->template;
    }

    public function delete(MailTemplate $item)
    {
        $item->delete();
    }
    public function create()
    {
        $this->validate([
            'template' => 'required|unique:mail_templates,template',
            'subject' => 'required|unique:mail_templates,subject'
        ]);
        MailTemplate::create([
            'template' => $this->template,
            'subject' => $this->subject
        ]);
    }
    public function update(MailTemplate $item)
    {
        $this->validate([
            'template' => 'required|unique:mail_templates,template',
            'subject' => 'required|unique:mail_templates,subject'
        ]);

        $item->update([
            'template' => $this->template,
            'subject' => $this->subject
        ]);
    }
}

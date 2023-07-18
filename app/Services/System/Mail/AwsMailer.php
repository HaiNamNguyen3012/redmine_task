<?php
namespace App\Services\System\Mail;

use App\Helpers\ResponseHelpers;
use App\Jobs\RunAwsCommand;
use App\Services\System\Mail\MailerInterface;
use Illuminate\Contracts\Queue\ShouldQueue;

class AwsMailer implements MailerInterface
{
    /**
     * Begin the process of mailing a mailable class instance.
     *
     * @param  mixed  $users
     * @return \Illuminate\Mail\PendingMail
     */
    public function to($users){

    }

    /**
     * Begin the process of mailing a mailable class instance.
     *
     * @param  mixed  $users
     * @return \Illuminate\Mail\PendingMail
     */
    public function bcc($users){

    }

    /**
     * Send a new message with only a raw text part.
     *
     * @param  string  $text
     * @param  mixed  $callback
     * @return void
     */
    public function raw($text, $callback){

    }

    /**
     * Send a new message using a view.
     *
     * @param  \Illuminate\Contracts\Mail\Mailable|string|array  $view
     * @param  array  $data
     * @param  \Closure|string|null  $callback
     * @return void
     */
    public function send($view, array $data = [], $callback = null){
        try {
            $view->build();
            $toData = collect($view->to)->map(function($item) {return $item['address'];})->toArray();
            $ccData = collect($view->cc)->map(function($item) {return $item['address'];})->toArray();
            $bccData = collect($view->bcc)->map(function($item) {return $item['address'];})->toArray();

            $to = [
                "ToAddresses" => $toData,
                "CcAddresses" => $ccData,
                "BccAddresses" => $bccData,
            ];

            $from = @$view->from[0] ?? config('mail.from.address');

            $html = [
                "Subject" => [
                    "Data" => @$view->subject ?? config('mail.default_subject'),
                    "Charset" => "UTF-8"
                ],
                "Body" => [
                    // "Text" => [
                    //     "Data" => "Test email sent using the AWS CLI",
                    //     "Charset" => "UTF-8"
                    // ],
                    "Html" => [
                        "Data" => $view->render(),
                        "Charset" => "UTF-8"
                    ],
                ],
            ];

            $cmd = "aws ses send-email --from ". $from . " --destination '" . @json_encode($to) . "' --message '" . @json_encode($html)."'";
            @file_put_contents("cmd.txt", $cmd);
            if ($view instanceof ShouldQueue) {
                RunAwsCommand::dispatch($cmd);
            }else{
                $exec = shell_exec($cmd);
                $result = json_decode($exec);
                if (!@$result->MessageId) return false;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }

    }

    /**
     * Get the array of failed recipients.
     *
     * @return array
     */
    public function failures(){

    }
}

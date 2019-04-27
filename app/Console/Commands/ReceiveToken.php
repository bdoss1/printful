<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

class ReceiveToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'receive:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Receive Auth2 Access Token';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $_headers = [ "Accept:application/json" ];
        $domain = 'https://api-billing-webservice.secu-ring.de/v1/invoices/debit/list?page=1&limit=25';
        $url = 'https://api-billing-webservice.secu-ring.de/oauth';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $_headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'client_id'     => env('OAUTH_CLIENT_ID'),
            'redirect_uri'  => $domain,
            'client_secret' => env('OAUTH_CLIENT_SECRET'),
            'grant_type'    => env('OAUTH_GRANT_TYPE'),
            'username'      => env('OAUTH_USERNAME'),
            'password'      => env('OAUTH_PASSWORD'),
        ));

        $response = curl_exec($ch);
        if (curl_error($ch)) {
            $error_msg = curl_error($ch);
        }
        if ($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
            dump("cURL error ({$errno}):\n {$error_message}");
            die;
        }
        /*
         *  After receiving headers first store the authentication key
         *  We can store the access_token in file as well which is also secure
         *  Due to the fact that Laravel folders rather than Public are stored outside public_html nobody will have access to this token.txt file
         *  Get requested data through API
         */
        $data = json_decode($response);

        if (isset($data->access_token)) {
            $file = Base_path('storage/token.txt');

            File::put($file, $data->token_type . ' ' . $data->access_token);
            $this->info('New access token received!');
            if (!File::isWritable($file)) {
                $this->error('File '.$file.' is not writable, or missing.');
                return;
            }
        } else {
            $this->error('Impossible to get Access Token!');
        }
    }
}

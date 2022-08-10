<?php

namespace App\Controllers;

class Contact extends BaseController
{

    use \Myth\Auth\AuthTrait;

    function __construct() 
    {
        $this->config = new \stdClass();
        $this->uri = service('uri');
        $this->auth = service('authentication');
        helper(['form','form_recaptcha']);


    }
    public function index()
    {

        $auth = service('authentication');
        

        if ($data['loggedin'] = $auth->check()) {
            $data['userName'] = $this->auth->user()->username;
            $data['userEmail'] = $this->auth->user()->email;
        }

        $this->config->pageTitle = 'Contact';
        $data['message'] = '';

        

        if ($this->request->getMethod() == "get") {
            

        } else {
            //$contactModel = model('App\Models\ContactModel');
            $data = array_merge($data,$this->request->getPost());
            //d($this);

            if (! $this->validate([
                'reCaptcha3' => 'required|reCaptcha3[contactForm,0.9]',
                ])) {
                    return redirect()->back()->withInput()->with('error',$this->validator->getErrors());
            } else {
                //d('Success');
            }

            //dd($data);
            // post data
            /** 
            * loggedin  =>  boolean
            * userNmae  =>  string
            * userEmail =>  string
            * message   =>  string  
            * name      =>  string
            * email     =>  string
            * subject   =>  int
            */

            $requiredFields = array('name','email','subject','message');

            foreach ($requiredFields as $required) {
                if (!$data[$required]) {
                    return redirect()->back()->withInput()->with('error',ucfirst($required) . ' Required!');
                }
            }
            //dd($data);

            //return is_null($data['subject']) ? redirect()->back()->withInput()->with('error','Subject Required!'):'';

            if ($data['subject']) {
                //print_r($data['subject']); die;
                $data['ip'] = $this->request->getIPAddress();
                $osMessage = $data['message'];

                // switching to osTicket for contact form. 
                /*if ($contactModel->save($data)) {
                    $data['message'] = 'Comment received.';
                }*/
                
                //print_r($data);
                $topic = json_decode(getTopics('specific',$data['subject']));
                //print_r($topic);die;
                $osConfig = [
                    'url'   =>  'https://support.theparkchat.com/api/http.php/tickets.json', // /api/http.php/tickets.json url
                    'key'   =>  '5E650E6B901E9D45A847266E35E23516', // osTicket API Key
                ];

                $osTicketData = array(
                    'email'     =>      $data['email'],  // required Email address of the submitter
                    'name'      =>      $data['name'],  // required Name of the submitter
                    'subject'   =>      $topic->data->topic->topic,  // required Subject of the ticket
                    'message'   =>      $osMessage,  // required Initial message for the ticket thread. The message content can be specified using RFC 2397 in the JSON format. The content of the message element should be the message body. Encoding is assumed based on the encoding attributed set in the xml processing instruction.
                    'alert'     =>      TRUE, //If unset, disable autoresponses. Default is true
                    'ip'        =>      $_SERVER['REMOTE_ADDR'], // IP address of the submitter
                    'priority'  =>      1, //Priority id for the new ticket to assume
                    'source'    =>      'API', //Source of the ticket, default is API
                    'topicId'   =>      $topic->data->topic->id, //Help topic id associated with the ticket
                    'attachments' => array()
                );

                //print_r($osTicketData);die;
                // print_r(json_encode($osTicketData));

                //function_exists('curl_version') or die('CURL support required');
                //function_exists('json_encode') or die('JSON support required');

                set_time_limit(30); // Set time limit for cURL function

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $osConfig['url']);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($osTicketData));
                curl_setopt($ch, CURLOPT_USERAGENT, 'osTicket API Client v1.8');
                curl_setopt($ch, CURLOPT_HEADER, TRUE);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:', 'X-API-Key: '.$osConfig['key']));
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                $result=curl_exec($ch);
                $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $curl_error = curl_error($ch);
                curl_close($ch);
                //print_r($result);
                //print_r($curl_error);
                if ($code != 201) {
            
                    //$data['error'] = 'Unable to create ticket: ' . $result;
                }

                //print_r($code);
                $ticket_id = (int) $result; // New ticket ID
                if(isset($ticket_id) && $ticket_id!='')
                {
                    //echo "Ticket Created Sucessfully";
                }else{
                    //echo "Ticket not created. Try again later.";
                    
                }
                //$data['message'] .= ' Ticket #' . $ticket_id;            
            } else {
                return redirect()->back()->withInput()->with('error','Subject Required!');
            }
        }

        $data['config'] = $this->config;

        return view('pages/contact',$data);
    }
}

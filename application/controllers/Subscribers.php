<?php
/**
 * Created by PhpStorm.
 * User: volgopoint.com
 * Date: 2/25/2019
 * Time: 2:29 PM
 */

class Subscribers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('Subscribers_Model');
    }

    public function create()
    {
        $data = array(
            'validation_errors' => '',
            'success_msg' => ''
        );
        $input_data = filter_input_array(INPUT_POST);
        if (!empty($input_data)) {

            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[newsletter_subscribers.email]');
            $this->form_validation->set_rules('name', 'Name', 'required');


            if ($this->form_validation->run() !== false) {

                $sendToSubscriberEmails = $this->input->post('email');
                $name = $this->input->post('name');
                $is_created = $this->Subscribers_Model->create_subscriber(
                    $sendToSubscriberEmails, $name
                );

                if ($is_created) {
                    $data = array(
                        'validation_errors' => validation_errors(),
                        'success_msg' => '<strong>Congratulation!</strong><br />' . $sendToSubscriberEmails . ' subscriber has been created.',
                        'email' => $sendToSubscriberEmails,
                        'name' => $name
                    );
                    try {
                        $mail = new \PHPMailer\PHPMailer\PHPMailer();

                        // SMTP configuration
                        $mail->isSMTP();
                        $mail->Host = PHPMAILER_SENDER_HOST;
                        $mail->SMTPAuth = PHPMAILER_SENDER_SMTPAUTH;
                        $mail->Username = PHPMAILER_SENDER_USERNAME;
                        $mail->Password = PHPMAILER_SENDER_PASSWORD;
                        $mail->SMTPSecure = PHPMAILER_SENDER_SMTP_SECURE;
                        $mail->Port = PHPMAILER_SENDER_PORT;

                        $mail->setFrom(NEWSLETTER_FROM_EMAIL);

                        // Email subject
                        if (isset($mail->Subject)) {
                            $mail->Subject = 'Verify Your Email |' . SITE_NAME;
                        }
                        // Set email format to HTML
                        $mail->isHTML(true);
                        $mail->addAddress($sendToSubscriberEmails, $name);
                        $html = 'email:' . $sendToSubscriberEmails . '|||status:' . 'email_pending_verifications';
                        $mailBody = base_url('subscribers/verify_email/') . volgo_encrypt_message($html);

                        if (isset($mailBody)) {
                            $mail->Body = $mailBody;
                        }

                        $mail->send();

                    }catch (Exception $e) {
                        log_message('error', $mail->ErrorInfo);
                    }

                }else {

                    $this->session->set_flashdata('validation_errors', 'subscribed error');
                    redirect(base_url());
                }

                if(!$mail->send()){
                    // echo 'Message could not be sent.';
                    // echo 'Mailer Error: ' . $mail->ErrorInfo;
                }else{
                    // echo 'Message has been sent';
                }
                    $this->session->set_flashdata('success_msg', 'subscribed successfully');
                    redirect(base_url());
                } else {
                  $this->session->set_flashdata('validation_errors', 'already subscribed');
                  redirect(base_url());
                }

            } else {
                $this->session->set_flashdata('validation_errors', 'subscription Error.');
                redirect(base_url());
            }

        }

        public function verify_email($token)
        {

            $result = volgo_decrypt_message($token);
            $data = explode("|||", $result, 2);
            $user_email = explode(':', $data[0], 2);
            $user_status = explode(':', $data[1], 2);
            $user_email = $user_email[1];
            $user_status = $user_status[1];

            if(!empty($user_email)) {

                $mail = new \PHPMailer\PHPMailer\PHPMailer();

                // SMTP configuration
                $mail->isSMTP();
                $mail->Host = PHPMAILER_SENDER_HOST;
                $mail->SMTPAuth = true;
                $mail->Username = PHPMAILER_SENDER_USERNAME;
                $mail->Password = PHPMAILER_SENDER_PASSWORD;
                $mail->SMTPSecure = 'ssl';
                $mail->Port = PHPMAILER_SENDER_PORT;

                $mail->setFrom(NEWSLETTER_FROM_EMAIL);


//          Email subject
                $mail->Subject = 'Congratulations!';
                // Set email format to HTML
                $mail->isHTML(true);
                $mail->addAddress($user_email);
                $mail->Body = 'Thank you! You are subscribed successfully';


                if (!$mail->send()) {
                    // echo 'Message could not be sent.';
                    // echo 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                    // echo 'Message has been sent';
                }

                $this->Subscribers_Model->verify_subscriber($user_email);

                $message = "<h2>Success! </h2>";
                $message .= '<p>subscriber verified successfully.</p>';

                $this->session->set_flashdata('subscriber_success', $message);
                redirect(base_url());
            }else{
                $message = "<h2>Sorry! </h2>";
                $message .= '<p>Unable to verify subscriber.</p>';
                $this->session->set_flashdata('subscriber_error', $message);
                redirect(base_url());
            }

        }
}
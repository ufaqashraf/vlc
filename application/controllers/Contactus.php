<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contactus extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('Contactus_Model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->load->view('frontend/contact_us/contactus');
    }

    public function create()
    {
        $data = array(
            'validation_errors' => '',
            'success_msg' => ''
        );

        $input_data = filter_input_array(INPUT_POST);

        if (!empty($input_data)) {

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|min_length[1]|max_length[255]|is_unique[contact.email]');
            $this->form_validation->set_rules('subject', 'Subject', 'required');
            $this->form_validation->set_rules('comments', 'Comments', 'required');

            if ($this->form_validation->run() !== false) {

                $name = $this->input->post('name');
                $subject = $this->input->post('subject');
                $email = $this->input->post('email');
                $comments = $this->input->post('comments');

                $is_created = $this->Contactus_Model->user_contact(
                    $name,
                    $subject,
                    $email,
                    $comments
                );

                if ($is_created) {
                    $data = array(
                        'validation_errors' => validation_errors(),
                        'name' => $name,
                        'subject' => $subject,
                        'email' => $email,
                        'comments ' => $comments
                    );

                    // @todo: contact us message to admin

                    $mail = new \PHPMailer\PHPMailer\PHPMailer();
                    // Passing `true` enables exceptions
                    try {
                        $mail->isSMTP();
                        $mail->Host = PHPMAILER_SENDER_HOST;
                        $mail->SMTPAuth = PHPMAILER_SENDER_SMTPAUTH;
                        $mail->Username = PHPMAILER_SENDER_USERNAME;
                        $mail->Password = PHPMAILER_SENDER_PASSWORD;
                        $mail->SMTPSecure = PHPMAILER_SENDER_SMTP_SECURE;
                        $mail->Port = PHPMAILER_SENDER_PORT;

                        $mail->setFrom(NEWSLETTER_FROM_EMAIL);
                        // Email subject
                        $mail->Subject = 'New user contact us |' . SITE_NAME;
                        // Set email format to HTML
                        $mail->isHTML(true);
                        $mail->addAddress(NEWSLETTER_FROM_EMAIL);
                        $mail->Body = 'new user submit a query via contact form';
                        $mail->send();
                    } catch (Exception $e) {
                        log_message('error', $mail->ErrorInfo);
                    }

                    // @todo: contact us message to user

                    $mail = new \PHPMailer\PHPMailer\PHPMailer();
                    // Passing `true` enables exceptions
                    try {
                        $mail->isSMTP();
                        $mail->Host = PHPMAILER_SENDER_HOST;
                        $mail->SMTPAuth = PHPMAILER_SENDER_SMTPAUTH;
                        $mail->Username = PHPMAILER_SENDER_USERNAME;
                        $mail->Password = PHPMAILER_SENDER_PASSWORD;
                        $mail->SMTPSecure = PHPMAILER_SENDER_SMTP_SECURE;
                        $mail->Port = PHPMAILER_SENDER_PORT;

                        $mail->setFrom(NEWSLETTER_FROM_EMAIL);
                        // Email subject
                        $mail->Subject = 'Welcome |' . SITE_NAME;
                        // Set email format to HTML
                        $mail->isHTML(true);
                        $mail->addAddress($data['email'], $data['name']);
                        $mail->Body = 'Your comment has been sent successfully';
                        $mail->send();
                    } catch (Exception $e) {
                        log_message('error', $mail->ErrorInfo);
                    }

                    $this->session->set_flashdata('success_msg', '<strong>Thank You!</strong><br />' . 'message submitted successfully.');
                    $this->load->view('frontend/contact_us/contactus', $data);
                    redirect(base_url() . 'contact-us');
                } else {
                    $this->session->set_flashdata('validation_errors', 'contact us error');
                    $this->load->view('frontend/contact_us/contactus', $data);
                    redirect(base_url(). 'contact-us');
                }
            } else {
                $this->session->set_flashdata('validation_errors', 'user already exist try new one');
                $this->load->view('frontend/contact_us/contactus', $data);
                redirect(base_url(). 'contact-us');
            }

        } else {
            $this->session->set_flashdata('validation_errors', '');
            $this->load->view('frontend/contact_us/contactus', $data);
            redirect(base_url(). 'contact-us');
        }

    }

}

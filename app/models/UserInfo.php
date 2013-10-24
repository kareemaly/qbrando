<?php 

class UserInfo extends Kareem3d\Membership\UserInfo {

    protected $rules = array(
        'first_name'     => 'required',
        'contact_number' => 'required',
        'contact_email'  => 'email'
    );

    protected $customMessages = array(
        'first_name.required'     => 'Please enter your name.',
        'contact_number.required' => 'Please enter a number to contact you.',
        'contact_email.email'     => 'Please enter a valid email address.'
    );

}
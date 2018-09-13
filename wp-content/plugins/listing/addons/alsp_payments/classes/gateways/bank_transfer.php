<?php

class alsp_bank_transfer extends alsp_payment_gateway
{
	public function __construct()
	{
        parent::__construct();
        
        $this->logIpn = FALSE;
	}

    public function name() {
    	return __('Bank transfer', 'ALSP');
    }

    public function description() {
    	return __('Print invoice and transfer the payment (bank transfer information included)', 'ALSP');
    }
    
    public function buy_button()
    {
    	return '<img src="' . ALSP_PAYMENTS_RESOURCES_URL . 'images/bank.png" />';
    }
    
    public function submitPayment($invoice) {
    	alsp_addMessage(__('You chose bank transfer payment gateway, now print invoice and transfer the payment', 'ALSP'));
    }
}

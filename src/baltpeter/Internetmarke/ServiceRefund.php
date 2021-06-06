<?php

namespace baltpeter\Internetmarke;

class ServiceRefund extends \SoapClient {
    protected $partner_information;
	
    /**
     * Service constructor.
     *
     * @param $partner_information PartnerInformation
     * @param array $options A array of config values for `SoapClient` (see PHP docs)
     * @param string $wsdl 
     */
    public function __construct($partner_information, $options = array(), $wsdl = null) {
        $this->partner_information = $partner_information;
        $options = array_merge(array('features' => SOAP_SINGLE_ELEMENT_ARRAYS), $options);
        if($wsdl === null) {
            $wsdl = 'https://internetmarke.deutschepost.de/OneClickForRefund?wsdl';
        }
        parent::__construct($wsdl, $options);
        $this->__setSoapHeaders($this->partner_information->soapHeaderArray());
    }



    /**
     * Used to authenticate a user on the system. Returns a token and some information about the user
     *
     * @param $username string The user's email address
     * @param $password string The user's (plaintext) password
     * @return User An object holding: - a token used as authentication for other methods, - the user's wallet balance,
     *      - whether the user accepted the T&C, - an (optional) information text
     */
    public function authenticateUser($username, $password) {
        $result = $this->__soapCall('authenticateUser', array('AuthenticateUserRequest' => array('username' => $username, 'password' => $password)));
        return User::fromStdObject($result);
    }



    /**
     * Fetch a retoure id
     *
     * @return string. A unifique id for identification of a retoure request
     */
    public function createRetoureId() {
		$result = $this->__soapCall('createRetoureId', array('CreateRetoureIdRequest' => array()));
		return $result->shopRetoureId;
    }

	
	
    /**
     * sets relating vouchers as unusable (if not used yet) and refund it to Portokasse
     * 
     * @param $user_token string. A token to authenticate the user (from `authenticateUser`)
     * @param $shop_retoure_id string. A unifique id for identification of a retoure request (from 'createRetoureId')
     * @param $shop_order_id. A shopping cart number to be refunded (from 'Service.createShopOrderId')
     * @param $voucher_set array (optional in Request):
	 *        !! All vouchers from shopping cart will be refunded if a voucher set not present !!
	 *        For creating a set use Voucher-IDs created from e.g. 'Service.CheckoutShoppingCartPDF'
     *        Format of each shoppingCart.voucherSet.voucherNo must be:
     *        1.trim no. / 2.take Position 11-19 / 3.convert HEX => INT
     * 
     * @return (int): refund transaction ID
	 *         
     */
	public function retoureVouchers($user_token, $shop_retoure_id, $shop_order_id, $voucher_set=NULL) {
		
		// Request without using voucherSet: refund total order = all vouchers of this order id
		if ( !is_array($voucher_set) ) {
			$retoure_vouchers_array = 
				array('RetoureVouchersRequest' =>
					array(
						'userToken' 		=> $user_token,
						'shopRetoureId' 	=> $shop_retoure_id,
						'shoppingCart' 	=> 
							array('shopOrderId'	=> $shop_order_id)
					)
				);
		}
		// Request using voucherSet: refund only vouchers included in this set 
		else {
			$array_voucher_no = array();
			foreach ($voucher_set AS $voucher_no)
				$array_voucher_no[] = (int)$voucher_no;
			
			$retoure_vouchers_array = 
				array('RetoureVouchersRequest' =>
					array(
						'userToken' 		=> $user_token,
						'shopRetoureId' 	=> $shop_retoure_id,
						'shoppingCart' 	=> 
						array(
							'shopOrderId'	=> $shop_order_id,
							'voucherSet'	=> array('voucherNo' => $array_voucher_no)
						)
					)
				);
		}
		
		$result = $this->__soapCall('retoureVouchers', $retoure_vouchers_array);
        return $result->retoureTransactionId;
	}
	
	
	
    /**
     * retrieve status of a retoure request from RetoureVouchers()
     * 
     * @param $user_token string. A token to authenticate the user (from `authenticateUser`)
     * @param $start_date string. ddMMyyyy-HHmmss 					[optional]
     * @param $end_date string. ddMMyyyy-HHmmss 					[optional]
     * @param $retoure_transaction_id int. (from 'RetoureVouchers')	[optional]
     * @param $shop_retoure_id string. (from 'createRetoureId')
     *
     * @return array. List of retoure states
     */
	public function retrieveRetoureState($user_token, $start_date="", $end_date="", $retoure_transaction_id="", $shop_retoure_id) {
		// DATE RANGE [optional]
		$date_array = array();
		if (trim($start_date) != "" && trim($end_date) != "") {
			$start_date = date( "dmY-His", strtotime(trim($start_date)) );
			$end_date = date( "dmY-His", strtotime(trim($end_date)) );
			$date_array = array(
							'startDate' => $start_date,
							'endDate' 	=> $end_date
						  );
		}
		
		// RETOURE-ID [optional]
		$transaction_id_array = array();
		if (trim($retoure_transaction_id) != "")
			$transaction_id_array = array('retoureTransactionId' 	=> $retoure_transaction_id);
		
		// Merge optional together with obligatoric parms
		$soap_array = array_merge($date_array, $transaction_id_array, 
						array('userToken' 		=> $user_token,
							  'shopRetoureId' 	=> $shop_retoure_id)
		);

		// SOAP-CALL
        $result = $this->__soapCall('retrieveRetoureState', 
								array('RetrieveRetoureStateRequest' => 	$soap_array)
						 );
		
		// RETURN
		$array_result = array();
        foreach($result as $item) {
            $array_result[] = RetoureState::fromStdObject($item);
        }
        return $result;

	}
	
}

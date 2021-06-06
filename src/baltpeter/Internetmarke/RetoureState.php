<?php

namespace baltpeter\Internetmarke;

use function DeepCopy\deep_copy;

class RetoureState extends ApiResult {
    /**
     * @var int Interne 1C4R Transaktionssnummer, unter der die Rückerstattung verbucht wurde
     */
    protected $retoureTransactionId;
    /**
     * @var string Vom Shop vergebene Id für die Retoure.
     */
    protected $shopRetoureId;
    /**
     * @var int Anzahl der Frankierungen, die mit dieser Retouretransaktion bearbeitet werden
     */
    protected $totalCount;
    /**
     * @var int  Anzahl der noch nicht bearbeiteten Frankierungen. Rückmeldung ist hier noch nicht eingetroffen
     */
    protected $countStillOpen;
    /**
     * @var int Gesamtwert der bestätigten Retouren (in EuroCent !)
     */
    protected $retourePrice;
    /**
     * @var string Zeitpunkt, zu dem die Retoure eingestellt wurde 
     */
    protected $creationDate;
    /**
     * @var string Seriennummer der Safebox (FrankierAccountId)
     */
    protected $serialnumber;
    /**
     * @var array FrankierIds der erfolgreich rückerstatteten Frankierungen. 
	 * Dieses Element wird auch gesendet, falls die Liste der .voucherIds leer ist.
     */
	protected $refundedVouchers;
    /**
     * @var array FrankierIds der NIChT erfolgreich rückerstatteten Frankierungen. 
	 * Dieses Element wird auch gesendet, falls die Liste der .voucherIds leer ist.
     */
	protected $notRefundedVouchers;

    /**
     * PageFormat constructor.
     *
     * @param int $retoureTransactionId
     * @param string $shopRetoureId
     * @param int $totalCount
     * @param int $countStillOpen
     * @param int $retourePrice
     * @param string $creationDate
     * @param string $serialnumber
     * @param array $refundedVouchers
     * @param array $notRefundedVouchers
     */
    public function __construct($retoureTransactionId, $shopRetoureId, $totalCount, $countStillOpen, $retourePrice, $creationDate, $serialnumber, array $refundedVouchers = NULL, array $notRefundedVouchers = NULL) {
        $this->setRetoureTransactionId($retoureTransactionId);
        $this->setShopRetoureId($shopRetoureId);
        $this->setTotalCount($totalCount);
        $this->setCountStillOpen($countStillOpen);
        $this->setRetourePrice($retourePrice);
        $this->setCreationDate($creationDate);
        $this->setSerialnumber($serialnumber);
        $this->setRefundedVouchers($refundedVouchers);
        $this->setNotRefundedVouchers($notRefundedVouchers);
    }

    /**
     * @return int
     */
    public function getRetoureTransactionId() {
        return $this->retoureTransactionId;
    }

    /**
     * @param int $retoureTransactionId
     */
    public function setRetoureTransactionId($retoureTransactionId) {
        $this->retoureTransactionId = $retoureTransactionId;
    }

    /**
     * @return string
     */
    public function getShopRetoureId() {
        return $this->shopRetoureId;
    }

    /**
     * @param string $shopRetoureId
     */
    public function setShopRetoureId($shopRetoureId) {
        $this->shopRetoureId = $shopRetoureId;
    }

    /**
     * @return int
     */
    public function getTotalCount() {
        return $this->totalCount;
    }

    /**
     * @param int $totalCount
     */
    public function setTotalCount($totalCount) {
        $this->totalCount = $totalCount;
    }

    /**
     * @return int
     */
    public function getCountStillOpen() {
        return $this->countStillOpen;
    }

    /**
     * @param int $countStillOpen
     */
    public function setCountStillOpen($countStillOpen) {
        $this->countStillOpen = $countStillOpen;
    }

    /**
     * @return int
     */
    public function getRetourePrice() {
        return $this->retourePrice;
    }

    /**
     * @param int $retourePrice
     */
    public function setRetourePrice($retourePrice) {
        $this->retourePrice = $retourePrice;
    }

    /**
     * @return string
     */
    public function getCreationDate() {
        return $this->creationDate;
    }

    /**
     * @param string $creationDate
     */
    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

    /**
     * @return string
     */
    public function getSerialnumber() {
        return $this->serialnumber;
    }

    /**
     * @param string $pageType
     */
    public function setSerialnumber($serialnumber) {
        $this->serialnumber = $serialnumber;
    }

    /**
     * @return array
     */
    public function getRefundedVouchers() {
        return $this->refundedVouchers;
    }

    /**
     * @param array of strings $refundedVouchers
     */
    public function setRefundedVouchers($refundedVouchers) {
        $this->refundedVouchers = $refundedVouchers;
    }
	
    /**
     * @return array
     */
    public function getNotRefundedVouchers() {
        return $this->notRefundedVouchers;
    }

    /**
     * @param array of strings $notRefundedVouchers
     */
    public function setNotRefundedVouchers($notRefundedVouchers) {
        $this->notRefundedVouchers = $notRefundedVouchers;
    }
	
}

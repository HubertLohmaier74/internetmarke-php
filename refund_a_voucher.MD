# REFUND A SINGLE VOUCHER OR A WHOLE SET OF VOUCHERS
(Eine einzelne Internetmarke stornieren, oder ein komplettes Markenset)

## 2 Files added:
- RetoureState.php
- ServiceRefund.php
Die beiden Dateien müssen in das gleiche Zielverzeichnis zu den anderen Quellcodedateien dieses Projekts kopiert werden.


Die Datei SERVICEREFUND.PHP wird gleichermaßen benutzt wie bei SERVICE.PHP, wenn sie den Service verbinden.
Also anstatt z.B.
      - $connect['service'] = new \baltpeter\Internetmarke\Service($partner_info);
geben Sie an:
      - $connect['service'] = new \baltpeter\Internetmarke\ServiceRefund($partner_info);

# WICHTIG:
Bevor eine Marke erstattet werden kann, müssen Sie sich bei 1C4R (one click for refund) freischalten lassen, so wie Sie sich vorher auch bei 1C4A_V3 haben freischalten lassen.

 <div class="col-md-6">
     <h3> <i class="fa fa-info-circle" aria-hidden="true"></i> How to submit bank challan online ?</h3>
     <p>
     <ol>
         <li>Print PSRA Deposit Slip / Bank Challan</li>
         <li>Deposit Fee as per due dates</li>
         <li>Take computerized bank challan having STAN No. from the bank</li>
         <li>Submit <strong>Bank STAN</strong> number and Transaction date</li>
         <li>Click on Submit bank challan</li>
         <li>View Registration application status on school dashboard</li>
         </ul>
     </ol>
     </p>
 </div>

 <div class="col-md-6">
     <div style="direction: rtl; font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif; line-height: 30px;">
         <h3> <i class="fa fa-info-circle" aria-hidden="true"></i> بینک چالان آن لائن کیسے جمع کریں؟</h3>
         <p>
         <ol>
             <li>PSRA ڈپازٹ سلپ/بینک چالان پرنٹ کریں۔</li>
             <li>مقررہ تاریخوں کے مطابق فیس جمع کروائیں۔</li>
             <li>بینک سے اسٹین نمبر والا کمپیوٹرائزڈ بینک چالان لیں۔</li>
             <li>بینک STAN نمبر اور لین دین کی تاریخ جمع کروائیں۔</li>
             <li>بینک چالان جمع کروائیں پر کلک کریں۔</li>
             <li>اسکول کے ڈیش بورڈ پر رجسٹریشن کی درخواست کی حیثیت دیکھیں</li>
             </ul>
         </ol>
         </p>
     </div>
 </div>

 <!-- Modal -->
 <script>
     function renewal_fee_sturucture() {
         $.ajax({
             type: "POST",
             url: "<?php echo site_url("form/renewal_fee_sturucture"); ?>",
             data: {
                 school_type_id: '<?php echo $school->school_type_id; ?>',
                 reg_type_id: '<?php echo $school->reg_type_id; ?>'
             }
         }).done(function(data) {

             $('#renewal_sturucture_body').html(data);
         });

         $('#renewal_sturucture_model').modal('toggle');
     }
 </script>
 <div class="modal fade" id="renewal_sturucture_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
     <div class="modal-dialog" role="document" style="width: 70%;">
         <div class="modal-content" id="renewal_sturucture_body">

             ...

         </div>
     </div>
 </div>
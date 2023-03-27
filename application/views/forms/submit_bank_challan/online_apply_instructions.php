<div class="col-md-12">
    <div class="col-md-6" style="font-size: 15px;">
        <h4> <i class="fa fa-info-circle" aria-hidden="true"></i> How to submit application online ?</h4>
        <p>
        <ol>
            <li>Print PSRA computer generated deposit bank challan</li>
            <li>Deposit the system-generated Bank Slip at any Bank of Khyber Branch in the province.</li>
            <li>Enter the <strong>STAN</strong> and <strong>Date</strong> on the receipt provided by Khyber Bank</li>
            <li>Click on <strong>"Submit bank challan"</strong></li>
            <li>Finally, Click on <strong>Submit Application Online</strong>.
            </li>
        </ol>

        </ul>
        </ol>
        </p>
    </div>

    <div class="col-md-6" style="font-size: 11px;">
        <div style="direction: rtl; font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif; line-height: 30px;">
            <h5> <i class="fa fa-info-circle" aria-hidden="true"></i>آن لائن درخواست کیسے جمع کی جائے؟</h5>
            <p>
            <ol>
                <li>پی ایس آر اے کمپیوٹر سے تیار کردہ ڈپازٹ بینک چالان پرنٹ کریں۔</li>
                <li>سسٹم سے تیار کردہ بینک سلپ صوبے کے کسی بھی بینک آف خیبر برانچ میں جمع کرائیں۔</li>
                <li>خیبر بینک کی طرف سے فراہم کردہ رسید پر اسٹین اور تاریخ درج کریں۔</li>
                <li>بینک چالان جمع کروائیں" پر کلک کریں۔</li>
                <li>آخر میں آن لائن درخواست جمع کروائیں پر کلک کریں۔

                </li>
                </ul>
            </ol>
            </p>
        </div>
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
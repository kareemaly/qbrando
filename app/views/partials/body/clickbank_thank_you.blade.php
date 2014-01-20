<div class="main-title">
    <span class="glyphicon glyphicon-info-sign"></span>
    Thank you for purchasing {{ $part->cbItem->product->title }} !
</div>

<div class="box">

    <p class="padding-p">

        Please be aware that your credit card or bank statement will show a charge by ClickBank or CLICKBANK*COM.
        <br />
        We will be delivering your order within the next 24 hours.
        Please feel free to contact us on mobile {{ $contactUs->getMobileNumber() }}

    </p>

    <p class="padding-p" style="font-size:12px; color:#999;">
        ClickBank is the retailer of products on this site.
        CLICKBANK® is a registered trademark of Click Sales,
        Inc., a Delaware corporation located at 917 S. Lusk Street,
        Suite 200, Boise Idaho, 83706, USA and used by permission.
        ClickBank's role as retailer does not constitute an endorsement,
        approval or review of these products or any claim, statement or
        opinion used in promotion of these products.
    </p>

</div>

<div class="main-bright-title">
    <span class="glyphicon glyphicon-comment"></span>
    Contact information
</div>

<div class="contact-us">
    <div class="row">
        <div class="key">Mobile number:</div>
        <div class="value">{{ $contactUs->getMobileNumber() }}</div>
    </div>
    <div class="row">
        <div class="key">Email:</div>
        <div class="value">{{ $contactUs->getEmailAddress() }}</div>
    </div>
</div>

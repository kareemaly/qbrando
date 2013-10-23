function HtmlSubmitter( modal )
{
    this.modal = modal;

    this.modal.dialog({
        autoOpen: false,
        modal: true
    });

    this.stepNo = 1;

    this.totalSteps = 1;

    this.addLoader();
}


HtmlSubmitter.prototype.addLoader = function()
{
    this.modal.append('<div style="width:250px; height:20px; border:2px solid #333;">' +
        '<div id="submitter_loader" style="height:20px; background:#FF3617"></div></div>');
}

HtmlSubmitter.prototype.startSubmitting = function( totalSteps )
{
    this.modal.dialog( 'open' );

    this.totalSteps = totalSteps;

    console.log(totalSteps);
}

HtmlSubmitter.prototype.addStep = function( form )
{
    var width = (this.stepNo / this.totalSteps) * 250;

    $("#submitter_loader").width(width);

    this.stepNo ++;
}

HtmlSubmitter.prototype.stopSubmitting = function()
{
    this.stepNo = 1;

    this.modal.find('.step').remove();

    this.modal.dialog( 'close' );
}

HtmlSubmitter.prototype.showErrors = function( errors )
{
    var errorsString = errors.join('<br />');

    $("#main-content").prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert">&times;</a>' + errorsString +'</div>');

    window.scrollTo(0, 0);
}
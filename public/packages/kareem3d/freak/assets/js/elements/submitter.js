function Submitter( $forms, html, elementEditUrl )
{
    this.forms = $forms;

    this.html = html;

    this.elementEditUrl = elementEditUrl;

    this.packagesData = [];

    this.insert_id = 0;
}

Submitter.prototype.run = function()
{
    this.i = 0;

    this.html.startSubmitting( this.forms.length );

    this.submitNextForm();
}

Submitter.prototype.submitNextForm = function()
{
    var form = this.forms.eq(this.i);

    if(form.length == 0) return this.finishedSubmittingAll();

    this.html.addStep(form);

    var that = this;

    var data = {'packagesData': this.getPackagesData()};
    if(this.insert_id != 0) data.insert_id = this.insert_id;

    console.log(data);

    form.ajaxSubmit({

        type: 'POST',
        data: data,
        success: function(data) {

            that.handleFormSuccess(data);
        }
    });

    this.i++;
}

Submitter.prototype.isMainForm = function()
{
    return this.i == 1;
}

Submitter.prototype.handleFormSuccess = function( data )
{
    if(data.status == 'success')
    {
        // If data is defined and packageData is defined
        if(data.data !== undefined)
        {
            if(data.data.packageData !== undefined)
            {
                this.addPackagesData(data.data.packageData);
            }

            if(this.isMainForm() && data.data.insert_id !== undefined)
            {
                this.insert_id = data.data.insert_id;
            }
        }

        return this.submitNextForm();
    }

    else if(data.status == 'fail')
    {
        var errors = [];

        for (var key in data.data) {

            errors.push(data.data[key]);
        }

        this.stop();
        this.html.showErrors(errors);
    }


    // If not main form then continue submitting...
    if(! this.isMainForm()) {

        this.submitNextForm();
    }
}

Submitter.prototype.getPackagesData = function()
{
    return this.packagesData;
}

Submitter.prototype.addPackagesData = function( data )
{
    this.packagesData.push(data);
}

Submitter.prototype.stop = function()
{
    this.html.stopSubmitting();
}

Submitter.prototype.finishedSubmittingAll = function()
{
    window.location.href = this.elementEditUrl + '/' + this.insert_id;
}
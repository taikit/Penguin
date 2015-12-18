var $ = require("jquery");

function API() {
    this.endpoint = "http://localhost:8080/api/";
}

API.prototype.exec = function (model, action, data) {
    return $.ajax({
        url: this.endpoint + '?model=' + model + '&action=' + action,
        dataType: 'json',
        type: 'POST',
        data: {data: JSON.stringify(data)},
        error: function (xhr, textStatus, errorThrown) {
            console.log(xhr);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
};

module.exports = new API();

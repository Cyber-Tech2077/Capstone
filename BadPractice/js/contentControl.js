class ContentControl {
    // This limits the user on current or future dates in the input elements
    // that are specified to the date category. Calendars in the browser will
    // only show todays date and beyond. All previous dates before today are
    // disabled and can one longer be used.
    limitedDatePeriod() {
        var currentMonth = new Date().getMonth();
        if (currentMonth > 0 && currentMonth < 10) {
            currentMonth = "0" + currentMonth;
        } else {
            currentMonth += 1;
        }
        var currentDay = new Date().getDate();
        if (currentDay < 10) {
            currentDay = "0" + currentDay;
        }
        return new Date().getFullYear() + '-' + currentMonth + '-' + currentDay;
    }
    // This will prevent letters and symbols from entering into the zipcode textbox.
    keyboardNumbers(event) {
        if (event.shiftKey == false) {
            // Keycodes are unicode values associated with each key on the keyboard .
            // When a key is pressed, a unicode number is returned associated with
            // that specific key that was pressed.
            if (event.keyCode >= 48 && event.keyCode <= 57 || event.keyCode >= 96 && event.keyCode <= 105 || event.keyCode == 8) {
                this.setBoolValue = true;
            } else {
                this.setBoolValue = false;
            }
        } else {
            this.setBoolValue = false;
        }
        return this.setBoolValue;
    }
    async preventiveMeasure(categoryArrays) {
        var queryType;
        var whereClauseSpecified = false;
        for (var index in categoryArrays) {
            for (var key in categoryArrays[index]) {
                if (key == 'sqlType') {
                    if (categoryArrays[index][key].toUpperCase() == 'UPDATE' || categoryArrays[index][key].toUpperCase() == 'DELETE') {
                        queryType = categoryArrays[index][key];
                    }
                } else if (key.toUpperCase() == 'WHERE') {
                    whereClauseSpecified = true;
                }
            }
        }
        if (whereClauseSpecified == false) {
            if (queryType.toUpperCase() == 'UPDATE' || queryType.toUpperCase() == 'DELETE') {
                return await Swal.fire({
                    icon: 'error',
                    title: 'Failure',
                    allowOutsideClick: false,
                    text: 'Please contact customer support.',
                    confirmButtonText: 'Ok'
                }).then(result => {
                    return false;
                });
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
    ajaxPostController(linkUrl) {
        var querySettings;
        var columnParams;
        var queryParams;
        try {
            var index = 0;
            for (var name in categoryArrays) {
                if (index == 0) {
                    querySettings = categoryArrays[name];
                } else if (index == 1) {
                    columnParams = categoryArrays[name];
                } else {
                    queryParams = categoryArrays[name];
                }
                index++;
            }
            $.post({
                url: linkUrl,
                data: {
                    dbQuerySettings: JSON.stringify(querySettings),
                    dbColumnParams: JSON.stringify(columnParams),
                    dbQueryParams: JSON.stringify(queryParams)
                },
                dataType: 'json',
                success: function(feedback) {
                    var jsonResult = JSON.parse(feedback);
                    for (var jsonKey in jsonResult) {
                        switch (jsonKey.toUpperCase()) {
                            case 'MESSAGE':
                                Swal.fire({
                                    icon: 'error',
                                    text: 'An error has occurred: ' + jsonResult[jsonKey]
                                });
                                break;
                            case 'SUCCESSFUL':
                                Swal.fire({
                                    icon: 'success',
                                    text: jsonResult[jsonKey]
                                }).then(result => {
                                    location.reload();
                                });
                                break;
                        }
                    }
                },
                error: function(err) {
                    for (var error in JSON.parse(err['responseText'])) {
                        switch (error.toUpperCase()) {
                            case 'RESPONSETEXT':
                                Swal.fire({
                                    icon: 'error',
                                    text: 'An ajax error has occurred: ' + error['message']
                                }).then(result => {
                                    location.reload();
                                });
                                break;
                        }
                    }
                }
            });
        } catch (errorMesage) {
            Swal.fire({
                icon: 'error',
                text: 'An error has occurred: ' + errorMesage
            });
        }
    }
}

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
    async preventiveMeasure(dialogType) {
        switch (dialogType.toUpperCase()) {
            case 'SIGNUP':
                Swal.fire({
                    title: 'Multiple inputs',
                    html: '<input type="username" id="swal-input1" class="swal2-input">' +
                        '<input type="password" id="swal-input2" class="swal2-input">' +
                        '<input type="email" id="swal-input3" class="swal2-input">',
                    focusConfirm: false,
                    preConfirm: () => {
                        return [
                            document.getElementById('swal-input1').value,
                            document.getElementById('swal-input2').value,
                            document.getElementById('swal-input3').value
                        ]
                    }
                }).then(result => {
                    if (result.value[0] !== '' && result.value[1] !== '' & result.value[2] !== '') {
                        var inputs = {
                            inputValues: {
                                username: result.value[0],
                                password: result.value[1],
                                email: result.value[2]
                            }
                        };
                        $.post({
                            url: '../php/dynamic-queries/insertCredentials.php',
                            data: {
                                credentials: JSON.stringify(inputs)
                            },
                            dataType: 'json',
                            success: function (feedback) {
                                return feedback;
                            }
                        });
                    }
                });
                break;
            case 'SIGNIN':
                break;
            default:
                return 'You must select a dialog type such as "signup" or "signin".';
        }
    }

}

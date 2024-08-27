function checkCreditCardBank(cardnumber, errorBox, disabled) {
    errorBox = null;
    function validateCard(code) {
        var L = code.length;
        if (L < 16 || parseInt(code.substr(1, 10), 10) == 0 || parseInt(code.substr(10, 6), 10) == 0) return false;
        var c = parseInt(code.substr(15, 1), 10);
        var s = 0;
        var k, d;
        for (var i = 0; i < 16; i++) {
            k = (i % 2 == 0) ? 2 : 1;
            d = parseInt(code.substr(i, 1), 10) * k;
            s += (d > 9) ? d - 9 : d;
        }
        return ((s % 10) == 0);
    }
    if (validateCard(cardnumber) === false) { errorBox = 'شماره کارت اشتباه می باشد'; disabled = true }
    else { disabled = false }
}
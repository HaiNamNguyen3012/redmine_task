/*
create: duycuong
*/

function isExist(str) {
    if (str == '' || str === undefined) {
        return false;
    } else {
        return true;
    }
}

function isCurrentEmail(email) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
        return true;
    } else {
        return false;
    }
}

function isStringLengthMinMax(str) {
    if (str.length >= 6 && str.length <= 32) {
        return true;
    } else {
        return false;
    }
}

function isStringLengthMax(str, number) {
    if (str.length <= number) {
        return true;
    } else {
        return false;
    }
}

function isStringLengthMin(str, number) {
    if (str.length >= number) {
        return true;
    } else {
        return false;
    }
}

function isCurrentUrl(str) {
    var regex = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
    if (!regex.test(str)) {
        return false;
    } else {
        return true;
    }
}

function isNumeric(num) {
    // var res = num.split(" ");
    // if(parseInt(res.length) > parseInt(1)) return false;
    return ((num >= 0 || num < 0) && (parseInt(num) == num));
}

function isFile(file) {
    if (file == '' || file === undefined) {
        return false;
    }
    else if (file[0].size.length <= 0) {
        return false;
    }
    else {
        return true;
    }
}

function isDataJson(file) {
    if (file == '' || file === undefined || file == '[]') {
        return false;
    }
    else {
        return true;
    }
}

function isCurrentTelNumber(tel) {
    return /(((\+|)84)|0)(3|5|7|8|9)+([0-9]{8})\b/.test(tel);
}
